<?php
class hinhanh_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->fyi = $this->load->database('fyi',true);
    }
    
    function get_all_img($limit,$offset){
        $this->fyi->where('ProductID !=',0);
        $this->fyi->order_by('ImageID','asc');
        return $this->fyi->get('productimage',$limit,$offset)->result();
    }
    
    function get_num_hinhanh(){
        $this->fyi->where('ProductID !=',0);
        return $this->fyi->get('productimage')->num_rows(); 
    }
}
