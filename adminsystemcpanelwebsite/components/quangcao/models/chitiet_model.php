<?php
class chitiet_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_danhmuc(){
        $this->db->where('parentid',0);
        return $this->db->get('shop_cat')->result();
    }
    
    function get_all_quangcao($catid){
        
        $this->db->where('cat_id',$catid);
        
        $this->db->where('position',2);
        $this->db->order_by('ordering','asc');
        return $this->db->get('banner_detail')->result();
    }
    
    function get_limit_qc($catid, $city_id = 25){
        $this->db->where('city_id',$city_id);
        $this->db->where('cat_id',$catid);
        $this->db->order_by('ordering','asc');
        $this->db->limit(2);
        return $this->db->get('banner_detail')->result();
    }
}
