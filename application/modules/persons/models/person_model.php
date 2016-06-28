<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class Person_model extends Response_Model
{
    public $table = 'xc_persons';
    public $primary_key = 'xc_persons.id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS xc_persons.*', FALSE);
    }

    //save Record into Database

    public function Save($data)
    {
        $this->db->insert('xc_persons',$data);
        $userId=$this->db->insert_id();
        return $userId;
    }
    //get all record
    public function All()
    {
        $result=$this->db->order_by('id','desc')->get('xc_persons');
        return $result->result();
    }
    public function is_active()
    {
        $this->filter_where('person_active', 1);
        return $this;
    }

    public function is_inactive()
    {
        $this->filter_where('person_active', 0);
        return $this;
    }

    //delete record from database
    public function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('xc_persons');
    }
    //edit record from database
    public  function edit($id)
    {
        $result=$this->db->get_where('xc_persons',$id);
        return $result->result_array();
    }
    //update record in database

    public function update($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('xc_persons',$data);
    }

    //get result search by ajax
    public function SearchResult($name)
    {
        $this->db->select('*');
        $this->db->from('xc_persons');
        $this->db->like('first_name',$name);
        $result=$this->db->get();

        return $result->result();
    }

    public function validation_rules()
    {
        return array(
            'title'=>array(
                'field'=>'title'
            ),
            'first_name'=>array(
                'field'=>'first_name',
                'label'=>lang('first_name'),
                'rules'=>'required'
            ),
            
            'middle_name'=>array(
                'field'=>'middle_name'
            ),
            'last_name'=>array(
                'field'=>'last_name'
            ),
            'Birthday'=>array(
                'field'=>'Birthday'
            ),
            'Birth_Place'=>array(
                'field'=>'Birth_Place'
            ),
            'Nationality'=>array(
                'field'=>'Nationality'
            ),
            'gender'=>array(
                'field'=>'gender'
            ),
            'Home_No'=>array(
                'field'=>'Home_No'
            ),
            'home_address'=>array(
                'field'=>'home_address',
            ),
            'street_address'=>array(
                'field'=>'street_address'
            ),
            'City'=>array(
                'field'=>'City'
            ),
            'Country'=>array(
                'field'=>'Country'
            ),
            'zipcode'=>array(
                'field'=>'zipcode'
            ),
            'Email_1'=>array(
                'field'=>'Email_1'
            ),
            'Email_2'=>array(
                'field'=>'Email_2'
            ),
            'Fax'=>array(
                'field'=>'Fax'
            ),
            'Mobile'=>array(
                'field'=>'Mobile'
            ),
            'phone_number'=>array(
                'field'=>'phone_number'
            ),
            'bank_name'=>array(
                'field'=>'bank_name'
            ),
            'account_number'=>array(
                'field'=>'account_number'
            ),
            'bic'=>array(
                'field'=>'bic'
            ),
            'swift_code'=>array(
                'field'=>'swift_code'
            ),
            'bank_short_code'=>array(
                'field'=>'bank_short_code'
            ),
            'routing_number'=>array(
                'field'=>'routing_number'
            )
            
        );
    }


}



