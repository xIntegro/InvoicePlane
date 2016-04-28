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
 * @license		http://xintegro.de/license.txt
 * @link		http://xintegro.de/
 * 
 */

class Guest extends Guest_Controller
{
    public function index()
    {
        $this->load->model('quotes/mdl_quotes');
        $this->load->model('invoices/mdl_invoices');

        $this->layout->set(
            array(
                'overdue_invoices' => $this->mdl_invoices->is_overdue()->where_in('xc_invoices.client_id', $this->user_clients)->get()->result(),
                'open_quotes' => $this->mdl_quotes->is_open()->where_in('xc_quotes.client_id', $this->user_clients)->get()->result(),
                'open_invoices' => $this->mdl_invoices->is_open()->where_in('xc_invoices.client_id', $this->user_clients)->get()->result()
            )
        );

        $this->layout->buffer('content', 'guest/index');
        $this->layout->render('layout_guest');
    }

}
