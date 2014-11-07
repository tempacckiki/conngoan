<?php
  class product extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->load->model('product_model','product');
          $this->regions = $this->session->userdata('fyi_regions'); 
          $this->city_id = $this->session->userdata('city_site');
          
          //init url
          
          $this->uri1 = $this->uri->segment('1');
       	  $this->uri2 = $this->uri->segment('2');
          $this->uri3 = $this->uri->segment('3');
      }
      function index(){
          redirect();
      }
      function view_product(){
		if($this->uri3 != ''){
		  $data['top_link_seo'] = 'http://alobuy.vn/'.$this->uri1.'/'.$this->uri2.'/'.$this->uri3.'.html';
        }else{
		  $data['top_link_seo'] = 'http://alobuy.vn/'.$this->uri1.'/'.$this->uri2.'.html';
		}
          $data['captcha_img'] = _make_captcha();
          
         //get productid ****************************
          $productid = (int)end(explode('-', $this->uri2));
         
		  if($productid == 205){
			redirect('http://alobuy.vn/san-pham/bep-nuong-dien-goldsun-gr-gyc1400-203.html');
		  }
		  //set view
		  $data['productid']  = $productid; 
          //get item product **************************
        
          $rs 	= $this->product->get_product_by_id($productid);
       
          //check price ***********
          if(empty($rs) || $rs->giaban == 0){
              redirect();
          }
          // UPdate View
          $this->db->query("UPDATE shop_product SET view = view + 1 WHERE productid = ".$productid);
            
          $catinfo                      = $this->product->get_info_cat($rs->catid);
          if($catinfo->parentid == 0){
              $data['menuid']           = $rs->catid;
          }else{
              $data['menuid']           = $catinfo->parentid;
          }          
          $data['info']                 = $catinfo;
          $data['top_link']             = $this->product->find_top_link($catinfo->catid,$catinfo->parentid);
          $data['catinfo']              = $this->product->find_main_cat($catinfo->catid,$catinfo->parentid);          
          $data['listimg']              = $this->vdb->find_by_list('shop_img',array('productid'=>$rs->productid));
          //$data['title']                = $catinfo->catname.' - '.$rs->productname;
          $data['title']                = $rs->productname;
          $data['rs']                   = $rs;
          $data['total_list']           = $rs;
           

          $data['giathitruong']       	= $rs->giathitruong;
          $data['giaban']             	= $rs->giaban;
          $data['giamgia']            	= $rs->giamgia;
          $data['phantram']           	= $rs->phantram;
          $data['tinhtrang']          	= $rs->tinhtrang;
          $data['tinhtrang_text']     	= $rs->tinhtrang_text; 
		  if (!empty($rs->manufactureid)){
		   $data['listcity_baohanh']             = $this->product->get_all_city_by_product($rs->manufactureid);
		  
		  }
          //get list product 
           $data['ds_sp_cung_gia']       = $this->product->get_sanpham_cunghang($rs->catid,$rs->manufactureid,$rs->productid);

          //get manufacture
          $data['listManufacture']		= $this->product->getManufactur($rs->catid);
         
          $data['listcity']             = $this->product->get_allCity($rs->manufactureid);
         // $data['listcomment']          = $this->product->get_list_comment($rs->productid);
       	
          //load templates  ************************************
          $this->_templates['page']     ='detail';
          $this->templates->load($this->_templates['page'],$data,'detail');
      }
      
      //**8 get district *****************
	  public function getDistricts(){
	        $city_id = $this->input->post('city_id');
	        $list = $this->vdb->find_by_list('city',array('parentid'=>$city_id,'parentid !='=>0));
	        $html ='<option value="0">|- Chọn Quận, Huyện</option>';
	        foreach($list as $rs):
	            $html .='<option value="'.$rs->city_id.'">'.$rs->city_name.'</option>';
	        endforeach;
	        $data['info'] = $html; 
	        echo json_encode($data);
	    }
  	
	    //**8 get shipping *****************
	    public function getShippingRate(){
	    	$city_id 		= $this->input->post('city_id');
	    	$itemShipping 	= $this->vdb->find_by_id('city',array('city_id'=>$city_id));
	    	
	    	$data['price'] = '<strong>Phí vận chuyển:</strong>  <span>'.number_format($itemShipping->rate,0,'.','.').' đ</span>';
	    	echo json_encode($data);
	    }
    
      
      // Auto Complete
      function autosearch(){
          $this->load->library('pagi');
          $productkey = $this->input->post('productkey');
          $data['productkey'] = $productkey;
          $limit = 10;
          $data['limit'] = $limit; 
          $offset = (int)$this->input->post('page_no'); 
          $data['offset'] = $offset;
          $num = $this->product->get_num_product_by_key($productkey);
          $data['num'] = $num;
          if($offset!=0) 
            $start = ($offset - 1) * $limit;
          else
            $start = 0;   
          $data['list'] =   $this->product->get_all_product_by_key($limit,$start,$productkey);
          $data['pagination']   = $this->pagi->page($num,$offset,$limit,'autosearch_page');  
          $this->_templates['page'] = 'autocomplete';
          $this->load->view($this->_templates['page'],$data);
      }
      
      // Search Result
      

      

  }

