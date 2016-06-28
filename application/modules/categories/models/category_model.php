
<?php
    if (!defined('BASEPATH'))
        exit('No direct script access allowed');

class category_model extends Response_Model
{

    public $table = 'xc_categories';
    public $primary_key = 'xc_categories.id';

    public function default_select()
    {
        $this->db->select('SQL_CALC_FOUND_ROWS xc_categories.*', FALSE);
    }

    public function Save($data)
    {
        $this->db->insert('xc_categories',$data);
        
    }
    //get all record
    public function All()
    {

        $result=$this->db->get('xc_categories');
        return $result->result();
    }


    public function is_active()
    {
        $this->filter_where('is_active', 1);
        return $this;
    }

    public function is_inactive()
    {
        $this->filter_where('is_active', 0);
        return $this;
    }


    //delete record from database
    public function delete($id)
    {
        $this->db->where('id',$id);
        $this->db->delete('xc_categories');
    }
    //edit record from database
    public  function edit($id)
    {
        $result=$this->db->get_where('xc_categories',$id);
        return $result->result_array();
    }
    //update record in database

    public function update($data,$id)
    {
        $this->db->where('id',$id);
        $this->db->update('xc_categories',$data);
    }

    //get result search by ajax
    public function SearchResult($name)
    {
        $this->db->select('*');
        $this->db->from('xc_categories');
        $this->db->like('category_name',$name);
        $result=$this->db->get();

        return $result->result();
    }

    public function category_Exist($categoryname)
    {
        $this->db->select('category_name');
        $this->db->where('category_name',$categoryname);
        $query=$this->db->get('xc_categories');
        if($query->num_rows()>0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function validation_rules()
    {
        return array(
            'category_name'=>array(
                'field'=>'category_name',
                'label'=>lang('category_name'),
                'rules'=>'required'
            )
        );
    }
    
    
}
