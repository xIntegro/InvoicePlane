<?php

/**
 * CodeIgniter CRUD Model 2
 * A base model providing CRUD, pagination and validation.
 *
 * Install this file as application/core/MY_Model.php
 *
 * @package    CodeIgniter
 * @author        Kovah (www.kovah.de)
 * @copyright    Copyright (c) 2012, Jesse Terry
 * @link        http://developer13.com
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 */
class MY_Model extends CI_Model
{

    public $table;
    public $primary_key;
    public $default_limit = 15;
    public $page_links;
    public $query;
    public $form_values = array();
    protected $default_validation_rules = 'validation_rules';
    protected $validation_rules;
    public $validation_errors;
    public $total_rows;
    public $date_created_field;
    public $date_modified_field;
    public $native_methods = array(
        'select', 'select_max', 'select_min', 'select_avg', 'select_sum', 'join',
        'where', 'or_where', 'where_in', 'or_where_in', 'where_not_in', 'or_where_not_in',
        'like', 'or_like', 'not_like', 'or_not_like', 'group_by', 'distinct', 'having',
        'or_having', 'order_by', 'limit'
    );
    public $total_pages = 0;
    public $current_page;
    public $next_page;
    public $previous_page;
    public $offset;
    public $next_offset;
    public $previous_offset;
    public $last_offset;
    public $id;
    public $filter = array();

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 7) == 'filter_') {
            $this->filter[] = array(substr($name, 7), $arguments);
        } else {
            call_user_func_array(array($this->db, $name), $arguments);
        }
        return $this;
    }

    /**
     * Sets CI query object and automatically creates active record query
     * based on methods in child model.
     * $this->model_name->get()
     */
    public function get($include_defaults = true)
    {
        if ($include_defaults) {
            $this->set_defaults();
        }

        $this->run_filters();

        $this->query = $this->db->get($this->table);

        $this->filter = array();

        return $this;
    }

    private function run_filters()
    {
        foreach ($this->filter as $filter) {
            call_user_func_array(array($this->db, $filter[0]), $filter[1]);
        }

        /**
         * Clear the filter array since this should only be run once per model
         * execution
         */
        $this->filter = array();
    }

    /**
     * Query builder which listens to methods in child model.
     * @param type $exclude
     */
    private function set_defaults($exclude = array())
    {
        $native_methods = $this->native_methods;

        foreach ($exclude as $unset_method) {
            unset($native_methods[array_search($unset_method, $native_methods)]);
        }

        foreach ($native_methods as $native_method) {
            $native_method = 'default_' . $native_method;

            if (method_exists($this, $native_method)) {
                $this->$native_method();
            }
        }
    }

    /**
     * Call when paginating results.
     * $this->model_name->paginate()
     */
    public function paginate($base_url, $offset = 0, $uri_segment = 3)
    {
        $this->load->helper('url');
        $this->load->library('pagination');

        $this->offset = $offset;
        $default_list_limit = $this->mdl_settings->setting('default_list_limit');
        $per_page = (empty($default_list_limit) ? $this->default_limit : $default_list_limit);

        $this->set_defaults();
        $this->run_filters();

        $this->db->limit($per_page, $this->offset);
        $this->query = $this->db->get($this->table);

        $this->total_rows = $this->db->query('SELECT FOUND_ROWS() AS num_rows')->row()->num_rows;
        $this->total_pages = ceil($this->total_rows / $per_page);
        $this->previous_offset = $this->offset - $per_page;
        $this->next_offset = $this->offset + $per_page;

        $config = array(
            'base_url'   => $base_url,
            'total_rows' => $this->total_rows,
            'per_page'   => $per_page
        );

        $this->last_offset = ($this->total_pages * $per_page) - $per_page;

        if ($this->config->item('pagination_style')) {
            $config = array_merge($config, $this->config->item('pagination_style'));
        }

        $this->pagination->initialize($config);

        $this->page_links = $this->pagination->create_links();
    }

    /**
     * Retrieves a single record based on primary key value.
     */
    public function get_by_id($id)
    {
        return $this->where($this->primary_key, $id)->get()->row();
    }

    public function save($id = NULL, $db_array = NULL)
    {
        if (!$db_array) {
            $db_array = $this->db_array();
        }
        $datetime = date('Y-m-d H:i:s');
        if (!$id) {
            if ($this->date_created_field) {
                if (is_array($db_array)) {
                    $db_array[$this->date_created_field] = $datetime;

                    if ($this->date_modified_field) {
                        $db_array[$this->date_modified_field] = $datetime;
                    }
                } else {
                    $db_array->{$this->date_created_field} = $datetime;

                    if ($this->date_modified_field) {
                        $db_array->{$this->date_modified_field} = $datetime;
                    }
                }
            } elseif ($this->date_modified_field) {
                if (is_array($db_array)) {
                    $db_array[$this->date_modified_field] = $datetime;
                } else {
                    $db_array->{$this->date_modified_field} = $datetime;
                }
            }

            $this->db->insert($this->table, $db_array);

            return $this->db->insert_id();
        } else {
            if ($this->date_modified_field) {
                if (is_array($db_array)) {
                    $db_array[$this->date_modified_field] = $datetime;
                } else {
                    $db_array->{$this->date_modified_field} = $datetime;
                }
            }

            $this->db->where($this->primary_key, $id);
            $this->db->update($this->table, $db_array);

            return $id;
        }
    }

    /**
     * Returns an array based on $_POST input matching the ruleset used to
     * validate the form submission.
     */
    public function db_array()
    {
        $db_array = array();

        $validation_rules = $this->{$this->validation_rules}();

        foreach ($this->input->post() as $key => $value) {
            if (array_key_exists($key, $validation_rules)) {
                $db_array[$key] = $value;
            }
        }

        return $db_array;
    }

    /**
     * Deletes a record based on primary key value.
     * $this->model_name->delete(5);
     */
    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }

    /**
     * Returns the CI query result object.
     * $this->model_name->get()->result();
     */
    public function result()
    {
        return $this->query->result();
    }

    /**
     * Returns the CI query row object.
     * $this->model_name->get()->row();
     */
    public function row()
    {
        return $this->query->row();
    }

    /**
     * Returns CI query result array.
     * $this->model_name->get()->result_array();
     */
    public function result_array()
    {
        return $this->query->result_array();
    }

    /**
     * Returns CI query row array.
     * $this->model_name->get()->row_array();
     */
    public function row_array()
    {
        return $this->query->row_array();
    }

    /**
     * Returns CI query num_rows().
     * $this->model_name->get()->num_rows();
     */
    public function num_rows()
    {
        return $this->query->num_rows();
    }

    /**
     * Used to retrieve record by ID and populate $this->form_values.
     * @param int $id
     * @return boolean
     */
    public function prep_form($id = NULL)
    {
        if (!$_POST and ($id)) {
            $row = $this->get_by_id($id);

            if ($row) {
                foreach ($row as $key => $value) {
                    $this->form_values[$key] = $value;
                }
                return TRUE;
            }
            return FALSE;
        } elseif (!$id) {
            return TRUE;
        }
    }

    /**
     * Performs validation on submitted form. By default, looks for method in
     * child model called validation_rules, but can be forced to run validation
     * on any method in child model which returns array of validation rules.
     * @param string $validation_rules
     * @return boolean
     */
    public function run_validation($validation_rules = NULL)
    {
        if (!$validation_rules) {
            $validation_rules = $this->default_validation_rules;
        }

        foreach (array_keys($_POST) as $key) {
            $this->form_values[$key] = $this->input->post($key);
        }

        if (method_exists($this, $validation_rules)) {
            $this->validation_rules = $validation_rules;

            $this->load->library('form_validation');

            $this->form_validation->set_rules($this->$validation_rules());

            $run = $this->form_validation->run();

            $this->validation_errors = validation_errors();

            return $run;
        }
    }

    /**
     * Returns the assigned form value to a form input element.
     * @param type $key
     * @return type
     */
    public function form_value($key)
    {
        return (isset($this->form_values[$key])) ? $this->form_values[$key] : '';
    }

    public function set_form_value($key, $value)
    {
        $this->form_values[$key] = $value;
    }

    public function set_id($id)
    {
        $this->id = $id;
    }


    /**
     * Select the database connection from the group names defined inside the database.php configuration file or an
     * array.
     */
    protected $_database_connection = NULL;

    /** @var
     * This one will hold the database connection object
     */
    protected $_database;

    /**
     * @var array
     * You can establish the fields of the table. If you won't these fields will be filled by MY_Model (with one query)
     */
    public $table_fields = array();

    /**
     * @var array
     * Sets fillable fields
     */
    public $fillable = array();

    /**
     * @var array
     * Sets protected fields
     */
    public $protected = array();

    private $_can_be_filled = NULL;


    /** @var bool | array
     * Enables created_at and updated_at fields
     */
    protected $timestamps = TRUE;
    protected $timestamps_format = 'Y-m-d H:i:s';

    protected $_created_at_field;
    protected $_updated_at_field;
    protected $_deleted_at_field;

    /** @var bool
     * Enables soft_deletes
     */
    protected $soft_deletes = FALSE;

    /** relationships variables */
    private $_relationships = array();
    public $has_one = array();
    public $has_many = array();
    public $has_many_pivot = array();
    public $separate_subqueries = TRUE;
    private $_requested = array();
    /** end relationships variables */

    /*caching*/
    public $cache_driver = 'file';
    public $cache_prefix = 'mm';
    protected $_cache = array();
    public $delete_cache_on_save = FALSE;

    public $all_pages;
    public $pagination_delimiters;
    public $pagination_arrows;

    /* validation */
    private $validated = TRUE;
    private $row_fields_to_update = array();


    /**
     * The various callbacks available to the model. Each are
     * simple lists of method names (methods will be run on $this).
     */
    protected $before_create = array();
    protected $after_create = array();
    protected $before_update = array();
    protected $after_update = array();
    protected $before_get = array();
    protected $after_get = array();
    protected $before_delete = array();
    protected $after_delete = array();
    protected $before_soft_delete = array();
    protected $after_soft_delete = array();

    protected $callback_parameters = array();

    protected $return_as = 'object';
    protected $return_as_dropdown = NULL;
    protected $_dropdown_field = '';

    private $_trashed = 'without';

    private $_select = '*';


    public function __construct()
    {
        parent::__construct();
        $this->_set_connection();
    }



    /** END RELATIONSHIPS */

    /**
     * public function on($connection_group = NULL)
     * Sets a different connection to use for a query
     * @param $connection_group = NULL - connection group in database setup
     * @return obj
     */
    public function on($connection_group = NULL)
    {
        if(isset($connection_group))
        {
            $this->_database->close();
            $this->load->database($connection_group);
            $this->_database = $this->db;
        }
        return $this;
    }

    /**
     * public function reset_connection($connection_group = NULL)
     * Resets the connection to the default used for all the model
     * @return obj
     */
    public function reset_connection()
    {
        if(isset($connection_group))
        {
            $this->_database->close();
            $this->_set_connection();
        }
        return $this;
    }

    /**
     * Trigger an event and call its observers. Pass through the event name
     * (which looks for an instance variable $this->event_name), an array of
     * parameters to pass through and an optional 'last in interation' boolean
     */
    public function trigger($event, $data = array(), $last = TRUE)
    {
        if (isset($this->$event) && is_array($this->$event))
        {
            foreach ($this->$event as $method)
            {
                if (strpos($method, '('))
                {
                    preg_match('/([a-zA-Z0-9\_\-]+)(\(([a-zA-Z0-9\_\-\., ]+)\))?/', $method, $matches);
                    $method = $matches[1];
                    $this->callback_parameters = explode(',', $matches[3]);
                }
                $data = call_user_func_array(array($this, $method), array($data, $last));
            }
        }
        return $data;
    }

    /**
     * private function _set_connection()
     *
     * Sets the connection to database
     */
    private function _set_connection()
    {
        if(isset($this->_database_connection))
        {
            $this->_database = $this->load->database($this->_database_connection,TRUE);
        }
        else
        {
            $this->load->database();
            $this->_database =$this->db;
        }
        // This may not be required
        return $this;
    }

    /**
     * private function _fetch_table()
     *
     * Sets the table name when called by the constructor
     *
     */
    private function _fetch_table()
    {
        if (!isset($this->table))
        {
            $this->table = $this->_get_table_name(get_class($this));
        }
        return TRUE;
    }
    private function _get_table_name($model_name)
    {
        $table_name = plural(preg_replace('/(_m|_model|_mdl)?$/', '', strtolower($model_name)));
        return $table_name;
    }

}

?>