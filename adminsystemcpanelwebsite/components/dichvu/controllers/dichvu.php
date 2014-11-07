<?php
class dichvu extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        //$this->load->model('tintuc_model','tintuc');
        $this->pre_message = "";
    }
    
    function index(){
        $this->write_config();
        $data['title'] = 'Dịch vụ'; 
        $data['delete'] = icon_dels('dichvu/dels');
        $data['add'] = 'dichvu/add|'.icon_add('dichvu/add');
        $list = $this->vdb->find_by_list('service',0,array('ordering'=>'asc'));
        $data['num'] = count($list);
        $data['list'] = $list;
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    function add(){
        $data['title'] = 'Thêm mới dịch vụ';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'dichvu/index';        
        
        // Form validation
        $this->form_validation->set_rules('con[name]','Tiêu đề','required');
        $this->form_validation->set_rules('content','Nội dung','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $con = $this->input->post('con');
            $con['slug'] = vnit_change_title($con['title']);
            $con['content'] = $this->input->post('content');

            if($id = $this->vdb->update('service',$con)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'dichvu';
                }else{
                    $url = 'dichvu/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }   
    
    function edit(){
        $data['title'] = 'Cập nhật dịch vụ';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'dichvu';        
        
        // Form validation
        $data['rs'] = $this->vdb->find_by_id('service',array('id'=>$this->uri->segment(3)));
        $this->form_validation->set_rules('con[name]','Tiêu đề','required');
        $this->form_validation->set_rules('content','Nội dung','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('newsid');
            $catid = $this->input->post('catid');
            $con = $this->input->post('con');
            $attr = $this->input->post('attr');
            $con['slug'] = vnit_change_title($con['slug']);
            $con['content'] = $this->input->post('content');

            if($this->vdb->update('service',$con,array('id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'dichvu';
                }else{
                    $url = 'dichvu/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    } 
    
    // Xoa nhieu bai viet
    function dels(){
        $ar_id = $this->input->post('ar_id');
        $page = $this->input->post('page');
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                 $this->vdb->delete('service',array('id'=>$ar_id[$i]));
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('dichvu/'); 
    }
    
    // Xóa 01 bai viet
    function del(){
        $page = $this->uri->segment(4);
        $newsid = $this->uri->segment(3);
        if($this->vdb->delete('service',array('id'=>$newsid))){
            $this->session->set_flashdata('message','Xóa thành công');
        }else{
            $this->session->set_flashdata('message','Xóa không thành công');
        }
        redirect('dichvu');
    }
    
    function write_config(){
          $this->load->helper('file');
          $list = $this->vdb->find_by_list('service',array('published'=>1),array('ordering'=>'asc'));
          $total = count($list);
          $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File Config_service language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
          $str .= "\n\$config['total_service'] = $total;\n\n"; 
          $i = 1;
          foreach($list as $rs):
            $id             = $rs->id;
            $name = $rs->name;
            $slug = $rs->slug;
            $str .= "\n\$config['service_id_$i'] = $id;";
            $str .= "\n\$config['service_name_$i'] = '$name';";
            $str .= "\n\$config['service_slug_$i'] = '$slug';";
            $i ++;  
          endforeach;
          $str .= "\n\n/* End of file Config_service*/";        
          write_file(ROOT.'site/config/config_service.php', $str);
    }
}

