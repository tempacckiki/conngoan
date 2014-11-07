<?php
class binhluan_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function get_all_comment($field,$order,$num,$offset){
      if($field != '' || $order != ''){
          $this->db->order_by($field,$order);
      }else{
          $this->db->order_by('commentid','desc');
      }
      return $this->db->get('cheap_comment',$num,$offset)->result();
    }

    function get_num_comment(){
      return $this->db->get('cheap_comment')->num_rows();
    }

    function get_comment_by_id($commentid){
      $this->db->select('cheap_comment.*,cheap_list.*');
      $this->db->join('cheap_list','cheap_list.id = cheap_comment.cheap_id');
      $this->db->where('cheap_comment.commentid',$commentid);
      return $this->db->get('cheap_comment')->row();
    } 

    function save_comment(){
      $commentid = (int)$this->uri->segment(3);
      $this->db->where('commentid',$commentid);
      if($this->db->update('cheap_comment',$this->input->post('comment'))){
          return true;
      }else{
          return false;
      }
    } 

    function delete_comment($commentid)     {
      $this->db->where('commentid',$commentid);
      if($this->db->delete('cheap_comment')){
          return true;
      }else{
          return false;
      }
    }
}