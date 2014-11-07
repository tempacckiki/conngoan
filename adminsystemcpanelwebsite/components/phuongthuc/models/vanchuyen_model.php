<?php
class vanchuyen_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function check_payment($shipping_id,$payment_id){
        $this->db->where('payment_id',$payment_id);
        $this->db->where('shipping_id',$shipping_id);
        $check = $this->db->get('shop_payment_shipping')->row();
        if($check){
            return true;
        }else{
            return false;
        }
    }
}
