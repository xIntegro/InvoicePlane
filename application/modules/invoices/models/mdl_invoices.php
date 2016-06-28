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

class Mdl_Invoices extends Response_Model
{
    public $table = 'xc_invoices';
    public $primary_key = 'xc_invoices.invoice_id';
    public $date_modified_field = 'invoice_date_modified';
    
    public function __construct()
    {
        $this->defaultDB = $this->load->database('default', true);
        $this->defaultDBName=$this->defaultDB->database;
        
    }

    public function statuses()
    {
        return array(
            '1' => array(
                'label' => lang('draft'),
                'class' => 'draft',
                'href' => 'invoices/status/draft'
            ),
            '2' => array(
                'label' => lang('sent'),
                'class' => 'sent',
                'href' => 'invoices/status/sent'
            ),
            '3' => array(
                'label' => lang('viewed'),
                'class' => 'viewed',
                'href' => 'invoices/status/viewed'
            ),
            '4' => array(
                'label' => lang('paid'),
                'class' => 'paid',
                'href' => 'invoices/status/paid'
            )
        );
    }

    public function default_select()
    {
        
        $this->db->select("
            SQL_CALC_FOUND_ROWS xc_invoice_custom.*,
            xc_client_custom.*,
            $this->defaultDBName.xc_user_custom.*,
            $this->defaultDBName.xc_users.user_name,
			$this->defaultDBName.xc_users.user_company,
			$this->defaultDBName.xc_users.user_address_1,
			$this->defaultDBName.xc_users.user_address_2,
			$this->defaultDBName.xc_users.user_city,
			$this->defaultDBName.xc_users.user_state,
			$this->defaultDBName.xc_users.user_zip,
			$this->defaultDBName.xc_users.user_country,
			$this->defaultDBName.xc_users.user_phone,
			$this->defaultDBName.xc_users.user_fax,
			$this->defaultDBName.xc_users.user_mobile,
			$this->defaultDBName.xc_users.user_email,
			$this->defaultDBName.xc_users.user_web,
			$this->defaultDBName.xc_users.user_vat_id,
			$this->defaultDBName.xc_users.user_tax_code,
			xc_clients.*,
			xc_invoice_amounts.invoice_amount_id,
			IFNULL(xc_invoice_amounts.invoice_item_subtotal, '0.00') AS invoice_item_subtotal,
			IFNULL(xc_invoice_amounts.invoice_item_tax_total, '0.00') AS invoice_item_tax_total,
			IFNULL(xc_invoice_amounts.invoice_tax_total, '0.00') AS invoice_tax_total,
			IFNULL(xc_invoice_amounts.invoice_total, '0.00') AS invoice_total,
			IFNULL(xc_invoice_amounts.invoice_paid, '0.00') AS invoice_paid,
			IFNULL(xc_invoice_amounts.invoice_balance, '0.00') AS invoice_balance,
			xc_invoice_amounts.invoice_sign AS invoice_sign,
            (CASE WHEN xc_invoices.invoice_status_id NOT IN (1,4) AND DATEDIFF(NOW(), invoice_date_due) > 0 THEN 1 ELSE 0 END) is_overdue,
			DATEDIFF(NOW(), invoice_date_due) AS days_overdue,
            (CASE (SELECT COUNT(*) FROM xc_invoices_recurring WHERE xc_invoices_recurring.invoice_id = xc_invoices.invoice_id and xc_invoices_recurring.recur_next_date <> '0000-00-00') WHEN 0 THEN 0 ELSE 1 END) AS invoice_is_recurring,
			xc_invoices.*", FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('xc_invoices.invoice_id DESC');
    }

    public function default_join()
    {
        $this->db->join('xc_clients', 'xc_clients.client_id = xc_invoices.client_id');
        $this->db->join($this->defaultDBName.'.xc_users', $this->defaultDBName.'.xc_users.user_id = xc_invoices.user_id');
        $this->db->join('xc_invoice_amounts', 'xc_invoice_amounts.invoice_id = xc_invoices.invoice_id', 'left');
        $this->db->join('xc_client_custom', 'xc_client_custom.client_id = xc_clients.client_id', 'left');
        $this->db->join($this->defaultDBName.'.xc_user_custom', $this->defaultDBName.'.xc_user_custom.user_id = xc_users.user_id', 'left');
        $this->db->join('xc_invoice_custom', 'xc_invoice_custom.invoice_id = xc_invoices.invoice_id', 'left');
    }

    public function validation_rules()
    {
        return array(
            'client_name' => array(
                'field' => 'client_name',
                'label' => lang('client'),
                'rules' => 'required'
            ),
            'invoice_date_created' => array(
                'field' => 'invoice_date_created',
                'label' => lang('invoice_date'),
                'rules' => 'required'
            ),
            'invoice_time_created' => array(
                'rules' => 'required'
            ),
            'invoice_group_id' => array(
                'field' => 'invoice_group_id',
                'label' => lang('invoice_group'),
                'rules' => 'required'
            ),
            'invoice_password' => array(
                'field' => 'invoice_password',
                'label' => lang('invoice_password')
            ),
            'user_id' => array(
                'field' => 'user_id',
                'label' => lang('user'),
                'rule' => 'required'
            ),
            'payment_method' => array(
                'field' => 'payment_method',
                'label' => lang('payment_method')
            ),
        );
    }

    public function validation_rules_save_invoice()
    {
        return array(
            'invoice_number' => array(
                'field' => 'invoice_number',
                'label' => lang('invoice') . ' #',
                'rules' => 'required|is_unique[xc_invoices.invoice_number' . (($this->id) ? '.invoice_id.' . $this->id : '') . ']'
            ),
            'invoice_date_created' => array(
                'field' => 'invoice_date_created',
                'label' => lang('date'),
                'rules' => 'required'
            ),
            'invoice_date_due' => array(
                'field' => 'invoice_date_due',
                'label' => lang('due_date'),
                'rules' => 'required'
            ),
            'invoice_time_created' => array(
                'rules' => 'required'
            ),
            'invoice_password' => array(
                'field' => 'invoice_password',
                'label' => lang('invoice_password')
            )
        );
    }

    public function create($db_array = NULL, $include_invoice_tax_rates = TRUE)
    {

        $invoice_id = parent::save(NULL, $db_array);

        // Create an invoice amount record
        $db_array = array(
            'invoice_id' => $invoice_id
        );

        $this->db->insert('xc_invoice_amounts', $db_array);

        if ($include_invoice_tax_rates) {
            // Create the default invoice tax record if applicable
            if ($this->mdl_settings->setting('default_invoice_tax_rate')) {
                $db_array = array(
                    'invoice_id' => $invoice_id,
                    'tax_rate_id' => $this->mdl_settings->setting('default_invoice_tax_rate'),
                    'include_item_tax' => $this->mdl_settings->setting('default_include_item_tax'),
                    'invoice_tax_rate_amount' => 0
                );

                $this->db->insert('xc_invoice_tax_rates', $db_array);
            }
        }

        return $invoice_id;
    }

    public function get_url_key()
    {
        $this->load->helper('string');
        return random_string('alnum', 15);
    }

    /**
     * Copies invoice items, tax rates, etc from source to target
     * @param int $source_id
     * @param int $target_id
     */
    public function copy_invoice($source_id, $target_id)
    {
        $this->load->model('invoices/mdl_items');

        $invoice_items = $this->mdl_items->where('invoice_id', $source_id)->get()->result();

        foreach ($invoice_items as $invoice_item) {
            $db_array = array(
                'invoice_id' => $target_id,
                'item_tax_rate_id' => $invoice_item->item_tax_rate_id,
                'item_name' => $invoice_item->item_name,
                'item_description' => $invoice_item->item_description,
                'item_quantity' => $invoice_item->item_quantity,
                'item_price' => $invoice_item->item_price,
                'item_order' => $invoice_item->item_order
            );

            $this->mdl_items->save(NULL, $db_array);
        }

        $invoice_tax_rates = $this->mdl_invoice_tax_rates->where('invoice_id', $source_id)->get()->result();

        foreach ($invoice_tax_rates as $invoice_tax_rate) {
            $db_array = array(
                'invoice_id' => $target_id,
                'tax_rate_id' => $invoice_tax_rate->tax_rate_id,
                'include_item_tax' => $invoice_tax_rate->include_item_tax,
                'invoice_tax_rate_amount' => $invoice_tax_rate->invoice_tax_rate_amount
            );

            $this->mdl_invoice_tax_rates->save(NULL, $db_array);
        }
    }

    /**
     * Copies invoice items, tax rates, etc from source to target
     * @param int $source_id
     * @param int $target_id
     */
    public function copy_credit_invoice($source_id, $target_id)
    {
        $this->load->model('invoices/mdl_items');

        $invoice_items = $this->mdl_items->where('invoice_id', $source_id)->get()->result();

        foreach ($invoice_items as $invoice_item) {
            $db_array = array(
                'invoice_id' => $target_id,
                'item_tax_rate_id' => $invoice_item->item_tax_rate_id,
                'item_name' => $invoice_item->item_name,
                'item_description' => $invoice_item->item_description,
                'item_quantity' => -$invoice_item->item_quantity,
                'item_price' => $invoice_item->item_price,
                'item_order' => $invoice_item->item_order
            );

            $this->mdl_items->save(NULL, $db_array);
        }

        $invoice_tax_rates = $this->mdl_invoice_tax_rates->where('invoice_id', $source_id)->get()->result();

        foreach ($invoice_tax_rates as $invoice_tax_rate) {
            $db_array = array(
                'invoice_id' => $target_id,
                'tax_rate_id' => $invoice_tax_rate->tax_rate_id,
                'include_item_tax' => $invoice_tax_rate->include_item_tax,
                'invoice_tax_rate_amount' => -$invoice_tax_rate->invoice_tax_rate_amount
            );

            $this->mdl_invoice_tax_rates->save(NULL, $db_array);
        }
    }

    public function db_array()
    {
        $db_array = parent::db_array();

        // Get the client id for the submitted invoice
        $this->load->model('clients/mdl_clients');
        $db_array['client_id'] = $this->mdl_clients->client_lookup($db_array['client_name']);
        unset($db_array['client_name']);

        $db_array['invoice_date_created'] = date_to_mysql($db_array['invoice_date_created']);
        $db_array['invoice_date_due'] = $this->get_date_due($db_array['invoice_date_created']);
        $db_array['invoice_number'] = $this->get_invoice_number($db_array['invoice_group_id']);
        $db_array['invoice_terms'] = $this->mdl_settings->setting('default_invoice_terms');

        if (!isset($db_array['invoice_status_id'])) {
            $db_array['invoice_status_id'] = 1;
        }

        // Generate the unique url key
        $db_array['invoice_url_key'] = $this->get_url_key();

        return $db_array;
    }

    public function get_invoice_number($invoice_group_id)
    {
        $this->load->model('invoice_groups/mdl_invoice_groups');
        return $this->mdl_invoice_groups->generate_invoice_number($invoice_group_id);
    }

    public function get_date_due($invoice_date_created)
    {
        $invoice_date_due = new DateTime($invoice_date_created);
        $invoice_date_due->add(new DateInterval('P' . $this->mdl_settings->setting('invoices_due_after') . 'D'));
        return $invoice_date_due->format('Y-m-d');
    }

    public function delete($invoice_id)
    {
        parent::delete($invoice_id);

        $this->load->helper('orphan');
        delete_orphans();
    }

    // Used from the guest module, excludes draft and paid
    public function is_open()
    {
        $this->filter_where_in('invoice_status_id', array(2, 3));
        return $this;
    }

    public function guest_visible()
    {
        $this->filter_where_in('invoice_status_id', array(2, 3, 4));
        return $this;
    }

    public function is_draft()
    {
        $this->filter_where('invoice_status_id', 1);
        return $this;
    }

    public function is_sent()
    {
        $this->filter_where('invoice_status_id', 2);
        return $this;
    }

    public function is_viewed()
    {
        $this->filter_where('invoice_status_id', 3);
        return $this;
    }

    public function is_paid()
    {
        $this->filter_where('invoice_status_id', 4);
        return $this;
    }

    public function is_overdue()
    {
        $this->filter_having('is_overdue', 1);
        return $this;
    }

    public function by_client($client_id)
    {
        $this->filter_where('xc_invoices.client_id', $client_id);
        return $this;
    }

    public function mark_viewed($invoice_id)
    {
        $this->db->select('invoice_status_id');
        $this->db->where('invoice_id', $invoice_id);

        $invoice = $this->db->get('xc_invoices');

        if ($invoice->num_rows()) {
            if ($invoice->row()->invoice_status_id == 2) {
                $this->db->where('invoice_id', $invoice_id);
                $this->db->set('invoice_status_id', 3);
                $this->db->update('xc_invoices');
            }

            // Set the invoice to read-only if feature is not disabled and setting is view
            if ($this->config->item('disable_read_only') == FALSE && $this->mdl_settings->setting('read_only_toggle') == 'viewed') {
                $this->db->where('invoice_id', $invoice_id);
                $this->db->set('is_read_only', 1);
                $this->db->update('xc_invoices');
            }
        }
    }

    public function mark_sent($invoice_id)
    {
        $this->db->select('invoice_status_id');
        $this->db->where('invoice_id', $invoice_id);

        $invoice = $this->db->get('xc_invoices');

        if ($invoice->num_rows()) {
            if ($invoice->row()->invoice_status_id == 1) {
                $this->db->where('invoice_id', $invoice_id);
                $this->db->set('invoice_status_id', 2);
                $this->db->update('xc_invoices');
            }

            // Set the invoice to read-only if feature is not disabled and setting is sent
            if ($this->config->item('disable_read_only') == FALSE && $this->mdl_settings->setting('read_only_toggle') == 'sent') {
                $this->db->where('invoice_id', $invoice_id);
                $this->db->set('is_read_only', 1);
                $this->db->update('xc_invoices');
            }
        }
    }

}
