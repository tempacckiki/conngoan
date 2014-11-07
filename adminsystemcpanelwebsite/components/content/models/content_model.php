<?php
class content_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_section($lang){
        $this->db->order_by('ordering','asc');
        $this->db->where('lang',$lang);
        return $this->db->get('sections')->result();
    }
    
    function get_all_category($section = 0,$lang){
        if($section != 0){
            $this->db->where('section',$section);
        }
        $this->db->where('lang',$lang);
        $this->db->order_by('ordering','asc');
        return $this->db->get('category')->result();
    }
    
    function find_by_num($sections_id, $cat_id, $key,$lang){
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($sections_id != 0){
            $this->db->where('sections_id',$sections_id);
        }
        if($cat_id != 0){
            $this->db->where('catid',$cat_id);
        }
        $this->db->where('lang',$lang);
        return $this->db->get('content')->num_rows();        
    }
    
    function find_by_all($num, $offset, $sections_id, $cat_id, $key, $lang, $field, $order){
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($sections_id != 0){
            $this->db->where('sections_id',$sections_id);
        }
        if($cat_id != 0){
            $this->db->where('catid',$cat_id);
        }

        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('id','desc');
        }
        $this->db->where('lang',$lang);
        return $this->db->get('content',$num,$offset)->result();
    }
}
