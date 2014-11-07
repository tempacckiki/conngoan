<?php
class tintuc_model extends CI_Model{
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
    
    function check_baiviet($catid){
        $this->db->where('catid',$catid);
        $total = $this->db->get('news_detail')->num_rows();
        if($total > 0){
            return false;
        }else{
            return true;
        }
    }
    
    
    /*********************************
    * Module Bai viet
    */
    function get_num_baiviet($cat_id = 0, $key){
        if($cat_id != 0){
            $ar_id = $this->get_ar_cat($cat_id);
        }
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($cat_id != 0){
            $this->db->where_in('catid',$ar_id);
        }
        return $this->db->get('news_detail')->num_rows();        
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
        $this->db->where('view_many',1);
        return $this->db->get('news_detail')->num_rows();        
    }
    
    
	/*********************************
    * Module Bai viet thumb
    +----------------------------*/
    function get_num_baivietThumb($cat_id = 0, $key){
        if($cat_id != 0){
            $ar_id = $this->get_ar_cat($cat_id);
        }
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($cat_id != 0){
            $this->db->where_in('catid',$ar_id);
        }
        $this->db->where('is_thumb',1);
        return $this->db->get('news_detail')->num_rows();        
    }
    
    function get_all_baiviet($num, $offset, $cat_id = 0, $key, $field, $order){
        if($cat_id != 0){
            $ar_id = $this->get_ar_cat($cat_id);
        }
        
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($cat_id != 0){
            $this->db->where_in('catid',$ar_id);
        }

        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('newsid','desc');
        }
        return $this->db->get('news_detail',$num,$offset)->result();
    }
    //view many
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
		$this->db->where("view_many", 1);
        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('newsid','desc');
        }
        return $this->db->get('news_detail',$num,$offset)->result();
    }
    
 //view thumb
 	public function get_all_baivietThumb($num, $offset, $cat_id = 0, $key, $field, $order){
        if($cat_id != 0){
            $ar_id = $this->get_ar_cat($cat_id);
        }
        
        if($key != ''){
            $this->db->like('title',$key);
        }        
        if($cat_id != 0){
            $this->db->where_in('catid',$ar_id);
        }
		$this->db->where("is_thumb", 1);
        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('newsid','desc');
        }
        return $this->db->get('news_detail',$num,$offset)->result();
    }
    
    function get_ar_cat($catid){
        $ar_id = array($catid);
        $this->db->where('parentid',$catid);
        $list = $this->db->get('news_cat')->result();
        foreach($list as $rs):
            array_push($ar_id, $rs->catid);
        endforeach;
        return $ar_id;
    }
      function get_num_comment(){
          return $this->db->get('news_comment')->num_rows();
      }    
      function get_all_comment($field,$order,$num,$offset){
          if($field != '' || $order != ''){
              $this->db->order_by($field,$order);
          }else{
              $this->db->order_by('commentid','desc');
          }
          return $this->db->get('news_comment',$num,$offset)->result();
      }
      function get_comment_by_id($commentid){
          $this->db->select('news_detail.title,news_comment.*');
          $this->db->join('news_detail','news_detail.newsid = news_comment.newsid');
          $this->db->where('news_comment.commentid',$commentid);
          return $this->db->get('news_comment')->row();
      }    
}
