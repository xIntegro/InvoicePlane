<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');
class mdl_client_persons extends Response_Model
{
    public $table = 'xc_client_persons';
    public $primary_key = 'xc_client_persons.id';

    public function default_join()
    {
        $this->db->join('xc_persons','xc_persons.id=xc_client_persons.person_id');
    }

    public function save($data)
    {
        $this->db->insert('xc_client_persons',$data);
    }
    public function edit($person_id,$client_id)
    {
       $query=$this->db->select('*')->where('person_id',$person_id)->where('client_id',$client_id)->get('xc_client_persons');
        return $query->row();
    }

    public function person_exist($client_id,$person_id)
    {
        $this->db->select('*');
        $this->db->where('client_id',$client_id);
        $this->db->where('person_id',$person_id);

        $query=$this->db->get('xc_client_persons');
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    public function get_person_detail($id)
    {
        $this->db->select('*');
        $this->db->from('xc_client_persons');
        $this->db->join('xc_persons','xc_persons.id=xc_client_persons.person_id');
        $this->db->where('xc_client_persons.client_id',$id);
        $result=$this->db->get();
        return $result->result();

    }
    public function get_client_detail($person_id)
    {
        $this->db->select('*');
        $this->db->from('xc_client_persons');
        $this->db->join('xc_clients','xc_clients.client_id=xc_client_persons.client_id');
        $this->db->where('xc_client_persons.person_id',$person_id);
        $result=$this->db->get();
        return $result->result();

    }
    public function delete($person_id,$client_id)
    {
        $this->db->where('person_id',$person_id);
        $this->db->where('client_id',$client_id);
        $this->db->delete('xc_client_persons');
        
    }

    public function update($data,$person_id,$client_id)
    {
        $this->db->where('person_id',$person_id);
        $this->db->where('client_id',$client_id);
        $this->db->update('xc_client_persons',$data);
    }
    public function MultipleDelete($clientId)
    {
        $this->db->where_in('client_id',$clientId);
        $this->db->delete('xc_client_persons');
    }

    public function validation_rules()
    {
        return array(

            'person_id'=>array(
                'field'=>'person_id',
                'label'=>lang('select_person_name'),
                'rules'=>'required'
            ),
            'email'=>array(
                'field'=>'email',
                'label'=>lang('email'),
                
            ),
            'client_id'=>array(
                'field'=>'client_id',
                'label'=>lang('client'),
                'rules'=>'required'
            ),

        );
    }

    public function MultipleDelete_person($personId)
    {
        $this->db->where_in('person_id',$personId);
        $this->db->delete('xc_client_persons');
    }
}
