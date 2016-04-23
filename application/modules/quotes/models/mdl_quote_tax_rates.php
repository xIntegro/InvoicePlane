<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 * Xintegrocore
 * 
 * A free and open source web based invoicing system
 *
 * @package		xintegrocore
 * @author		dhaval (www.codeembassy.in	)
 * @copyright	Copyright (c) 2012 - 2015 xintegrocore.com
 * @license		https://xintegrocore.com/license.txt
 * @link		https://xintegrocore.com
 * 
 */

class Mdl_Quote_Tax_Rates extends Response_Model
{
    public $table = 'xc_quote_tax_rates';
    public $primary_key = 'xc_quote_tax_rates.quote_tax_rate_id';

    public function default_select()
    {
        $this->db->select('xc_tax_rates.tax_rate_name AS quote_tax_rate_name');
        $this->db->select('xc_tax_rates.tax_rate_percent AS quote_tax_rate_percent');
        $this->db->select('xc_quote_tax_rates.*');
    }

    public function default_join()
    {
        $this->db->join('xc_tax_rates', 'xc_tax_rates.tax_rate_id = xc_quote_tax_rates.tax_rate_id');
    }

    public function save($id = NULL, $db_array = NULL)
    {
        parent::save($id, $db_array);

        $this->load->model('quotes/mdl_quote_amounts');
        
        $quote_id = $this->input->post('quote_id');
        
        if ($quote_id) {
            $this->mdl_quote_amounts->calculate($quote_id);
        }
    }

    public function validation_rules()
    {
        return array(
            'quote_id' => array(
                'field' => 'quote_id',
                'label' => lang('quote'),
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
