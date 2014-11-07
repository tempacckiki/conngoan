<?php
class danhmuc_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
     /*********************************|
      |                                 |
      |  Model xu ly san pham           |
      |                                 |
      |*********************************/    
      
      function get_all_product($catid){       
         $this->db->select('newsid, title_alias,catid,caturl');                  
         $this->db->where('catid',$catid);
         $this->db->where('published',1);
                  
         return $this->db->get('news_detail')->result(); 
             
          
      } 
      
      
    // Get list main cat 
    function get_main_cat($maincat = 0){
        $this->db->where('parentid',$maincat);
        $this->db->order_by('ordering','asc');
        return $this->db->get('news_cat')->result();
    }
    
    // Hien thi danh sach chuyen mục tin tuc
    function get_all_cat($num, $offset, $maincat=0, $field, $order){
         
        $this->db->where('parentid',$maincat);
        return $this->db->get('news_cat',$num,$offset)->result();
    }
    
    function get_num_cat($maincat=0){
        $this->db->where('parentid',$maincat);
        return $this->db->get('news_cat')->num_rows();
    }    
    
    // Get list sub cat
    function get_sub_cat($CatID){
        $this->db->where('parentid',$CatID);
        $this->db->order_by('ordering','asc');
        return $this->db->get('news_cat')->result();
    } 
    
    
    /*******/     
    // Xoa chuyen muc
    function delete_cat($catid){
        $this->db->where('catid',$catid);
        if($this->db->delete('shop_cat')){
          $this->vdb->delete('shop_cat_en',array('catid'=>$catid));
          return true;
        }else{
          return false;
        }
    } 
    
    function check_subcat($catid){
        $this->db->where('parentid',$catid);
        $total = $this->db->get('shop_cat')->num_rows();
        if($total > 0){
            return false;
        }else{
            return true;
        }
    }
    
    function check_product_incat($catid){
        $this->db->where('catid',$catid);
        $total = $this->db->get('shop_product')->num_rows();
        if($total > 0){
            return false;
        }else{
            return true;
        }
    }
    
    function get_list_nsx($catid){
        $this->db->select('shop_cat_manufacture.*, shop_manufacture.*');
        $this->db->join('shop_cat_manufacture','shop_manufacture.manufactureid = shop_cat_manufacture.manufactureid');
        $this->db->where('shop_cat_manufacture.catid',$catid);
        $this->db->order_by('shop_cat_manufacture.ordering','asc');
        return $this->db->get('shop_manufacture')->result();
    }
    
      

}
