<?php
class thanhtoan_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    
    function get_payment_shipping($shipping_id){
    	$this->db->select('shop_payment.payment_id, shop_payment_shipping.*');
    	$this->db->join('shop_payment','shop_payment.payment_id = shop_payment_shipping.payment_id');
    	$this->db->where('shop_payment_shipping.shipping_id',$shipping_id);
    	$this->db->order_by('shop_payment.ordering','asc');
    	return $this->db->get('shop_payment_shipping')->result();
    }
    
    function get_payment_sub($payment_id){
    	$this->db->where_in('parentid',$payment_id);
    	$this->db->order_by('ordering','asc');
    	return $this->db->get('shop_payment')->result();
    }
    
}
