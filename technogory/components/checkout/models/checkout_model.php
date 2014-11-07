<?php
  class checkout_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      
      function get_product_by_id($productid){
          $this->db->select('*');
          $this->db->where('productid',$productid);
          return $this->db->get('shop_product')->row();
      }
      
      function get_payment_sub($payment_id){
          $this->db->where('parentid',$payment_id);
          $this->db->where('published',1);
          $this->db->order_by('ordering','asc');
          return $this->db->get('shop_payment')->result();
      }
  }

