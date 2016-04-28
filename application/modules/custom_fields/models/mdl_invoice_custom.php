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

class Mdl_Invoice_Custom extends MY_Model
{
    public $table = 'xc_invoice_custom';
    public $primary_key = 'xc_invoice_custom.invoice_custom_id';

    public function save_custom($invoice_id, $db_array)
    {
        $invoice_custom_id = NULL;

        $db_array['invoice_id'] = $invoice_id;

        $invoice_custom = $this->where('invoice_id', $invoice_id)->get();

        if ($invoice_custom->num_rows()) {
            $invoice_custom_id = $invoice_custom->row()->invoice_custom_id;
        }

        parent::save($invoice_custom_id, $db_array);
    }

}
