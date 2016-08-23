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

class mdl_user_company extends MY_Model
{
    public $table = 'xc_user_companies';
    public $primary_key = 'xc_user_companies.id';
    
    public function __construct()
    {
        $this->defaultDB = $this->load->database('default', true);
        $mainDB = $this->load->database('default', true);
        $this->dbName = $mainDB->database;
        $this->_database_connection = 'default';
        $this->table = $mainDB->database . '.xc_user_companies';
        
        parent::__construct();
    }
    
    public function save($data, $userId = null)
    {
        if (!empty($userId)) {
            $this->delete($userId);
        }
        $this->defaultDB->insert_batch('xc_user_companies', $data);
    }
    public function create($data)
    {
        $this->defaultDB->insert('xc_user_companies', $data);
    }
    /**
     * @param $userId
     */
    public function delete($userId)
    {
        $this->defaultDB->where('user_id', $userId);
        $this->defaultDB->delete('xc_user_companies');
    }
    public function deleteUserCompany($id)
    {
        $this->defaultDB->where_in('user_id',$id);
        $this->defaultDB->delete('xc_user_companies');
    }
    
    /**
     * @param $userId
     * @return mixed
     */
    public function getUserCompany($userId)
    {
        $query = $this->defaultDB->select('company_id')->from('xc_user_companies')->where('user_id', $userId)->get();
        
        if ($query->num_rows() > 0) {
            $row = $query->result();
            return $row;
        }
    }
    public function getFirstUserCompany($userId)
    {
        $query = $this->defaultDB->select('company_id')->from('xc_user_companies')->where('user_id', $userId)->get();
        if ($query->num_rows() > 0) {
            return $query->first_row();
        }
    }
}
