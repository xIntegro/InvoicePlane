<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
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
class Clients extends Admin_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('mdl_clients');
        $this->load->model('categories/category_model');
        $this->load->model('mdl_client_category');
        $this->load->model('client_persons/mdl_client_persons');
    }

    public function index()
    {
        // Display active clients by default
        redirect('clients/status/active');
    }

    public function status($status = 'active', $page = 0)
    {
        if (is_numeric(array_search($status, array('active', 'inactive')))) {
            $function = 'is_' . $status;
            $this->mdl_clients->$function();
        }

        $this->mdl_clients->with_total_balance()->paginate(site_url('clients/status/' . $status), $page);
        $clients = $this->mdl_clients->result();

        $this->layout->set(
            array(
                'records'            => $clients,
                'filter_display'     => TRUE,
                'filter_placeholder' => lang('filter_clients'),
                'filter_method'      => 'filter_clients'
            )
        );

        $this->layout->buffer('content', 'clients/index');
        $this->layout->render();
    }

    public function form($id = NULL)
    {
        //get category list

        $categories= $this->category_model->all();

        if ($this->input->post('btn_cancel')) {
            redirect('clients');
        }

        // Set validation rule based on is_update
        if ($this->input->post('is_update') == 0 && $this->input->post('client_name') != '') {
            $check = $this->db->get_where('xc_clients', array('client_name' => $this->input->post('client_name')))->result();
            if (!empty($check)) {
                $this->session->set_flashdata('alert_error', lang('client_already_exists'));
                redirect('clients/form');
            }
        }

        if ($this->mdl_clients->run_validation() and $this->mdl_client_category->run_validation()) {
            $id = $this->mdl_clients->save($id);

            // insert category into xc_client_category Table;
            $category=$this->input->post('category');
            foreach ($category as $key => $value)
            {
                $data[]=array(
                    'client_id'=>$id,
                    'category_id'=>$value
                );
            }
            $this->mdl_client_category->Update($id,$data);

            $this->load->model('custom_fields/mdl_client_custom');

            $this->mdl_client_custom->save_custom($id, $this->input->post('custom'));

            redirect('clients/view/' . $id);
        }

        if ($id and !$this->input->post('btn_submit')) {
            if (!$this->mdl_clients->prep_form($id)) {
                show_404();
            }

            $this->load->model('custom_fields/mdl_client_custom');
            $this->mdl_clients->set_form_value('is_update', true);

            $client_custom = $this->mdl_client_custom->where('client_id', $id)->get();

            //get category for particular client
            $client_category=$this->mdl_client_category->get_category($id);



            if ($client_custom->num_rows()) {
                $client_custom = $client_custom->row();

                unset($client_custom->client_id, $client_custom->client_custom_id);

                foreach ($client_custom as $key => $val) {
                    $this->mdl_clients->set_form_value('custom[' . $key . ']', $val);
                }
            }
        } elseif ($this->input->post('btn_submit')) {
            if ($this->input->post('custom')) {
                foreach ($this->input->post('custom') as $key => $val) {
                    $this->mdl_clients->set_form_value('custom[' . $key . ']', $val);
                }
            }
        }

        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->helper('country');

        $this->layout->set('client_category',$client_category);
        $this->layout->set('categories',$categories);
        $this->layout->set('custom_fields', $this->mdl_custom_fields->by_table('xc_client_custom')->get()->result());
        $this->layout->set('countries', get_country_list(lang('cldr')));
        $this->layout->set('selected_country', $this->mdl_clients->form_value('client_country') ?: $this->mdl_settings->setting('default_country'));

        $this->layout->buffer('content', 'clients/form');
        $this->layout->render();
    }

    public function view($client_id)
    {
        $this->load->model('clients/mdl_client_notes');
        $this->load->model('invoices/mdl_invoices');
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('payments/mdl_payments');
        $this->load->model('custom_fields/mdl_custom_fields');
        $this->load->model('client_persons/mdl_client_persons');

        $client = $this->mdl_clients->with_total()->with_total_balance()->with_total_paid()->where('xc_clients.client_id', $client_id)->get()->row();
        $persons=$this->mdl_client_persons->get_person_detail($client_id);

        if (!$client) {
            show_404();
        }

        $this->layout->set(array(
                'client'           => $client,
                'client_notes'     => $this->mdl_client_notes->where('client_id', $client_id)->get()->result(),
                'client_persons'    => $persons,
                'invoices'         => $this->mdl_invoices->by_client($client_id)->limit(20)->get()->result(),
                'quotes'           => $this->mdl_quotes->by_client($client_id)->limit(20)->get()->result(),
                'payments'         => $this->mdl_payments->by_client($client_id)->limit(20)->get()->result(),
                'custom_fields'    => $this->mdl_custom_fields->by_table('xc_client_custom')->get()->result(),
                'quote_statuses'   => $this->mdl_quotes->statuses(),
                'invoice_statuses' => $this->mdl_invoices->statuses(),

            )
        );

        $this->layout->buffer(
            array(
                array(
                    'client_person_table',
                    'client_persons/partial_client_person_table'
                ),
                array(
                    'invoice_table',
                    'invoices/partial_invoice_table'
                ),
                array(
                    'quote_table',
                    'quotes/partial_quote_table'
                ),
                array(
                    'payment_table',
                    'payments/partial_payment_table'
                ),
                array(
                    'partial_notes',
                    'clients/partial_notes'
                ),
                array(
                    'content',
                    'clients/view'
                ),

            )
        );

        $this->layout->render();
    }

    public function delete($client_id)
    {
        $this->mdl_clients->delete($client_id);
        $this->mdl_client_category->MultipleDelete($client_id);
        $this->mdl_client_persons->MultipleDelete($client_id);
        redirect('clients');
    }
    public function personDelete($person_id,$client_id)
    {
        $this->load->model('client_persons/mdl_client_persons');
        $this->load->mdl_client_persons->delete($person_id,$client_id);
        redirect('clients/view/'.$client_id);
    }
    public function personedit($person_id,$client_id)
    {
        $this->load->model('clients/mdl_clients');
        $this->load->model('persons/person_model');

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
                redirect('clients/view/'.$client_id);
            }
        }
        if ($this->input->post('btn_cancel')) {

                redirect('clients/view/'.$client_id);
        }




        $person=$this->mdl_client_persons->edit($person_id,$client_id);

        $this->layout->set(
        array(
            'records'   => $person,
            'clients'   => $this->mdl_clients->get()->result(),
            'persons'   =>$this->person_model->All()

        )
    );
        $this->layout->buffer('content', 'clients/client_person');
        $this->layout->render();
    }


}
