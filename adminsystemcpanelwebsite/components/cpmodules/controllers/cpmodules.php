<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class cpmodules extends CI_Controller{
    protected $_templates;
    function __construct() {
        parent::__construct();
        //$this->load->model('cpmodules_model','cpmodules');
        $this->pre_message = "";
        $this->load->helper('xml_helper'); 
    }
    
    function index(){
        redirect('cpmodules/listmodules');
    }
    
    function listmodules(){
        $data['title'] = 'Quản lý Module';
        $data['add'] = 'cpmodules/readadd';
        $data['delete'] = true;
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);          
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'cpmodules/listmodules/';  
        $config['total_rows']   =  $this->vdb->find_by_num('modules',array('lang'=>vnit_lang()));
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->vdb->find_by_all('modules',$config['per_page'],$this->uri->segment(4),array('lang'=>vnit_lang()),$field,$order);
        $data['pagination']    = $this->pagination->create_links();        
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    function readadd(){
        $data['title'] = 'Thêm mới Modules';
        $data['save'] = true;
        $data['cancel'] = 'cpmodules/listmodules';
        $handle = opendir(ROOT.'site/views/modules');
        if(!$handle){
            $this->session->set_flashdata('notice','Đường dẫn tới thư mục Modules không đúng');
        }
        $data['handle'] = $handle;
        // Form validation
        $this->form_validation->set_rules('modules_name','Tên Module','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            redirect('cpmodules/add/'.$this->input->post('modules_name'));
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'readmodules';
        $this->templates->load($this->_templates['page'],$data);
    }    
    function add(){
        $data['title'] = 'Thêm mới Modules';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'cpmodules/listmodules';
        $url3 = $this->uri->segment(3);
        $data['list_position'] = $this->vdb->find_by_list('modules_position');
        $data['xml'] = simplexml_load_file(ROOT.'site/views/modules/'.$url3.'/'.$url3.'.xml'); 
        $data['position'] = simplexml_load_file(ROOT.'site/views/templates/templates.xml'); 
        // Form validation
        $this->form_validation->set_rules('mod[title]','Tên module - vi','required');
        $this->form_validation->set_rules('mod_en[title]','Tên module - en','required');
        $this->form_validation->set_rules('mod[show_title]','Hiển thị tiêu đề','required');
        $this->form_validation->set_rules('mod[published]','Bật Module','required');
        $this->form_validation->set_rules('mod[position]','Vị trí hiển thị','required');
        $this->form_validation->set_rules('mod[params]','','');
        $this->form_validation->set_rules('mod[content]','','');
        $this->form_validation->set_rules('mod_en[content]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = (int)$this->input->post('id');
            $mod = $this->input->post('mod');
            $mod_en = $this->input->post('mod_en');
            $mod['lang'] = vnit_lang();
            $param = $this->input->post('param');
            $html = '';
            if(is_array($param)){
                foreach($param as $v=>$k){
                    $html .='&'.$v.'='.$k;
                }
                $html .='&test=true';
            }else{
                $html .='test=true';
            }
            $mod['attr'] = trim($html,'&');
            $mod_en['position']  = $mod['position'];
            $mod_en['params']  = $mod['params'];
            $mod_en['module']  = $mod['module'];
            $mod_en['show_title']  = $mod['show_title'];
            $mod_en['published']  = $mod['published'];
            $mod_en['html']  = $mod['html'];
            $mod_en['attr'] = trim($html,'&');           
            if($id = $this->vdb->update('modules',$mod)){
                $mod_en['id'] = $id;
                $this->vdb->update('modules_en',$mod_en);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                    $url = 'cpmodules/listmodules';
                }else{
                    $url = 'cpmodules/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $data['title'] = 'Cập nhật Modules';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'cpmodules/listmodules';        
        $data['rs'] = $this->vdb->find_by_id('modules',array('id'=>$this->uri->segment(3)));
        $data['rs_en'] = $this->vdb->find_by_id('modules_en',array('id'=>$this->uri->segment(3)));
        $data['list_position'] = $this->vdb->find_by_list('modules_position');
        $data['xml'] = simplexml_load_file(ROOT.'site/views/modules/'.$data['rs']->module.'/'.$data['rs']->module.'.xml');
        $data['position'] = simplexml_load_file(ROOT.'site/views/templates/templates.xml');
        // Form validation
        $this->form_validation->set_rules('mod[title]','Tên module - vi','required');
        $this->form_validation->set_rules('mod_en[title]','Tên module - en','required');
        $this->form_validation->set_rules('mod[show_title]','Hiển thị tiêu đề','required');
        $this->form_validation->set_rules('mod[published]','Bật Module','required');
        $this->form_validation->set_rules('mod[position]','Vị trí hiển thị','required');
        $this->form_validation->set_rules('mod[params]','','');
        $this->form_validation->set_rules('mod[content]','','');
        $this->form_validation->set_rules('mod_en[content]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = (int)$this->input->post('id');
            $mod = $this->input->post('mod');
            $mod_en = $this->input->post('mod_en');
            $param = $this->input->post('param');
            $html = '';
            if(is_array($param)){
                foreach($param as $v=>$k){
                    $html .='&'.$v.'='.$k;
                }
                $html .='&test=true';
            }else{
                $html .='test=true';
            }
             
            $mod['attr'] = trim($html,'&');
            // Update Mod En
            $mod_en['position']  = $mod['position'];
            $mod_en['params']  = $mod['params'];
            $mod_en['module']  = $mod['module'];
            $mod_en['show_title']  = $mod['show_title'];
            $mod_en['published']  = $mod['published'];
            $mod_en['html']  = $mod['html']; 
            $mod_en['attr'] = trim($html,'&');
            
            if($this->vdb->update('modules',$mod,array('id'=>$id))){
                $this->vdb->update('modules_en',$mod_en,array('id'=>$id));
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'cpmodules/listmodules/';
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

    // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    if($this->vdb->delete('modules', array('id'=>$ar_id[$i]))){
                        $this->vdb->delete('modules_en', array('id'=>$ar_id[$i]));
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('cpmodules/listmodules/'.$page);
    }
    function save_order(){
        $id = $this->input->post('id');
        for($i = 0 ; $i< sizeof($id);$i++){
            $menu['ordering'] = $this->input->post('order_'.$id[$i]);
            
                $this->vdb->update('modules',$menu,array('id'=>$id[$i]));
            
        }
    }      
}
