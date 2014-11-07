<?php
class producthome_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    // Get list main cat 
    function get_main_cat(){
      $this->db->where('parentid',0);
      $this->db->order_by('ordering','asc');
      return $this->db->get('shop_cat')->result();
    }
    
    function get_sub_cat($CatID){
      $this->db->where('parentid',$CatID);
      $this->db->order_by('ordering','asc');
      return $this->db->get('shop_cat')->result();
    } 
    
    function get_all_product($num,$offset,$catid,$city_id,$barcode,$productkey,$field,$order){
        if($catid == 0 && $city_id == 0){
          return array();
        }else{
          if($catid != 0){  
             $ar_cat = $this->get_arr_cat($catid);  
          }
          $this->db->select('shop_product.*, shop_price.*');
          $this->db->join('shop_price','shop_price.productid = shop_product.productid');
          $this->db->where('shop_price.city_id',$city_id);
          if($catid != 0){
              $this->db->where_in('catid',$ar_cat);
          }
          if($barcode != ''){
              $this->db->like('shop_product.barcode',$barcode);
              //$this->db->or_where('productid',$barcode);
          }
          if($productkey != ''){
              $this->db->like('shop_product.productname',$productkey);
          }
          $this->db->where('home',1);
          if($field!='' && $order !=''){
              $this->db->order_by($field,$order);
          }else{
             $this->db->order_by('shop_product.orderhome','asc');    
          }
          return $this->db->get('shop_product',$num,$offset)->result();   
        }
    } 

    function get_num_product($catid,$city_id,$barcode,$productkey){
        if($catid == 0 && $city_id == 0){
          return 0;
        }else{
          if($catid != 0){  
             $ar_cat = $this->get_arr_cat($catid);  
          }
          $this->db->select('shop_product.*, shop_price.*');
          $this->db->join('shop_price','shop_price.productid = shop_product.productid');
          $this->db->where('shop_price.city_id',$city_id);
          if($catid != 0){
              $this->db->where_in('catid',$ar_cat);
          }
          if($barcode != ''){
              $this->db->like('shop_product.barcode',$barcode);
          }
          if($productkey != ''){
              $this->db->like('shop_product.productname',$productkey);
          }
          $this->db->where('home',1); 
          return $this->db->get('shop_product')->num_rows();
        }
    }
    
    function get_product_home($catid){
         $ar_cat = $this->get_arr_cat($catid);
         $this->db->select('productid, productname, producturl, productimg');
         $this->db->where_in('catid',$catid);
         $this->db->where('published',1);
         $this->db->where('home',1);
         $this->db->order_by('orderhome','asc');
         $this->db->limit(8);
         return $this->db->get('shop_product')->result();
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
    
    function get_item_hot($id,$city_id,$cat_id,$position ='hot'){
        $this->db->select('shop_product.productid, shop_product.productname, shop_product.producturl,shop_product.tinhnang,shop_product.phukien, shop_product.productimg, shop_hot.*');
        $this->db->join('shop_product','shop_product.productid = shop_hot.productid');
        $this->db->where('shop_hot.id',$id);
        $this->db->where('shop_hot.position',$position);
        $this->db->where('shop_hot.city_id',$city_id);
        $this->db->where('shop_hot.cat_id',$cat_id);
        return $this->db->get('shop_hot')->row();
    }
    
    //hot cat
    function get_item_hotcat($id,$city_id,$cat_id,$position ='hot'){
    	$this->db->select('shop_product.productid, shop_product.productname, shop_product.producturl,shop_product.tinhnang,shop_product.phukien, shop_product.productimg, shop_hotcat.*');
    	$this->db->join('shop_product','shop_product.productid = shop_hotcat.productid');
    	$this->db->where('shop_hotcat.id',$id);
    	$this->db->where('shop_hotcat.position',$position);
    	$this->db->where('shop_hotcat.city_id',$city_id);
    	$this->db->where('shop_hotcat.cat_id',$cat_id);
    	return $this->db->get('shop_hotcat')->row();
    }
    
    function get_price_hot($productid, $city_id){
        $this->db->where('city_id',$city_id);
        $this->db->where('productid',$productid);
        return $this->db->get('shop_price')->row();
    }
    

}
