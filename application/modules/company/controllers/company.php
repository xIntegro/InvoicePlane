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
        $this->load->dbforge();
    }

    public function index()
    {

        $users = $this->mdl_users->getUsers();
        $companies = $this->mdl_company->getCompany();
        $this->layout->set(
            array(
                'companies' => $companies,
                'filter_display'     => TRUE,
                'filter_placeholder' => lang('filter_companies'),
                'filter_method'      => 'filter_companies',
                'users' => $users,
                'user_types' => $this->mdl_users->user_types()
            )
        );

        $this->layout->buffer('content', 'company/view');
        $this->layout->render();

    }

    public function form($id = null)
    {
        if ($this->input->post('btn_cancel')) {
            redirect('company');
        }
        if ($this->mdl_company->run_validation()) {

            if ($this->mdl_company->companyExist($this->input->post('name'))) {
                $this->session->set_flashdata('alert_error', lang('company_already_exists'));
                redirect('company/form');
            }

            $dbname = 'xintegro_' . $this->input->post('name') . '_' . rand();
            $this->dbforge->create_database($dbname);

            $data = array('name' => $this->input->post('name'), 'dbname' => $dbname);
            $this->mdl_company->insert($data);

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
        $query = $this->defaultDB->get('xc_companies');
        $this->defaultDB->where('dbName', $dbName);
        $company = $this->defaultDB->get('xc_companies')->row();
        $this->session->set_userdata('user_company', $company->name);
        $this->session->set_userdata('dbName', $dbName);
        redirect('/clients/status/active');
    }
}