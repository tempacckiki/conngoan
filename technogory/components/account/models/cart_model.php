<?php
class cart_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_num_order(){

        $this->db->where('active_buy',1);
        $this->db->where('user_id',$this->user_id);
        
        return $this->db->get('shop_cart')->num_rows();
    }
    
    function get_all_order($num,$offset){
        $this->db->where('active_buy',1);
        $this->db->where('user_id',$this->user_id);
        $this->db->order_by('date_buy','desc'); 
        return $this->db->get('shop_cart',$num,$offset)->result();
    }
    
    function get_list_product($cartid){
        $this->db->select('shop_product.*, shop_cart_detail.*');
        $this->db->join('shop_product','shop_product.productid = shop_cart_detail.productid');
        $this->db->where('shop_cart_detail.cartid',$cartid);
        return $this->db->get('shop_cart_detail')->result();
    }
    
    // Check Cart
    function check_cart($order_id){
        $this->db->where('order_id',$order_id);
        $this->db->where('user_id',$this->user_id);
        return $this->db->get('shop_cart')->row();
    }
    
    // Danh sach ma phieu giam gia
    function get_list_discount($order_id){
        $this->db->where('cartid',$order_id);
        return $this->db->get('shop_cart_discount')->result();
    }
    function get_total_discount($cart_id){
        $this->db->select_sum('price');
        $this->db->where('cart_id',$cart_id);
        return $this->db->get('cheap_discount')->row()->price;
    }
    
    function get_list_order_active(){
        $ar_order = $this->get_ar_order();
        
        $this->db->where('user_id',$this->user_id);
        $this->db->where('active_buy',1);
        if($ar_order){
        $this->db->where_not_in('order_id',$ar_order);
        }
        $this->db->where('status',2);
        return $this->db->get('shop_cart')->result();
    }
    
    function get_ar_order(){
        $this->db->where('user_id',$this->user_id);
        $list = $this->db->get('shop_message_transfer')->result();
        if(count($list)){
            $ar = array();
            foreach($list as $rs):
                array_push($ar,$rs->order_id);
            endforeach;
            return $ar;
        }else{
            return false;
        }
    }
}
