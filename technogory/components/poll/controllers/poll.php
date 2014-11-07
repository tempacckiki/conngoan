<?php
  class poll extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->load->model('poll_model','poll');
          $this->load->helper('cookie');
      }
      
      function index(){
          $data['rs'] = $this->poll->get_last_poll();
          $data['list'] = $this->poll->get_poll_row($data['rs']->pid);
          $this->_templates['page'] = 'index';
          $this->load->view($this->_templates['page'],$data);
      }
      
      function show_poll(){      
      $this->load->helper('cookie');     
          $pid = (int)$this->uri->segment(3);
          $row_id = (int)$this->uri->segment(4);
          $ip_address = $this->input->ip_address();
          $check = $this->poll->check_history_poll($pid,$ip_address);
          if(get_cookie("voted".$pid)!='yes'){
              if($this->poll->update_his_in_question($pid)){
                  if($this->poll->update_his_in_row($row_id)){
                        set_cookie("voted".$pid, 'yes', time()+86400*300); 
                        //set_cookie($cookie)                ;
                      $this->poll->insert_history($pid);

                      $data['fix'] = 0;
                      $data['msg'] = 'Bình chọn thành công. Cảm ơn bạn đã bình chọn';
                  }else{
                      $data['fix'] = 1;
                      $data['msg'] = 'Bạn không thể thực hiện được bình chọn';
                  }  
              }else{
                  $data['fix'] = 1;
                  $data['msg'] = 'Bạn không thể thực hiện được bình chọn';
              } 
          }else{
                  $data['fix'] = 1;
                  $data['msg'] = 'Bạn đã bình chọn';              
          }   
          $data['poll'] = $this->poll->get_poll_by_id($pid);
          $data['list'] = $this->poll->get_poll_row($pid);                
          $this->_templates['page'] = 'result';
          $this->load->view($this->_templates['page'],$data);
      }
      
      function show_result(){
          $pid = (int)$this->uri->segment(3);
          $data['poll'] = $this->poll->get_poll_by_id($pid);
          $data['list'] = $this->poll->get_poll_row($pid);       
          $this->_templates['page'] = 'show_result';
          $this->load->view($this->_templates['page'],$data);             
      }
  }
?>
