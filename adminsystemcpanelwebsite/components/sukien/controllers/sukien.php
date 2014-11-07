<?php
 class sukien extends CI_Controller{
     protected $_templates;
     function __construct(){
         parent::__construct();
         $this->load->model('sukien_model','sukien');
     }
     
     function ds(){
        $data['title'] = 'Quản lý sự kiện';
        $data['add'] = 'sukien/add|'.icon_add('sukien/add');
        $data['delete'] = icon_dels('sukien/dels');
        

        $data['cat_id'] = (int)$this->input->get('cat_id');
        $data['key'] = $this->input->get('key');

        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);          
        

        $key = ($data['key'] != '') ? '&key='.$data['key'] : '';
        
        $config['suffix'] = '/'.$field.'/'.$order.'?option=true'.$key;          
        $config['base_url'] = base_url().'content/listcontent/';  
        $config['total_rows']   =  $this->sukien->get_num_baiviet($data['key']);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->sukien->get_all_baiviet($config['per_page'], $this->uri->segment(3), $data['key'], $field, $order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
     }
     
    function add(){
        $data['title'] = 'Thêm mới sự kiện';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'sukien/ds';        
        // Form validation
        $this->form_validation->set_rules('con[title]','Tiêu đề','required');
        $this->form_validation->set_rules('content','Nội dung','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{

            $catid = $this->input->post('catid');
            $con = $this->input->post('con');
            $attr = $this->input->post('attr');
            $con['title_alias'] = vnit_change_title($con['title']);

            $con['fulltext'] = $this->input->post('content');
            $con['hot'] = (int)$this->input->post('hot');
            $con['created_by'] = $this->session->userdata('user_id');
            $con['created'] = time();
            $con['attr'] ='';
            $con['attr'] .= 'show_intro='.$attr['show_intro'];
            $con['attr'] .= ',show_author='.$attr['show_author'];
            $con['attr'] .= ',show_date='.$attr['show_date'];
            $con['attr'] .= ',show_editdate='.$attr['show_editdate'];
            $con['attr'] .= ',show_print='.$attr['show_print'];
            $con['attr'] .= ',show_email='.$attr['show_email'];
            $con['attr'] .= ',show_comment='.$attr['show_comment'];
            if($_FILES["userfile"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/templ/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userfile')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $images = $result['file_name']; 
                    $ext = end(explode('.',$images));
                    $filename = vnit_change_title(strtolower($con['title'])).'.'.$ext;
                    
                    $this->load->helper('img_helper');
                    $news_img_thumb = 'data/events/'.$filename;
                    
                    vnit_resize_image(ROOT.'data/templ/'.$images,ROOT.$news_img_thumb,200,200,false);
                    $con['images_thumb'] = $filename;
                                  
                }                    
            }
            if($id = $this->vdb->update('events',$con)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sukien/ds';
                }else{
                    $url = 'sukien/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }   
    
    function edit(){
        $data['title'] = 'Cập nhật sự kiện';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'sukien/ds';        

        // Form validation
        $data['rs'] = $this->vdb->find_by_id('events',array('newsid'=>$this->uri->segment(3)));
        $this->form_validation->set_rules('con[title]','Tiêu đề','required');
        $this->form_validation->set_rules('content','Nội dung','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $newsid = $this->input->post('newsid');

            $con = $this->input->post('con');
            $attr = $this->input->post('attr');
            $con['title_alias'] = vnit_change_title($con['title']);
            $con['fulltext'] = $this->input->post('content');
            $con['hot'] = (int)$this->input->post('hot');
            $con['created_by'] = $this->session->userdata('user_id');
            $con['modified'] = time();
            $con['attr'] ='';
            $con['attr'] .= 'show_intro='.$attr['show_intro'];
            $con['attr'] .= ',show_author='.$attr['show_author'];
            $con['attr'] .= ',show_date='.$attr['show_date'];
            $con['attr'] .= ',show_editdate='.$attr['show_editdate'];
            $con['attr'] .= ',show_print='.$attr['show_print'];
            $con['attr'] .= ',show_email='.$attr['show_email'];
            $con['attr'] .= ',show_comment='.$attr['show_comment'];
            // Upload FIle
            
            if($_FILES["userfile"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/templ/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userfile')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $images = $result['file_name']; 
                    $ext = end(explode('.',$images));
                    $filename = vnit_change_title(strtolower($con['title'])).'.'.$ext;
                    
                    $this->load->helper('img_helper');
                    $news_img_thumb = 'data/events/'.$filename;
                    
                    vnit_resize_image(ROOT.'data/templ/'.$images,ROOT.$news_img_thumb,200,200,false);
                    $con['images_thumb'] = $filename;
                                  
                }                    
            }else{
                $con['images_thumb'] = $this->input->post('images');
            }

            if($this->vdb->update('events',$con,array('newsid'=>$newsid))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sukien/ds';
                }else{
                    $url = 'sukien/edit/'.$newsid;
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
                 $this->vdb->delete('events',array('newsid'=>$ar_id[$i]));
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('sukien/ds/'.$page); 
    }
    
    // Xóa 01 bai viet
    function del(){
        $page = $this->uri->segment(4);
        $newsid = $this->uri->segment(3);
        if($this->vdb->delete('events',array('newsid'=>$newsid))){
            $this->session->set_flashdata('message','Xóa bài viết thành công');
        }else{
            $this->session->set_flashdata('message','Xóa bài viết không thành công');
        }
        redirect('sukien/ds/'.$page);
    }
}
