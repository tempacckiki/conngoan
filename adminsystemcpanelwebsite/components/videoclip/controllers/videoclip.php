<?php
class videoclip extends CI_Controller{
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
        redirect('videoclip/listvideo');
    }
    
    function listvideo(){
        $data['title'] = 'Video';
        $data['add'] = 'videoclip/add';
        $data['delete'] = true;
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);   
             
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'videoclip/listvideo/';  
        $config['total_rows']   =  $this->vdb->find_by_num('video_news');
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->vdb->find_by_all('video_news',$config['per_page'],$this->uri->segment(3),0,$field,$order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới video';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'videoclip/listvideo';
        $this->form_validation->set_rules('video[video_title]','Tiêu đề','required');
        $this->form_validation->set_rules('tuychon','Tùy chọn','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $video = $this->input->post('video');
            $video['video_alias'] = vnit_change_title($video['video_title']);
            $tuychon = $this->input->post('tuychon');
            
            //resize
            $img 	= $this->input->post('img');
            if(!empty($img)){
            	$this->load->helper('img_helper');
            	vnit_resize_image(ROOT.'alobuy0862779988/videoclip/full_images/'.$img,ROOT.'alobuy0862779988/videoclip/thumb/'.$img,300,240,false);
            }
            $video['video_img']  = $img;
            $video['tuychon'] = ($tuychon=='file')?1:0;
            if($tuychon == 'file'){
                $video['video_link'] = $this->input->post('video_link');
            }else{
                $video['video_url'] = $this->input->post('video_url');
            }
            if($id = $this->vdb->update('video_news',$video)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'videoclip/listvideo';
                }else{
                    $url = 'videoclip/edit/'.$id;
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
        $data['cancel'] = 'videoclip/listvideo';        
        
        $data['rs'] = $this->vdb->find_by_id('video_news',array('video_id'=>$this->uri->segment(3)));
        $this->form_validation->set_rules('video[video_title]','Tiêu đề','required');
        $this->form_validation->set_rules('tuychon','Tùy chọn','required');

        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id 					= $this->input->post('id');
            $video 					= $this->input->post('video');
            $video['video_alias'] 	= vnit_change_title($video['video_title']);
            $tuychon 				= $this->input->post('tuychon');
            
            //resize           
            $img 	= $this->input->post('img');
            if(!empty($img)){
            	$this->load->helper('img_helper');            	
            	vnit_resize_image(ROOT.'alobuy0862779988/videoclip/full_images/'.$img,ROOT.'alobuy0862779988/videoclip/thumb/'.$img,300,240,false);
            }
            
          	$video['video_img']  = $img;
            $video['tuychon'] = ($tuychon=='file')?1:0;
            if($tuychon == 'file'){
                $video['video_link'] = $this->input->post('video_link');
            }else{
                $video['video_url'] = $this->input->post('video_url');
            }
            if($this->vdb->update('video_news',$video,array('video_id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'videoclip/listvideo';
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
             if($this->vdb->delete('video_news', array('video_id'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('videoclip/listvideo/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('video_news', array('video_id'=>$ar_id[$i])))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('videoclip/listvideo/'.$page);
      }
      
      
      
      /*----------------------------------+
       * Uploader
      +----------------------------------*/
      function uploader(){
      	// $ProductID = $this->uri->segment(3);
      	/// $session_info = $this->session->userdata('session_id');
      	$dir 		= ROOT.'alobuy0862779988/videoclip/full_images/';
      	$dir_admin  = 'alobuy0862779988/ads/225x101/';
      	//chmod($uploaddir,0777);
      	$size=$_FILES['uploadfile']['size'];
      	if($size>204857600)
      	{
      		echo "file_biger";
      		unlink($_FILES['uploadfile']['tmp_name']);
      		//exit;
      	}
      	$filename = stripslashes($_FILES['uploadfile']['name']);
      	$i = strrpos($filename,".");
      	if (!$i) { return ""; }
      	$l = strlen($filename) - $i;
      	$extension = substr($filename,$i+1,$l);
      	$extension = strtolower($extension);
      	$file_name = str_replace($extension,'',$filename);
      	$name = time();
      	$filename = $dir.$name.'.'.$extension;
      	$file_ext = $name.'.'.$extension;
      	if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $filename)) {
      		echo $file_ext;
      
      	} else {
      		echo 'error';
      	}
      }
      
      /*----------------------------------+
       * END Uploader
      +----------------------------------*/
}