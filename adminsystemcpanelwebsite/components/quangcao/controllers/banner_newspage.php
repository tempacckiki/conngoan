<?php
class banner_newspage extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->helper('file');
        
        //load model
        $this->load->model("productdeal_model","news");
    } 
    
 	function listads(){
          $data['title'] = 'Danh sách banner';
          $data['add'] 		= 'quangcao/banner_newspage/add';
          $data['delete'] 	= true;

          //create cache
          $this->writeAdsNews();
          //xoa cahe
       	//  $this->vdb->delcache(ROOT.'site/cache/');
       	 
          $field = $this->uri->segment(4);
          $order = $this->uri->segment(5);   
          if($field =='' && $order == ''){
              $field = 'ordering';
              $order = 'asc';
          }       
          $config['suffix'] 		= '/'.$field.'/'.$order;            
          $config['base_url'] 		= base_url().'quangcao/banner_newspage/listads/';  
          $config['total_rows']  	=  $this->vdb->find_by_num('ads_news');
          $data['num'] 				= $config['total_rows'];
          $config['per_page']  		= 20;
          $config['uri_segment'] 	= 3;  
          $this->pagination->initialize($config);  
          $data['list'] 			=   $this->vdb->find_by_all('ads_news',$config['per_page'],$this->uri->segment(3),0,$field,$order);
          $data['pagination']    	= $this->pagination->create_links(); 
          
          //load templates
          $this->_templates['page'] = 'bannernews/list';
          $this->templates->load($this->_templates['page'],$data);
      }
      
      
    function add(){
        $data['title'] = 'Quảng cáo banner tin tức'; 
        $data['save'] = true;
     
        $this->form_validation->set_rules('productid','Nhập vào product ID','required');        
        if($this->form_validation->run() == FALSE){
            $this->pre_message = validation_errors();
        }else{            
        	//get array id    
            $productID	= $this->input->post('productid');
        	//check id
        	if($productID !=0){        	
        		$itemProduct    		= $this->news->getproductID($productID); 
        	
	    		$vdata["productid"]  	= $itemProduct->productid;	    		    		
	    		$vdata["productname"]  	= $itemProduct->productname;
	    		$vdata["producturl"]  	= $itemProduct->producturl;
	    		$vdata["decription"]  	= $this->input->post("decription");
	    		$vdata["productimg"]  	= $itemProduct->productimg;
	    		$vdata["giaban"]  		= $itemProduct->giaban;
	    		$vdata["giathitruong"]  = $itemProduct->giathitruong;	    		
	    		$vdata["ordering"] 		= 1;
	    		$vdata["published"] 	= 1;
	    		
	    		//kiem tra productid
	    		$checkId = $this->news->checkIdProduct($productID);
	        	if($checkId !=0){
	    			
	    			$this->vdb->update("ads_news",$vdata, array("productid"=>$productID));
	    			$this->session->userdata('message','Lưu thành công');
            		redirect('quangcao/banner_newspage/listads');
	    		}else{
	    			
	    			$this->vdb->insert("ads_news", $vdata);
	    			$this->session->userdata('message','Lưu thành công');
            		redirect('quangcao/banner_newspage/listads');
	    		}
	    		
        	}
            
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannernews/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    //*============
 	/*-------------------------------+
     * This is ban chay top (col ban chay)
     +----------------------------*/
	// Xoa 1 ban ghi
	  function del(){
	    $id 	= $this->uri->segment(4);	   	  
	    if($this->news->delete_product($id)){
	        //write_log(62,189,'Xóa sản phẩm: '.$sp); 
	        $this->session->set_flashdata('message','Đã xóa thành công');
	    }else{
	        $this->session->set_flashdata('message','Xóa không thành công');
	    }
	     redirect('quangcao/banner_newspage/listads/');
	  }
	  // Xoa nhieu ban ghi
	  function dels(){
	        if(!empty($_POST['ar_id']))
	        {
	            $page = (int)$this->input->post('page');
	            $catid = (int)$this->input->post('catid');
	            $city_id = (int)$this->input->post('city_id');
	         
	            $ar_id = $this->input->post('ar_id');
	            
	            for($i = 0; $i < sizeof($ar_id); $i ++) {
	                if ($ar_id[$i]){
	                    $sp = $this->vdb->find_by_id('ads_news',array('productid'=>$ar_id[$i]))->productname;   
	                    if($this->news->delete_product($ar_id[$i]))
	                    {
	                      //  write_log(62,188,'Xóa sản phẩm: '.$sp);
	                        $this->session->set_flashdata('message','Đã xóa thành công');
	                    }
	                    
	                    else $this->session->set_flashdata('error','Xóa không thành công');
	                }
	            }
	        }
	        redirect('quangcao/banner_newspage/listads/'.$page);
	  }
   /*--------------------*/
    public function writeAdsNews(){
    	//get all product
         $listNews = $this->news->get_all_product(); 
         
         $strNews = '';
                                   
                   	
            	$strNews .= '<div class="ads-news-r">';
            	$strNews .= '<div class="title">Sản phẩm giá rẻ hot nhất tại FYI Á Châu.</div>';
            	$strNews .='<ul class="items">'; 
                $i = 1;  
            	foreach($listNews as $valLeft) :
            		$decription 	= $valLeft->decription;
            		$giathitruong 	= number_format($valLeft->giathitruong,0,'.','.');
            		$giaban 		= number_format($valLeft->giaban,0,'.','.');
            		$imgLeft		= base_url_site()."data/img_product/200/".$valLeft->productimg;
            		$link 			= base_url_site()."product/".vnit_change_title($valLeft->productname).'/'.$valLeft->productid.".html";
                    $style 			= ($i == 3)?'style="border-bottom:0px"':'';
	                $strNews .='<li class="row'.$i.'">';  
	                $strNews .='<div class="sub-adv">';  
	              	$strNews .='<p class="name"><a href="'.$link.'">'.$valLeft->productname.'</a></p>';
	                $strNews .='<p class="img"> 
				    				<a href="'.$link.'" target="_blank"><img src="'.$imgLeft.'" width="115" alt="'.$valLeft->productname.'"></a>    
				    			</p>';    
	                $strNews .='<div class="info-adv">';    
	                $strNews .='<div class="summary">
			    				'.$decription.'
			    				</div>';    
	                $strNews .='<p class="price">Giá bán:
			    					<span>'.$giaban.' đ</span>
			    				</p>';    
	                $strNews .='<p class="price-old">Giá cũ:
			    					<span>'.$giathitruong.' đ</span>
			    				</p>';    
	                $strNews .='</div>';    
	                
	                $strNews .='</div>';    
	                $strNews .='</li>'; 
	                // giam i   
                    $i = 1-$i;
           		endforeach;
            $strNews .='</ul>';
            $strNews .= '</div>';
           
           //write news ***********************
            write_file(ROOT.'site/config/home/bannerNews.db', $strNews);
         
    }

}
