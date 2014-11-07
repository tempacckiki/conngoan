<?php
class order_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE); 
    }
    
	function get_all_donhang($num, $offset, $tinhtrang, $field,$order){
        $tinhtrang = $this->get_id_tinhtrang($tinhtrang);
        $sql = "
            SELECT 
                shop_cart.*
            FROM 
                shop_cart           
        ";
        if($tinhtrang == 0){
            $sql .=" WHERE order_news = 1";
        }else{
            $sql .=" WHERE status = $tinhtrang";
        }
        
        if($field !='' && $order !=''){
            $sql .=" ORDER by $field $order";
        }else{
            $sql .=" ORDER by order_id DESC";
        }
        $sql .=" LIMIT ".$num." OFFSET ".(int)$offset;
        
        return $this->db->query($sql)->result();
    }
    /*------------------------------------------------+
     * get_all_donhang_old
     +-------------------------------------------------*/
    function get_all_donhang_old($num, $offset, $tinhtrang, $field,$order){
        $tinhtrang = $this->get_id_tinhtrang($tinhtrang);
        $sql = "
            SELECT 
                shop_cart.*
            FROM 
                shop_cart
            WHERE
                active_buy = 1
        ";
        if($tinhtrang == 0){
            $sql .=" AND order_news = 1";
        }else{
            $sql .=" AND status = $tinhtrang";
        }
        
        if($field !='' && $order !=''){
            $sql .=" ORDER by $field $order";
        }else{
            $sql .=" ORDER by order_id DESC";
        }
        $sql .=" LIMIT ".$num." OFFSET ".(int)$offset;
        
        return $this->db->query($sql)->result();
    }
    
 	function get_num_donhang($tinhtrang){
        $tinhtrang = $this->get_id_tinhtrang($tinhtrang);
        $sql = "
            SELECT 
                shop_cart.*
            FROM 
                shop_cart                          
        ";
        if($tinhtrang == 0){
            $sql .=" WHERE order_news = 1";
        }else{
            $sql .=" WHERE status = $tinhtrang";
        }
        
        return $this->db->query($sql)->num_rows();
    }
    
    
     /*------------------------------------------------+
     * get_num_donhang_old
     +-------------------------------------------------*/
    
    function get_num_donhang_old($tinhtrang){
        $tinhtrang = $this->get_id_tinhtrang($tinhtrang);
        $sql = "
            SELECT 
                shop_cart.*
            FROM 
                shop_cart
            WHERE
                active_buy = 1
        ";
        if($tinhtrang == 0){
            $sql .=" AND order_news = 1";
        }else{
            $sql .=" AND status = $tinhtrang";
        }
        
        return $this->db->query($sql)->num_rows();
    }
    
    function get_all_search($num, $offset,$barcode, $fullname, $date_begin, $date_end, $city_id, $status){
        if($barcode != ''){
            $this->db->where('barcode',$barcode);
        }
         if($date_begin != '' && $date_end != ''){
            $this->db->where('date_buy >=',strtotime($date_begin));
            $this->db->where('date_buy <=',strtotime($date_end));
        }
        if($city_id != 0){
            $this->db->where('city_id',$city_id);
        }
        if($status != 0){
            $this->db->where('status',$status);
        }
        if($fullname != ''){
            $this->db->like('fullname',$fullname);
        }
        $this->db->order_by('date_buy','desc');
        return $this->db->get('shop_cart',$num, $offset)->result();
    }
    
    function get_num_search($barcode, $fullname, $date_begin, $date_end, $city_id, $status){
        if($barcode != ''){
            $this->db->where('barcode',$barcode);
        }
        if($date_begin != '' && $date_end != ''){
            $this->db->where('date_buy >=',strtotime($date_begin));
            $this->db->where('date_buy <=',strtotime($date_end));
        }
        if($city_id != 0){
            $this->db->where('city_id',$city_id);
        }
        if($status != 0){
            $this->db->where('status',$status);
        }
        if($fullname != ''){
            $this->db->like('fullname',$fullname);
        }
        return $this->db->get('shop_cart')->num_rows();
    }
    
    function get_id_tinhtrang($str){
        if($str == 'chuaxacnhan'){
            $tinhtrang = 1;
        }else if($str == 'daxacnhan'){
            $tinhtrang = 2;
        }else if($str == 'dangxuly'){
            $tinhtrang = 3;
        }else if($str == 'hoanthanh'){
            $tinhtrang = 4;
        }else if($str == 'dahuy'){
            $tinhtrang = 5;
        }else if($str == 'moinhat'){
            $tinhtrang = 0;
        }
        return $tinhtrang;
    }
    
    function get_status_text($str){
        if($str == 1){
            $tinhtrang = 'chuaxacnhan';
        }else if($str == 2){
            $tinhtrang = 'daxacnhan';
        }else if($str == 3){
            $tinhtrang = 'dangxuly';
        }else if($str == 4){
            $tinhtrang = 'hoanthanh';
        }else if($str == 5){
            $tinhtrang = 'dahuy';
        }
        return $tinhtrang;
    }
    
    // Tong don hang
    function get_total_donhang(){
        //$this->db->where('active_buy',1);
        return $this->db->get('shop_cart')->num_rows();
    }
    
    /*****************
    * Chi tiet don hang
    */
    // Thong tin dat hang
    function get_info_order($order_id){
        $this->db->where('order_id',$order_id);
        return $this->db->get('shop_cart')->row();
    }
    
    // Danh sach san pham trong don hang
    function get_list_order($order_id){
      $this->db->select('shop_product.*, shop_cart_detail.*');
      $this->db->join('shop_product','shop_product.productid = shop_cart_detail.productid');
      $this->db->where('shop_cart_detail.cartid',$order_id);
      return $this->db->get('shop_cart_detail')->result();
    }
    
    // Danh sach ma phieu giam gia
    function get_list_discount($order_id){
        $this->db->where('cartid',$order_id);
        return $this->db->get('shop_cart_discount')->result();
    }
    
    function get_gifts($cart_detail_id){
        $this->db->where('cart_detail_id',$cart_detail_id);
        return $this->db->get('shop_cart_gifts')->result();
    }
    
    function find_user($user_id){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('user_id',$user_id);
        return $this->member->get('user')->row();
    }
    
    
}
