<?php
class syn_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->fyi = $this->load->database('fyi',true);
        
    }
    
    function getCity(){
        return $this->fyi->get('city')->result();
    }
    
    function getUser(){
        return $this->fyi->get('account')->result();
    }
    
    function get_category($ar_id){
        $this->fyi->where_in('ParentID',$ar_id);
        return $this->fyi->get('category')->result();
    }
    
    function get_sub_cat($parentid){
        $this->fyi->where('ParentID',$parentid);
        return $this->fyi->get('category')->result();  
    }
    
    
    function get_sanpham($ar_id){
        $this->fyi->select('categoryproduct.*, product.*');
        $this->fyi->join('categoryproduct','categoryproduct.ProductID = product.ProductID');
        $this->fyi->where_in('categoryproduct.CategoryID',$ar_id);
        $this->fyi->limit(10);
       return  $this->fyi->get('product')->result();
    }
    
    
    function get_nsx(){
        return $this->fyi->get('menufacture')->result();
    }
    
    function check_id($ProductID){
       
    }

    
    function get_product_img($ProductID){
        $this->fyi->where('ProductID',$ProductID);
        return $this->fyi->get('productimage')->result();
    }
}
