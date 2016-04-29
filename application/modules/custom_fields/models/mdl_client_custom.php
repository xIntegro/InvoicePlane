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

class Mdl_Client_Custom extends MY_Model
{
    public $table = 'xc_client_custom';
    public $primary_key = 'xc_client_custom.client_custom_id';

    public function save_custom($client_id, $db_array)
    {
        $client_custom_id = NULL;

        $db_array['client_id'] = $client_id;

        $client_custom = $this->where('client_id', $client_id)->get();

        if ($client_custom->num_rows()) {
            $client_custom_id = $client_custom->row()->client_custom_id;
        }

        parent::save($client_custom_id, $db_array);
    }

}
