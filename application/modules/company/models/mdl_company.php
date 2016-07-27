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

}