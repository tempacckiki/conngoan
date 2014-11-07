<?php
class thanhtoan extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('thanhtoan_model','thanhtoan');
        $this->pre_message = "";
    }
    
    function ds(){
        $data['title'] = 'Thanh toán';
        //get
        $uri4  	= $this->uri->segment('4');
        write_log(70,222,'Xem danh sách phương thức thanh toán');  
        $data['add'] = 'phuongthuc/thanhtoan/add/'.$uri4.'|'.icon_add('phuongthuc/thanhtoan/add');
        $data['delete'] = icon_dels('phuongthuc/thanhtoan/dels');
        
        //get list shipping 
        $data['listShipping'] = $this->vdb->find_by_list('shop_shipping',0,array('ordering'=>'asc'));
      
       
       
        $data['list'] 	= $this->vdb->find_by_list('shop_payment',array('shipping_id'=>$uri4,'parentid'=>0),array('ordering'=>'asc'));
        $data['num'] = count($data['list']);
        $this->_templates['page'] = 'thanhtoan/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){ 
        $data['title'] = 'Thêm phương thức thanh toán';
        $data['save'] = true;
        $data['apply'] = true;
        $uri4 = $this->uri->segment('4');
        $data['list'] = $this->vdb->find_by_list('shop_payment',array('parentid'=>0),array('ordering'=>'asc'));
        $data['cancel'] = 'phuongthuc/thanhtoan/ds/'.$uri4;
        
        //get list shipping
        $data['listShipping'] = $this->vdb->find_by_list('shop_shipping',0,array('ordering'=>'asc'));
        
        $this->form_validation->set_rules('pay_vi[payment_name]','Phuong thức','required');
        $this->form_validation->set_rules('pay_vi[payment_intro]','Giới thiệu','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $pay_vi 	= $this->input->post('pay_vi');
            $pay_en 	= $this->input->post('pay_en');
            $ordering 	= $this->input->post('ordering');
            $published 	= $this->input->post('published');
            $payment_id = $this->input->post('payment_id');
            $pay_vi['ordering'] = $ordering;
            
            $img  =  $this->input->post('img');
             
            if(!empty($img)){
            	$this->load->helper('img_helper');
            	$imgRoot    = ROOT.'alobuy0862779988/payment/bank/'.$img;
            	$imgThumb   = ROOT.'alobuy0862779988/payment/bank/thumb/'.$img;
            	 
            	vnitResizeImage($imgRoot,$imgThumb,100,100);
            }
            
            $pay_vi['payment_img']	 = $img;
            
            if($payment_id = $this->vdb->update('shop_payment',$pay_vi)){
                write_log(70,223,'Thêm phương thức thanh toán: '.$pay_vi['payment_name']); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'phuongthuc/thanhtoan/ds/'.$uri4;
                }else{
                    $url = 'phuongthuc/thanhtoan/edit/'.$payment_id;
                }
                redirect($url);
            }
           
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'thanhtoan/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $data['title'] = 'Cập nhật thức thanh toán';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'phuongthuc/thanhtoan/ds';
        $data['listShipping'] = $this->vdb->find_by_list('shop_shipping',0,array('ordering'=>'asc'));
        $data['list'] = $this->vdb->find_by_list('shop_payment',array('parentid'=>0),array('ordering'=>'asc'));
        
        //get 
        $data['rs_vi'] = $this->vdb->find_by_id('shop_payment',array('payment_id'=>$this->uri->segment(4)));
        
        $this->form_validation->set_rules('pay_vi[payment_name]','Phuong thức','required');
        $this->form_validation->set_rules('pay_vi[payment_intro]','Giới thiệu','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $pay_vi = $this->input->post('pay_vi');
            $pay_en = $this->input->post('pay_en');
            $ordering = $this->input->post('ordering');
            $published = $this->input->post('published');
            $payment_id = $this->input->post('payment_id');
            $pay_vi['ordering'] = $ordering;

            $img  =  $this->input->post('img');
           
            if(!empty($img)){
            	$this->load->helper('img_helper');
            	$imgRoot    = ROOT.'alobuy0862779988/payment/bank/'.$img;
            	$imgThumb   = ROOT.'alobuy0862779988/payment/bank/thumb/'.$img;
            	
            	vnitResizeImage($imgRoot,$imgThumb,100,100);
            }
          
            $pay_vi['payment_img']	 = $img;
          	
            if($this->vdb->update('shop_payment',$pay_vi,array('payment_id'=>$payment_id))){
                write_log(70,224,'Cập nhật phương thức thanh toán:'.$pay_vi['payment_name']); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'phuongthuc/thanhtoan/ds/'. $data['rs_vi']->shipping_id;
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
      
      
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'thanhtoan/edit';
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
                    $tt = $this->vdb->find_by_id('shop_payment',array('payment_id'=>$ar_id[$i]))->payment_name;
                    if($this->vdb->delete('shop_payment',array('payment_id'=>$ar_id[$i]))){
                        $this->vdb->delete('shop_payment_en',array('payment_id'=>$ar_id[$i]));
                        write_log(70,225,'Xóa phương thức thanh toán: '.$tt); 
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('phuongthuc/thanhtoan/ds/'.$page);
    }
    
    /*----------------------------------+
     * Uploader
    +----------------------------------*/
    function uploader(){
    	// $ProductID = $this->uri->segment(3);
    	/// $session_info = $this->session->userdata('session_id');
    	$dir 		= ROOT.'alobuy0862779988/payment/bank/';
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
