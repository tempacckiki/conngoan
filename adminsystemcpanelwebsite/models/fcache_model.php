<?php
class fcache_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->helper('file');
    }
    // Begin Ghi san pham trang chu theo danh muc
    
    function write_file_cat(){
    	 //path image
    	 $imgPath   = base_url_static().'technogory/templates/default/images/';
    		
         $listmaincat = $this->vdb->find_by_list('shop_cat',array('parentid'=>0,'published'=>1),array('ordering'=>'asc'));
         foreach($listmaincat as $main){
             $catid = $main->catid;
             $folder_cat = ROOT.'technogory/config/home/productcat/'.$main->catid.'/';
             if(!is_dir($folder_cat)){
                 mkdir($folder_cat);
             }
             $listcity = $this->get_city_site();
             foreach($listcity as $city){
                // Thuc hien ghi file san pham theo tinh, thanh pho;
                $city_id = $city->city_id; 
                $listproduct = $this->getlistproduct($catid, $city_id);
              
                $str = '<ul id="items-index">';
                foreach($listproduct as $val):                   
                    $tangpham 		= addli($val->phukien); 
                    $productid  	= $val->productid;
                    $productname 	= $val->productname;
                    $producturl 	= $val->producturl;
                    $productimg 	= $val->productimg;
                    $giathitruong 	= number_format($val->giathitruong,0,'.','.');                                      
                    $phantram 		= $val->phantram .' %';
                    $giaban 		= number_format($val->giaban,0,'.','.');
                           

                    $str .='
                        
                        <li>
                        	<div class="div-info">
                                <p class="img">                                  
                                    <a title="'.$productname.'" href="'.base_url_site().'san-pham/'.$producturl.'-'.$productid.'.html">
                                    <img height="190" src="'.$imgPath."placeholder.gif".'" data-original="'.base_url_static().'alobuy0862779988/0862779988product/190/'.$productimg.'"  alt="'.$productname.'">
                                    </a>
                                </p>
                                <p class="name"><a title="'.$productname.'" href="'.base_url_site().'san-pham/'.$producturl.'-'.$productid.'.html">'.$productname.'</a></p>
                                <div class="tangpham"><ul class="tangpham-item">'.$tangpham.'</ul></div>
                                <p class="price-old"><span>'.$giathitruong.' ₫</p>                                                              
                                <p class="price">'.$giaban.' ₫</p>    
                             </div> 
                             <div class="discount">
								<p class="lable">Tiết kiệm</p>
                                <p class="price-discount">'.$phantram.'</p>
                            </div>
                                		
                            <div class="buttom-buy-prod">
			                   <p class="text"><a href="javascript:;" id="product_'.$productid.'" class="addtocart">Mua ngay</a></p>
			                </div>  		
                        </li>
                            ';
                endforeach;
                $str .='</ul>';
                write_file($folder_cat.'cat_'.$main->catid.'_'.$city_id.'.db', $str);
             }
         }
    }
    
    
    function getlistproduct($catid = 0,$city_id){
    
        if($catid > 0){
            $ar_catid = $this->vdb->get_ar($catid);
        }
        $this->db->select('shop_product.productid, shop_product.productimg, shop_product.tinhnang, shop_product.productname,shop_product.phukien,shop_product.producturl, shop_product.manufactureid, shop_price.*');
        $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        $this->db->where('shop_price.city_id',$city_id);
        if($catid > 0){
            $this->db->where_in('shop_product.catid',$ar_catid);
        }
        $this->db->where('shop_product.home',1);
        $this->db->where('shop_price.giaban >',0);
        $this->db->order_by('shop_product.orderhome','asc');
        $this->db->limit(8);
        return $this->db->get('shop_product')->result();
         
    }
    
    function gettangpham($productid){
        $this->db->where('productid',$productid);
        return $this->db->get('shop_gifts')->row();
    }
    
    function get_city_site(){
        $this->db->where('site',1);
        $this->db->where('published',1);
        $this->db->order_by('ordering','asc');
        return $this->db->get('city')->result();
    }
    // Danh sach chuyen muc con theo chuyen muc chinh
    function get_arr_cat($catid){
      $ar_cat = array($catid);
      $this->db->where('parentid',$catid);
      $list = $this->db->get('shop_cat')->result();
      foreach($list as $rs):
        $list1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->catid));
        array_push($ar_cat, $rs->catid);
        if(count($list1) > 0){
            foreach($list1 as $rs1):
                $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs1->catid));
                array_push($ar_cat, $rs1->catid);
                if(count($list2) > 0){  
                    foreach($list2 as $rs2):
                       array_push($ar_cat, $rs2->catid);
                    endforeach; 
                }
            endforeach;
        }
        
      endforeach;
      return $ar_cat;
    }
    
    // End Ghi san pham trang chu theo danh muc
    
    // Begin write File muanhieu 
    function write_file_muanhieu(){ 
    	 //path image
    	 $imgPath   = base_url_site().'technogory/templates/fyi/images/';
         $listcity = $this->get_city('muanhieu');
         if(count($listcity) > 0){
             foreach($listcity as $val):
                 $city_id = $val->city_id;
                 $list_product = $this->get_list_product_hot($city_id,'muanhieu');
               	 $str = '<div id="topnew_slideshow">';
                 if(count($list_product) > 0){
                     $k = 1; 
                     foreach($list_product as $val1):
                        $rs = $this->get_item_hot($val1->id,$city_id,'muanhieu');
                        $tangpham = $this->gettangpham($rs->productid);
                        $price = $this->get_price_hot($rs->productid, $city_id);
                        $url = base_url_site().'product/'.$rs->producturl.'/'.$rs->productid.'.html';
                        $img = base_url_img().'data/img_product/200/'.$rs->productimg;
                        $productname = $rs->productname;
                        $giathitruong = number_format($price->giathitruong,0,'.','.');
                        $giamgia = number_format($price->giamgia,0,'.','.');
                        $giaban = number_format($price->giaban,0,'.','.');
                        $border = ($k == 6)?'border-bottom: 0px':'';
                        
                        $str .='<div id="topnew_slideshow_'.$k.'" class="topnew_slideshow">';
                        $str .='
                                <div class="img-thumb"> 
                                    <a href="'.$url.'" title="'.$productname.'"><img src="'.$img.'"  alt="'.$productname.'" height="130" /></a>
                                </div>
                                <h3 class="name"><a href="'.$url.'" title="'.$productname.'">'.$productname.'</a></h3>
                                <p class="price-old">'.$giathitruong.'</p>
                                <p class="price"><span>'.$giaban.' VND</span></p>                                                           
                        </div>';
                        
                        $k ++;
                        endforeach;
                 }
                 $str .= '</div>';
                 write_file(ROOT.'technogory/config/home/muanhieu/product_'.$city_id.'.db', $str);
                   
             endforeach;
         } 
    }
    // Begin write File muanhieu 
    
    
    // Begin write File Hot
    // Ghi file san pham hot
    function write_file_hot(){
    	 //path image
    	 $imgPath   = base_url_site().'technogory/templates/fyi/images/';
         $listcity = $this->get_city('hot');
         if(count($listcity) > 0){
             foreach($listcity as $val):
                 $city_id = $val->city_id;
                 $list_product = $this->get_list_product_hot($city_id,'hot');
                 $str = '<ul id="thumb" class="items-p-i">';
                 if(count($list_product) > 0){
                     foreach($list_product as $val1):
                        $rs = $this->get_item_hot($val1->id,$city_id);
                        $tangpham = $this->gettangpham($rs->productid);
                        $price = $this->get_price_hot($rs->productid, $city_id);
                        $url = base_url_site().'product/'.$rs->producturl.'/'.$rs->productid.'.html';
                        $img = base_url_img().'data/img_product/200/'.$rs->productimg;
                        $productname = $rs->productname;
                        $giathitruong = number_format($price->giathitruong,0,'.','.');
                        $giamgia = number_format($price->giamgia,0,'.','.');
                        $giaban = number_format($price->giaban,0,'.','.');
                        $str .='<li id="tip_'.$rs->productid.'" class="vnit_tip">';
                        $str .='
                                <div class="img" align="center">
                                    <p class="icon-hot">&nbsp;</p> 
                                    <a href="'.$url.'" title="'.$productname.'"><img id="zoom" src="'.$imgPath."placeholder.gif".'" data-original="'.$img.'" height="120" alt="'.$productname.'" /></a>
                                </div>
                                <p class="name"><a href="'.$url.'" title="'.$productname.'">'.$productname.'</a></p>
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
                                        '.addli($rs->tinhnang).' 
                                    </ul>
                                </div>
                            </div>
                        </li>
                                
                        ';
                        endforeach;
                 }
                 $str .='</ul>';
                 write_file(ROOT.'technogory/config/home/hot/hot_'.$city_id.'.db', $str);
             endforeach;
         }
    }
    
    function get_item_hot($id,$city_id,$position ='hot'){
        $this->db->select('shop_product.productid, shop_product.productname, shop_product.tinhnang, shop_product.producturl, shop_product.productimg, shop_hot.*');
        $this->db->join('shop_product','shop_product.productid = shop_hot.productid');
        $this->db->where('shop_hot.id',$id);
        $this->db->where('shop_hot.position',$position);
        $this->db->where('shop_hot.city_id',$city_id);
        return $this->db->get('shop_hot')->row();
    }
    
    function get_list_product_hot($city_id, $position){
        $this->db->where('city_id',$city_id);
        $this->db->where('position',$position);
        $this->db->order_by('id','asc');
        return $this->db->get('shop_hot')->result();
    }
    
    function get_city($position){
        $this->db->where('position',$position);
        $this->db->group_by('city_id');
        return $this->db->get('shop_hot')->result();
    }
    
    function get_price_hot($productid, $city_id){
        $this->db->where('city_id',$city_id);
        $this->db->where('productid',$productid);
        return $this->db->get('shop_price')->row();
    }
    
    // End write File Hot
}
