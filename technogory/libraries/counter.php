<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 
  class CI_counter{
      function __construct(){
          $this->CI = get_instance();
          $this->set_counter();
      }
      
      function set_counter(){
          $limit_time = time() - 300;
          $this->CI->db->where('timestamp <',$limit_time);
          $this->CI->db->delete('counter');
          
          $session_id = $this->CI->session->userdata('session_id');
          $accountid = $this->CI->session->userdata('accountid');
          $this->CI->db->where('session_id',$session_id);
          $query = $this->CI->db->get('counter');
          $check_session = $query->row();
          $date = date('Y-m-d',time()); 
          $month = date('m',time());
          $today = date('d',time());

          if(!$check_session){
             // Kiem tra session ton tai hay khong => them moi vao db;
             $counter['session_id'] = $session_id;
             $counter['ip_address'] = $_SERVER['REMOTE_ADDR'];
             $counter['accountid'] = $accountid;
             $counter['timestamp'] = time();  
             $this->CI->db->insert('counter',$counter);
             
             // Cap nhat thong tin tong bo dem
             $this->CI->db->query("UPDATE counter_history SET c_count = c_count + 1, last_update = ".time()." WHERE c_type = 'total'");
             // Cap nhat thong tin bo dem thang
             if($this->check_counter_month()){
                $this->CI->db->query("UPDATE counter_history SET c_count = c_count + 1, last_update = ".time()." WHERE c_type = 'month'");
             }else{
                $this->CI->db->query("UPDATE counter_history SET c_count = 1 , c_val = '$month' , last_update = ".time()." WHERE c_type = 'month'");
             }
             
             // Cap nhat thong tin bo dem hom nay
             if($this->check_counter_today()){
                $this->CI->db->query("UPDATE counter_history SET c_count = c_count + 1,c_val = '$today', last_update = ".time()." WHERE c_type = 'today'");
             }else{
                $this->CI->db->query("UPDATE counter_history SET c_count = 1 , c_val = '$today' , last_update = ".time()." WHERE c_type = 'today'");
             }
             
             $total = $this->CI->db->get('counter')->num_rows();
             $this->CI->db->query("UPDATE counter_history SET c_count = $total , last_update = ".time()." WHERE c_type = 'isonline'");
          }else{
             //Session_id <> null cập nhật
             $data = array(
                'timestamp' => time()
             );
             $this->CI->db->where('session_id',$session_id);
             $this->CI->db->update('counter',$data);
          }                              
      }
      
      function check_counter_month(){
          $this->CI->db->where('c_type','month');
          $this->CI->db->where('c_val',date('m',time()));
          $check = $this->CI->db->get('counter_history')->row();
          if($check){
              return true;
          }else{
              return false;
          }
      }
      
      function check_counter_today(){
          $this->CI->db->where('c_type','today');
          $this->CI->db->where('c_val',date('d',time()));
          $check = $this->CI->db->get('counter_history')->row();
          if($check){
              return true;
          }else{
              return false;
          }          
      }
  }