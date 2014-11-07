<?php
 class thongke_model extends CI_Model{
     function __construct(){
         parent::__construct();
     }
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
      
      function get_all_order($tungay, $denngay, $status, $city_id,$field,$order){
          $tungay = strtotime($tungay);
          $denngay = strtotime($denngay);
          if($status != 0){
              $this->db->where('status',$status);
          }
          if($city_id != 0){
              $this->db->where('city_id',$city_id);
          }
          $this->db->where('date_buy >=',$tungay);
          $this->db->where('date_buy <=',$denngay);
          $this->db->where('barcode !=','');
          $this->db->order_by($field, $order);
          return $this->db->get('shop_cart')->result();
      }
      
      function get_all_order_detail($order_id,$catid){
          if($catid != 0){
              $ar_id = $this->get_arr_cat($catid);
          }
          $this->db->select('shop_product.productname, shop_product.productid,shop_product.catid, shop_cart_detail.*');
          $this->db->join('shop_product','shop_product.productid = shop_cart_detail.productid');
          if($catid != 0){
              $this->db->where_in('shop_product.catid',$ar_id);
          }
          $this->db->where('shop_cart_detail.cartid',$order_id);
          //$this->db->group_by('shop_cart_detail.productid');
          return $this->db->get('shop_cart_detail')->result();
      }
      
      function get_qty($productid){
          $this->db->select_sum('s_qty');
          $this->db->where('productid',$productid);
          $this->db->where('cartid >',0);
          $row = $this->db->get('shop_cart_detail')->row();
          return $row->s_qty;
      }
      
      function get_price($productid){
          $this->db->select_avg('s_price');
          $this->db->where('productid',$productid);
          $this->db->where('cartid >',0);
          $row = $this->db->get('shop_cart_detail')->row();
          return $row->s_price;  
      }
      
      
      
      function get_arr_cat($catid){
          $ar_cat = array($catid);
          $this->db->where('parentid',$catid);
          $list = $this->db->get('shop_cat')->result();
          foreach($list as $rs):
            $list1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->catid));
            array_push($ar_cat, $rs->catid);
            if(count($list1) > 0){
                foreach($list1 as $rs1):
                    $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs1->catid));
                    array_push($ar_cat, $rs1->catid);
                    if(count($list2) > 0){  
                        foreach($list2 as $rs2):
                           array_push($ar_cat, $rs2->catid);
                        endforeach;
                    }
                endforeach;
            }
            
          endforeach;
          return $ar_cat;
      }
      
      function get_user($user_id){
          $this->member = $this->load->database('member', TRUE);
          $this->member->where('user_id',$user_id);
          return $this->member->get('user')->row();
      }
 }
