<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Mdl_client_category extends Response_Model
{
    public $table = 'xc_clients_categories';
    public $primary_key = 'xc_clients_categories.id';

    //Insert record Into Database
    public function Save($data)
    {
        $this->db->insert_batch('xc_clients_categories',$data);
    }
    public function get_category($client_id)
    {
        $query=$this->db->select('category_id')->from('xc_clients_categories')->where('client_id',$client_id)->get();

        if($query->num_rows()>0)
        {
            $row=$query->result();
            return $row;
        }
    }
    public function Update($clientId,$data)
    {
        $this->db->where_in('client_id',$clientId);
        $this->db->delete('xc_clients_categories');

        $this->Save($data);
    }
    public function MultipleDelete($clientId)
    {
        $this->db->where_in('client_id',$clientId);
        $this->db->delete('xc_clients_categories');
    }
    public function validation_rules()
    {
        return array(
            'category'=>array(
                'field'=>'category',
                'label'=>lang('category'),
                'rules'=>'required'
            )
        );
    }
}