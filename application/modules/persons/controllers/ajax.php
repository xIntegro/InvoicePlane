<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Ajax extends Admin_Controller
{
    public $ajax_controller = TRUE;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('client_persons/mdl_client_persons');
    }


    public function modal_create_client()
    {
        $this->load->module('layout');

        $this->load->model('clients/mdl_clients');
        $this->load->model('person_model');



        $data=array(

            'clients' => $this->mdl_clients->get()->result(),
            'person_name' => $this->input->post('person_name'),
            'persons'=>$this->person_model->All()
        );

        $this->layout->load_view('persons/modal_create_clients',$data);

    }
    public function form($client_id)
    {

        $this->load->module('layout');

        $this->layout->load_view('client_persons/form',$client_id);


    }
    public function create()
    {
        if($this->mdl_client_persons->run_validation())
        {
            if($this->mdl_client_persons->person_exist($this->input->post('client_name'),$this->input->post('person_id')))
            {
                $response=array(
                    'success'=>2
                );
            }
            else
            {
                $inputs=array(
                    'client_id'=>$this->input->post('client_name'),
                    'person_id'=>$this->input->post('person_id'),
                    'telephone_number'=>$this->input->post('telephone_number'),
                    'mobile_number'=>$this->input->post('mobile_number'),
                    'email'=>$this->input->post('email'),
                    'fax'=>$this->input->post('fax'),
                    'office_address'=>$this->input->post('office_address')
                );
                $this->mdl_client_persons->save($inputs);
                $response=array(
                    'success'=>1
                );

            }
        }
        else
        {
            $this->load->helper('json_error');
            $response = array(
                'success' => 0,
                'validation_errors' => json_errors()
            );
        }
        echo json_encode($response);

    }



}