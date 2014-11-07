<?php
class CI_vtragop{
    function __construct(){
        $this->CI = get_instance();
        $this->session_id = $this->CI->session->userdata('session_id');
        $this->city_id = $this->CI->session->userdata('city_site');
    }
    
    function addcart($productid,$qty =1){
        $row = $this->get_product($productid);
        if($row){
            if($row->giaban > 0){
                $check_cart = $this->CI->vdb->find_by_id('tragop_donhang_ct',array('productid'=>$productid,'session_id'=>$this->session_id,'city_id'=>$this->city_id));
                if($check_cart){
                    $vdata['s_qty'] = $check_cart->s_qty + $qty;
                    $this->CI->vdb->update('tragop_donhang_ct',$vdata,array('productid'=>$productid,'city_id'=>$this->city_id,'session_id'=>$this->session_id));
                    return $check_cart->id;
                }else{
                    $vdata['city_id'] = $this->city_id;
                    $vdata['productid'] = $productid;
                    $vdata['productname'] = $row->productname;
                    $vdata['s_price'] = $row->giaban;
                    $vdata['s_qty'] = $qty;
                    $vdata['session_id'] = $this->session_id;
                    $id = $this->CI->vdb->update('tragop_donhang_ct',$vdata);
                    return $id;
                }
            }else{
                return '-1';
            }
        }else{
            return '-2';
        }
    }
    
    
    function get_product($productid){
        $this->CI->db->select('shop_product.productid, shop_product.producturl, shop_product.productname, shop_price.*');
        $this->CI->db->join('shop_price','shop_price.productid = shop_product.productid');
        $this->CI->db->where('shop_price.city_id',$this->city_id);
        $this->CI->db->where('shop_product.productid',$productid);
        return $this->CI->db->get('shop_product')->row();
    }
    
    function list_product(){
        $this->db = $this->CI->load->database('default', TRUE);    
        $this->db->where('session_id',$this->session_id);
        return $this->db->get('tragop_donhang_ct')->result();
    }
    
    function total_price(){
        $this->db = $this->CI->load->database('default', TRUE);
        $this->db->where('session_id',$this->session_id);
        $list = $this->db->get('tragop_donhang_ct')->result();
        $total = 0;
        foreach($list as $rs):
            $total = $total + ($rs->s_price * $rs->s_qty);
        endforeach;
        return $total;
    }
}
