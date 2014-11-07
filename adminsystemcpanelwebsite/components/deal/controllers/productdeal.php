<?php
class productdeal extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('productdeal_model','productdeal');
        $this->pre_message = "";
    }
    function ds(){
        $data['title'] = 'Dánh sách sản phẩm deals';
        $data['listcat'] 	= $this->productdeal->get_main_cat(); 
        $data['delete'] 	= icon_dels('deal/productdeal/dels');
        $data['add'] 		= 'deal/productdeal/add|'.icon_add('deal/productdeal/add');
        //get catid
        $catid 				= (int)$this->uri->segment(4);
        $city_id 			= (int)$this->uri->segment(5);
       
        //delete cache home
       	$this->vdb->delcache(ROOT."technogory/cache/sangiare/category/");
        //delete cache home
        $this->vdb->delcache(ROOT.'technogory/cache/sangiare/index/');
        
       
        
        $page 		= (int)$this->uri->segment(6);
        $field 		= $this->uri->segment(7);
        $order 		= $this->uri->segment(8);
        $barcode 	= $this->input->get('barcode');
        $productkey = $this->input->get('productkey');
        
        if($barcode != '' && $productkey != ''){
            $url_get = "/?barcode=".$barcode.'&productkey='.$productkey;
        }else{
            if($barcode != ''){
                $url_get = "/?barcode=".$barcode; 
            }else if($productkey != ''){
                $url_get = "/?productkey=".$productkey; 
            }else{
                $url_get = '';
            }
        }
        
        
        $data['barcode'] 		= $barcode;
        $data['productkey'] 	= $productkey;
        $data['catid'] 			= $catid;
        $data['city_id'] 		= $city_id;
        $config['suffix'] 		= '/'.$field.'/'.$order.$url_get;
        $config['base_url'] 	= base_url().'deal/productdeal/ds/'.$catid.'/'.$city_id; 
        $config['total_rows']   = $this->productdeal->get_num_product($catid,$city_id,$barcode,$productkey);
      
        $data['num'] 			= $config['total_rows'];
        $config['per_page']  	= 30;
        $config['uri_segment'] 	= 6; 
        $this->pagination->initialize($config);   
        
        $data['list'] 			= $this->productdeal->get_all_product($config['per_page'], $this->uri->segment(6),$catid, $city_id,$barcode,$productkey,$field,$order);
      
        
        $data['list_city'] 		= $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $data['pagination']     = $this->pagination->create_links();           
        $data['message'] 		= $this->pre_message; 

        //********************************
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    /*--------------------------+
     * 
     +------------------------*/
    public function add(){
    	$data['title']		 = "Thêm deal";
    	$data['apply'] 		 = true;
    	
    	//get idproduct
    	$idProduct       = (int)$this->input->post("productid");
    	if($idProduct !=0){
    		$itemProduct    		= $this->productdeal->getproductID($idProduct);
    		
    		$vdata["productid"]  	= $itemProduct->productid;
    		$vdata["catid"]  		= $itemProduct->catid;
    		$vdata["caturl"]  		= $itemProduct->caturl;
    		$vdata["city_id"]  		= $itemProduct->city_id;
    		$vdata["productname"]  	= $itemProduct->productname;
    		$vdata["producturl"]  	= $itemProduct->producturl;
    		$vdata["decription"]  	= $this->input->post("decription");
    		$vdata["is_home"]  		= $this->input->post("is_home");
    		$vdata["views"]  		= $this->input->post("views");
    		$vdata["productimg"]  	= $itemProduct->productimg;
    		$vdata["giaban"]  		= $itemProduct->giaban;
    		$vdata["giathitruong"]  = $itemProduct->giathitruong;
    		$vdata["giamgia"]  		= $itemProduct->giamgia;
    		$vdata["percent_price"] = $itemProduct->phantram;
    		$vdata["ordering"] 		= 1;
    		$vdata["published"] 	= 1;
    		
    		//kiem tra productid
    		$checkId = $this->productdeal->checkIdProduct($idProduct);
    		//resize photo    			
    		//vnit_resize_image(ROOT.'data/img_product/500/'.$vdata["productimg"],ROOT.'data/img_product/310/'.$vdata["productimg"],310,250);
    		if($checkId !=0){
    			
    			$this->vdb->update("sangiare",$vdata, array("productid"=>$idProduct));
    			 $this->session->set_flashdata('message','Lưu thành công');
                 redirect('deal/productdeal/ds');
    		}else{
    			
    			$this->vdb->insert("sangiare", $vdata);
    			$this->session->set_flashdata('message','Lưu thành công');
                redirect('deal/productdeal/ds');
    		}
    	}
    	
    	//********************************
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }
    function save_ajax(){
      $vproduct['giathitruong'] 	= str_replace('.','',$this->input->post('giathitruong'));
      $vproduct['giaban'] 			= str_replace('.','',$this->input->post('giaban'));
      $vproduct['giamgia'] 			= str_replace('.','',$this->input->post('giamgia'));
     // $vprice['percent_price'] 	= ($vprice['giamgia'] * 100)/ $vprice['giathitruong'];     
      $vproduct['percent_price'] 	= $this->input->post('phantram');     
      $vproduct['decription'] 		= $this->input->post('decription');       
      $vproduct['ordering'] 		= $this->input->post('thutu');       
      $vproduct['is_home'] 			= $this->input->post('is_home');       
      $vproduct['views'] 			= $this->input->post('views');       
      $productid 					= $this->input->post('productid');
      // array price
      $vprice['giathitruong']		= $vproduct['giathitruong'];
      $vprice['giaban']				=  $vproduct['giaban'];
      $vprice['giamgia']			=  $vproduct['giamgia'];
      $vprice['phantram']			=  $vproduct['percent_price'];
      
      $city_id = $this->input->post('city_id');
      
      if($this->vdb->update('sangiare',$vproduct,array('productid'=>$productid))){   
          //luu gia ban
          $this->vdb->update('shop_price',$vprice,array('productid'=>$productid,'city_id'=>$city_id));      
          $data['msg'] = 'Lưu thành công';
      }else{
          $data['msg'] = 'Lưu không thành công';
      }
      echo json_encode($data);
    }
    
    
    /*-------------------------------+
     * This is ban chay top (col ban chay)
     +----------------------------*/
	// Xoa 1 ban ghi
	  function delproduct(){
	    $id 	= $this->uri->segment(4);
	    $uri4 	= $this->uri->segment(5);
	    $uri5 	= $this->uri->segment(6);
	    $sp 	= $this->vdb->find_by_id('sangiare',array('productid'=>$id))->productname; 
	      
	    if($this->productdeal->delete_product($id)){
	        //write_log(62,189,'Xóa sản phẩm: '.$sp); 
	        $this->session->set_flashdata('message','Đã xóa thành công');
	    }else{
	        $this->session->set_flashdata('message','Xóa không thành công');
	    }
	    redirect('deal/productdeal/ds/'.$uri4.'/'.$uri5);
	  }
	  // Xoa nhieu ban ghi
	  function delsproduct(){
	        if(!empty($_POST['ar_id']))
	        {
	            $page = (int)$this->input->post('page');
	            $catid = (int)$this->input->post('catid');
	            $city_id = (int)$this->input->post('city_id');
	         
	            $ar_id = $this->input->post('ar_id');
	            
	            for($i = 0; $i < sizeof($ar_id); $i ++) {
	                if ($ar_id[$i]){
	                    $sp = $this->vdb->find_by_id('sangiare',array('productid'=>$ar_id[$i]))->productname;   
	                    if($this->productdeal->delete_product($ar_id[$i]))
	                    {
	                      //  write_log(62,188,'Xóa sản phẩm: '.$sp);
	                        $this->session->set_flashdata('message','Đã xóa thành công');
	                    }
	                    
	                    else $this->session->set_flashdata('error','Xóa không thành công');
	                }
	            }
	        }
	        redirect('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page);
	  }
   
   
}
