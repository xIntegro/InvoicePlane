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
class Mdl_User_Clients extends MY_Model
{
    public $table = 'xc_user_clients';
    public $primary_key = 'xc_user_clients.user_client_id';

    public function default_select()
    {
        $this->db->select('xc_user_clients.*, xc_users.user_name, xc_clients.client_name');
    }

    public function default_join()
    {
        $this->db->join('xc_users', 'xc_users.user_id = xc_user_clients.user_id');
        $this->db->join('xc_clients', 'xc_clients.client_id = xc_user_clients.client_id');
    }

    public function default_order_by()
    {
        $this->db->order_by('xc_clients.client_name');
    }

    public function assigned_to($user_id)
    {
        $this->filter_where('xc_user_clients.user_id', $user_id);
        return $this;
    }

}
