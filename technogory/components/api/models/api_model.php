<?php
class api_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function loadRating($id){
      $this->db->where('productid',$id);
      $query = $this->db->get('shop_rating');
      $item = $query->row();
      $rating = (@round($item->value / $item->counter,1)) * 20;
      return $rating;
    } 
    
    /**********
    * Comment
    */
    function get_num_comment($productid){
        $this->db->where('productid',$productid);
        $this->db->where('published',1);
        return $this->db->get('shop_comment')->num_rows();
    }
    
    function get_all_comment($num, $offset, $productid){
        $this->db->where('productid',$productid);
        $this->db->where('published',1);
        $this->db->order_by('add_date','desc');
        return $this->db->get('shop_comment',$num,$offset)->result();
    }
}
