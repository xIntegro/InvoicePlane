<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
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
class Continuous extends Admin_Controller
{
    /**
     * Continuous constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('mdl_invoices_continuous');
    }

    /**
     * @param int $page
     */
    public function index($page = 0)
    {
        $this->mdl_invoices_continuous->paginate(site_url('invoices/continuous'), $page);
        $recurring_invoices = $this->mdl_invoices_continuous->result();

        $this->layout->set('recur_frequencies', $this->mdl_invoices_continuous->recur_frequencies);
        $this->layout->set('continuous_invoices', $recurring_invoices);
        $this->layout->buffer('content', 'invoices/index_continuous');
        $this->layout->render();
    }

    /**
     * @param integer $invoice_recurring_id
     */
    public function stop($invoice_recurring_id)
    {
        $this->mdl_invoices_continuous->stop($invoice_recurring_id);
        redirect('invoices/continuous/index');
    }

    public function delete($invoice_recurring_id)
    {
        $this->mdl_invoice_continuous->delete($invoice_recurring_id);
        redirect('invoices/continuous/index');
    }

}
