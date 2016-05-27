<?php
        if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class Persons extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('person_model');
        $this->load->model('mdl_person_category');
        $this->load->model('categories/category_model');
        $this->load->model('client_persons/mdl_client_persons');
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
        //load country
        $this->load->helper('country');

        //get category list

        $categories= $this->category_model->all();


        if($this->input->post('btn_cancel'))
        {
            redirect('persons');
        }


        if($id!="" or $id != NULL)
        {
            $person_id=$id;
            $id=array('id'=>$id);
            $result=$this->person_model->edit($id);
            //get category by person selected

            $person_category=$this->mdl_person_category->get_category($person_id);

            $this->layout->set(
                array(
                    'record'=>$result,
                    'person_category'=>$person_category
                )
            );

        }
        if($this->input->post('btn_submit'))
        {

            if($id!="" || $id != NULL)
            {
                if($this->person_model->run_validation() and $this->mdl_person_category->run_validation())
                {
                    $this->update($this->input->post('is_update'));

                    $category=$this->input->post('category');
                    foreach ($category as $key => $value)
                    {
                        $data[]=array(
                            'person_id'=>$person_id,
                            'category_id'=>$value
                        );
                            $personid=array(
                            'person_id'=>$person_id
                        );


                    }
                    //print_r($data);
                    $this->mdl_person_category->Update($personid,$data);
                    
                    redirect('persons/view/'.$person_id);
                }


            }
            else
            {
                if($this->person_model->run_validation() and $this->mdl_person_category->run_validation())
                {

                    $userId=$this->insert();
                    $category=$this->input->post('category');
                    foreach ($category as $key => $value)
                    {
                        $data[]=array(
                            'person_id'=>$userId,
                            'category_id'=>$value
                        );
                    }
                    $this->mdl_person_category->Save($data);
                    redirect('persons/view/'.$userId);
                }

            }

        }
        $this->layout->set(
            array(
                'countries' => get_country_list(lang('cldr')),
                'categories'=>$categories

            )
        );
        $this->layout->buffer('content', 'persons/form');
        $this->layout->render();
    }
    public function view($person_id)
    {
        $this->load->model('client_persons/mdl_client_persons');
        $clients=$this->mdl_client_persons->get_client_detail($person_id);


        $person_id=array('id'=>$person_id);
        $persons=$this->person_model->edit($person_id);

        $this->layout->set(
            array(
                    'persons'=>$persons,
                    'clients'=>$clients,
                 )
        );

          $this->layout->buffer(
                            array(
                                array(
                                    'client_person_table',
                                    'persons/partial_person_client_table'
                                ),
                                array(
                                    'content',
                                    'persons/view'
                                ),
                            )

          );
          $this->layout->render();

    }
    public function clientEdit($person_id,$client_id)
    {
        $this->load->model('clients/mdl_clients');

        $this->load->model('client_persons/mdl_client_persons');


        if($this->input->post('btn_submit'))
        {
            if($this->mdl_client_persons->run_validation())
            {
                $data=array(
                    'client_id'=>$this->input->post('client_id'),
                    'person_id'=>$this->input->post('person_id'),
                    'telephone_number'=>$this->input->post('telephone_number'),
                    'mobile_number'=>$this->input->post('mobile_number'),
                    'email'=>$this->input->post('email'),
                    'fax'=>$this->input->post('fax'),
                    'office_address'=>$this->input->post('office_address')
                );
                $this->mdl_client_persons->update($data,$person_id,$client_id);
                redirect('persons/view/'.$person_id);
            }
        }
        if ($this->input->post('btn_cancel')) {


            redirect('persons/view/'.$person_id);


        }




        $person=$this->mdl_client_persons->edit($person_id,$client_id);

        $this->layout->set(
            array(
                'records'   => $person,
                'clients'   => $this->mdl_clients->get()->result(),
                'persons'   =>$this->person_model->All()

            )
        );
        $this->layout->buffer('content', 'persons/person_client');
        $this->layout->render();
    }
    public function clientDelete($person_id,$client_id)
    {
        $this->load->model('client_persons/mdl_client_persons');
        $this->load->mdl_client_persons->delete($person_id,$client_id);
        redirect('persons/view/'.$person_id);
    }

    public function delete($person_id)
    {
        $this->person_model->delete($person_id);
        $this->mdl_client_persons->MultipleDelete_person($person_id); //delete from client_persons table
        $this->mdl_person_category->Delete_person_category($person_id); //delete from person_category Table

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
        $user_Id=$this->person_model->Save($data);
        return $user_Id;

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

