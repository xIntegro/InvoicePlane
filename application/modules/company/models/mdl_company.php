<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Company extends MY_Model
{
    public $table = 'xc_companies';
    public $primary_key = 'xc_companies.id';

    public function __construct()
    {
        $this->defaultDB = $this->load->database('default', true);
        $mainDB = $this->load->database('default', true);
        $this->_database_connection = 'default';
        $this->table =  $mainDB->database . '.xc_companies';

        parent::__construct();
    }

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        $insert_id = $this->db->insert_id();

        return $insert_id;
    }

    public function getCompany()
    {
        //set default Databse if Company or Users not exits
        $result = $this->db->get($this->table);
        return $result->result();
    }

    public function companyExist($companyName)
    {
        $this->db->select('name');
        $this->db->where('name', $companyName);
        $query = $this->db->get($this->table);
        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function searchResult($companyName)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->like('name', $companyName);
        $result = $this->db->get();

        return $result->result();
    }


    public function validation_rules()
    {
        return array(
            'company_name' => array(
                'field' => 'name',
                'label' => lang('company_name'),
                'rules' => "required"
            )
        );
    }

    public function getCompanyByDBName($companyName)
    {
        $this->db->select('*');
        $this->db->where('dbName', $companyName);
        $result = $this->db->get($this->table);

        if ($result->num_rows() > 0) {
            return $result->row();
        } else {
            return false;
        }
    }
    public function getCompanyByUser($id)
    {
        $this->defaultDB->select('*');
        $this->defaultDB->from('xc_companies');
        $this->defaultDB->join('xc_user_companies','xc_user_companies.company_id=xc_companies.id');
        $this->defaultDB->where_in('xc_user_companies.user_id',$id);
        $query=$this->defaultDB->get();
        return $query->result();
    }
}