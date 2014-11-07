<?php
class sangiare extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('sangiare_model','sangiare');
        //$this->regions = $this->session->userdata('fyi_regions');
        $this->city_id = $this->session->userdata('city_site');
        
        
        $this->uri1 = $this->uri->segment('1');
        $this->uri2 = $this->uri->segment('2');
        $this->uri3 = $this->uri->segment('3');
        //load css
        $cssArr = array(
        		array(base_url().'technogory/templates/default/css/deal.css')
        );
        $this->esset->css($cssArr);
        
        //load file
        $this->load->helper('file');
    }

    function index(){
      
       //get catID
       $catID   = (int)end(explode('-', $this->uri->segment("2")));
       if($catID == 0){		
       		//set title
       		$data["title"]      = "Khuyến mãi mỗi ngày";
       		
       		//get item 0 
       	   $item0   = $this->vdb->find_by_id("sangiare", array('published'=>1,'is_home'=>1),null); 
       	    	  
       	   if(!empty($item0)){
       	   		//get list image
       	   		$listImg 	= $this->vdb->find_by_list('shop_img',array('productid'=>$item0->productid));
	       	   if(!file_exists(ROOT."technogory/cache/sangiare/index/products_item0_city_".$this->city_id.".db")){	       	   		
	       	   		$nameItem0  		  	= (!empty($item0->decription))?$item0->decription:$item0->productname;
	       	   		$giabanProduct0  	  	= number_format($item0->giaban,0,'.','.') .' ₫';
	       	   		$giathitruongProduct0  	= number_format($item0->giathitruong,0,'.','.') .' ₫';
	       	   		$giaTietKiem0			= number_format($item0->giathitruong - $item0->giaban,0,'.','.').' ₫';
	       	   		$linkItem0 		      	= site_url('san-pham/'.$item0->producturl.'-'.$item0->productid);
	       	   		$percentPrice0		  	= $item0->percent_price ."%";
	       	   		
	       	   		
	       	   		$strIndex0 = '<div class="deal-top">';
	       	   		$strIndex0 .= '<h1 class="name"><a href="'.$linkItem0.'">'.$nameItem0.'</a></h1>';
	       	   		$strIndex0 .= '<div class="box-left-0">';
	       	   		
	       	   		$strIndex0 .= '<div class="box-price">';
	       	   		$strIndex0 .= '<div class="price-sale">';
	       	   		$strIndex0 .= '<p class="label">Giá chỉ</p>';
	       	   		$strIndex0 .= '<p class="price">'.$giabanProduct0.'</p>';
	       	   		$strIndex0 .= '</div>';
	       	   		$strIndex0 .= '<div class="button-deal">
										<a href="'.$linkItem0.'">&nbsp;</a>
									</div>';
	       	   		$strIndex0 .= '</div>';
	       	   		
	       	   		$strIndex0 .= '<div class="box-other">';
	       	   		$strIndex0 .= '<div class="info-price-deal">';
	       	   		$strIndex0 .= '<dl class="price-old">
							        	<dt>Giá gốc</dt>
							            <dd>'.$giathitruongProduct0.'</dd>
							        </dl>';
	       	   		$strIndex0 .= '<dl class="discount">
							        	<dt>Giảm</dt>
							            <dd>'.$percentPrice0.'</dd>
							        </dl>';
	       	   		$strIndex0 .= ' <dl class="off">
				                    	<dt>Tiết kiệm</dt>
				                   		<dd>'.$giaTietKiem0.'</dd>
				        			</dl>';
	       	   		$strIndex0 .= '</div>';
	       	   		
	       	   		$strIndex0 .= '<div class="box-buyer-info">';
	       	   		$strIndex0 .= '<p class="number-letter"> Vẫn còn <strong>75</strong> phiếu </p>';
	       	   		$strIndex0 .= '<div class="min"></div>';
	       	   		$strIndex0 .= '<div class="progress-bar">
										<div class="l_p"></div>
							        	<div class="r_p" style="width:20%;"><div class="node"></div></div>
									</div>';
	       	   		$strIndex0 .= '<div class="max"></div>';
	       	   		$strIndex0 .= '<p class="number-buyer"> Đã có <strong>275</strong> người mua </p>';
	       	   		$strIndex0 .= '</div>';
	       	   		
	       	   		$strIndex0 .= '<div class="chinh-hang">';
	       	   		$strIndex0 .= '<div class="content">
										Giao hàng trong vòng 1-3 ngày!
									</div>';
	       	   		$strIndex0 .= '</div>';       	   		
	       	   		$strIndex0 .= '</div>';
	       	   		
	       	   		$strIndex0 .= '</div>';
	       	   		
	       	   		
	       	   		$strIndex0 .= '<div class="gallary-box">';
	       	   		$strIndex0 .= '<div class="wrapper_slider">';
	       	   		$strIndex0 .= '<div id="slider" class="nivoSlider">';
	       	   		
	       	   		foreach($listImg as $img):
	       	   		$imgPath	= base_url_static().'alobuy0862779988/0862779988product/500/'.$img->imagepath;
	       	   		$strIndex0 .= ' <a href="javascript:;" title="'.$item0->productname.'"><img src="'.$imgPath.'" width="410" height="330"  alt="'.$item0->productname.'"></a>';
	       	   		endforeach;
	       	   		
	       	   		$strIndex0 .= '</div>';
	       	   		$strIndex0 .= '<div class="icon-circle">
	       	   							<p class="text">&nbsp;</p>					
										<p class="off">'.$percentPrice0.'</p>
									</div>';
	       	   		$strIndex0 .= '</div>';
	       	   		$strIndex0 .= '</div>';
	       	   		
	       	   		$strIndex0 .= '</div>';
	       	   		
		       	   	//list item
		       	   	write_file(ROOT.'technogory/cache/sangiare/index/products_item0_'.'city_'.$this->city_id.'.db', $strIndex0);
		       	   	//get data
		       	   	$data["productIndexItem0"]= ROOT."technogory/cache/sangiare/index/products_item0_city_".$this->city_id.".db";
	       	   }else{
	       	   		//get data
	       	   		$data["productIndexItem0"]= ROOT."technogory/cache/sangiare/index/products_item0_city_".$this->city_id.".db";
	       	   }
       		}
       		
       	   //list cat**************************************************************************
	       if(!file_exists(ROOT."technogory/cache/sangiare/index/products_city_".$this->city_id.".db")){
		       
		       //get cat 
		        $listCats = $this->vdb->find_by_list('shop_cat',array('parentid'=>0,'published'=>1), array('ordering'=>'ASC'));
		       if (sizeof($listCats)>0){
		       	$strIndex = '<div class="groups-cat">';
		       	foreach ($listCats as $valCat):		       		
		       		$linkCat   = site_url('gia-re-moi-ngay/'.$valCat->caturl.'-'.$valCat->catid);
		       		//get lis
		       		$listProducts	   = $this->sangiare->getAllListDealCatID($valCat->catid,8);
			       if(sizeof($listProducts)>0){
			       		
			       		$strIndex .= '<div class="title-cat"><p class="text"><a href="'.$linkCat.'">'.$valCat->catname.'</a></p><span class="more"><a href="'.$linkCat.'">Xem thêm</a></span></div>';
			       		$strIndex  .=  '<ul class="items-box">';
			       		
			       		foreach ($listProducts as $val){
			       			$productID			  = $val->productid;
			       			$nameProduct  		  =  (!empty($val->decription))?$val->decription:$val->productname;
			       			$giabanProduct  	  =  number_format($val->giaban,0,'.','.') .' ₫';
			       			$giathitruongProduct  =  number_format($val->giathitruong,0,'.','.') .' ₫';
			       			$linkProduct 		  = site_url('san-pham/'.$val->producturl.'-'.$val->productid);
			       			$percentPrice		  = $val->percent_price ."%";
			       			$views				  = ($val->views)?$val->views:20; 
			       			$imgThumb			  = base_url().'alobuy0862779988/0862779988product/300/'.$val->productimg; 
			       			//image path
			       			$imgPath    		  = base_url().'technogory/templates/default/images/';
			       			
				       		$strIndex .= '<li>';
				       		if(!empty($val->decription)){
				       			$strIndex .= '<p class="name-decription"><a href="'.$linkProduct.'">'.$nameProduct.'</a></p>';
				       		}else{
				       			$strIndex .= '<p class="name-decription"><a href="'.$linkProduct.'">'.$nameProduct.'</a></p>';
				       		}
				       		$strIndex .= '<div class="img">';
				       			
				       		$strIndex .= '<a href="'.$linkProduct.'"><img src="'.$imgPath.'loading.gif" data-original="'.$imgThumb.'" width="302" alt="'.$nameProduct.'"></a>';		       			
				       		$strIndex .= '<div class="deal-circle"><p class="text">&nbsp;</p><p class="off">'.$percentPrice.'</p></div>';
				       		
				       		$strIndex .= '<div class="view-old-price">';
				       		$strIndex .= '<p class="price-old">'.$giathitruongProduct.'</p>';
				       		$strIndex .= '<p class="views">Còn <strong>'.$views.'</strong> phiếu</p>';
				       		$strIndex .= '</div>';
				       		
				       		$strIndex .= '</div>';
				       		
				       		$strIndex .= '<div class="info-deal-bootom">';				       			
				       		$strIndex .= '<p class="price-sales"><span>Giá chỉ:</span>'.$giabanProduct.'</p>';	
				       		$strIndex .= '<p class="buttom-buy"><a href="'.$linkProduct.'">&nbsp;</a></p>';				       									
				       		$strIndex .= '</div>';
				       			
				       		$strIndex .= '</li>';
			       		
			       			
			       		}
			       		$strIndex .='</ul>';
			       					       	
			        	//list item
			        	write_file(ROOT.'technogory/cache/sangiare/index/products_'.'city_'.$this->city_id.'.db', $strIndex);
			        	//get data
			        	$data["productIndex"]= ROOT."technogory/cache/sangiare/index/products_city_".$this->city_id.".db";
			       	 } 
		       	 endforeach; //end for cat
		       	 $strIndex .= '</div>';
		       }
	       }else{
	       	
	       		$data["productIndex"]= ROOT."technogory/cache/sangiare/index/products_city_".$this->city_id.".db";
	       }
	       
	       //load template **********************
	       $this->_templates['page'] = 'index';
	       $this->templates->load($this->_templates['page'],$data,'deal');
       
       }else{
       		$rsCat   = $this->vdb->find_by_id('shop_cat', array('catid'=>$catID)); 
       		$data["title"]      = $rsCat->catname;
       		//set title
       		$data["catinfo"]    = $rsCat;       		
       		       		
	       // kiem tra file co ton tai hay khong?   
	    	if(!file_exists(ROOT.'technogory/cache/sangiare/category/products_item0_'.$catID.'_city_'.$this->city_id.'.db') || !file_exists(ROOT."technogory/cache/sangiare/category/products_".$catID."_city_".$this->city_id.".db")){    		
			       
		       //get lis
		       $listProductsCat	   = $this->sangiare->getAllListDealCatID($catID);
		       if(sizeof($listProductsCat)>0){
		       		$item  = 0;
		       		$strIndex = '<div class="groups-cat">';		       		
		       		$strIndex .=  '<ul class="items-box">';
		       		foreach ($listProductsCat as $valCat){
		       			$productIDCat				= $valCat->productid;
		       			$nameProductCat  		  	= (!empty($valCat->decription))?$valCat->decription:$valCat->productname;
		       			$giabanProductCat  	  		= number_format($valCat->giaban,0,'.','.') .' ₫';
		       			$giathitruongProductCat  	= number_format($valCat->giathitruong,0,'.','.') .' ₫';
		       			$giaTietKiem0				= number_format($valCat->giathitruong - $valCat->giaban,0,'.','.').' ₫';
		       			$linkProductCat 		  	= site_url('san-pham/'.$valCat->producturl.'-'.$valCat->productid);
		       			$viewsCat  					= ($valCat->views)?$valCat->views:20;
		       			$imgThumbCat			  	= base_url().'alobuy0862779988/0862779988product/300/'.$valCat->productimg;
		       			//image path
		       			$imgPath    		  		= base_url().'technogory/templates/default/images/';
		       			$percentPriceCat		  	= $valCat->percent_price ."%";
		       			
		       			if ($item == 0){		       						       				
		       				//get list image
		       				$listImg 	= $this->vdb->find_by_list('shop_img',array('productid'=>$valCat->productid));
		       				if(!file_exists(ROOT."technogory/cache/sangiare/category/products_item0_".$catID."_city_".$this->city_id.".db")){		       						
		       						 
		       						$strIndex0 = '<div class="deal-top">';
		       						$strIndex0 .= '<h1 class="name"><a href="'.$linkProductCat.'">'.$nameProductCat.'</a></h1>';
		       						$strIndex0 .= '<div class="box-left-0">';
		       						 
		       						$strIndex0 .= '<div class="box-price">';
		       						$strIndex0 .= '<div class="price-sale">';
		       						$strIndex0 .= '<p class="label">Giá chỉ</p>';
		       						$strIndex0 .= '<p class="price">'.$giabanProductCat.'</p>';
		       						$strIndex0 .= '</div>';
		       						$strIndex0 .= '<div class="button-deal">
										<a href="'.$linkProductCat.'">&nbsp;</a>
									</div>';
		       						$strIndex0 .= '</div>';
		       						 
		       						$strIndex0 .= '<div class="box-other">';
		       						$strIndex0 .= '<div class="info-price-deal">';
		       						$strIndex0 .= '<dl class="price-old">
							        	<dt>Giá gốc</dt>
							            <dd>'.$giathitruongProductCat.'</dd>
							        </dl>';
		       						$strIndex0 .= '<dl class="discount">
							        	<dt>Giảm</dt>
							            <dd>'.$percentPriceCat.'</dd>
							        </dl>';
		       						$strIndex0 .= ' <dl class="off">
				                    	<dt>Tiết kiệm</dt>
				                   		<dd>'.$giaTietKiem0.'</dd>
				        			</dl>';
		       						$strIndex0 .= '</div>';
		       						 
		       						$strIndex0 .= '<div class="box-buyer-info">';
		       						$strIndex0 .= '<p class="number-letter"> Vẫn còn <strong>75</strong> phiếu </p>';
		       						$strIndex0 .= '<div class="min"></div>';
		       						$strIndex0 .= '<div class="progress-bar">
										<div class="l_p"></div>
							        	<div class="r_p" style="width:20%;"><div class="node"></div></div>
									</div>';
		       						$strIndex0 .= '<div class="max"></div>';
		       						$strIndex0 .= '<p class="number-buyer"> Đã có <strong>275</strong> người mua </p>';
		       						$strIndex0 .= '</div>';
		       						 
		       						$strIndex0 .= '<div class="chinh-hang">';
		       						$strIndex0 .= '<div class="content">
										Giao hàng trong vòng 1-3 ngày!
									</div>';
		       						$strIndex0 .= '</div>';
		       						$strIndex0 .= '</div>';
		       						 
		       						$strIndex0 .= '</div>';
		       						 
		       						 
		       						$strIndex0 .= '<div class="gallary-box">';
		       						$strIndex0 .= '<div class="wrapper_slider">';
		       						$strIndex0 .= '<div id="slider" class="nivoSlider">';
		       						 
		       						foreach($listImg as $img):
		       						$imgPath	= base_url_static().'alobuy0862779988/0862779988product/500/'.$img->imagepath;
		       						$strIndex0 .= ' <a href="javascript:;" title="'.$nameProductCat.'"><img src="'.$imgPath.'" width="410" height="330"  alt="'.$nameProductCat.'"></a>';
		       						endforeach;
		       						 
		       						$strIndex0 .= '</div>';
		       						$strIndex0 .= '<div class="icon-circle">
	       	   							<p class="text">&nbsp;</p>
										<p class="off">'.$percentPriceCat.'</p>
									</div>';
		       						$strIndex0 .= '</div>';
		       						$strIndex0 .= '</div>';
		       						 
		       						$strIndex0 .= '</div>';
		       						 
		       						//list item
		       						write_file(ROOT.'technogory/cache/sangiare/category/products_item0_'.$catID.'_city_'.$this->city_id.'.db', $strIndex0);
		       						//get data
		       						$data["productIndexItem0"]= ROOT."technogory/cache/sangiare/category/products_item0_".$catID."_city_".$this->city_id.".db";
		       				}else{
		       						//get data
		       						$data["productIndexItem0"]= ROOT."technogory/cache/sangiare/category/products_item0_".$catID."_city_".$this->city_id.".db";
		       				}
		       				
		       			}else{
		       						       					       			
			       			$strIndex .= '<li>';
			       			if(!empty($valCat->decription)){
			       				$strIndex .= '<p class="name-decription"><a href="'.$linkProductCat.'">'.$nameProductCat.'</a></p>';
			       			}else{
			       				$strIndex .= '<p class="name-decription"><a href="'.$linkProductCat.'">'.$nameProductCat.'</a></p>';
			       			}
			       			$strIndex .= '<div class="img">';
			       			
			       			$strIndex .= '<a href="'.$linkProductCat.'"><img src="'.$imgPath.'loading.gif" data-original="'.$imgThumbCat.'" width="310" alt="'.$nameProductCat.'"></a>';
			       			$strIndex .= '<div class="deal-circle"><p class="text">&nbsp;</p><p class="off">'.$percentPriceCat.'</p></div>';
			       			
			       			$strIndex .= '<div class="view-old-price">';
			       			$strIndex .= '<p class="price-old">'.$giathitruongProductCat.'</p>';
			       			$strIndex .= '<p class="views">Còn <strong>'.$viewsCat.'</strong> phiếu</p>';
			       			$strIndex .= '</div>';
							
			       			$strIndex .= '</div>';
			       			
			       			$strIndex .= '<div class="info-deal-bootom">';
			       			$strIndex .= '<p class="price-sales"><span>Giá chỉ:</span>'.$giabanProductCat.'</p>';
			       			$strIndex .= '<p class="buttom-buy"><a href="'.$linkProductCat.'">&nbsp;</a></p>';
			       			$strIndex .= '</div>';
			       						       			
			       			
			       			$strIndex .= '</li>';
		       			}
		       			$item++;
		       		}
		       		$strIndex .='</ul>';
		       		$strIndex .='</div>';
		       		
		       		
		       		//write ************
		        	write_file(ROOT."technogory/cache/sangiare/category/products_".$catID."_city_".$this->city_id.".db", $strIndex);
		        	//Product cat
		        	$data["productCat"]= ROOT."technogory/cache/sangiare/category/products_".$catID."_city_".$this->city_id.".db";
		       } 
	       }else{
	       		//get data
	       		$data["productIndexItem0"]= ROOT."technogory/cache/sangiare/category/products_item0_".$catID."_city_".$this->city_id.".db";
	       		//list cat
	       		$data["productCat"]= ROOT."technogory/cache/sangiare/category/products_".$catID."_city_".$this->city_id.".db";
	       }
       		
	       //load template **********************
	       $this->_templates['page'] = 'cat';
	       $this->templates->load($this->_templates['page'],$data,'deal');
       
       }
        
    
    }
    
  
}
