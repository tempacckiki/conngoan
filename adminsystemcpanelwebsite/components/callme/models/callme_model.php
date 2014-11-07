<?php
class callme_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_callme($num, $offset, $field, $order){
        if($field != '' && $order != ''){
            $this->db->order_by($field, $order);
        }else{
            $this->db->order_by('id','desc');
        }
        return $this->db->get('callforme',$num, $offset)->result();
    }
    
    function get_num_callme(){
        return $this->db->get('callforme')->num_rows();
    }
    
    function get_callme_by_id($id){
        $this->db->select('callforme.*, shop_product.*');
        $this->db->join('shop_product','shop_product.productid = callforme.productid');
        $this->db->where('callforme.id',$id);
        return $this->db->get('callforme')->row();
    }
}
