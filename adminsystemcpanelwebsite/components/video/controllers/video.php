<?php
class video extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $js_array = array(
            array(base_url().'templates/video/swfobject.js')
        ); 
        $this->esset->js($js_array);          
    }
    
    function index(){
        redirect('video/listvideo');
    }
    
    function listvideo(){
        $data['title'] = 'Video';
        $data['add'] = 'video/add';
        $data['delete'] = true;
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);   
             
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'video/listvideo/';  
        $config['total_rows']   =  $this->vdb->find_by_num('video');
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->vdb->find_by_all('video',$config['per_page'],$this->uri->segment(3),0,$field,$order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới video';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'video/listvideo';
        $this->form_validation->set_rules('video[video_title]','Tiêu đề','required');
        $this->form_validation->set_rules('tuychon','Tùy chọn','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $video = $this->input->post('video');
            $video['video_alias'] = vnit_change_title($video['video_title']);
            $tuychon = $this->input->post('tuychon');
            $video['tuychon'] = ($tuychon=='file')?1:0;
            if($tuychon == 'file'){
                $video['video_link'] = $this->input->post('video_link');
            }else{
                $video['video_url'] = $this->input->post('video_url');
            }
            if($id = $this->vdb->update('video',$video)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'video/listvideo';
                }else{
                    $url = 'video/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
    function edit(){
        $data['title'] = 'Cập nhật video';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'video/listvideo';        
        
        $data['rs'] = $this->vdb->find_by_id('video',array('video_id'=>$this->uri->segment(3)));
        $this->form_validation->set_rules('video[video_title]','Tiêu đề','required');
        $this->form_validation->set_rules('tuychon','Tùy chọn','required');

        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $video = $this->input->post('video');
            $video['video_alias'] = vnit_change_title($video['video_title']);
            $tuychon = $this->input->post('tuychon');
            $video['tuychon'] = ($tuychon=='file')?1:0;
            if($tuychon == 'file'){
                $video['video_link'] = $this->input->post('video_link');
            }else{
                $video['video_url'] = $this->input->post('video_url');
            }
            if($this->vdb->update('video',$video,array('video_id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'video/listvideo';
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
             if($this->vdb->delete('video', array('video_id'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('video/listvideo/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('video', array('video_id'=>$ar_id[$i])))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('video/listvideo/'.$page);
      }
}