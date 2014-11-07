<?php
class producthome extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('producthome_model','producthome');
        $this->pre_message = "";
    }
    function ds(){
        $data['title'] = 'Dánh sách sản phẩm trang chủ';
        $data['listcat'] = $this->producthome->get_main_cat(); 
        $catid = (int)$this->uri->segment(4);
        $city_id = (int)$this->uri->segment(5);
        $page = (int)$this->uri->segment(6);
        $field = $this->uri->segment(7);
        $order = $this->uri->segment(8);
        $barcode = $this->input->get('barcode');
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
        
        
        $data['barcode'] = $barcode;
        $data['productkey'] = $productkey;
        $data['catid'] = $catid;
        $data['city_id'] = $city_id;
        $config['suffix'] = '/'.$field.'/'.$order.$url_get;
        $config['base_url'] = base_url().'product/producthome/ds/'.$catid.'/'.$city_id; 
        $config['total_rows']   =  $this->producthome->get_num_product($catid,$city_id,$barcode,$productkey);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   15;
        $config['uri_segment'] = 6; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->producthome->get_all_product($config['per_page'], $this->uri->segment(6),$catid, $city_id,$barcode,$productkey,$field,$order);
        $data['list_city'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message;           
        $this->_templates['page'] = 'producthome/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function save_ajax(){
      $vprice['giathitruong'] = str_replace('.','',$this->input->post('giathitruong'));
      $vprice['giaban'] = str_replace('.','',$this->input->post('giaban'));
      $vprice['giamgia'] = str_replace('.','',$this->input->post('giamgia'));
      $vprice['phantram'] = ($vprice['giamgia'] * 100)/ $vprice['giathitruong'];
      $vprice['tinhtrang'] =$this->input->post('tinhtrang');
      
      
      $vproduct['sphot'] =$this->input->post('sphot');
      $vproduct['spmoi'] =$this->input->post('spmoi');
      $vproduct['spkhuyenmai'] =$this->input->post('spkhuyenmai');
      $vproduct['home'] =$this->input->post('home');
      $vproduct['orderhome'] =$this->input->post('thutu');  
      
      $productid = $this->input->post('productid');
      $city_id = $this->input->post('city_id');
      
      if($this->vdb->update('shop_product',$vproduct,array('productid'=>$productid))){
          $this->vdb->update('shop_price',$vprice,array('productid'=>$productid,'city_id'=>$city_id));
          
          $data['msg'] = 'Lưu thành công';
      }else{
          $data['msg'] = 'Lưu không thành công';
      }
      echo json_encode($data);
    }
    
    function write_cache(){
        $this->load->helper('file');
        $listmain = $this->producthome->get_main_cat(0);
        foreach($list as $main):
            $listproduct = $this->producthome->get_product_home($main->catid);
            $str = '
                <ul id="thumb" class="items-p-i">';
                    foreach($listproduct as $rs):
                    $imgPath   = base_url_site().'site/templates/fyi/images/placeholder.gif';
                    $url = base_url_site().'product/'.$rs->producturl.'/'.$rs->productid.'.html';
                    $img_product = base_url_img().'data/img_product/200/'.$rs->productimg;
                    $giathitruong = number_format($rs->giathitruong,0,'.','.');
                    $giamgia = number_format($rs->giamgia,0,'.','.');
                    $giaban = number_format($rs->giaban,0,'.','.');
                    $str .='<li class="vnit_tip">
                        <div class="img" align="center">
                            <p class="icon-hot">&nbsp;</p> 
                            <a href="'.$url.'" title="'.$rs->productname.'">
                            <img id="zoom" src="'.$img_product.'"  alt="'.$rs->productname.'" height="120" />
                            </a>
                        </div>
                        <p class="name"><a href="'.$url.'" title="'.$rs->productname.'">'.$rs->productname.'</a></p>
                        <div class="sales-off">
                            <p class="price-old">'.$giathitruong.' VND</p>
                            <p class="discount">Tiết kiệm: '.$giamgia.' VND</p>
                        </div>
                        
                        <p class="price"><span>'.$giaban.' VND</span></p>
                        
                        
                        <div id="vtip">
                            <div class="v-title">
                                <p>'.$productname.'</p>
                                <p class="giaban">Giá bán: <span>'.$giaban.'</span> VND</p>
                            </div>
                            <div class="vcontent">';
                            if($tangpham){
                                $str .='<div class="v-discount">';
                                $str .='<div class="tangpham">Khuyến mãi</div>';
                                $str .= '<div class="tangpham_title">'.$tangpham->name.'</div>';
                                $str .='</div>';
                            }
                            $str .='<div class="tinhnang">Tính năng nổi bật</div>
                                <ul class="tinhnangnoibat">
                                    '.addli($val->tinhnang).' 
                                </ul>
                            </div>
                        </div>
                    </li>';
                    endforeach;
                $str .='</ul>
            ';
            
        endforeach;
    }
    
    /*-------------------------------+
     * Cat
     */
    function cat(){
    	$data['title'] 				= 'Khuyến mãi bán chạy chuyên mục';
    	$data['listcity'] 			= $this->vdb->find_by_list('city',array('parentid'=>0,'site'=>1));
    	$data['listcat'] 			= $this->vdb->find_by_list('shop_cat',array('parentid'=>0));
    	 
    	$this->_templates['page'] 	= 'producthome/cat/index';
    	$this->templates->load($this->_templates['page'],$data);
    }
    
    //load cat
    function load_cat(){
    	$data['city_id'] = $this->input->post('city_id');
    	$data['cat_id'] = $this->input->post('cat_id');
    	$this->_templates['page'] = 'producthome/cat/ajax';
    	$this->load->view($this->_templates['page'],$data);
    }
    
    
    function hot(){
        $data['title'] 				= 'Khuyến mãi bán chạy Trang chủ';
        $data['listcity'] 			= $this->vdb->find_by_list('city',array('parentid'=>0,'site'=>1));
        $data['listcat'] 			= $this->vdb->find_by_list('shop_cat',array('parentid'=>0));
       
        $this->_templates['page'] 	= 'producthome/hot/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function load_hot(){
        $data['city_id'] = $this->input->post('city_id');
        $data['cat_id'] = $this->input->post('cat_id');
        $this->_templates['page'] = 'producthome/hot/ajax';
        $this->load->view($this->_templates['page'],$data);
    }
    
    /*-------------------------------+
     * This is ban chay top (col ban chay) category
     +----------------------------*/
    
    function save_cat(){
        $this->load->helper('file');
        $city_id 	= $this->input->post('city_id');
        $cat_id 	= $this->input->post('cat_id');
        
        $ar_id = $this->input->post('ar_id');
        $this->vdb->delete('shop_hotcat',array('position'=>'hot','city_id'=>$city_id,'cat_id'=>$cat_id));
        $k = 1;
       
        for($i = 0; $i < sizeof($ar_id) ; $i++){
            if($ar_id[$i]){
                $vdata['id'] 		= $ar_id[$i];
                $vdata['productid'] = $this->input->post('productid_'.$ar_id[$i]);
                $vdata['city_id'] 	= $city_id;
                $vdata['cat_id'] 	= $cat_id;
                $vdata['position'] 	= 'hot';
                $this->db->insert('shop_hotcat',$vdata);
                // Write File
                $rs = $this->producthome->get_item_hotcat($ar_id[$i],$city_id, $cat_id);
                if($rs){
                	$productid		= $rs->productid;
                	$imgPath   		= base_url_site().'technogory/templates/default/images/placeholder.gif';
                    $price 			= $this->producthome->get_price_hot($rs->productid, $city_id);                   
                    $tangpham 		= addli($rs->phukien);
                    $url 			= base_url_site().'san-pham/'.$rs->producturl.'-'.$rs->productid.'.html';
                    $img 			= base_url_static().'alobuy0862779988/0862779988product/190/'.$rs->productimg;
                    $productname 	= $rs->productname;
                    $giathitruong 	= number_format($price->giathitruong,0,'.','.');                   
                    $giaban 		= number_format($price->giaban,0,'.','.');
                    $phantram 		= $price->phantram .' %';
                    
                    $str .='<li>';
                    $str .='<div class="box-info-index">';
                    $str .='                    		
			                <p class="img"><a href="'.$url.'" title="'.$productname.'"><img src="'.$img.'" width="186" alt="'.$productname.'"></a></p>		                
                			<p class="name"><a href="'.$url.'" title="'.$productname.'">'.$productname.'</a></p>                           
                            <div class="tang-pham"><ul class="item">'.$tangpham.'</ul></div>
                			<p class="price-old">'.$giathitruong.' ₫</p>                            
                            <p class="price"><span>'.$giaban.' ₫</span></p>
                                                   
                    ';
                    $str .='<div class="discount-off">';
                    $str .='<p class="label">Tiết kiệm</p>';
                    $str .='<p class="sales-off">'.$phantram.'</p>';                   
                    $str .='</div>';
                    
                    $str .='<div class="buttom-buy">';
                    $str .='<p class="text"><a href="javascript:;" id="product_'.$productid.'" class="addtocart">Mua ngay</a></p>';
                    $str .='</div>';
                    
                    $str .='</div>';
                    $str .='</li>';
                }
                $k++; 
            }
        }
        //write ************
        write_file(ROOT.'technogory/cache/cat/hot_'.$cat_id.'city_'.$city_id.'.db', $str);
        
        $data['msg'] = 'Lưu dữ liệu thành công';
        $data['city_id'] = $city_id;
        echo json_encode($data);
    }
    
    /*-------------------------------+
     * This is ban chay top (col ban chay)
    +----------------------------*/
    
    function save_hot(){
    	$this->load->helper('file');
    	$city_id 	= $this->input->post('city_id');
    	$cat_id 	= $this->input->post('cat_id');
    
    	$ar_id = $this->input->post('ar_id');
    	$this->vdb->delete('shop_hot',array('position'=>'hot','city_id'=>$city_id,'cat_id'=>$cat_id));
    	$k = 1;
    	 
    	for($i = 0; $i < sizeof($ar_id) ; $i++){
    		if($ar_id[$i]){
    			$vdata['id'] = $ar_id[$i];
    			$vdata['productid'] = $this->input->post('productid_'.$ar_id[$i]);
    			$vdata['city_id'] = $city_id;
    			$vdata['cat_id'] = $cat_id;
    			$vdata['position'] = 'hot';
    			$this->db->insert('shop_hot',$vdata);
    			// Write File
    			$rs = $this->producthome->get_item_hot($ar_id[$i],$city_id, $cat_id);
    			if($rs){
    				$productid		= $rs->productid;
    				$imgPath   		= base_url_site().'technogory/templates/fyi/images/placeholder.gif';
    				$price 			= $this->producthome->get_price_hot($rs->productid, $city_id);
    				$tangpham 		= addli($rs->phukien);
    				$url 			= base_url_site().'san-pham/'.$rs->producturl.'-'.$rs->productid.'.html';
    				$img 			= base_url_static().'alobuy0862779988/0862779988product/190/'.$rs->productimg;
    				$productname 	= $rs->productname;
    				$giathitruong 	= number_format($price->giathitruong,0,'.','.');
    				$giaban 		= number_format($price->giaban,0,'.','.');
    				$phantram 		= $price->phantram .' %';
    
    				$str .='<li>';
    				$str .='<div class="box-info-index">';
    				$str .='
			                <p class="img"><a href="'.$url.'" title="'.$productname.'"><img src="'.$img.'" width="186" alt="'.$productname.'"></a></p>
                			<p class="name"><a href="'.$url.'" title="'.$productname.'">'.$productname.'</a></p>
                            <div class="tang-pham"><ul class="item">'.$tangpham.'</ul></div>
                			<p class="price-old">'.$giathitruong.' ₫</p>
                            <p class="price"><span>'.$giaban.' ₫</span></p>
                          
                    ';
    				$str .='<div class="discount-off">';
    				$str .='<p class="label">Tiết kiệm</p>';
    				$str .='<p class="sales-off">'.$phantram.'</p>';
    				$str .='</div>';
    
    				$str .='<div class="buttom-buy">';
    				$str .='<p class="text"><a href="javascript:;" id="product_'.$productid.'" class="addtocart">Mua ngay</a></p>';
    				$str .='</div>';
    
    				$str .='</div>';
    				$str .='</li>';
    			}
    			$k++;
    		}
    	}
    	//write ************
    	write_file(ROOT.'technogory/config/home/hot/hot_'.$cat_id.'city_'.$city_id.'.db', $str);
    
    	$data['msg'] = 'Lưu dữ liệu thành công';
    	$data['city_id'] = $city_id;
    	echo json_encode($data);
    }
    
    function muanhieu(){
        $data['title'] = 'Sản phẩm mua nhiều Trang chủ';
        $data['listcity'] = $this->vdb->find_by_list('city',array('parentid'=>0,'site'=>1));
        $this->_templates['page'] = 'producthome/muanhieu/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function load_muanhieu(){
        $data['city_id'] = $this->input->post('city_id');
        $data['cat_id']  = 0;
        $this->_templates['page'] = 'producthome/muanhieu/ajax';
        $this->load->view($this->_templates['page'],$data);
    }
    /*-------------------------------+
     * This is promotion top (col promotion)
     +----------------------------*/
    function save_muanhieu(){
        $this->load->helper('file');
        $city_id = $this->input->post('city_id');
        $ar_id = $this->input->post('ar_id');
        $this->vdb->delete('shop_hot',array('position'=>'muanhieu','city_id'=>$city_id));
        $k = 1;
        $str = '<div id="topnew_slideshow">';
        for($i = 0; $i < sizeof($ar_id) ; $i++){
            if($ar_id[$i]){
                $vdata['id'] = $ar_id[$i];
                $vdata['productid'] = $this->input->post('productid_'.$ar_id[$i]);
                $vdata['city_id'] = $city_id;
                $vdata['position'] = 'muanhieu';
                $this->db->insert('shop_hot',$vdata);
                // Write File
                $rs = $this->producthome->get_item_hot($ar_id[$i],$city_id,0,'muanhieu');
                if($rs){
                	$imgPath   = base_url_site().'technogory/templates/fyi/images/placeholder.gif';
                    $price = $this->producthome->get_price_hot($rs->productid, $city_id);
                    $url = base_url_site().'product/'.$rs->producturl.'/'.$rs->productid.'.html';
                    $img = base_url_static().'data/img_product/200/'.$rs->productimg;
                   
                    //$tangpham = $rs->phukien;
                    $productname 	= $rs->productname;
                    $giathitruong 	= number_format($price->giathitruong,0,'.','.');
                    $giamgia 		= number_format($price->giamgia,0,'.','.');
                    $giaban 		= number_format($price->giaban,0,'.','.');
                 
                    $str .='<div id="topnew_slideshow_'.$k.'" class="topnew_slideshow">';
                    $str .='
                    		<div class="img-thumb">
			                    <a href="'.$url.'" title="'.$productname.'"><img src="'.$img.'"  height="130" alt="'.$productname.'"></a>
			                </div>
                			<h3 class="name"><a href="'.$url.'" title="'.$productname.'">'.$productname.'</a></h3>                           
                            <p class="price-old">'.$giathitruong.' VND</p>
                            
                            <p class="price"><span>'.$giaban.' VND</span></p>
                            
                        </div>
                    ';
                }
                $k++; 
            }
        }
        $str .='</div>';
        write_file(ROOT.'technogory/config/home/muanhieu/product_'.$city_id.'.db', $str);
        
        $data['msg'] = 'Lưu dữ liệu thành công';
        $data['city_id'] = $city_id;
        echo json_encode($data);
    }
}
