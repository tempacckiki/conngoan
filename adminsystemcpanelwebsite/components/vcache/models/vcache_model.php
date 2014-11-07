<?php
 class vcache_model extends CI_Model{
     
     function __construct(){
         parent::__construct();
     }
    function get_istab_by_cat($catid){
        $this->db->select('catid, catname,caturl');
        $this->db->where('published',1);
        $this->db->where('parentid',$catid);
        $this->db->where('istab',1);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }
    
    function get_subcat($catid){
        $this->db->select('catid, catname,caturl');
        $this->db->where('published',1);
        $this->db->where('parentid',$catid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();  
    }
    
    function check_cat($catid){
        $this->db->where('catid',$catid);
        return $this->db->get('cachecat')->row();
    }
 }
