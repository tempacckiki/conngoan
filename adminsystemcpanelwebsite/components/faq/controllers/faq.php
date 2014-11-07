<?php
class faq extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
       // $this->load->model('faq_model','faq');
    }     
    function index(){
        redirect('faq/listfaq');
    }
    function listfaq(){
      $data['title'] = 'Hướng dẫn';
      write_log(88,286,'Xem danh sách hướng dẫn');
      $data['delete'] = icon_dels('faq/dels');
      $data['add'] = 'faq/add|'.icon_add('faq/add');
      $field = $this->uri->segment(4);
      $order = $this->uri->segment(5);   
      if($field =='' && $order == ''){
          $field = '';
          $order = '';
      }       
      $config['suffix'] = '/'.$field.'/'.$order;            
      $config['base_url'] = base_url().'faq/listfaq/';  
      $config['total_rows']   =  $this->vdb->find_by_num('faq');
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   30;
      $config['uri_segment'] = 3; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->vdb->find_by_all('faq',$config['per_page'],$this->uri->segment(3),0,$field,$order);
      $data['pagination']    = $this->pagination->create_links(); 
      $this->_templates['page'] = 'list';
      $this->templates->load($this->_templates['page'],$data);        
    }
    
    function add(){
      $data['title'] = 'Thêm hướng dẫn';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'faq/listfaq';
      //form validation
      $this->form_validation->set_rules('title','Tiêu đề','required');
      $this->form_validation->set_rules('content','Nội dung','required');
      if($this->form_validation->run() === FALSE){
          $this->pre_message = validation_errors();
      }else{
          $faq['title'] = $this->input->post('title'); 
          $faq['slug'] = vnit_change_title($this->input->post('title')); 
          $faq['content'] = $this->input->post('content');
          if($id = $this->vdb->update('faq',$faq)){
              write_log(88,287,'Thêm Hướng dẫn: '.$this->input->post('title'));
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'faq/listfaq';
                }else{
                    $url = 'faq/edit/'.$id;
                }
                redirect($url);
            }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'add';
      $this->templates->load($this->_templates['page'],$data);
    }
    function edit(){
        $data['title'] = 'Cập nhật hướng dẫn';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'faq/listfaq';
        $data['rs'] = $this->vdb->find_by_id('faq',array('id'=>$this->uri->segment(3)));
        // Form validation
        $this->form_validation->set_rules('title','Tiêu đề','required');
        $this->form_validation->set_rules('content','Nội dung','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = (int)$this->input->post('id');
            $faq['title'] = $this->input->post('title'); 
            $faq['slug'] = vnit_change_title($this->input->post('title')); 
            $faq['content'] = $this->input->post('content'); 
            if($this->vdb->update('faq',$faq,array('id'=>$id))){
                write_log(88,288,'Cập nhật Hướng dẫn: '.$this->input->post('title'));
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'faq/listfaq';
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
    
    function del(){
        $page = $this->uri->segment(4);
        $title = $this->vdb->find_by_id('faq',array('id'=>$this->uri->segment(3)))->title;
        if($this->vdb->delete('faq',array('id'=>$this->uri->segment(3)))){
            write_log(88,290,'Xóa Hướng dẫn: '.$title);
            $this->session->set_flashdata('message','Xóa thành công');
            redirect('faq/listfaq/'.$page);
        }else{
            $this->session->set_flashdata('message','Xóa không thành công');
            redirect('faq/listfaq/'.$page);
        }
    } 
    
    function dels(){
        $page = $this->input->post("page");
        $ar_id = $this->input->post('ar_id');
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                $this->vdb->delete('faq',array('id'=>$ar_id[$i]));
                write_log(88,289,'Xóa nhiều Hướng dẫn');
            }
        }
        $this->session->set_flashdata('message','Xóa thành công');
        redirect('faq/listfaq/'.$page);
    }       
} 
?>
