<?php
class newsproduct extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
      
        $this->load->model('newsproduct_model','tintuc');
        $this->pre_message = "";
        
    }
    
    public function index(){
    	redirect('tintuc/newsproduct/getNewsProduct');
    }
   
    
	//************************
    // Controller Bai viet
    //**************************
    public function getNewsProduct(){
    	 
        $data['title'] 		= 'Quản lý bài viết';
        write_log(75,244,'Xem danh sách bài viết');
        $data['add'] 		= 'tintuc/newsproduct/addPhoto|'.icon_add('tintuc/newsproduct/add');
        $data['delete'] 	= icon_dels('tintuc/newsproduct/delPhoto');
        //delete cache
        $this->vdb->delcache(ROOT.'site/cache/news/');

        $data['cat_id'] 	= (int)$this->input->get('cat_id');
        $data['key'] 		= $this->input->get('key');
        $data['listcat'] 	= $this->tintuc->get_all_danhmuc();
        
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);          
        
        $cat_id = ($data['cat_id'] != 0) ? '&cat_id='.$data['cat_id'] : '';
        $key = ($data['key'] != '') ? '&key='.$data['key'] : '';
        
        $config['suffix'] 			= '/'.$field.'/'.$order.'?option=true'.$cat_id.$key;          
        $config['base_url'] 		= base_url().'tintuc/newsproduct/';  
        $config['total_rows']   	=  $this->tintuc->get_num_baivietMany($data['cat_id'], $data['key']);
        $data['num'] 				= $config['total_rows'];
        $config['per_page']  		= 30;
        $config['uri_segment'] 		= 3; 
        $this->pagination->initialize($config);   
        $data['list'] 		   		= $this->tintuc->get_all_baivietMany($config['per_page'], $this->uri->segment(3), $data['cat_id'], $data['key'], $field, $order);
        $data['pagination']    		= $this->pagination->create_links();         
        
        //**********************************
        $this->_templates['page'] = 'baiviet/newsproduct';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
    
    //*******************
    function addPhoto(){
    	$data['title']	 	= "Thêm mới";
    	$data['save'] 		= true;
        $data['apply'] 		= true;
        $data['cancel'] 	= 'tintuc/newsproduct/getNewsProduct';       
        
    	$newsid			 	= $this->input->post("newsid");
    	$dataNews['is_detail']	 = 1;
     	$this->form_validation->set_rules('newsid','Tiêu đề','required');      
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
        	 if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
        	 	 $this->session->set_flashdata('message','Lưu thành công');
        	 	redirect('tintuc/newsproduct/getNewsProduct');
        	 }
        }
    	$data['message'] = $this->pre_message;
    	//load templates ======
        $this->_templates['page'] = 'baiviet/addphoto';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
     
    // Xóa 01 bai viet
    function delPhoto(){
        $page 		= $this->uri->segment(5);
        $newsid 	= $this->uri->segment(4);
        $title 		= $this->vdb->find_by_id('news_detail',array('newsid'=>$newsid))->title;
        $dataNews['is_detail'] = 0;
       
        if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
          
            $this->session->set_flashdata('message','Xóa bài viết thành công');
        }else{
            $this->session->set_flashdata('message','Xóa bài viết không thành công');
        }
        redirect('tintuc/newsproduct/getNewsProduct/'.$page);
    }
    
     
    
     // Xoa nhieu bai viet
    function delsPhoto(){
        $ar_id = $this->input->post('ar_id');
       
        $page = $this->input->post('page');
        $dataNews['is_detail']  = 0;
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
            	
                 $title = $this->vdb->find_by_id('news_detail',array('newsid'=>$ar_id[$i]))->title;
                 $this->vdb->update('news_detail', $dataNews, array('newsid'=>$ar_id[$i]));
                
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('tintuc/newsproduct/getNewsProduct/'.$page); 
    }
    
	
    
    //***************
    function saveAjaxPhoto(){
    	$data['msg']    = '';
    	$newsid  		= (int)$this->input->post("newsid");
    	$order_photo 	= (int)$this->input->post("order_detail");    	
    	$dataNews['order_detail'] = $order_photo;
    	if($this->vdb->update('news_detail',$dataNews,array('newsid'=>$newsid))){
    		$data['msg']  =  'Lưu thành công';    		
    	}else{
    		$data['msg']  =  'Lưu không thành công';
    	}
    	echo json_encode($data);
    }
    
    
  	
}

