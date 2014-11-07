<?php
class search_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    // Search key
   function get_all_product_by_key($num, $offset, $productkey){
       $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.producturl, shop_product.manufactureid,shop_product.phukien, shop_price.*');
       $this->db->join('shop_price','shop_price.productid = shop_product.productid');
       $this->db->where('shop_price.city_id',$this->city_id);
       $this->db->where('published',1);
       $this->db->where('shop_price.giaban !=',0);
       $this->db->like('productname',$productkey);
       $this->db->order_by('productname');
       return $this->db->get('shop_product',$num,$offset)->result();
   }
   
   function get_num_product_by_key($productkey){
       $this->db->select('shop_product.productid, shop_price.*');
       $this->db->join('shop_price','shop_price.productid = shop_product.productid');
       $this->db->where('shop_price.city_id',$this->city_id);
       $this->db->where('published',1);
       $this->db->where('shop_price.giaban !=',0);
       $this->db->like('productname',$productkey);
       return $this->db->get('shop_product')->num_rows();
   }
   
    function get_list_gifts($productid){
        $this->db->where('local',$this->regions);
        $this->db->where('productid',$productid);
        return $this->db->get('shop_gifts')->result();
    }
    
    /*****************
    * Rating
    */
    function loadRating($id){
      $this->db->where('productid',$id);
      $query = $this->db->get('shop_rating');
      $item = $query->row();
      $rating = (@round($item->value / $item->counter,1)) * 20;
      return $rating;
    }  
    
    function check_session_rating($id){
      $session_id = $this->session->userdata('session_id');
      $this->db->where('rating_session_id',$session_id);
      $this->db->where('productid',$id);
      $query = $this->db->get('shop_rating_history');
      if($query->num_rows() > 0){
          return 1;
      }else{
          return 0;
      }
    }
}