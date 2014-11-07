<?php
class tintuc extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('tintuc_model','tintuc');
        $this->pre_message = "";
    }
    
    function danhmuc(){
        $data['title'] = 'Danh mục bài viết';
         write_log(74,240,'Xem danh mục bài viết');  
        $data['delete'] = icon_dels('tintuc/delscat');
        $data['add'] = 'tintuc/addcat|'.icon_add('tintuc/addcat');
        $list = $this->tintuc->get_all_danhmuc();
        $data['num'] = count($list);
        $data['list'] = $list;
        $this->_templates['page'] = 'danhmuc/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function addcat(){
        $data['title'] = 'Thêm mới danh mục';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'tintuc/danhmuc';
        $data['listcat'] = $this->vdb->find_by_list('news_cat',array('parentid'=>0));
        $this->form_validation->set_rules('cat[catname]','Tiêu đề','required');
        $this->form_validation->set_rules('cat[ordering]','Sắp xếp','required');
        $this->form_validation->set_rules('cat[parentid]','','');
        $this->form_validation->set_rules('cat[desc]','','');
        $this->form_validation->set_rules('cat[keyword]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $cat = $this->input->post('cat');
            $cat['caturl'] = vnit_change_title($cat['catname']);
            if($cat['parentid'] == 0){
                $cat['productcat'] = $this->input->post('productcat');
            }
            if($catid = $this->vdb->update('news_cat',$cat)){
                write_log(74,241,'Thêm danh mục bài viết: '.$cat['catname']);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'tintuc/danhmuc';
                }else{
                    $url = 'tintuc/editcat/'.$catid;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'danhmuc/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function editcat(){
        $data['title'] = 'Thêm mới danh mục';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'tintuc/danhmuc';
        $data['rs'] = $this->vdb->find_by_id('news_cat',array('catid'=>$this->uri->segment(3)));
        $data['listcat'] = $this->vdb->find_by_list('news_cat',array('parentid'=>0));
        $this->form_validation->set_rules('cat[catname]','Tiêu đề','required');
        $this->form_validation->set_rules('cat[ordering]','Sắp xếp','required');
        $this->form_validation->set_rules('cat[parentid]','','');
        $this->form_validation->set_rules('cat[desc]','','');
        $this->form_validation->set_rules('cat[keyword]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $catid = $this->input->post('catid');
            $cat = $this->input->post('cat');
            $cat['caturl'] = vnit_change_title($cat['catname']);
            if($cat['parentid'] == 0){
                $cat['productcat'] = $this->input->post('productcat');
            }
          
            if($this->vdb->update('news_cat',$cat,array('catid'=>$catid))){
                write_log(74,242,'Cập nhật danh mục bài viết: '.$cat['catname']);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'tintuc/danhmuc';
                }else{
                    $url = 'tintuc/editcat/'.$catid;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'danhmuc/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function delscat(){
        $ar_id = $this->input->post('ar_id');
        $msg = '';
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                 $rs = $this->vdb->find_by_id('news_cat',array('catid'=>$ar_id[$i]));
                 $checkcat = $this->tintuc->check_danhmuc($ar_id[$i]);
                 if($checkcat){
                      $checkbaiviet = $this->tintuc->check_baiviet($ar_id[$i]);
                      if($checkbaiviet){    
                          $this->vdb->delete('news_cat',array('catid'=>$ar_id[$i]));
                          write_log(74,243,'Xóa nhiều danh mục bài viết: '.$rs->catname);
                          $msg .='<div>Danh mục: <b>'.$rs->catname.'</b> đã được xóa thành công</div>';
                      }else{
                          $msg .='<div>Danh mục: <b>'.$rs->catname.'</b> vẫn tồn tại bài viết. Không thể xóa</div>';
                      }
                 }else{
                     $msg .='<div>Danh mục: <b>'.$rs->catname.'</b> vẫn tồn tại danh mục con. Không thể xóa</div>';
                 }
            }
        }
        
        $this->session->set_flashdata('message',$msg);
        redirect('tintuc/danhmuc');
    }
    
    
    //************************
    // Controller Bai viet
    //**************************
    function baiviet(){
        $data['title'] = 'Quản lý bài viết';
        write_log(75,244,'Xem danh sách bài viết');
        $data['add'] = 'tintuc/add|'.icon_add('tintuc/add');
        $data['delete'] = icon_dels('tintuc/dels');
        

        $data['cat_id'] = (int)$this->input->get('cat_id');
        $data['key'] = $this->input->get('key');
        $data['listcat'] = $this->tintuc->get_all_danhmuc();
        
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);          
        
        $cat_id = ($data['cat_id'] != 0) ? '&cat_id='.$data['cat_id'] : '';
        $key = ($data['key'] != '') ? '&key='.$data['key'] : '';
        
        $config['suffix'] = '/'.$field.'/'.$order.'?option=true'.$cat_id.$key;          
        $config['base_url'] 	= base_url().'tintuc/baiviet/';  
        $config['total_rows']   =  $this->tintuc->get_num_baiviet($data['cat_id'], $data['key']);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->tintuc->get_all_baiviet($config['per_page'], $this->uri->segment(3), $data['cat_id'], $data['key'], $field, $order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'baiviet/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
	//************************
    // Controller Bai viet
    //**************************
    function readMany(){
        $data['title'] = 'Quản lý bài viết';
        write_log(75,244,'Xem danh sách bài viết');
        $data['add'] = 'tintuc/addMany|'.icon_add('tintuc/add');
        $data['delete'] = icon_dels('tintuc/delMany');
        

        $data['cat_id'] = (int)$this->input->get('cat_id');
        $data['key'] = $this->input->get('key');
        $data['listcat'] = $this->tintuc->get_all_danhmuc();
        
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);          
        
        $cat_id = ($data['cat_id'] != 0) ? '&cat_id='.$data['cat_id'] : '';
        $key = ($data['key'] != '') ? '&key='.$data['key'] : '';
        
        $config['suffix'] = '/'.$field.'/'.$order.'?option=true'.$cat_id.$key;          
        $config['base_url'] = base_url().'content/listcontent/';  
        $config['total_rows']   =  $this->tintuc->get_num_baivietMany($data['cat_id'], $data['key']);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] 		   = $this->tintuc->get_all_baivietMany($config['per_page'], $this->uri->segment(3), $data['cat_id'], $data['key'], $field, $order);
        $data['pagination']    = $this->pagination->create_links();         
        
        
        $this->_templates['page'] = 'baiviet/many';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
    //************************
    // Controller Bai viet
    //**************************
   public function readThumb(){
        $data['title'] = 'Quản lý bài viết';
        write_log(75,244,'Xem danh sách bài viết');
        $data['add'] = 'tintuc/addThumb|'.icon_add('tintuc/add');
        $data['delete'] = icon_dels('tintuc/delThumb');
        
        $data['cat_id'] = (int)$this->input->get('cat_id');
        $data['key'] = $this->input->get('key');
        $data['listcat'] = $this->tintuc->get_all_danhmuc();
        
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);          
        
        $cat_id = ($data['cat_id'] != 0) ? '&cat_id='.$data['cat_id'] : '';
        $key = ($data['key'] != '') ? '&key='.$data['key'] : '';
        
        $config['suffix'] = '/'.$field.'/'.$order.'?option=true'.$cat_id.$key;          
        $config['base_url'] = base_url().'content/listcontent/';  
        $config['total_rows']   =  $this->tintuc->get_num_baivietThumb($data['cat_id'], $data['key']);
        $data['num'] = $config['total_rows'];
        $config['per_page']  	= 30;
        $config['uri_segment'] 	= 3; 
        $this->pagination->initialize($config);   
        $data['list'] 		   = $this->tintuc->get_all_baivietThumb($config['per_page'], $this->uri->segment(3), $data['cat_id'], $data['key'], $field, $order);
        $data['pagination']    = $this->pagination->create_links();         
        
        
        $this->_templates['page'] = 'baiviet/thumb';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
    
    function add(){
        $data['title'] = 'Thêm mới bài viết';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'tintuc/baiviet';        
        $data['listcat'] = $this->tintuc->get_all_danhmuc(); 
        
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
            $con['catid'] = $catid;
            $con['caturl'] = $this->vdb->find_by_id('news_cat',array('catid'=>$catid))->caturl;
            $con['fulltext'] = $this->input->post('content');
            $con['hot'] = (int)$this->input->post('hot');
            $con['is_thumb'] = (int)$this->input->post('is_thumb');
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
            if($this->input->post('img')!=''){
                  $this->load->helper('img_helper');
                  $news_img = $this->input->post('img');                 
                 
                  vnit_resize_image(ROOT.'alobuy0862779988/news/full_images/'.$news_img,ROOT.'alobuy0862779988/news/330/'.$news_img,330,330,false);                 
                  vnit_resize_image(ROOT.'alobuy0862779988/news/full_images/'.$news_img,ROOT.'alobuy0862779988/news/'.$news_img,200,200,false);                 
                  vnit_resize_image(ROOT.'alobuy0862779988/news/full_images/'.$news_img,ROOT.'alobuy0862779988/news/90/'.$news_img,90,90,false);
                  $con['images'] 		= 'alobuy0862779988/news/full_images/'.$news_img;
                  $con['images_thumb']  = 'alobuy0862779988/news/'.$news_img;
                  $con['images_330']    = 'alobuy0862779988/news/330/'.$news_img;
                  
                 
            }
            if($id = $this->vdb->update('news_detail',$con)){
                write_log(75,245,'Thêm bài viết: '.$con['title']); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'tintuc/baiviet';
                }else{
                    $url = 'tintuc/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'baiviet/add';
        $this->templates->load($this->_templates['page'],$data);
    }   
    
    function edit(){
        $data['title'] = 'Cập nhật bài viết';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'tintuc/baiviet';        
        $data['listcat'] = $this->tintuc->get_all_danhmuc(); 
        
        // Form validation
        $data['rs'] = $this->vdb->find_by_id('news_detail',array('newsid'=>$this->uri->segment(3)));
        $this->form_validation->set_rules('con[title]','Tiêu đề','required');
        $this->form_validation->set_rules('content','Nội dung','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $newsid = $this->input->post('newsid');
            $catid = $this->input->post('catid');
            $con = $this->input->post('con');
            $attr = $this->input->post('attr');
            $con['title_alias'] = vnit_change_title($con['title']);
            $con['catid'] = $catid;
            $con['caturl'] = $this->vdb->find_by_id('news_cat',array('catid'=>$catid))->caturl;
            $con['fulltext'] = $this->input->post('content');
            $con['hot'] = (int)$this->input->post('hot');
            $con['is_thumb'] = (int)$this->input->post('is_thumb');
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
            if($this->input->post('img')!=''){
                  $this->load->helper('img_helper');
                  $news_img = $this->input->post('img');
                  //$filename = end(explode('/',$news_img));
                  
                  vnit_resize_image(ROOT.'alobuy0862779988/news/full_images/'.$news_img,ROOT.'alobuy0862779988/news/330/'.$news_img,330,330,false);                 
                  vnit_resize_image(ROOT.'alobuy0862779988/news/full_images/'.$news_img,ROOT.'alobuy0862779988/news/'.$news_img,200,200,false);                 
                  vnit_resize_image(ROOT.'alobuy0862779988/news/full_images/'.$news_img,ROOT.'alobuy0862779988/news/90/'.$news_img,90,90,false);
                  $con['images'] 		= 'alobuy0862779988/news/full_images/'.$news_img;
                  $con['images_thumb']  = 'alobuy0862779988/news/'.$news_img;
                  $con['images_330']    = 'alobuy0862779988/news/330/'.$news_img;
            }
          
            
            if($this->vdb->update('news_detail',$con,array('newsid'=>$newsid))){
                write_log(75,246,'Cập nhật bài viết: '.$con['title']); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'tintuc/baiviet';
                }else{
                    $url = 'tintuc/edit/'.$newsid;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'baiviet/edit';
        $this->templates->load($this->_templates['page'],$data);
    } 
    
    //*******************
    function addMany(){
    	$data['title']	 = "Thêm mới";
    	$data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'tintuc/readMany';       
        
    	$newsid			 = $this->input->post("newsid");
    	$dataNews['view_many']	 = 1;
     	$this->form_validation->set_rules('newsid','Tiêu đề','required');      
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
        	 if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
        	 	 $this->session->set_flashdata('message','Lưu thành công');
        	 	redirect('tintuc/readMany');
        	 }
        }
    	$data['message'] = $this->pre_message;
        $this->_templates['page'] = 'baiviet/addmany';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
    
	//*********Add Thumb**********
    public function addThumb(){
    	$data['title']	 	= "Thêm mới";
    	$data['save'] 		= true;
        $data['apply'] 		= true;
        $data['cancel'] 	= 'tintuc/readThumb';       
        
    	$newsid			 		 = $this->input->post("newsid");
    	$dataNews['is_thumb']	 = 1;
     	$this->form_validation->set_rules('newsid','Tiêu đề','required');      
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
        	 if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
        	 	 $this->session->set_flashdata('message','Lưu thành công');
        	 	redirect('tintuc/readThumb');
        	 }
        }
    	$data['message'] = $this->pre_message;
        $this->_templates['page'] = 'baiviet/addthumb';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    // Xoa nhieu bai viet
    function dels(){
        $ar_id = $this->input->post('ar_id');
        $page = $this->input->post('page');
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                 $title = $this->vdb->find_by_id('news_detail',array('newsid'=>$ar_id[$i]))->title;
                 $this->vdb->delete('news_detail',array('newsid'=>$ar_id[$i]));
                 $this->vdb->delete('news_comment',array('newsid'=>$ar_id[$i]));
                 write_log(75,247,'Xóa bài viết: '.$title); 
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('tintuc/baiviet/'.$page); 
    }
    
    
    // Xóa 01 bai viet
    function del(){
        $page = $this->uri->segment(4);
        $newsid = $this->uri->segment(3);
        $title = $this->vdb->find_by_id('news_detail',array('newsid'=>$newsid))->title;
        if($this->vdb->delete('news_detail',array('newsid'=>$newsid))){
            write_log(75,248,'Xóa bài viết: '.$title); 
            $this->session->set_flashdata('message','Xóa bài viết thành công');
        }else{
            $this->session->set_flashdata('message','Xóa bài viết không thành công');
        }
        redirect('tintuc/baiviet/'.$page);
    }
     
    // Xóa 01 bai viet
    function delMany(){
        $page = $this->uri->segment(4);
        $newsid = $this->uri->segment(3);
        $title = $this->vdb->find_by_id('news_detail',array('newsid'=>$newsid))->title;
        $dataNews['view_many']  = 0;
        if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
          
            $this->session->set_flashdata('message','Xóa bài viết thành công');
        }else{
            $this->session->set_flashdata('message','Xóa bài viết không thành công');
        }
        redirect('tintuc/readMany/'.$page);
    }
    
     // Xóa 01 bai viet
    function delThumb(){
        $page = $this->uri->segment(4);
        $newsid = $this->uri->segment(3);
        $title = $this->vdb->find_by_id('news_detail',array('newsid'=>$newsid))->title;
        $dataNews['is_thumb']  = 0;
        if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
          
            $this->session->set_flashdata('message','Xóa bài viết thành công');
        }else{
            $this->session->set_flashdata('message','Xóa bài viết không thành công');
        }
        redirect('tintuc/readThumb/'.$page);
    }
    
    
     // Xoa nhieu bai viet
    function delsMany(){
        $ar_id = $this->input->post('ar_id');
       
        $page = $this->input->post('page');
        $dataNews['view_many']  = 0;
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
            	
                 $title = $this->vdb->find_by_id('news_detail',array('newsid'=>$ar_id[$i]))->title;
                 $this->vdb->update('news_detail', $dataNews, array('newsid'=>$ar_id[$i]));
                
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('tintuc/readMany/'.$page); 
    }
    
	// Xoa nhieu bai viet
    function delsThumb(){
        $ar_id = $this->input->post('ar_id');
       
        $page = $this->input->post('page');
        $dataNews['is_thumb']  = 0;
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
            	
                 $title = $this->vdb->find_by_id('news_detail',array('newsid'=>$ar_id[$i]))->title;
                 $this->vdb->update('news_detail', $dataNews, array('newsid'=>$ar_id[$i]));
                
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('tintuc/readThumb/'.$page); 
    }
    
    //***************
    function saveAjax(){
    	$data['msg']    = '';
    	$newsid  		= (int)$this->input->post("newsid");
    	$order_many  	= (int)$this->input->post("order_many");    	
    	$dataNews['order_many'] = $order_many;
    	if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
    		$data['msg']  =  'Lưu thành công';
    	}else{
    		$data['msg']  =  'Lưu không thành công';
    	}
    	echo json_encode($data);
    }
    
//***************
    public function saveAjaxthumb(){
    	$data['msg']    = '';
    	$newsid  		= (int)$this->input->post("newsid");
    	$order_many  	= (int)$this->input->post("order_thumb");    	
    	$dataNews['order_many'] = $order_many;
    	if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
    		$data['msg']  =  'Lưu thành công';
    	}else{
    		$data['msg']  =  'Lưu không thành công';
    	}
    	echo json_encode($data);
    }
    
    //***********************
    //commen
    //********************
    function listcomment(){
      $data['title'] = 'Danh sách bình luận';
      write_log(76,249,'Xem danh sách bình luận bài viết'); 
      $data['delete'] = icon_dels('tintuc/delscomment');
      $field = $this->uri->segment(5);
      $order = $this->uri->segment(6);          
      $config['suffix'] = '/'.$field.'/'.$order; 
      $config['base_url'] = base_url().'tintuc/listcomment/';
      $config['total_rows']   =  $this->tintuc->get_num_comment();
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   20;
      $config['uri_segment'] = 4; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->tintuc->get_all_comment($field,$order,$config['per_page'],$this->uri->segment(4));
      $data['pagination']    = $this->pagination->create_links();           
      $data['message'] = $this->pre_message;    
      
      $this->_templates['page'] ='comment/list';
      $this->templates->load($this->_templates['page'],$data);
  }
  
  function editcomment(){
      $data['title'] = 'Cập nhật bình luận';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'tintuc/listcomment';       
      $data['rs'] = $this->tintuc->get_comment_by_id($this->uri->segment(3));
      //Form validation
      $this->form_validation->set_rules('comment[fullname]','Người gửi bình luận','required');
      $this->form_validation->set_rules('comment[content]','Nội dung','required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors();
      }else{
          $id = $this->input->post('commentid');
          $page = $this->input->post('page');
          $com = $this->input->post('comment');
          if($this->vdb->update('news_comment',$com,array('commentid'=>$id))){
              write_log(76,250,'Cập nhật bình luận');
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'tintuc/listcomment/'.$page;
                }else{
                    $url = uri_string();
                }
                redirect($url);              
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'comment/edit';
      $this->templates->load($this->_templates['page'],$data);
  }
  // Xoa 1 ban ghi
  function delcomment(){
      $id = $this->uri->segment(4);
      $page = $this->uri->segment(5);
        if($this->shop->delete_comment($id)) {
            write_log(76,252,'Xóa nhiều bình luận');  
            $this->session->set_flashdata('message','Đã xóa thành công');  
        }
            
        else $this->session->set_flashdata('message','Xóa không thành công');
      redirect('tintuc/listcomment/'.$page);
  }
  // Xoa nhieu ban ghi
  function delscomment(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    if($this->shop->delete_comment($ar_id[$i])) {
                        write_log(76,251,'Xóa bình luận');
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }
                    
                    else $this->session->set_flashdata('error','Xóa không thành công');
                }
            }
        }
        redirect('tintuc/listcomment/'.$page);
  } 
  
   /*----------------------------------+
	 * Uploader
	 +----------------------------------*/
     function uploader(){
       // $ProductID = $this->uri->segment(3);
       /// $session_info = $this->session->userdata('session_id');
        $dir 		= ROOT.'alobuy0862779988/news/full_images/';
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

