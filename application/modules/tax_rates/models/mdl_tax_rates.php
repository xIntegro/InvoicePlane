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

class Mdl_Tax_Rates extends Response_Model
{
    public $table = 'xc_tax_rates';
    public $primary_key = 'xc_tax_rates.tax_rate_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('xc_tax_rates.tax_rate_percent');
    }

    public function validation_rules()
    {
        return array(
            'tax_rate_name' => array(
                'field' => 'tax_rate_name',
                'label' => lang('tax_rate_name'),
                'rules' => 'required'
            ),
            'tax_rate_percent' => array(
                'field' => 'tax_rate_percent',
                'label' => lang('tax_rate_percent'),
                'rules' => 'required'
            )
        );
    }

}
