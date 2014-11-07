<?php
  class payment extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->pre_message = "";        
          $this->load->model('payment_model','payment');
      }
      
      function index(){
          redirect('product/payment/listpay');
      }
      
      function listpay(){
          $data['title'] = 'Phương thức thanh toán';
          $data['delete'] = true;
          $data['add'] = 'product/payment/add|Thêm mới phương thức';
          $data['list'] = $this->payment->get_all_payment();
          $data['num'] = count($data['list']);
          $this->_templates['page'] = 'payment/list';
          $this->templates->load($this->_templates['page'],$data);
      }
      function add(){
          $data['title']  = 'Thêm mới';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'product/payment/listpay';          
          // Form validation
          $this->form_validation->set_rules('payment[payment_name]','Phương thức','required');
          $this->form_validation->set_rules('payment[payment_des]','Nội dung','required');
          if($this->form_validation->run() == false){
              $this->pre_message = validation_errors();
          }else{
              if($this->payment->save_payment()){
                  $this->session->set_flashdata('message','Lưu thành công');
                  redirect('product/payment/listpay');
              }
          }
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'payment/add';
          $this->templates->load($this->_templates['page'],$data);
      }
            
      function edit(){
          $data['title']  = 'Câp nhật';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'product/payment/listpay';          
          $data['rs'] = $this->payment->get_payment_by_id($this->uri->segment(4));
          // Form validation
          $this->form_validation->set_rules('payment[payment_name]','Phương thức','required');
          $this->form_validation->set_rules('payment[payment_des]','Nội dung','required');
          $this->form_validation->set_rules('payment[payment_img]','Hình ảnh','');
          $this->form_validation->set_rules('payment[ordering]','Sắp xếp','');
          $this->form_validation->set_rules('payment[published]','Hiển thị','');
          if($this->form_validation->run() == false){
              $this->pre_message = validation_errors();
          }else{
              $id = $this->input->post('id');
              $pay = $this->input->post('payment');
              if($this->vdb->update('shop_payment',$pay,array('payment_id'=>$id))){
                    $this->session->set_flashdata('message','Lưu thành công');
                    $option =  $this->input->post('option');
                    if($option == 'save'){
                       $url = 'product/payment/listpay/';
                    }else{
                        $url = uri_string();
                    }
                    redirect($url);
              }
          }
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'payment/edit';
          $this->templates->load($this->_templates['page'],$data);
      }
  }
?>
