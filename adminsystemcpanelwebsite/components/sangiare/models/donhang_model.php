<?php
class donhang_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_donhang($num, $offset, $tinhtrang, $field,$order){
        $tinhtrang = $this->get_id_tinhtrang($tinhtrang);
        $sql = "
            SELECT 
                cheap_list.*, cheap_cart.*
            FROM 
                cheap_list, cheap_cart
            WHERE
                cheap_list.id = cheap_cart.cheap_id
        ";
        if($tinhtrang == 0){
            $sql .=" AND moinhat = 1";
        }else{
            $sql .=" AND tinhtrang = $tinhtrang";
        }
        
        if($field !='' && $order !=''){
            $sql .=" ORDER by $field $order";
        }else{
            $sql .=" ORDER by cart_id DESC";
        }
        $sql .=" LIMIT ".$num." OFFSET ".(int)$offset;
        
        return $this->db->query($sql)->result();
    }
    
    function get_num_donhang($tinhtrang){
        $tinhtrang = $this->get_id_tinhtrang($tinhtrang);
        $sql = "
            SELECT 
                cheap_list.*, cheap_cart.*
            FROM 
                cheap_list, cheap_cart
            WHERE
                cheap_list.id = cheap_cart.cheap_id
        ";
        if($tinhtrang == 0){
            $sql .=" AND moinhat = 1";
        }else{
            $sql .=" AND tinhtrang = $tinhtrang";
        }
        
        return $this->db->query($sql)->num_rows();
    }
    
    function get_total_donhang(){
        $this->db->where('published',1);
        return $this->db->get('cheap_cart')->num_rows();
    }
    
    function get_id_tinhtrang($str){
        if($str == 'chuaxacnhan'){
            $tinhtrang = 1;
        }else if($str == 'daxacnhan'){
            $tinhtrang = 2;
        }else if($str == 'hoanthanh'){
            $tinhtrang = 3;
        }else if($str == 'dangxuly'){
            $tinhtrang = 4;
        }else if($str == 'dahuy'){
            $tinhtrang = 5;
        }else if($str == 'moinhat'){
            $tinhtrang = 0;
        }
        return $tinhtrang;
    }
    
    function get_chitiet($cart_id){
        $this->db->select('cheap_list.*, cheap_cart.*');
        $this->db->join('cheap_list','cheap_list.id = cheap_cart.cheap_id');
        $this->db->where('cheap_cart.cart_id',$cart_id);
        return $this->db->get('cheap_cart')->row();
    }
    
    function get_sum_giamgia($cart_id){
        $this->db->select_sum('price');
        $this->db->where('cart_id',$cart_id);
        return $this->db->get('cheap_discount')->row()->price;
        
    }
    
    function get_all_giamgia($cart_id){
        $this->db->where('cart_id',$cart_id);
        return $this->db->get('cheap_discount')->result();
        
    }
}
