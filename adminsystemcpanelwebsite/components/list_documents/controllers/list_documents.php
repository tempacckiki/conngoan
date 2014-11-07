<?php
class list_documents extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        //$this->load->model('tintuc_model','tintuc');
        $this->pre_message = "";
    }
    
    function index(){       
        $data['title'] = 'Download bảng giá'; 
        $data['delete'] = icon_dels('list_documents/dels');
        $data['add'] 	= 'list_documents/add|'.icon_add('documents/add');
        $list = $this->vdb->find_by_list('documents',0,array('ordering'=>'asc'));
        $data['num'] = count($list);
        $data['list'] = $list;
        
        //Load templates
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    function add(){
        $data['title'] 		= 'Thêm mới bảng giá';
        $data['save'] 		= true;
        $data['apply'] 		= true;
        $data['cancel'] 	= 'list_documents/index';        
        
        // Form validation
        $this->form_validation->set_rules('con[name]','Tiêu đề','required');       
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $con 		= $this->input->post('con');
            $fileDoc 	= $this->input->post('img');
            if(!empty($fileDoc)){
            	$con['file'] = $fileDoc; 
            }
            
            //uploads hinh
       
            if($_FILES["file_photo"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/documents/full_images/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('file_photo')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $con['image'] = $result['file_name'];               
                }                    
            }
            
           
          	if($id = $this->vdb->update('documents',$con)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'list_documents';
                }else{
                    $url = 'list_documents/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }   
    
    function edit(){
        $data['title'] 		= 'Cập nhật bảng giá';
        $data['save'] 		= true;
        $data['apply'] 		= true;
        $data['cancel'] 	= 'list_documents';        
        
        // Form validation
        $data['rs'] = $this->vdb->find_by_id('documents',array('id'=>$this->uri->segment(3)));
        $this->form_validation->set_rules('con[name]','Tiêu đề','required');
       
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id 		= $this->input->post('newsid');           
            $con 		= $this->input->post('con');
        	$fileDoc 	= $this->input->post('img');
            if(!empty($fileDoc)){
            	$con['file'] = $fileDoc; 
            }
            
         // photo
            if($_FILES["file_photo"]["size"] > 0){
            	
                $config['upload_path'] = ROOT.'data/documents/full_images/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('file_photo')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $con['image'] = $result['file_name'];               
                }                    
            }else{
                $con['image'] = $this->input->post('img_old');
            }
            
         
            if($this->vdb->update('documents',$con,array('id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'list_documents';
                }else{
                    $url = 'list_documents/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        //load templates **************************
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    } 
    
    // Xoa nhieu bai viet
    function dels(){
        $ar_id = $this->input->post('ar_id');
        $page = $this->input->post('page');
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                 $this->vdb->delete('documents',array('id'=>$ar_id[$i]));
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('list_documents/'); 
    }
    
    // Xóa 01 bai viet
    function del(){
        $page = $this->uri->segment(4);
        $newsid = $this->uri->segment(3);
        if($this->vdb->delete('documents',array('id'=>$newsid))){
            $this->session->set_flashdata('message','Xóa thành công');
        }else{
            $this->session->set_flashdata('message','Xóa không thành công');
        }
        redirect('list_documents');
    }
    
    function write_config(){
          $this->load->helper('file');
          $list = $this->vdb->find_by_list('service',0,array('ordering'=>'asc'));
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
    
    
    
    /*----------------------------------+
	 * Uploader
	 +----------------------------------*/
     function uploader(){
       // $ProductID = $this->uri->segment(3);
       /// $session_info = $this->session->userdata('session_id');
        $dir 		= ROOT.'data/documents/full_images/';
        $dir_admin  = 'data/ads/225x101/';
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

