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
 * @link		https://xintegro.de
 * 
 */

class Mdl_Projects extends Response_Model
{

    public $table = 'xc_projects';
    public $primary_key = 'xc_projects.project_id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS *', FALSE);
    }

    public function default_order_by()
    {
        $this->db->order_by('xc_projects.project_id');
    }

    public function default_join()
    {
        //$this->db->join('xc_projects', 'xc_projects.project_id = xc_client.project_id', 'left');
        $this->db->join('xc_clients', 'xc_clients.client_id = xc_projects.client_id', 'left');
    }

    public function validation_rules()
    {
        return array(
            'project_name' => array(
                'field' => 'project_name',
                'label' => lang('project_name'),
                'rules' => 'required'
            ),
            'client_id' => array(
                'field' => 'client_id',
                'label' => lang('client'),
            )
        );
    }

}

?>