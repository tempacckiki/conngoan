<?php
class category extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('category_model','category');
        $this->regions = $this->session->userdata('fyi_regions');
        $this->city_id = $this->session->userdata('city_site');
        //$this->load->library('pagi');
        if(!$this->session->userdata('vnit_view')){
            $this->session->set_userdata('vnit_view','view_list');
        }
        
        $this->uri1 = $this->uri->segment('1');
        $this->uri2 = $this->uri->segment('2');
        $this->uri3 = $this->uri->segment('3');
		$this->uri4 = (int)$this->uri->segment('4');
		
    }

    function index(){
        $get                = $this->input->get();
       

        //get catid *******************************
       	$catid              = end(explode('-',  $this->uri2));
        $catinfo            = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid));
        if(!$catinfo){
            redirect();
        }
        
         //get list cat ******************************************
        $data['listcat']    = $this->category->get_subcat($catid);
        
        //get top link 
        $data['top_link']   			= $this->category->find_top_link($catinfo->catid,$catinfo->parentid);
        $data['top_link_seo'] 			= 'http://alobuy.vn/'.$this->uri1.'/'.$this->uri2.'/'.$this->uri3.'.html';
        //set redirectitlle
        $data['top_link_redirect'] 		= 'http://alobuy.vn/chuyen-muc/'. $catinfo->caturl.'-'.$catid.'.html';
        if($this->uri3){
        	$data['top_link_redirect']  = 'http://alobuy.vn/chuyen-muc/'. $catinfo->caturl.'-'.$catid.'/'.$this->uri3;
        }
      
        
        $limit  = 40;
        $max 	= (int)$this->input->get('max');
        $min 	= (int)$this->input->get('min');
        $data['max'] = $max;
        $data['min'] = $min; 
        $data['catinfo']    = $catinfo;
        $data['catid']      = $catid;
        $data['title']      = $catinfo->catname;
		
		
        //set view key
        $data['catkeyword'] = $catinfo->catkeyword;
        //set view description
        $data['catdes'] 	= $catinfo->catdes;
        
        $data['catmenu']    = ($catinfo->parentid !=0 )?$catinfo->parentid:$catinfo->catid;
       
        $num                = $this->category->get_num_product($catid,$max,$min,$hot='all');
        $data['num']        = $num;
      
        //config paginator 
        $config['base_url'] 		= base_url().'chuyen-muc/'.$this->uri2.'/';
        
        $config['total_rows']  		=  $num;;
        
        $config['per_page']   		=  $limit;
        $config['uri_segment'] 		=  3;
        $this->pagination->initialize($config);
       
        //phan product cache        
	    $strOptions = '';
	    $fileProduct 	 = ROOT."technogory/cache/products/".$catinfo->catid."_"."product_".$this->city_id.".db" ;
	    	
	   if(file_exists($fileProduct) && ($this->uri3 ==0)){	   	
	    	$data["cacheFile"] = @file_get_contents($fileProduct);
	   }else{
        
        	//get list product      
        	$data['list']       =   $this->category->get_all_product($config['per_page'],(int)$this->uri->segment('3'),$catid, $max, $min, $hot='all',$order='price_asc');
		
	   		if(sizeof($data['list'])>0){
	    			$strOptions .= '<ul class="cat-p-items">';
					$i   = 1;
	    			foreach ($data['list'] as $valProd):
	    				//gan data
	    				$imgPath    	= base_url_static().'technogory/templates/default/images/';
	    				$idProd     	= $valProd->productid;
	    				$linkProd   	= site_url('san-pham/'.$valProd->producturl.'-'.$valProd->productid);    				
	    				$productName 	= $valProd->productname;
	    				$imgName 	 	= base_url_static().'alobuy0862779988/0862779988product/190/'.$valProd->productimg;
	    				$priceSales     = number_format($valProd->giathitruong,0,'.','.').' ₫';
	    				$priceTietK		= number_format($valProd->giamgia,0,'.','.') .' ₫';
	    				$phantram 		= $valProd->phantram .' %';
	    				$priceBuy		= number_format($valProd->giaban,0,'.','.') .' ₫';	    				
	    				$phuKien 		= addli($valProd->phukien);
	    				
	    				//truyen to string options
	    				$strOptions .= '<li>';    				
	    				$strOptions .= '<div class="info-prod-cat">';    				
	    				$strOptions .= '<figure class="img">';
	    				$strOptions .= '<a href="'.$linkProd.'" title="'.$productName.'">';
	    				$strOptions .= '<img id="zoom" src="'.$imgPath.'placeholder.gif" data-original="'.$imgName.'" width="188" alt="'.$productName.'" class="product">';
	    				$strOptions .= '</a>';
	    				$strOptions .= '</figure>';
						if($i >5){
							$i = 1;
	    					$strOptions .= '<h'.$i.' class="name"><a href="'.$linkProd.'" title="'.$productName.'">'.$productName.'</a></h'.$i.'>';
						}else{
							$strOptions .= '<h'.$i.' class="name"><a href="'.$linkProd.'" title="'.$productName.'">'.$productName.'</a></h'.$i.'>';
						}
						
						
	    				$strOptions .= '<ul class="phu-kien">'.$phuKien.'</ul>';
	    				$strOptions .= '<p class="price-old">'.$priceSales.'</p>';
						             						               
	    				$strOptions .= '<p class="price">
						                <span>'.$priceBuy.'</span>
						            	</p>';
	    					    				
	    				$strOptions .= '<div class="discount">';
	    				$strOptions .= '<p class="lable">Tiết kiệm</p>';
	    				$strOptions .= '<p class="price-discount">'.$phantram.'</p>';
	    				$strOptions .= '</div>';
	    				//check tinhtrang
						if($valProd->tinhtrang == 1){
							$strOptions .= '<div class="buttom-buy-prod">
											   <p class="text"><a href="javascript:;"  id="product_'.$idProd.'" class="addtocart">Mua ngay</a></p>
											</div>';
	    				}else{
							$strOptions .= '<div class="buttom-buy-prod">
											   <p class="text"><a href="javascript:;">Hết hàng</a></p>
											</div>';

						}
	    				$strOptions .= '</div>';
	    				$strOptions .= '</li>';
						$i++;
	    			endforeach;
					
	    			$strOptions .= '</ul>';
	    		}
	    		
	   			//check options 
		        if(!empty($strOptions) && ($this->uri3 ==0)){
		        	@file_put_contents($fileProduct, $strOptions);
		        	//set view
		        	$data["cacheFile"] = @file_get_contents($fileProduct);
		        }else{
					 $fileProductPage 	 = ROOT."technogory/cache/products/".$catinfo->catid."_"."product_".$this->city_id."_".$this->uri3.".db" ;
					 @file_put_contents($fileProductPage, $strOptions);
					 //set view ****
					 $data["cacheFilePage"] = @file_get_contents($fileProductPage);
				}
	    		
	   }
        
        $data['total_list'] = $data['list'];
        
        
        //*****
        $data['listcompare'] = $this->vdb->find_by_list('shop_compare',array('session_id'=>cookie_mycart()));
        $data['pagination']  = $this->pagination->create_links(); 
        
    	
        //load template *********************************************
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data,'cat');
    }
    
    
}
