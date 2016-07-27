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

class Users extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('mdl_users');
        $this->load->model('users_company/mdl_user_company');
        $this->load->model('company/mdl_company');
        $this->defaultDB = $this->load->database('default', true);
        $this->defaultDBName = $this->defaultDB->database;
    }
    
    public function index($page = 0)
    {
        $this->mdl_users->paginate(site_url('users/index'), $page);
        $users = $this->mdl_users->result();
        
        $this->layout->set('users', $users);
        $this->layout->set('user_types', $this->mdl_users->user_types());
        $this->layout->buffer('content', 'users/index');
        $this->layout->render();
    }
    
    /**  used for add and update company user
     * @param null $id
     */
    public function form($id = null)
    {
        $this->save($id);
        $this->layout->buffer('content', 'users/form');
        $this->layout->render();
    }
    
    /**  used for add and update user
     * @param null $id
     */
    public function create($id = null)
    {
        $this->save($id);
        $this->layout->buffer('content', 'users/new');
        $this->layout->render();
    }
    
    /**  used for add and update user
     * @param null $id
     */
    public function save($id = null)
    {
        $companies = $this->mdl_company->getCompany();
        // get user's companies
        $selectedCompany = $this->mdl_user_company->getUserCompany($id);
        if ($this->input->post('btn_cancel')) {
            redirect('users');
        }
        
        if ($this->mdl_users->run_validation(($id) ? 'validation_rules_existing' : 'validation_rules')) {
            $id = $this->mdl_users->save($id);
            $data = [];
            // insert category into xc_client_category Table;
            $companies = $this->input->post('companies');
            if (!empty($companies)) {
                foreach ($companies as $key => $value) {
                    $data[] = array(
                        'user_id' => $id,
                        'company_id' => $value
                    );
                }
            }
            $this->mdl_user_company->save($data, $id);
            
            $this->load->model('custom_fields/mdl_user_custom');
            
            $this->mdl_user_custom->save_custom($id, $this->input->post('custom'));
            
            redirect('users');
        }
        
        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_users->prep_form($id)) {
                show_404();
            }
            
            $this->load->model('custom_fields/mdl_user_custom');
            
            $user_custom = $this->mdl_user_custom->where('user_id', $id)->get();
            
            if ($user_custom->num_rows()) {
                $user_custom = $user_custom->row();
                
                unset($user_custom->user_id, $user_custom->user_custom_id);
                
                foreach ($user_custom as $key => $val) {
                    $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                }
            }
        } elseif ($this->input->post('btn_submit')) {
            if ($this->input->post('custom')) {
                foreach ($this->input->post('custom') as $key => $val) {
                    $this->mdl_users->set_form_value('custom[' . $key . ']', $val);
                }
            }
        }
        
        $this->load->model('users/mdl_user_clients');
        $this->load->model('clients/mdl_clients');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->helper('country');
        
        $this->layout->set(
            array(
                'id' => $id,
                'user_types' => $this->mdl_users->user_types(),
                'user_clients' => $this->mdl_user_clients->where('xc_user_clients.user_id', $id)->get()->result(),
                'custom_fields' => $this->mdl_custom_fields->by_table('xc_user_custom')->get()->result(),
                'countries' => get_country_list(lang('cldr')),
                'selected_country' => $this->mdl_users->form_value('user_country') ?:
                    $this->mdl_settings->setting('default_country'),
                'companies' => $companies,
                'selected_companies' => isset($selectedCompany) ? $selectedCompany : null
            )
        );
        
        $this->layout->buffer('user_client_table', 'users/partial_user_client_table');
        $this->layout->buffer('modal_user_client', 'users/modal_user_client');
    }
    public function change_password($user_id)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('users');
        }
        
        if ($this->mdl_users->run_validation('validation_rules_change_password')) {
            $this->mdl_users->save_change_password($user_id, $this->input->post('user_password'));
            redirect('users/form/' . $user_id);
        }
        
        $this->layout->buffer('content', 'users/form_change_password');
        $this->layout->render();
    }
    
    public function delete($id)
    {
        if ($id <> 1) {
            $this->mdl_users->delete($id);
        }
        redirect('users');
    }
    
    public function delete_user_client($user_id, $user_client_id)
    {
        $this->load->model('mdl_user_clients');
        
        $this->mdl_user_clients->delete($user_client_id);
        
        redirect('users/form/' . $user_id);
    }
    
}
