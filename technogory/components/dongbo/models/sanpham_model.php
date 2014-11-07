<?php
class sanpham_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->fyi = $this->load->database('fyi',true);
    }
    
    function get_sanpham(){
        $this->fyi->order_by('product.ProductID','asc');
        return  $this->fyi->get('product',500,18500)->result();
    }
    
    
    function get_list_sanpham($num, $offset){
        $this->fyi->order_by('ProductID','asc');
        return  $this->fyi->get('product',$num,$offset)->result();
    }
    
    function get_all_sanpham(){
        $this->fyi->select('ProductID');
        return  $this->fyi->get('product')->num_rows(); 
    }
    
    function get_danhmuc_by_id($ProductID){
        $this->fyi->where('ProductID',$ProductID);
        return $this->fyi->get('categoryproduct')->row()->CategoryID;
    }
}
