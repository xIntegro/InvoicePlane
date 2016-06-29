<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

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

    public function __construct()
    {
        $this->defaultDB = $this->load->database('default', true);
        $this->defaultDBName = $this->defaultDB->database;
    }

    public function default_select()
    {
        $this->defaultDB->select("$this->defaultDBName.xc_user_clients.*, $this->defaultDBName.xc_users.user_name, xc_clients.client_name");
    }

    public function default_join()
    {
        $this->defaultDB->join($this->defaultDBName . '.xc_users',
            $this->defaultDBName . '.xc_users.user_id = xc_user_clients.user_id');
        $this->defaultDB->join('xc_clients', 'xc_clients.client_id = xc_user_clients.client_id');
    }

    public function default_order_by()
    {
        $this->defaultDB->order_by('xc_clients.client_name');
    }

    public function assigned_to($user_id)
    {
        $this->filter_where('xc_user_clients.user_id', $user_id);
        return $this;
    }

    public function get($include_defaults = true)
    {
        if ($include_defaults) {
            $this->set_defaults();
        }

        $this->run_filters();

        $this->query = $this->defaultDB->get($this->table);

        $this->filter = array();

        return $this;
    }

}
