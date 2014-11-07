<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('cookie_mycart'))
{
    function cookie_mycart()
    {
        // Set the config file options
        $CI =& get_instance();
        if(get_cookie('my_cart')){
            return get_cookie('my_cart');
        }else{
            $session_id = $CI->session->userdata('session_id');
            set_cookie('my_cart', $CI->session->userdata('session_id'), $CI->config->item('exp_time_cart'));
            return $session_id;
        }
    }
}
if ( ! function_exists('cookie_total_qty'))
{
    function cookie_total_qty()
    {
        // Set the config file options
        $CI =& get_instance();
        $CI->db->select_sum('s_qty');
        $CI->db->where('session_id',cookie_mycart());
        $row =  $CI->db->get('shop_cart_detail')->row();
        if($row){
            return $row->s_qty;
        }else{
            return 0;
        }
    }
}

if ( ! function_exists('cookie_total_price'))
{
    function cookie_total_price()
    {
        // Set the config file options
        $CI =& get_instance();
        $CI->db->where('session_id',cookie_mycart());
        $list =  $CI->db->get('shop_cart_detail')->result();
        if(count($list) > 0){
            $price = 0;
            foreach($list as $rs):
                $price = $price + ($rs->s_price * $rs->s_qty);
            endforeach;
            return $price;
        }else{
            return 0;
        }
    }
}
