<?php
  class poll_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      
      function get_last_poll(){
          $this->db->where('IsActive',1);
          return $this->db->get('poll')->row();
      }
      
      function get_poll_by_id($pid){
          $this->db->where('pid',$pid);
          return $this->db->get('poll')->row();
      }
      
      function get_poll_row($pid){
          $this->db->where('pid',$pid);
          $this->db->order_by('id','asc');
          return $this->db->get('poll_rows')->result();
      }
      
      function update_his_in_question($pid){
          $query = $this->db->query("UPDATE poll SET total = total + 1, hit_date = ".time()." WHERE pid = ".$pid);
          if($query){
              return true;
          }else{
              return false;
          }
      }
      function update_his_in_row($id){
          $query = $this->db->query("UPDATE poll_rows SET hitstotal = hitstotal + 1 WHERE id = ".$id);
          if($query){
              return true;
          }else{
              return false;
          }
      } 
      
      function insert_history($pid){
          $poll['pid'] = $pid;
          $poll['ip_address'] = $this->input->ip_address();
          $poll['history_date'] = time();
          if($this->db->insert('poll_history',$poll)){
              return true;
          }else{
              return false;
          }
      }
      
      function check_history_poll($pid,$ip_address){
         $this->db->where('pid',$pid);
         $this->db->where('ip_address',$ip_address);
         $this->db->order_by('history_date','desc');
         return $this->db->get('poll_history')->row();
         
      }
  }
?>
