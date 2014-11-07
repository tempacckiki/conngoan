<?php
  class photo extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->pre_message = "";
          $this->uri3  = $this->uri->segment(3);
          $this->load->model('photo_model','photo');   
          $this->load->config('config_photo');
          $this->menu = $this->config->item('menu');
      }
      
      function index(){
          redirect('photo/listalbum');
      }
      /*************************************************
      |            Controller xu lu Album               |
      |                                                 |
      **************************************************/
      
      /*******
      * Danh sách Album
      * 
      */
      function listalbum(){
          $data['title'] = 'Danh sách Album';
          $data['add'] = 'photo/add';
          $data['delete'] = true;
          $catid = (int)$this->uri3;
          $data['listcat'] = $this->photo->get_list_cat();
          $field = $this->uri->segment(5);
          $order = $this->uri->segment(6);          
          $config['suffix'] = '/'.$field.'/'.$order;          
          $config['base_url'] = base_url().'photo/listalbum/'.$catid;  
          $config['total_rows']   =  $this->photo->get_num_album($catid);
          $data['num'] = $config['total_rows'];
          $config['per_page']  =   20;
          $config['uri_segment'] = 4; 
          $this->pagination->initialize($config);   
          $data['list'] =   $this->photo->get_all_album($catid,$field,$order,$config['per_page'],$this->uri->segment(4));
          $data['pagination']    = $this->pagination->create_links();           
          $data['message'] = $this->pre_message;           
          $this->_templates['page'] = 'album/list';
          $this->templates->load($this->_templates['page'],$data);
      }
      /***************
      * Them moi Album
      * 
      */
      function add(){
          $data['title'] = 'Thêm mới Album';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'photo/listalbum';    
                
          $data['listcat'] = $this->photo->get_list_cat(); 
          $data['listimg'] = $this->photo->get_list_img_by_session($this->session->userdata('session_id'));
          // Form validation
          $this->form_validation->set_rules('album_name','Tên Album','required');
          $this->form_validation->set_rules('album_img','Hình đại điện','required');
          if($this->form_validation->run() == false){
               $this->pre_message = validation_errors();
          }else{
              if($id = $this->photo->save_album()){
                    $this->session->set_flashdata('message','Lưu thành công');
                    $option =  $this->input->post('option');
                    if($option == 'save'){
                       $url = 'photo/listalbum';
                    }else{
                        $url = 'photo/edit/'.$id;
                    }
                    redirect($url);
              }else{
                  $this->pre_message = 'Lưu không thành công';
              }              
          }                                                   
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'album/add';
          $this->templates->load($this->_templates['page'],$data);
      }
      /***********
      * Cap nhat Album
      * 
      */
      function edit(){
          $data['title'] = 'Cập nhật Album';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'photo/listalbum';
                    
          $data['listcat'] = $this->photo->get_list_cat(); 
          $data['rs'] = $this->photo->get_album_by_id($this->uri3);
          $data['listimg'] = $this->photo->get_list_img_by_album($this->uri3);
          // Form validation
          $this->form_validation->set_rules('album_name','Tên Album','required');
          $this->form_validation->set_rules('album_img','Hình đại điện','required');
          if($this->form_validation->run() == false){
               $this->pre_message = validation_errors();
          }else{
              if($this->photo->save_album()){
                    $this->session->set_flashdata('message','Lưu thành công');
                    $option =  $this->input->post('option');
                    if($option == 'save'){
                       $url = 'photo/listalbum';
                    }else{
                        $url = uri_string();
                    }
                    redirect($url);
              }else{
                  $this->pre_message = 'Lưu không thành công';
              }              
          }                                                   
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'album/edit';
          $this->templates->load($this->_templates['page'],$data);
      }      
      // Xoa 1 ban ghi
      function del(){
          $id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
            if($this->photo->delete($id))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('photo/listalbum/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->photo->delete($ar_id[$i]))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('photo/listalbum/'.$page);
      }
      
      
      /*********
      * Xoa anh trong Album
      * 
      */
      function del_file(){
          $data['error'] = 0;
          $imageid = $this->input->post('id');
          $this->db->where('imageid',$imageid);
          $check = $this->db->get('album_img')->row();
          //unlink(ROOT.'data/album/210/'.$check->imagepath);
          unlink(ROOT.'data/album/500/'.$check->imagepath);
          
          $this->db->where('imageid',$imageid);  
          if(!$this->db->delete('album_img')){
              $data['error'] = 1;
          }
          echo json_encode($data);
      }
      /******
      * Upload Anh
      * 
      */
      function uploader(){
            $albumid = $this->uri->segment(3);
            $session_info = $this->session->userdata('session_id');
            $dir = ROOT.'data/album/500/';
            $dir_admin = 'data/album/500/';
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
                $id_img = $this->photo->add_img($file_ext,$albumid,$session_info);
                                
                echo $id_img.','.$file_ext;
            } else {
                echo 'error';
            }
      } 
      
      /*************************************************
      |            Controller xu ly chuyen muc          |
      |                                                 |
      **************************************************/      
      /*******
      * Danh sách chuyen muc
      * 
      */
      function listcat(){
          $data['title'] = 'Danh sách chuyen muc'; 
          $data['add'] = 'photo/addcat';
          $data['delete'] = true;
          $field = $this->uri->segment(4);
          $order = $this->uri->segment(5);          
          $config['suffix'] = '/'.$field.'/'.$order;          
          $config['base_url'] = base_url().'photo/listcat/';  
          $config['total_rows']   =  $this->photo->get_num_cat();
          $data['num'] = $config['total_rows'];
          $config['per_page']  =   20;
          $config['uri_segment'] = 3; 
          $this->pagination->initialize($config);   
          $data['list'] =   $this->photo->get_all_cat($field,$order,$config['per_page'],$this->uri->segment(3));
          $data['pagination']    = $this->pagination->create_links();           
          $data['message'] = $this->pre_message;           
          $this->_templates['page'] = 'cat/list';
          $this->templates->load($this->_templates['page'],$data);
      }
      
      /*********
      * Them moi chuyen muc
      * 
      */
      function addcat(){
          $data['title'] = 'Thêm mới chuyên mục';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'photo/listcat';
          //Form validation
          $this->form_validation->set_rules('catname','Tên chuyên mục','required');
          $this->form_validation->set_rules('des','','');
          $this->form_validation->set_rules('keyword','','');
          $this->form_validation->set_rules('ordering','','');
          if($this->form_validation->run() == false){
              $this->pre_message = validation_errors();
          }else{
              if($id = $this->photo->save_cat()){
                    $this->session->set_flashdata('message','Lưu thành công');
                    $option =  $this->input->post('option');
                    if($option == 'save'){
                       $url = 'photo/listcat';
                    }else{
                        $url = 'photo/editcat/'.$id;
                    }
                    redirect($url);
              }
          }
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'cat/add';
          $this->templates->load($this->_templates['page'],$data);
      }  
      
      /*********
      * Them moi chuyen muc
      * 
      */
      function editcat(){
          $data['title'] = 'Cập nhật chuyên mục';
          $data['save'] = true;
          $data['apply'] = true;
          $data['cancel'] = 'photo/listcat';
                    
          $data['rs'] = $this->photo->get_cat_by_id($this->uri3);
          //Form validation
          $this->form_validation->set_rules('catname','Tên chuyên mục','required');
          $this->form_validation->set_rules('des','','');
          $this->form_validation->set_rules('keyword','','');
          $this->form_validation->set_rules('ordering','','');
          if($this->form_validation->run() == false){
              $this->pre_message = validation_errors();
          }else{
              if($this->photo->save_cat()){
                    $this->session->set_flashdata('message','Lưu thành công');
                    $option =  $this->input->post('option');
                    if($option == 'save'){
                       $url = 'photo/listcat';
                    }else{
                        $url = uri_string();
                    }
                    redirect($url);
              }
          }
          $data['message'] = $this->pre_message;
          $this->_templates['page'] = 'cat/edit';
          $this->templates->load($this->_templates['page'],$data);
      }
      
      // Xoa 1 ban ghi
      function delcat(){
          $id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
          if($this->photo->check_total_album($id) == 0){ 
            if($this->photo->delete_cat($id))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          }else{
              $this->session->set_flashdata('message','Chuyên mục này không thể xóa. Vì vẫn còn Album trong chuyên mục.');
          }
          redirect('photo/listcat/'.$page);
      }
      // Xoa nhieu ban ghi
      function delscat(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->photo->check_total_album($ar_id[$i]) == 0){
                            if($this->photo->delete_cat($ar_id[$i]))
                            $this->session->set_flashdata('message','Đã xóa thành công');
                            else $this->session->set_flashdata('error','Xóa không thành công');
                        }else{
                            $this->session->set_flashdata('message','Chuyên mục này không thể xóa. Vì vẫn còn Album trong chuyên mục.');
                        }
                    }
                }
            }
            redirect('photo/listcat/'.$page);
      }    
  }