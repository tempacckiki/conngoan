<?php
/****************************************+

+***************************************** */
$uri1 	= $this->uri->segment(1);
$uri2 	= end(explode('-',$this->uri->segment(2)));
$uri3 	= end(explode('-', $this->uri->segment(3)));
$catid 	= $uri2;
	
if($uri1 == 'product'){
	 $catid = $this->vdb->find_by_id("shop_product", array('productid'=>$uri3))->catid;
}
if($uri1 == 'hang-san-xuat'){
	$catid 	= $this->uri->segment('3');
}
	
if(file_exists(ROOT."technogory/cache/manufacture/manufacture_".$catid."_".$this->city_id.".db")){
	 //Strign path 
     $filePath   = ROOT."technogory/cache/manufacture/manufacture_".$catid."_".$this->city_id.".db";
     echo  @file_get_contents($filePath);   
	
}else{
	
	//get info shopcat 
	$infoCategory   = $this->vdb->find_by_id("shop_cat", array('catid'=>$catid));
	//get cat url 
	$catUrl    		= $infoCategory->caturl;
	$catName    	= $infoCategory->catname;
		
	$strOptions  = '';

	//get hang san xuat ********************************************
	$this->db->select('shop_manufacture.*, shop_cat_manufacture.*');
	$this->db->join('shop_manufacture','shop_manufacture.manufactureid = shop_cat_manufacture.manufactureid');
	$this->db->where_in('shop_cat_manufacture.catid',$catid); 
	$this->db->order_by('shop_cat_manufacture.ordering','asc'); 
	$list = $this->db->get('shop_cat_manufacture')->result();
	
	//kiem tra 
	 if(count($list) > 0){
	 	$strOptions .= '<p class="title"><span>&nbsp;</span>Tìm theo thương hiệu</p>';
	 	$strOptions  .='<div class="box-m">';
	 	$strOptions  .='<ul class="sub-left-items">';
	 	//duyet 
	 	foreach($list as $val):    	
	    	$sql = "
	                SELECT 
	                    pro.productid, shop_price.productid
	                FROM 
	                    shop_product as pro LEFT JOIN shop_price ON pro.productid = shop_price.productid
	               WHERE 
	                    pro.published = 1
	                AND 
	                    pro.catid = $catid";  
	    	 $sql .= " AND shop_price.city_id =".$this->city_id;
	       	 $sql .=" AND shop_price.giaban != 0";
	    	// $sql .=" GROUP BY pro.productid ";
	  		 $sql .=" AND pro.manufactureid IN ($val->manufactureid)";
	         //$this->db->cache_on();
	         
  		 $listProductCount =  $this->db->query($sql)->result();
  		 	
   		//Hien thi
   		$checkedManu =($val->manufactureid == $uri2)?'checked="checked"':'';
   		$linkManu 	 = site_url("hang-san-xuat/".$catUrl."-".vnit_change_title($val->name)."-".$val->manufactureid."/".$catid);
   		$bold 		 = ($val->manufactureid == $uri2)?'class="bold"':'';
   		if(sizeof($listProductCount)>0){
	   		$strOptions .='<li>';
	   		$strOptions .='<a href="'.$linkManu.'" title="'.$val->name.'">'.$catName.' '.$val->name.'</a> ('.count($listProductCount).')';
	   		$strOptions .='</li>';
   		}
  		 endforeach;
  		 $strOptions .= '<li><a href="'.site_url('chuyen-muc/'.$catUrl.'-'.$catid).'" title="'.$catName.'"><strong>Xem lại tất cả</strong></a></li>';
	 	$strOptions  .='</ul>';
	 	$strOptions  .='</div>';
	 	
	 	//check $strOptions witr file
	 	if(!empty($strOptions)){
			  //**** write ****************
		     @file_put_contents(ROOT."technogory/cache/manufacture/manufacture_".$catid."_".$this->city_id.".db", $strOptions);
			 //Strign path 
			 $filePath   = ROOT."technogory/cache/manufacture/manufacture_".$catid."_".$this->city_id.".db";
			 echo  @file_get_contents($filePath);   
		}
		
	 }
	
	
		

}
