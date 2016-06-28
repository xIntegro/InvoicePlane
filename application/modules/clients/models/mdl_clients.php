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

class Mdl_Clients extends Response_Model
{
    public $table = 'xc_clients';
    public $primary_key = 'xc_clients.client_id';
    public $date_created_field = 'client_date_created';
    public $date_modified_field = 'client_date_modified';


    public function default_select()
    {

        $this->db->select('SQL_CALC_FOUND_ROWS xc_client_custom.*, xc_clients.*', false);
    }

    public function default_join()
    {
        $this->db->join('xc_client_custom', 'xc_client_custom.client_id = xc_clients.client_id', 'left');
    }

    public function default_order_by()
    {
        $this->db->order_by('xc_clients.client_name');
    }

    public function validation_rules()
    {
        return array(
            'client_name' => array(
                'field' => 'client_name',
                'label' => lang('client_name'),
                'rules' => 'required'
            ),
            'client_active' => array(
                'field' => 'client_active'
            ),
            'client_address_1' => array(
                'field' => 'client_address_1'
            ),
            'client_address_2' => array(
                'field' => 'client_address_2'
            ),
            'client_city' => array(
                'field' => 'client_city'
            ),
            'client_state' => array(
                'field' => 'client_state'
            ),
            'client_zip' => array(
                'field' => 'client_zip'
            ),
            'client_country' => array(
                'field' => 'client_country'
            ),
            'client_phone' => array(
                'field' => 'client_phone'
            ),
            'client_fax' => array(
                'field' => 'client_fax'
            ),
            'client_mobile' => array(
                'field' => 'client_mobile'
            ),
            'client_email' => array(
                'field' => 'client_email'
            ),
            'client_web' => array(
                'field' => 'client_web'
            ),
            'client_vat_id' => array(
                'field' => 'user_vat_id'
            ),
            'client_tax_code' => array(
                'field' => 'user_tax_code'
            )
        );
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        if (!isset($db_array['client_active'])) {
            $db_array['client_active'] = 0;
        }

        return $db_array;
    }


    public function delete($id)
    {
        parent::delete($id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    /**
     * Returns client_id of existing or new record
     */
    public function client_lookup($client_name)
    {
        $client = $this->mdl_clients->where('client_name', $client_name)->get();

        if ($client->num_rows()) {
            $client_id = $client->row()->client_id;
        } else {
            $db_array = array(
                'client_name' => $client_name
            );

            $client_id = parent::save(null, $db_array);
        }

        return $client_id;
    }

    public function with_total()
    {
        $this->filter_select('IFNULL((SELECT SUM(invoice_total) FROM xc_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM xc_invoices WHERE xc_invoices.client_id = xc_clients.client_id)), 0) AS client_invoice_total',
            false);
        return $this;
    }

    public function with_total_paid()
    {
        $this->filter_select('IFNULL((SELECT SUM(invoice_paid) FROM xc_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM xc_invoices WHERE xc_invoices.client_id = xc_clients.client_id)), 0) AS client_invoice_paid',
            false);
        return $this;
    }

    public function with_total_balance()
    {

        $this->filter_select('IFNULL((SELECT SUM(invoice_balance) FROM xc_invoice_amounts WHERE invoice_id IN (SELECT invoice_id FROM xc_invoices WHERE xc_invoices.client_id = xc_clients.client_id)), 0) AS client_invoice_balance',
            false);
        return $this;
    }

    public function is_active()
    {
        $this->filter_where('client_active', 1);
        return $this;
    }

    public function is_inactive()
    {
        $this->filter_where('client_active', 0);
        return $this;
    }

}
