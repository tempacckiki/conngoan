<?php
class productdeal_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
	function get_all_product() {			
		$this->db->where("published",1);
		$this->db->order_by ( 'ordering', 'DESC' );		
		return $this->db->get ('ads_news')->result();
	
	}
	
    function getproductID($id){    	
        $this->db->select('shop_product.productid,shop_product.productname, shop_product.producturl, shop_product.productimg, shop_product.published, shop_price.*');
        $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        $this->db->where('shop_product.productid',$id);      
        $this->db->where('shop_product.published',1);      
        return $this->db->get('shop_product')->row();
    }
    
    // check id product 
    public function checkIdProduct($id){    	
    	$this->db->select('ads_news.productid, ads_news.published');
    	$this->db->where('ads_news.published',1);
    	$this->db->where('ads_news.productid',$id);
    	$query  = $this->db->get("ads_news");
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
          if($this->db->delete('ads_news')){
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
