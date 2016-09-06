<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Company extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_company');
        $this->load->model('users/mdl_users');
        $this->load->model('users_company/mdl_user_company');
        $this->load->dbforge();
    }
    
    public function index()
    {
        
        $usersData = $this->mdl_users->getUsers();
        $companies = $this->mdl_company->getCompany();
        $users = [];
        foreach ($usersData as $user) {
            $userCompany = [];
            $selectedCompany = [];
            $userCompanies = $this->mdl_user_company->getUserCompany($user->user_id);
            foreach ($userCompanies as $comp) {
                 array_push($selectedCompany, $comp->company_id);
            }
            foreach ($companies as $company) {
                if (in_array($company->id, $selectedCompany)) {
                    $userCompany[$company->id] = true;
                } else {
                    $userCompany[$company->id] = false;
                }
            }
            array_unshift($user, $user->userCompany = (object)$userCompany);
            $users[] = $user;
        }
        $this->layout->set(
            array(
                'companies' => $companies,
                'users' => $users,
                'user_types' => $this->mdl_users->user_types()
            )
        );

        $this->layout->buffer('content', 'company/view');
        $this->layout->render();

    }

    public function form($id = null)
    {
        $users = $this->mdl_users->getUsers();
        if ($this->input->post('btn_cancel')) {
            redirect('company');
        }
        if ($this->mdl_company->run_validation()) {

            if ($this->mdl_company->companyExist($this->input->post('name'))) {
                $this->session->set_flashdata('alert_error', lang('company_already_exists'));
                redirect('company/form');
            }
            $companyName = preg_replace('/[^A-Za-z0-9]/', '_', $this->input->post('name'));
            $dbname = 'xintegro_' . $companyName . '_' . rand();
            $this->dbforge->create_database($dbname);

            $data = array('name' => $this->input->post('name'), 'dbname' => $dbname);
            $id = $this->mdl_company->insert($data);
            foreach ($users as $user) {
                if ($user->access_company == 1||$user->user_type == 1) {
                    $data = array(
                        'user_id' => $user->user_id,
                        'company_id' => $id,

                    );
                    $this->mdl_user_company->create($data);
                }
            }

            //import database
            $abc = new DBSwitch_Controller($dbname);
            redirect('company');
        }
        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_company->prep_form($id)) {
                show_404();
            }
        }

        $this->layout->buffer('content', 'company/form');
        $this->layout->render();

    }

    public function switchDb($dbName)
    {
        $company = $this->mdl_company->getCompanyByDBName($dbName);
        if (!$company) {
            $this->session->set_flashdata('alert_error', 'Unable to find company');
            redirect('/clients/status/active');
        }
        $this->session->set_userdata('user_company', $company->name);
        $this->session->set_userdata('company_id', $company->id);
        $this->session->set_userdata('dbName', $dbName);
        redirect('/clients/status/active');
    }
}