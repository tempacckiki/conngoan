<?php
  class poll_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      
      function get_all_poll($field,$order,$num,$offset){
          if($field != '' && $order !=''){
              $this->db->order_by($field,$order);
          }else{
              $this->db->order_by('pid','DESC');
          }
          return $this->db->get('poll',$num,$offset)->result();
      }
      
      function get_num_poll(){
          return $this->db->get('poll')->num_rows();
      }
      
      function save_add(){
          $ar_value = $this->input->post('ar_value');
          $question = $this->input->post('question');
          $data_poll = array(
            'question' => $question,
            'add_date' => time()
          );
          if($this->db->insert('poll',$data_poll)){
              $pid = $this->db->insert_id();
              for($i=0;$i<sizeof($ar_value);$i++){
                  $data_rows = array(
                    'title' => $ar_value[$i],
                    'pid' => $pid
                  );
                  $this->db->insert('poll_rows',$data_rows);
              }
              return $pid;
          }else{
              return false;
          }
      }
      
      function get_poll_by_id($pid){
          $this->db->where('pid',$pid);
          return $this->db->get('poll')->row();
      }
      
      function get_poll_list_rows($pid){
          $this->db->order_by('id','asc');
          $this->db->where('pid',$pid);
          return $this->db->get('poll_rows')->result();
      }
      
      function save_update($pid){
          $ar_value = $this->input->post('ar_value');
          $question = $this->input->post('question');
          $data_poll = array(
            'question' => $question,
            'add_date' => time()
          );
          $this->db->where('pid',$pid);
          if($this->db->update('poll',$data_poll)){
              $total = count($this->get_poll_list_rows($pid));
              $i=1;  
              foreach($this->input->post('ar_value') as $key => $value){
                    $data_rows = array(
                        'title' => $value,
                        'pid' => $pid
                    );
                    if($i <= $total){
                        if($value==''){
                            $this->db->where('id',$key);
                            $this->db->delete('poll_rows');
                        }
                            $this->db->where('id',$key);
                            $this->db->update('poll_rows',$data_rows);                        
                        
                    }else{
                        if($value !=''){
                         $this->db->insert('poll_rows',$data_rows); 
                        }
                    }
                    $i++;
              }
              return true;
          }else{
              return false;
          }
      }      
  }
?>
