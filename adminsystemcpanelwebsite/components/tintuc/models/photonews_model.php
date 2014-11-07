<?php
class photonews_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
   
     
    /// Model Danh muc tin tuc
    function get_all_danhmuc($parentid = 0){
        $this->db->where('parentid',$parentid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('news_cat')->result();
    }
    
    function check_danhmuc($catid){
        $this->db->where('parentid',$catid);
        $total =  $this->db->get('news_cat')->num_rows();
        if($total > 0){
            return false;
        }else{
            return true;
        }
    }
    
    
    
  /*********************************
    * Module Bai viet
    */
    function get_num_baivietMany($cat_id = 0, $key){
        if($cat_id != 0){
            $ar_id = $this->get_ar_cat($cat_id);
        }
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($cat_id != 0){
            $this->db->where_in('catid',$ar_id);
        }
        $this->db->where('is_photo',1);
        return $this->db->get('news_detail')->num_rows();        
    }
    
    
	
     /*--------------------------------------+
     * 
     +------------------------------------*/
 	function get_all_baivietMany($num, $offset, $cat_id = 0, $key, $field, $order){
        if($cat_id != 0){
            $ar_id = $this->get_ar_cat($cat_id);
        }
        
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($cat_id != 0){
            $this->db->where_in('catid',$ar_id);
        }
		$this->db->where("is_photo", 1);
        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('newsid','desc');
        }
        return $this->db->get('news_detail',$num,$offset)->result();
    }
    
 
    /*--------------------------------------+
     * 
     +------------------------------------*/
    function get_ar_cat($catid){
        $ar_id = array($catid);
        $this->db->where('parentid',$catid);
        $list = $this->db->get('news_cat')->result();
        foreach($list as $rs):
            array_push($ar_id, $rs->catid);
        endforeach;
        return $ar_id;
    }
     
}
