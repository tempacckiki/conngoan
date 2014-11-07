<?php
class baohanh_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_manufacture($field, $order, $key, $num, $offset){
        if($key != ''){
            $this->db->like('name',$key);
        }
        if($field != '' && $order != ''){
          $this->db->order_by($field,$order);
        }else{
          $this->db->order_by('name','asc');    
        }
        return $this->db->get('shop_manufacture',$num,$offset)->result();
    }
      
    function get_num_manufacture($key){
        if($key != ''){
            $this->db->like('name',$key);
        }
        return $this->db->get('shop_manufacture')->num_rows();
    }
}
