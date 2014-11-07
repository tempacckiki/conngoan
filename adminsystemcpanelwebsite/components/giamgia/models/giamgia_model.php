<?php
class giamgia_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_num_giamgia(){
        return $this->db->get('shop_discount')->num_rows();
    }
    
    function get_all_giamgia($num, $offset, $field, $order){
        $this->db->order_by($field,$order);
        return $this->db->get('shop_discount', $num, $offset)->result();
    }
}
