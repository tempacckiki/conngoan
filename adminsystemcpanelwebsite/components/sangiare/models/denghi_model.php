<?php
class denghi_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_denghi($field,$order,$num,$offset){
        if($field != '' || $order != ''){
          $this->db->order_by($field,$order);
        }else{
          $this->db->order_by('id','desc');
        }
        return $this->db->get('cheap_proposal',$num,$offset)->result();
    }

    function get_num_denghi(){
        return $this->db->get('cheap_proposal')->num_rows();
    }

    function get_comment_by_id($commentid){
      $this->db->select('cheap_comment.*,cheap_list.*');
      $this->db->join('cheap_list','cheap_list.id = cheap_comment.cheap_id');
      $this->db->where('cheap_comment.commentid',$commentid);
      return $this->db->get('cheap_comment')->row();
    } 
}
