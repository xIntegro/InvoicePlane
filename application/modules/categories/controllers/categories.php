<?php
    if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Categories extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('category_model');
        $this->load->model('persons/mdl_person_category');
        $this->load->model('clients/mdl_client_category');
        $this->load->library("pagination");
    }
        public function index()
    {
        redirect('categories/status/all');
    }
    public function status($status='all',$page=0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->category_model->$function();
        }

        $this->category_model->paginate(site_url('categories/status/' . $status), $page);
        $data = $this->category_model->result();

        $this->layout->set(
            array(
                'records'   =>  $data,
                'filter_display'     => TRUE,
                'filter_placeholder' => lang('filter_categories'),
                'filter_method'      => 'filter_persons'
            )

        );
        $this->layout->buffer('content', 'categories/index');
        $this->layout->render();
    }
    public function form($id=NULL)
    {
        if($this->input->post('btn_cancel'))
        {
            redirect('categories');
        }
        if($id!="" or $id != NULL)
        {
            $id=array('id'=>$id);
            $result=$this->category_model->edit($id);
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
                if($this->category_model->run_validation())
                {
                    $data=array(
                        'category_name'=>$this->input->post('category_name'),
                        'is_active'=>$this->input->post('is_active')=='1'?1:0,
                    );
                    $this->category_model->update($data,$this->input->post('is_update'));


                    $this->session->set_flashdata('alert_success', lang('category_updated'));
                    redirect('categories');
                }


            }
            else
            {
                if($this->category_model->run_validation())
                {
                    if($this->category_model->category_Exist($this->input->post('category_name')))
                    {
                        $this->session->set_flashdata('alert_error', lang('category_already_exists'));
                        redirect('categories/form');
                    }
                    else
                    {
                        $data=array(
                            'category_name'=>$this->input->post('category_name'),
                            'is_active'=>$this->input->post('is_active')=='1'?1:0,
                        );
                        $this->category_model->Save($data);
                        $this->session->set_flashdata('alert_success', lang('category_saved'));
                    }

                    redirect('categories');
                }

            }

        }


        $this->layout->buffer('content', 'categories/form');
        $this->layout->render();
    }
    public function delete($id)
    {
        $this->category_model->delete($id); //delete main category
        $this->mdl_person_category->Delete_category_person($id); //delete category from category_person
        $this->mdl_client_category->Delete_category_client($id); //delete category from category_Client
        redirect('categories');
    }
}