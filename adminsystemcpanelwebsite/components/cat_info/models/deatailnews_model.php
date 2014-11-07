<?php
class deatailnews_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    /*
     * getItem method
    * Params <iteger>
    */
    
    function get_all_danhmuc(){    	
    	return $this->db->get('cat_info')->result();
    }
    /*
     * getItem method
     * Params <iteger>
     */ 
    
    function getItem($idNews){
        $this->db->where('cat_id', $idNews);
        return $this->db->get('cat_info')->result();
    }
    //**
    
    function get_all_quangcao($idNews){
    	if ($idNews >0){
        	$this->db->where('cat_id',$idNews);
    	}             
        $this->db->order_by('ordering','asc');
        return $this->db->get('cat_info')->result();
    }
    
    function get_limit_qc($catid){
        $this->db->where('cat_id',$catid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('cat_info')->result();
    }
}
