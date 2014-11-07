<?php
class productdeal_model extends CI_Model{
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
    
    public function get_all_product($num,$offset,$catid,$city_id = 0,$barcode,$productkey,$field,$order){        
          if($catid != 0){  
             $ar_cat = $this->get_arr_cat($catid);  
          }      
          if($city_id != 0){ 
          	$this->db->where('city_id',$city_id);
          }
          if($catid != 0){
              $this->db->where_in('catid',$ar_cat);
          }
          if($barcode != ''){
              $this->db->like('barcode',$barcode);
              //$this->db->or_where('productid',$barcode);
          }
          if($productkey != ''){
              $this->db->like('productname',$productkey);
          }
         
          if($field!='' && $order !=''){
              $this->db->order_by($field,$order);
          }else {
          	$this->db->order_by('id','desc');
          }
          return $this->db->get('sangiare',$num,$offset)->result();   
        
    } 

    function get_num_product($catid,$city_id,$barcode,$productkey){
    	
		 if($catid != 0){  
             $ar_cat = $this->get_arr_cat($catid);  
          }    
          if($city_id !=0){     
          	$this->db->where('city_id',$city_id);
          }
          if($catid != 0){
              $this->db->where_in('catid',$ar_cat);
          }
          if($barcode != ''){
              $this->db->like('sangiare.barcode',$barcode);
          }
          if($productkey != ''){
              $this->db->like('productname',$productkey);
          }
         
          return $this->db->get('sangiare')->num_rows();
      
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
    
    function getproductID($id){
        $this->db->select('shop_product.productid, shop_product.catid,shop_product.barcode,shop_product.caturl,shop_product.productname, shop_product.producturl, shop_product.productimg, shop_product.published, shop_price.*');
        $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        $this->db->where('shop_product.productid',$id);      
        $this->db->where('shop_product.published',1);      
        return $this->db->get('shop_product')->row();
    }
    
    // check id product 
    public function checkIdProduct($id){
    	
    	$this->db->select('sangiare.productid, sangiare.published');
    	$this->db->where('sangiare.published',1);
    	$this->db->where('sangiare.productid',$id);
    	$query  = $this->db->get("sangiare");
    	if($query->num_rows()>0){
    		return 1;
    	}else{
    		return 0;
    	}
    	
    }
    
    //*******************
    function delete_product($productid){
          // Xoa thuoc tinh
          $this->db->where('productid',$productid);                  
          $this->db->where('productid',$productid);
          if($this->db->delete('sangiare')){
              return true;
          }else{
              return false;
          }
          
          
      }
      
      
    
    
    function get_price_hot($productid, $city_id){
        $this->db->where('city_id',$city_id);
        $this->db->where('productid',$productid);
        return $this->db->get('shop_price')->row();
    }
    

}
