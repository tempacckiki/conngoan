<?php
    class weblink extends CI_Controller{
        protected $_templates;
        function __construct(){
            parent::__construct();
            $this->pre_message  = "";
            $this->load->model('weblink_model','weblink');
        }
        function index(){
            redirect('weblink/listweblink'); 
        }
        function listweblink(){
            $data['title'] = 'Danh sách liên kết website';
            $data['delete'] = true;
            $data['add']  = 'weblink/add';
            $field = $this->uri->segment(4);
            $order = $this->uri->segment(5);
            if($field = '' && $order = ''){
                $field = 'kh_id';
                $order = 'desc';
            }
            $config['suffix'] = '/'.$field.'/'.$order;
            $config['base_url'] = base_url().'weblink/listweblink';
            $config['total_row'] = $this->vdb->find_by_num('weblink');
            $data['num'] = $config['total_row'];
            $config['per_page'] = '20';
            $config['uri_segment'] = '3';
            $this->pagination->initialize($config);
            $data['list'] = $this->vdb->find_by_all('weblink', $config['total_row'], $this->uri->segment(3),0 ,$field, $order);
            $data['pagination'] = $this->pagination->create_links();
            $this->_templates['page'] = 'index';
            $this->templates->load($this->_templates['page'],$data);
        
        }
        function add(){
            $this->load->model('weblink_model','weblink');
          $data['title'] = 'Thêm mới';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'weblink/listweblink'; 
          // Form validation
          $this->form_validation->set_rules('name','Tên liên kết','trim|required');
          $this->form_validation->set_rules('weblink_img','','');
          $this->form_validation->set_rules('link','','');
          if($this->form_validation->run() == false){
              $this->pre_message = validation_errors();
          }else{
              if($this->weblink->save_weblink()){
                  $this->session->set_flashdata('message','Lưu thành công');
                  redirect('weblink/listweblink');
              }else{
                  $this->pre_message = 'Lưu không thành công';
              }
          }
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'add';
          $this->templates->load($this->_templates['page'],$data);
      }
      
      //Them moi khach hang
      function edit(){

          $data['title'] = 'Cập nhật';
          $data['save'] = true;
          $data['rs'] = $this->weblink->get_customer_by_id($this->uri->segment(3));
          // Form validation
          $this->form_validation->set_rules('name','Tên liên kết','trim|required');
          $this->form_validation->set_rules('weblink_img','','');
          $this->form_validation->set_rules('link','','');
          if($this->form_validation->run() == false){
              $this->pre_message = validation_errors();
          }else{
              if($this->weblink->save_weblink()){
                  $this->session->set_flashdata('message','Lưu thành công');
                  redirect('weblink/listweblink');
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
            if($this->weblink->delete($id))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('weblink/listweblink/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->weblink->delete($ar_id[$i]))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('weblink/listweblink/'.$page);
      }           

}

?>
