<?php
class contacts extends CI_Controller{
    protected $_templates;
    
    function __construct(){
        parent::__construct();
    }
    function index(){
        redirect('contacts/listcontacts');
    }
    function listcontacts(){
        $data['title'] = 'Quản lý Danh bạ';
        $data['add'] = 'contacts/add';
        $data['delete'] = true;
        
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);  
        if($field =='' && $order ==''){
            $field = 'ordering';
            $order = 'asc';
        }        
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'contacts/listcontacts/';  
        $config['total_rows']   =  $this->vdb->find_by_num('contacts');
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->vdb->find_by_all('contacts',$config['per_page'],$this->uri->segment(4),0,$field,$order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
     function add(){
        $data['title'] = 'Thêm mới Danh bạ';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'contacts/listcontacts';
        // Form validation
        $this->form_validation->set_rules('contacts[hoten]','Họ tên','required');
        $this->form_validation->set_rules('contacts[chucvu]','Chức vụ','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $contacts_id = (int)$this->input->post('contacts_id');
            $contacts = $this->input->post('contacts');
            //$sections['sections_alias'] = vnit_change_title($sections['sections_title']);
            if($id = $this->vdb->update('contacts',$contacts)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'contacts/listcontacts';
                }else{
                    $url = 'contacts/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }  
    function edit(){
        
        $data['title'] = 'Cập nhật Danh bạ';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'contacts/listcontacts';        
        
        $data['rs'] = $this->vdb->find_by_id('contacts',array('id'=>$this->uri->segment(3)));
        // Form validation
        $this->form_validation->set_rules('contacts[hoten]','Họ tên','required');
        $this->form_validation->set_rules('contacts[chucvu]','Chức vụ','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $contacts_id = (int)$this->input->post('id');
            $contacts = $this->input->post('contacts');
           // $sections['sections_alias'] = vnit_change_title($sections['sections_title']);
            if($this->vdb->update('contacts',$contacts,array('id'=>$contacts_id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'contacts/listcontacts';
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
          $id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
             if($this->vdb->delete('contacts', array('id'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('contacts/listcontacts/'.$page);
      }
      // Xoa nhieu ban ghi
    function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('contacts', array('id'=>$ar_id[$i])))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('contacts/listcontacts/'.$page);
      }
    function save_order(){
        $id = $this->input->post('id');
        for($i = 0 ; $i< sizeof($id);$i++){
            $menu['ordering'] = $this->input->post('order_'.$id[$i]);
            
                $this->vdb->update('contacts',$menu,array('id'=>$id[$i]));
            
        }
    } 
}

