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

class Mdl_User_Custom extends MY_Model
{
    public $table = 'xc_user_custom';
    public $primary_key = 'xc_user_custom.user_custom_id';

    public function __construct()
    {
        $mainDB = $this->load->database('default', true);
        $this->defaultDBName = $mainDB->database;
        $this->_database_connection = 'default';
        $this->table = $this->defaultDBName . '.xc_user_custom';

        parent::__construct();
    }


    public function save_custom($user_id, $db_array)
    {
        $user_custom_id = null;

        $db_array['user_id'] = $user_id;

        $user_custom = $this->where('user_id', $user_id)->get();

        if ($user_custom->num_rows()) {
            $user_custom_id = $user_custom->row()->user_custom_id;
        }

        $this->save($user_custom_id, $db_array);

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

            $this->db->insert($this->table, $db_array);

            $id = $this->db->insert_id();
            return $id;
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

            // return $id;
        }
        if ($user_clients = $this->session->userdata('user_clients')) {
            $this->load->model('users/mdl_user_clients');

            foreach ($user_clients as $user_client) {
                $this->mdl_user_clients->save(null, array('user_id' => $id, 'client_id' => $user_client));
            }

            $this->session->unset_userdata('user_clients');
        }

    }

    public function edit($id)
    {
        $result = $this->db->get_where('xc_user_custom', $id);
        return $result->result();
    }

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

}
