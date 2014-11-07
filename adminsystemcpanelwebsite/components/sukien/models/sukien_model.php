<?php
class sukien_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function get_num_baiviet($key){
        if($key != ''){
            $this->db->like('title',$key);
        }        

        return $this->db->get('events')->num_rows();        
    }
    
    function get_all_baiviet($num, $offset, $key, $field, $order){
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('newsid','desc');
        }
        return $this->db->get('events',$num,$offset)->result();
    }
}
