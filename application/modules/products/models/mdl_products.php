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

class Mdl_Products extends Response_Model
{
    public $table = 'xc_products';
    public $primary_key = 'xc_products.product_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('xc_families.family_name, xc_products.product_name');
    }

    public function default_join()
    {
        $this->db->join('xc_families', 'xc_families.family_id = xc_products.family_id', 'left');
        $this->db->join('xc_tax_rates', 'xc_tax_rates.tax_rate_id = xc_products.tax_rate_id', 'left');
    }

    public function by_product($match)
    {
        $this->db->like('product_sku', $match);
        $this->db->or_like('product_name', $match);
        $this->db->or_like('product_description', $match);
    }

    public function validation_rules()
    {
        return array(
            'product_sku' => array(
                'field' => 'product_sku',
                'label' => lang('product_sku'),
                'rules' => 'required'
            ),
            'product_name' => array(
                'field' => 'product_name',
                'label' => lang('product_name'),
                'rules' => 'required'
            ),
            'product_description' => array(
                'field' => 'product_description',
                'label' => lang('product_description'),
                'rules' => ''
            ),
            'product_price' => array(
                'field' => 'product_price',
                'label' => lang('product_price'),
                'rules' => 'required'
            ),
            'purchase_price' => array(
                'field' => 'purchase_price',
                'label' => lang('purchase_price'),
                'rules' => ''
            ),
            'family_id' => array(
                'field' => 'family_id',
                'label' => lang('family'),
                'rules' => 'numeric'
            ),
            'tax_rate_id' => array(
                'field' => 'tax_rate_id',
                'label' => lang('tax_rate'),
                'rules' => 'numeric'
            ),

        );
    }

}
