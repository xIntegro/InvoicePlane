<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Xintegrocore
 * 
 * A free and open source web based invoicing system
 *
 * @package		xintegrocore
 * @author		xintegro (xintegro.de)
 * @copyright	Copyright (c) 2012 - 2015 xintegro.de
 * @license		https://xintegro.de/license.txt
 * @link		https://xintegro.de
 * 
 */

class Mdl_Invoice_Tax_Rates extends Response_Model
{
    public $table = 'xc_invoice_tax_rates';
    public $primary_key = 'xc_invoice_tax_rates.invoice_tax_rate_id';

    public function default_select()
    {
        $this->db->select('xc_tax_rates.tax_rate_name AS invoice_tax_rate_name');
        $this->db->select('xc_tax_rates.tax_rate_percent AS invoice_tax_rate_percent');
        $this->db->select('xc_invoice_tax_rates.*');
    }

    public function default_join()
    {
        $this->db->join('xc_tax_rates', 'xc_tax_rates.tax_rate_id = xc_invoice_tax_rates.tax_rate_id');
    }

    public function save($id = NULL, $db_array = NULL)
    {
        parent::save($id, $db_array);

        $this->load->model('invoices/mdl_invoice_amounts');

        $invoice_id = $this->input->post('invoice_id');
        
        if ($invoice_id) {
            $this->mdl_invoice_amounts->calculate($invoice_id);
        }
    }

    public function validation_rules()
    {
        return array(
            'invoice_id' => array(
                'field' => 'invoice_id',
                'label' => lang('invoice'),
                'rules' => 'required'
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => lang('tax_rate'),
                'rules' => 'required'
            ),
            'include_item_tax' => array(
                'field' => 'include_item_tax',
                'label' => lang('tax_rate_placement'),
                'rules' => 'required'
            )
        );
    }

}
