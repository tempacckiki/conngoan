<?php
class import_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
      // Get list main cat 
      function get_main_cat(){
          $this->db->where('parentid',0);
          $this->db->order_by('ordering','asc');
          return $this->db->get('shop_cat')->result();
      }
      
      // Get list sub cat
      function get_sub_cat($CatID){
          $this->db->where('parentid',$CatID);
          $this->db->order_by('ordering','asc');
          return $this->db->get('shop_cat')->result();
      }
      
      function check_price_product($productid, $city_id){
          $this->db->where('productid',$productid);
          $this->db->where('city_id',$city_id);
          return $this->db->get('shop_price')->row();
      }
}
