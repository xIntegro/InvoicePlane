<?php
        if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class Persons extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('person_model');


    }
    public function index()
    {
        redirect('persons/status/all');
    }
    public function status($status='all',$page=0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->person_model->$function();
        }
        $this->person_model->paginate(site_url('persons/status/' . $status), $page);
        $data = $this->person_model->result();


        $this->layout->set(
            array(
                'records'   =>  $data,
                'filter_display'     => TRUE,
                'filter_placeholder' => lang('filter_persons'),
                'filter_method'      => 'filter_persons'
            )

        );
        $this->layout->buffer('content', 'persons/index');
        $this->layout->render();
    }
    public function form($id = NULL)
    {
        $this->load->helper('country');

        if($this->input->post('btn_cancel'))
        {
            redirect('persons');
        }


        if($id!="" or $id != NULL)
        {
            $id=array('id'=>$id);
            $result=$this->person_model->edit($id);
            $this->layout->set(
                array(
                    'record'=>$result
                )
            );

        }
        if($this->input->post('btn_submit'))
        {

            if($id!="" || $id != NULL)
            {
                if($this->person_model->run_validation())
                {
                    $this->update($this->input->post('is_update'));
                    $this->session->set_flashdata('alert_success', lang('client_already_exists'));
                    redirect('persons');
                }


            }
            else
            {
                if($this->person_model->run_validation())
                {
                    $this->insert();
                    $this->session->set_flashdata('alert_success', lang('client_already_exists'));
                    redirect('persons');
                }

            }

        }
        $this->layout->set(
            array(
                'countries' => get_country_list(lang('cldr')),
            )
        );
        $this->layout->buffer('content', 'persons/form');
        $this->layout->render();
    }
    public function view($person_id)
    {
        $this->layout->buffer('content','person/view');
    }

    public function delete($person_id)
    {
        $this->person_model->delete($person_id);
        redirect('persons');
    }
    public function insert()
    {
        $data=array(
            'person_active'=>$this->input->post('person_active')=='1'?1:0,
            'title'=>$this->input->post('title'),
            'first_name'=>$this->input->post('first_name'),
            'middle_name'=>$this->input->post('middle_name'),
            'last_name'=>$this->input->post('last_name'),
            'birthday'=>$this->input->post('Birthday'),
            'birth_place'=>$this->input->post('Birth_Place'),
            'nationality'=>$this->input->post('Nationality'),
            'language_known'=>$this->input->post('Language_known')!=NULL?implode(',',$this->input->post('Language_known')):"",
            'gender'=>$this->input->post('gender'),
            'home_no'=>$this->input->post('Home_No'),
            'home_address'=>$this->input->post('home_address'),
            'street_address'=>$this->input->post('street_address'),
            'city'=>$this->input->post('City'),
            'country'=>$this->input->post('Country'),
            'zipcode'=>$this->input->post('zipcode'),
            'email_1'=>$this->input->post('Email_1'),
            'email_2'=>$this->input->post('Email_2'),
            'fax'=>$this->input->post('Fax'),
            'mobile'=>$this->input->post('Mobile'),
            'phone_number'=>$this->input->post('phone_number'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_number'=>$this->input->post('account_number'),
            'bic'=>$this->input->post('bic'),
            'swift_code'=>$this->input->post('swift_code'),
            'bank_short_code'=>$this->input->post('bank_short_code'),
            'routing_number'=>$this->input->post('routing_number')

        );

        //Save Record into Database
        $this->person_model->Save($data);

    }
    public function update($id)
    {

        $data=array(
            'person_active'=>$this->input->post('person_active')=='1'?1:0,
            'title'=>$this->input->post('title'),
            'first_name'=>$this->input->post('first_name'),
            'middle_name'=>$this->input->post('middle_name'),
            'last_name'=>$this->input->post('last_name'),
            'birthday'=>$this->input->post('Birthday'),
            'birth_place'=>$this->input->post('Birth_Place'),
            'nationality'=>$this->input->post('Nationality'),
            'language_known'=>$this->input->post('Language_known')!=NULL?implode(',',$this->input->post('Language_known')):"",
            'gender'=>$this->input->post('gender'),
            'home_no'=>$this->input->post('Home_No'),
            'home_address'=>$this->input->post('home_address'),
            'street_address'=>$this->input->post('street_address'),
            'city'=>$this->input->post('City'),
            'country'=>$this->input->post('Country'),
            'zipcode'=>$this->input->post('zipcode'),
            'email_1'=>$this->input->post('Email_1'),
            'email_2'=>$this->input->post('Email_2'),
            'fax'=>$this->input->post('Fax'),
            'mobile'=>$this->input->post('Mobile'),
            'phone_number'=>$this->input->post('phone_number'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_number'=>$this->input->post('account_number'),
            'bic'=>$this->input->post('bic'),
            'swift_code'=>$this->input->post('swift_code'),
            'bank_short_code'=>$this->input->post('bank_short_code'),
            'routing_number'=>$this->input->post('routing_number')

        );
        $this->person_model->update($data,$id);
    }

}

