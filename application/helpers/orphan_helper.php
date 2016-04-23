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

function delete_orphans()
{
    $CI =& get_instance();

    $queries = array(
        'DELETE FROM xc_invoices WHERE client_id NOT IN (SELECT client_id FROM xc_clients)',
        'DELETE FROM xc_quotes WHERE client_id NOT IN (SELECT client_id FROM xc_clients)',
        'DELETE FROM xc_invoice_amounts WHERE invoice_id NOT IN (SELECT invoice_id FROM xc_invoices)',
        'DELETE FROM xc_quote_amounts WHERE quote_id NOT IN (SELECT quote_id FROM xc_quotes)',
        'DELETE FROM xc_payments WHERE invoice_id NOT IN (SELECT invoice_id FROM xc_invoices)',
        'DELETE FROM xc_client_custom WHERE client_id NOT IN (SELECT client_id FROM xc_clients)',
        'DELETE FROM xc_invoice_custom WHERE invoice_id NOT IN (SELECT invoice_id FROM xc_invoices)',
        'DELETE FROM xc_user_custom WHERE user_id NOT IN (SELECT user_id FROM xc_users)',
        'DELETE FROM xc_payment_custom WHERE payment_id NOT IN (SELECT payment_id FROM xc_payments)',
        'DELETE FROM xc_quote_custom WHERE quote_id NOT IN (SELECT quote_id FROM xc_quotes)',
        'DELETE FROM xc_invoice_items WHERE invoice_id NOT IN (SELECT invoice_id FROM xc_invoices)',
        'DELETE FROM xc_invoice_item_amounts WHERE item_id NOT IN (SELECT item_id FROM xc_invoice_items)',
        'DELETE FROM xc_quote_items WHERE quote_id NOT IN (SELECT quote_id FROM xc_quotes)',
        'DELETE FROM xc_quote_item_amounts WHERE item_id NOT IN (SELECT item_id FROM xc_quote_items)',
        'DELETE FROM xc_client_notes WHERE client_id NOT IN (SELECT client_id FROM xc_clients)'
    );

    foreach ($queries as $query) {
        $CI->db->query($query);
    }
}
