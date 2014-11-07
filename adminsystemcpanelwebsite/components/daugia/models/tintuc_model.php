<?php
class tintuc_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_section($lang){
        $this->db->order_by('ordering','asc');
        $this->db->where('site',2);
        return $this->db->get('sections')->result();
    }
    
    function get_all_category($section = 0){
        $this->db->where('site',2);
        $this->db->where('parent_id',0);
        $this->db->order_by('ordering','asc');
        return $this->db->get('product_category')->result();
    }
    
    function find_by_num($sections_id, $cat_id, $key){
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($sections_id != 0){
            $this->db->where('sections_id',$sections_id);
        }
        if($cat_id != 0){
            $this->db->where('catid',$cat_id);
        }
        $this->db->where('site',2);
        return $this->db->get('product_content')->num_rows();        
    }
    
    function find_by_all($num, $offset, $sections_id, $cat_id, $key, $field, $order){
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
        $this->db->where('site',2);
        return $this->db->get('product_content',$num,$offset)->result();
    }
    
    function ar_option_cat($cat_id = 0, $select=0, $level = 0){
        $this->db->where('parent_id',$cat_id);
        $this->db->where('lang',vnit_lang());
        $this->db->order_by('ordering','asc');
        $list = $this->db->get('product_category')->result();
        $level ++;
        $data = '';
        foreach($list as $rs):
            $sel = ($select == $rs->cat_id)?'selected="selected"':'';
            $data .='<option value="'.$rs->cat_id.'" '.$sel.'>'.str_repeat('<span class="gi">|----</span>', $level).' '.$rs->cat_title.'</option>';    
            $data .=$this->ar_option_cat($rs->cat_id,$select,$level);
        endforeach;
        
        $data .='';
        return $data;
        
    }
    
    function ar_option_catlist($cat_id = 0, $select=0, $level = 0){
        $this->db->where('parent_id',$cat_id);
        $this->db->where('lang',vnit_lang());
        $this->db->order_by('ordering','asc');
        $list = $this->db->get('product_category')->result();
        $level ++;
        $data = '';
        foreach($list as $rs):
            $link = site_url('content/listcontent/0/?option=true&cat_id='.$select);
            $sel = ($select == $rs->parent_id)?'selected="selected"':'';
            $data .='<option value="'.$link.'" '.$sel.'>'.str_repeat('<span class="gi">|----</span>', $level).' '.$rs->cat_title.'</option>';    
            $data .=$this->ar_option_catlist($rs->cat_id,$select,$level);
        endforeach;
        
        $data .='';
        return $data;
        
    }
}
