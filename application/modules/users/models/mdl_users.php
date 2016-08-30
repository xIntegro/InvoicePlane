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
        $mainDB=$this->mainDB = $this->load->database('default', true);
        $this->_database_connection = 'default';
        $this->table = $mainDB->database . '.xc_users';

        parent::__construct();
    }

    public function user_types()
    {
        return array(
            '1' => lang('SuperAdministrator'),
            '2' => lang('administrator'),
            '3' => lang('guest_read_only')
        );
    }
    public function user_type()
    {
        if($this->session->userdata('user_type')==1)
        {
            return array(
                '1' => lang('SuperAdministrator'),
                '2' => lang('administrator'),
                '3' => lang('guest_read_only')
            );
        }
        else
        {
            return array(
                '2' => lang('administrator'),
                '3' => lang('guest_read_only')
            );
        }

    }

    public function getUsers()
    {
        $result = $this->db->get($this->table);
        return $result->result();
    }

    public function companyUsers($companyId)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->join($this->mainDB->database.".xc_user_companies", $this->mainDB->database.".xc_user_companies.user_id = xc_users.user_id","inner");
        $this->db->where(array($this->mainDB->database.".xc_user_companies.company_id" => $companyId));
        $query = $this->db->get();
        return $query->result();
    }

    public function getUsersWithCompany()
    {
        $result = $this->db->get($this->table);
        return $result->result();
    }

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS xc_user_custom.*, xc_users.*', false);
    }

    public function default_join()
    {
        $this->db->join('xc_user_custom', 'xc_user_custom.user_id = xc_users.user_id', 'left');
    }

    public function default_order_by()
    {
        $this->db->order_by('xc_users.user_name');
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
                'rules' => "required|valid_email|callback_isEmailExist"
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
            ),
            'company' => array(
                'field' => 'companies[]',
                'label' => lang('company_required'),
                'rules' => 'required'
            ),
            'companyName'=>array(
                'field'=>'companyName',
                'label'=>lang('companyName'),
                'rules'=>'required'
            ),

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
            ),
            'company' => array(
                'field' => 'companies[]',
                'label' => lang('company_required'),
                'rules' => 'required'
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
        if ($user_clients = $this->session->userdata('user_clients')) {
            $this->load->model('users/mdl_user_clients');

            foreach ($user_clients as $user_client) {
                $this->mdl_user_clients->save(null, array('user_id' => $id, 'client_id' => $user_client));
            }

            $this->session->unset_userdata('user_clients');
        }
        return $id;
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


    public function db_array()
    {
        $db_array = $_REQUEST;
        if ($db_array['access_company'] == 'on') {
            $db_array['access_company'] = 1;
        } else {
            $db_array['access_company'] = 0;
        }
        unset($db_array['btn_continue']);
        unset($db_array['btn_submit']);
        unset($db_array['companies']);
        unset($db_array['companyName']);

        if (isset($db_array['user_password'])) {
            unset($db_array['user_passwordv']);

            $this->load->library('crypt');

            $user_psalt = $this->crypt->salt();

            $db_array['user_psalt'] = $user_psalt;
            $db_array['user_password'] = $this->crypt->generate_password($db_array['user_password'], $user_psalt);
        }

        return $db_array;
    }

    public function delete($id)
    {
        $this->db->where($this->primary_key, $id);
        $this->db->delete($this->table);
    }

    public function getUserByEmail($email)
    {
        $this->db->where('user_email', $email);
        return $this->get($this->table)->row();

    }

    /**
     * @param $id
     * @return mixed
     */
    public function userAccessAllCompany($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->get($this->table)->row();
    }


    /**
     * @param $key
     * @return bool
     */
    function isEmailExist($key) {
      $isExist=$this->mail_exists($key);
        if($isExist)
        {
            $this->form_validation->set_message('isEmailExist', 'Email address is already exist.'
            );
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * @param $key
     * @return bool
     */
    function mail_exists($key)
    {
        $this->db->where('user_email',$key);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0){
            return true;
        }
        else{
            return false;
        }
    }
}
