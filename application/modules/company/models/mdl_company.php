<?php
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mdl_Company extends MY_Model
{
    public $table = 'xc_companies';
    public $primary_key = 'xc_companies.id';

    public  function __construct()
    {
        $this->defaultDB = $this->load->database('default', true);
    }

    public function insert($data)
    {
        $this->defaultDB->insert('xc_companies', $data);
        $insert_id = $this->defaultDB->insert_id();

        return $insert_id;
    }

    public function getCompany()
    {
        //set default Databse if Company or Users not exits

        $result = $this->defaultDB->get('xc_companies');
        return $result->result();
    }

    public function validation_rules()
    {
        return array(
            'company_name' => array(
                'field' => 'name',
                'label' => lang('company_name'),
                'rules' => 'required'
            )
        );
    }

}