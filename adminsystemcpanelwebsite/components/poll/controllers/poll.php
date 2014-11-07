<?php
/**************************
* Controller Poll - Tham do y kien
* Author: Tran Ngoc Duoc
* Email: tranngocduoc@gmail.com
* Date: 08/07/2011
***************************/
  class poll extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->pre_message = "";
          $this->uri3  = $this->uri->segment(3);
          $this->load->model('poll_model','poll');        

      }
      
      function index(){
          redirect('poll/listpoll');
      }

      function listpoll(){
          $data['title'] = 'Danh sách thăm dò ý kiến';
          $data['add'] = 'poll/add';
          $data['delete'] = true;
          $field = $this->uri->segment(4);
          $order = $this->uri->segment(5);          
          $config['suffix'] = '/'.$field.'/'.$order;          
          $config['base_url'] = base_url().'poll/listpoll/';  
          $config['total_rows']   =  $this->poll->get_num_poll();
          $data['num'] = $config['total_rows'];
          $config['per_page']  =   20;
          $config['uri_segment'] = 3; 
          $this->pagination->initialize($config);   
          $data['list'] =   $this->poll->get_all_poll($field,$order,$config['per_page'],$this->uri->segment(3));
          $data['pagination']    = $this->pagination->create_links();           
          $data['message'] = $this->pre_message;           
          $this->_templates['page'] = 'list';
          $this->templates->load($this->_templates['page'],$data);
      }

      function add(){
          $data['title'] = 'Thêm mới thăm dò ý kiến';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'poll/listpoll';          
          // Form validation
          $this->form_validation->set_rules('question','Câu hỏi','required');
          if($this->form_validation->run() == false){
               $this->pre_message = validation_errors();
          }else{
              if($id = $this->poll->save_add()){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'poll/listpoll';
                }else{
                    $url = 'poll/edit/'.$id;
                }
                redirect($url);
              }else{
                  $this->pre_message = 'Lưu không thành công';
              }              
          }                                                   
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'add';
          $this->templates->load($this->_templates['page'],$data);
      }
      /***********
      * Cap nhat Album
      * 
      */
      function edit(){
          $data['title'] = 'Cập nhật';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'poll/listpoll';          
          
          $data['rs'] = $this->poll->get_poll_by_id($this->uri3);
          $data['list_rows'] = $this->poll->get_poll_list_rows($data['rs']->pid); 
          // Form validation
          $this->form_validation->set_rules('question','Câu hỏi','required');
          if($this->form_validation->run() == false){
               $this->pre_message = validation_errors();
          }else{

              if($this->poll->save_update($this->uri3)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'poll/listpoll';
                }else{
                    $url = uri_string();
                }
                redirect($url);
              }else{
                  $this->pre_message = 'Lưu không thành công';
              }          

          }                                                   
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'edit';
          $this->templates->load($this->_templates['page'],$data);
      }      
      // Xoa 1 ban ghi
      function del(){
          $id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
            if($this->vdb->delete('poll',array('pid'=>$id))){
                $this->vdb->delete('poll_rows',array('pid'=>$id));
                $this->session->set_flashdata('message','Đã xóa thành công');
            }else{
                $this->session->set_flashdata('message','Xóa không thành công');
            } 
          redirect('poll/listpoll/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('poll',array('pid'=>$ar_id[$i]))){
                            $this->vdb->delete('poll_rows',array('pid'=>$ar_id[$i]));
                            $this->session->set_flashdata('message','Đã xóa thành công');
                        }else{
                            $this->session->set_flashdata('error','Xóa không thành công');
                        }
                    }
                }
            }
            redirect('poll/listpoll/'.$page);
      }

  }
