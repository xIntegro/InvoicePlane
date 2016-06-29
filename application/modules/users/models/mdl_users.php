<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

/*
 * xintegro
 * 
 * A free and open source web based invoicing system
 *
 * @package		xintegro
 * @author		xintegro (xintegro.de)
 * @copyright	Copyright (c) 2012 - 2015 xintegro.de
 * @license		http://xintegro.de/license.txt
 * @link		http://xintegro.de/
 * 
 */

class Mdl_Users extends Response_Model
{
    public $table = 'xc_users';
    public $primary_key = 'xc_users.user_id';
    public $date_created_field = 'user_date_created';
    public $date_modified_field = 'user_date_modified';
    public $query;
    public $native_methods = array(
        'select',
        'select_max',
        'select_min',
        'select_avg',
        'select_sum',
        'join',
        'where',
        'or_where',
        'where_in',
        'or_where_in',
        'where_not_in',
        'or_where_not_in',
        'like',
        'or_like',
        'not_like',
        'or_not_like',
        'group_by',
        'distinct',
        'having',
        'or_having',
        'order_by',
        'limit'
    );

    public function __construct()
    {
        $this->defaultDB = $this->load->database('default', true);
        $this->defaultDBName = $this->defaultDB->database;
    }

    public function user_types()
    {
        return array(
            '1' => lang('SuperAdministrator'),
            '2' => lang('administrator'),
            '3' => lang('guest_read_only')
        );
    }

    public function getUsers()
    {

        $result = $this->defaultDB->get('xc_users');
        return $result->result();
    }

    public function default_select()
    {
        $this->defaultDB->select("SQL_CALC_FOUND_ROWS
                            $this->defaultDBName.xc_user_custom.*,
                            $this->defaultDBName.xc_users.*", false);
    }

    public function default_join()
    {
        $this->defaultDB->join($this->defaultDBName . '.xc_user_custom',
            $this->defaultDBName . '.xc_user_custom.user_id = xc_users.user_id', 'left');
    }

    public function default_order_by()
    {
        $this->defaultDB->order_by($this->defaultDBName . '.xc_users.user_name');
    }

    public function validation_rules()
    {
        return array(
            'user_type' => array(
                'field' => 'user_type',
                'label' => lang('user_type'),
                'rules' => 'required'
            ),
            'user_email' => array(
                'field' => 'user_email',
                'label' => lang('email'),
                // 'rules' => "required|valid_email|is_unique[xc_users.user_email]"
            ),
            'user_name' => array(
                'field' => 'user_name',
                'label' => lang('name'),
                'rules' => 'required'
            ),
            'user_password' => array(
                'field' => 'user_password',
                'label' => lang('password'),
                'rules' => 'required|min_length[8]'
            ),
            'user_passwordv' => array(
                'field' => 'user_passwordv',
                'label' => lang('verify_password'),
                'rules' => 'required|matches[user_password]'
            ),
            'user_company' => array(
                'field' => 'user_company'
            ),
            'user_address_1' => array(
                'field' => 'user_address_1'
            ),
            'user_address_2' => array(
                'field' => 'user_address_2'
            ),
            'user_city' => array(
                'field' => 'user_city'
            ),
            'user_state' => array(
                'field' => 'user_state'
            ),
            'user_zip' => array(
                'field' => 'user_zip'
            ),
            'user_country' => array(
                'field' => 'user_country',
                'label' => lang('country'),
            ),
            'user_phone' => array(
                'field' => 'user_phone'
            ),
            'user_fax' => array(
                'field' => 'user_fax'
            ),
            'user_mobile' => array(
                'field' => 'user_mobile'
            ),
            'user_web' => array(
                'field' => 'user_web'
            ),
            'user_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'user_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            'access_company' => array(
                'field' => 'access_company'
            )
        );
    }

    public function validation_rules_existing()
    {
        return array(
            'user_type' => array(
                'field' => 'user_type',
                'label' => lang('user_type'),
                'rules' => 'required'
            ),
            'user_email' => array(
                'field' => 'user_email',
                'label' => lang('email'),
                'rules' => 'required|valid_email'
            ),
            'user_name' => array(
                'field' => 'user_name',
                'label' => lang('name'),
                'rules' => 'required'
            ),
            'user_company' => array(
                'field' => 'user_company'
            ),
            'user_address_1' => array(
                'field' => 'user_address_1'
            ),
            'user_address_2' => array(
                'field' => 'user_address_2'
            ),
            'user_city' => array(
                'field' => 'user_city'
            ),
            'user_state' => array(
                'field' => 'user_state'
            ),
            'user_zip' => array(
                'field' => 'user_zip'
            ),
            'user_country' => array(
                'field' => 'user_country',
                'label' => lang('country'),
                'rules' => 'required'
            ),
            'user_phone' => array(
                'field' => 'user_phone'
            ),
            'user_fax' => array(
                'field' => 'user_fax'
            ),
            'user_mobile' => array(
                'field' => 'user_mobile'
            ),
            'user_web' => array(
                'field' => 'user_web'
            ),
            'user_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'user_tax_code' => array(
                'field' => 'user_tax_code'
            ),
            'access_company' => array(
                'field' => 'access_company'
            )
        );
    }

    public function validation_rules_change_password()
    {
        return array(
            'user_password' => array(
                'field' => 'user_password',
                'label' => lang('password'),
                'rules' => 'required'
            ),
            'user_passwordv' => array(
                'field' => 'user_passwordv',
                'label' => lang('verify_password'),
                'rules' => 'required|matches[user_password]'
            )
        );
    }

    public function db_array()
    {
        $db_array = $this->parentDB_array();

        if (isset($db_array['user_password'])) {
            unset($db_array['user_passwordv']);

            $this->load->library('crypt');

            $user_psalt = $this->crypt->salt();

            $db_array['user_psalt'] = $user_psalt;
            $db_array['user_password'] = $this->crypt->generate_password($db_array['user_password'], $user_psalt);
        }

        return $db_array;
    }

    public function save_change_password($user_id, $password)
    {
        $this->load->library('crypt');

        $user_psalt = $this->crypt->salt();
        $user_password = $this->crypt->generate_password($password, $user_psalt);

        $db_array = array(
            'user_psalt' => $user_psalt,
            'user_password' => $user_password
        );

        $this->db->where('user_id', $user_id);
        $this->db->update('xc_users', $db_array);

        $this->session->set_flashdata('alert_success', 'Password Successfully Changed');
    }

//    public function save($id = null, $db_array = null)
//    {
//        $id = parent::save($id, $db_array);
//
//        if ($user_clients = $this->session->userdata('user_clients')) {
//            $this->load->model('users/mdl_user_clients');
//
//            foreach ($user_clients as $user_client) {
//                $this->mdl_user_clients->save(null, array('user_id' => $id, 'client_id' => $user_client));
//            }
//
//            $this->session->unset_userdata('user_clients');
//        }
//
//        return $id;
//    }


    public function paginate($base_url, $offset = 0, $uri_segment = 3)
    {
        $this->load->helper('url');
        $this->load->library('pagination');

        $this->offset = $offset;
        $default_list_limit = $this->mdl_settings->setting('default_list_limit');
        $per_page = (empty($default_list_limit) ? $this->default_limit : $default_list_limit);

        $this->set_defaults();
        $this->run_filters();

        $this->defaultDB->limit($per_page, $this->offset);
        $this->query = $this->defaultDB->get($this->table);

        $this->total_rows = $this->defaultDB->query('SELECT FOUND_ROWS() AS num_rows')->row()->num_rows;
        $this->total_pages = ceil($this->total_rows / $per_page);
        $this->previous_offset = $this->offset - $per_page;
        $this->next_offset = $this->offset + $per_page;

        $config = array(
            'base_url' => $base_url,
            'total_rows' => $this->total_rows,
            'per_page' => $per_page
        );

        $this->last_offset = ($this->total_pages * $per_page) - $per_page;

        if ($this->config->item('pagination_style')) {
            $config = array_merge($config, $this->config->item('pagination_style'));
        }

        $this->pagination->initialize($config);

        $this->page_links = $this->pagination->create_links();
    }

    public function save($id = null, $db_array = null)
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

            $this->defaultDB->insert($this->table, $db_array);

            $id = $this->defaultDB->insert_id();
        } else {
            if ($this->date_modified_field) {
                if (is_array($db_array)) {
                    $db_array[$this->date_modified_field] = $datetime;
                } else {
                    $db_array->{$this->date_modified_field} = $datetime;
                }
            }

            $this->defaultDB->where($this->primary_key, $id);
            $this->defaultDB->update($this->table, $db_array);

            return $id;
        }
        if ($user_clients = $this->session->userdata('user_clients')) {
            $this->load->model('users/mdl_user_clients');

            foreach ($user_clients as $user_client) {
                $this->mdl_user_clients->save(null, array('user_id' => $id, 'client_id' => $user_client));
            }

            $this->session->unset_userdata('user_clients');
        }
        return $id;
    }

    public function parentDB_array()
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

    public function delete($id)
    {
        $this->defaultDB->where($this->primary_key, $id);
        $this->defaultDB->delete($this->table);
    }

    public function prep_form($id = null)
    {
        if (!$_POST and ($id)) {
            $row = $this->get_by_id($id);

            if ($row) {
                foreach ($row as $key => $value) {
                    $this->form_values[$key] = $value;
                }
                return true;
            }
            return false;
        } elseif (!$id) {
            return true;
        }
    }

    public function get_by_id($id)
    {
        return $this->where($this->primary_key, $id)->get()->row();
    }

    public function get($include_defaults = true)
    {
        if ($include_defaults) {
            $this->set_defaults();
        }

        $this->run_filters();

        $this->query = $this->defaultDB->get($this->table);

        $this->filter = array();

        return $this;
    }

    private function run_filters()
    {
        foreach ($this->filter as $filter) {
            call_user_func_array(array($this->defaultDB, $filter[0]), $filter[1]);
        }

        /**
         * Clear the filter array since this should only be run once per model
         * execution
         */
        $this->filter = array();
    }

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

    public function row()
    {
        return $this->query->row();
    }


}
