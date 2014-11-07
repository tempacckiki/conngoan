<?php
class eskin extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('eskin_model','eskin');
    }
    
    function ds(){
        $data['title'] = 'Danh sách Email templates';
        write_log(87,281,'Danh sách Email templates'); 
        $data['delete'] = icon_dels('eskin/dels');
        $data['add'] = 'eskin/add|'.icon_add('eskin/add');
        $data['list'] = $this->vdb->find_by_list('email_templates');
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới Email templates';
        $data['apply'] = true;
        $data['save'] = true;
        $data['cancel'] = 'eskin/ds';
        $this->form_validation->set_rules('e[slug]','Code','required');
        $this->form_validation->set_rules('e[subject]','Tiêu đề','required');
        $this->form_validation->set_rules('e[content]','Tiêu đề','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $vdata = $this->input->post('e');
            if($id = $this->vdb->update('email_templates',$vdata)){
                write_log(87,282,'Thêm Email templates');
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'eskin/ds';
                }else{
                    $url = 'eskin/edit/'.$id;
                }
                redirect($url);
            }
        }
        
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $data['title'] = 'Cập nhật Email templates';
        $data['apply'] = true;
        $data['save'] = true;
        $data['cancel'] = 'eskin/ds';
        $data['rs'] = $this->vdb->find_by_id('email_templates',array('id'=>$this->uri->segment(3)));
        $this->form_validation->set_rules('e[slug]','Code','required');
        $this->form_validation->set_rules('e[subject]','Tiêu đề','required');
        $this->form_validation->set_rules('e[content]','Tiêu đề','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $vdata = $this->input->post('e');
            if($id = $this->vdb->update('email_templates',$vdata,array('id'=>$id))){
                write_log(87,283,'Cập nhật Email templates');
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'eskin/ds';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    }
}
