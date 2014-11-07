<?php
class danhmuc_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->fyi = $this->load->database('fyi',true);  
    }
    
    function get_all_danhmuc($parentid = 0){
        $this->fyi->where('ParentID',$parentid);
        $this->fyi->order_by('Ordering','asc');
        return $this->fyi->get('category')->result();
        
    }
}
