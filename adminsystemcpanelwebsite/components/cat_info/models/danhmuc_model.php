<?php
class danhmuc_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_danhmuc(){
        $this->db->where('parentid',0);
        return $this->db->get('shop_cat')->result();
    }
    
    function get_all_quangcao($catid){
        if($catid != 0){
            $this->db->where('cat_id',$catid);
        }
        $this->db->where('position',2);
        $this->db->order_by('ordering','asc');
        return $this->db->get('banner')->result();
    }
    
    function get_limit_qc($catid){
        $this->db->where('cat_id',$catid);
        $this->db->order_by('ordering','asc');
        $this->db->limit(2);
        return $this->db->get('banner')->result();
    }
    
    // Get list sub cat
    function get_sub_cat($CatID){
    	$this->db->where('parentid',$CatID);
    	$this->db->order_by('ordering','asc');
    	return $this->db->get('shop_cat')->result();
    }
}
