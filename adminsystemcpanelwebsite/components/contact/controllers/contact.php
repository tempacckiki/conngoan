<?php
  class contact extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->load->config('config_contact');
          $this->menu = $this->config->item('menu');
          $this->pre_message = "";
      }
      
      function index(){
          $this->create_config();
          $data['title'] = 'Liên hệ';
          $data['save'] = true;
          $data['rs'] = $this->vdb->find_by_id('contact',array('id'=>1));
          $data['rs_en'] = $this->vdb->find_by_id('contact_en',array('id'=>1));
          //form validation
          $this->form_validation->set_rules('contact[name]','Tên liên hệ - vi','required');
          $this->form_validation->set_rules('contact_en[name]','Tên liên hệ - en','required');
          $this->form_validation->set_rules('contact[address]','Địa chỉ - vi','required');
          $this->form_validation->set_rules('contact_en[address]','Địa chỉ - en','required');
          if($this->form_validation->run() === FALSE){
              $this->pre_message = validation_errors();
          }else{
              $contact = $this->input->post('contact');
              $contact_en = $this->input->post('contact_en');
              if($this->vdb->update('contact',$contact,array('id'=>1))){
                  $contact_en['phone'] = $contact['phone'];
                  $contact_en['fax'] = $contact['fax'];
                  $contact_en['email'] = $contact['email'];
                  $contact_en['img'] = $contact['img'];
                  $this->vdb->update('contact_en',$contact_en,array('id'=>1));
                  $this->session->set_flashdata('message','Lưu thành công');
                  redirect('contact');
              }
          }
          $data['messsage'] = $this->pre_message;
          $this->_templates['page'] = 'index';
          $this->templates->load($this->_templates['page'],$data);
      }
      
      function listcontact(){
          $data['title'] = 'Danh sách liên hệ';
          $data['delete'] = true;
          $field = $this->uri->segment(4);
          $order = $this->uri->segment(5);   
          if($field =='' && $order == ''){
              $field = 'read';
              $order = 'asc';
          }       
          $config['suffix'] = '/'.$field.'/'.$order;            
          $config['base_url'] = base_url().'contact/listcontact/';  
          $config['total_rows']   =  $this->vdb->find_by_num('contact_row');
          $data['num'] = $config['total_rows'];
          $config['per_page']  =   20;
          $config['uri_segment'] = 3; 
          $this->pagination->initialize($config);   
          $data['list'] =   $this->vdb->find_by_all('contact_row',$config['per_page'],$this->uri->segment(3),0,$field,$order);
          $data['pagination']    = $this->pagination->create_links(); 
          $this->_templates['page'] = 'list';
          $this->templates->load($this->_templates['page'],$data);
      }
      
      function edit(){
          $data['title'] = 'Chi tiết liên hệ';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'contact/listcontact';
          
          $data['rs'] = $this->vdb->find_by_id('contact_row',array('contactid'=>$this->uri->segment(3)));
          // Form validation
          $this->form_validation->set_rules('subject','Tiêu đề','required');
          $this->form_validation->set_rules('content','Nội dung','required');
          if($this->form_validation->run() === FALSE){
              $this->pre_message = validation_errors();
          }else{
              $this->load->helper('mail_helper');
              $rs = $this->vdb->find_by_id('contact',array('id'=>1));
              $to = $this->input->post('to');
              $subject = $this->input->post('subject');
              $message = $this->input->post('content');
              $contact_name = $rs->name;
              $contact_email = $rs->email;
              if(!send($to,$subject,$message,$contact_name,$contact_email)){
                 $this->pre_message = "Gửi E-mail không thành công";
              }else{
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'contact/listcontact';
                }else{
                    $url = uri_string();
                }
                redirect($url);                  
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
             if($this->vdb->delete('contact_row', array('contactid'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('contact/listcontact/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('contact_row', array('contactid'=>$ar_id[$i])))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('contact/listcontact/'.$page);
      }
      
      function create_config(){
          $this->load->helper('file');
          $rs = $this->vdb->find_by_id('contact',array('id'=>1));

          $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File Config_site language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
          $str .= "\n\$config['contact_name'] = '$rs->name';"; 
          $str .= "\n\$config['contact_address'] = '$rs->address';"; 
          $str .= "\n\$config['contact_phone'] = '$rs->phone';"; 
          $str .= "\n\$config['contact_fax'] = '$rs->fax';"; 
          $str .= "\n\$config['contact_email'] = '$rs->email';"; 
          $str .= "\n\n/* End of file config_site*/";        
          write_file(ROOT.'technogory/config/config_contact.php', $str);
      }
  }
