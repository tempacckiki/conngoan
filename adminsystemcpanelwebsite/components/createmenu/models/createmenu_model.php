<?php
class createmenu_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function check($maincat,$col,$catid){
        $this->db->where('maincat',$maincat);
        $this->db->where('col',$col);
        $this->db->where('catid',$catid);
        $row = $this->db->get('built_menu')->row();
        if($row){
            return true;
        }else{
            return false;
        }
    }
    
    function checkcatid($catid,$maincat){
        $this->db->where('catid',$catid);
        $this->db->where('maincat',$maincat);
        $check = $this->db->get('built_menu')->row();  
        if($check){
            return true;
        }else{
            return false;
        }
    }
    
    function get_all_maincat(){ 
        $this->db->select('shop_cat.*, built_menu.*');
        $this->db->join('shop_cat','built_menu.maincat = shop_cat.catid');
       // $this->db->where('built_menu.maincat',$maincat);
        $this->db->where("shop_cat.parentid",0);
        $this->db->group_by('maincat');
        $this->db->order_by('shop_cat.ordering','asc');
        return $this->db->get('built_menu')->result();
    }
    
    function get_sub2($maincat,$col){
        $this->db->select('shop_cat.*, built_menu.*');
        $this->db->join('shop_cat','shop_cat.catid = built_menu.catid');       
        $this->db->where('shop_cat.no_menu !=',1);
        $this->db->where('built_menu.maincat',$maincat);
        $this->db->where('built_menu.col',$col);
        $this->db->order_by('shop_cat.ordering','asc');
        return $this->db->get('built_menu')->result(); 
    }
    
    function get_sub3($catid){
        $this->db->where('published',1);
        $this->db->where('no_menu !=',1);
        $this->db->where('parentid',$catid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result(); 
    }
    
    function get_total_col($maincat){
        $this->db->where('maincat',$maincat);
        $this->db->group_by('col');
        return $this->db->get('built_menu')->num_rows();
    }
}
