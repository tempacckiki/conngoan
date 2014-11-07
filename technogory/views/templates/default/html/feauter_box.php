<?php
//get info url
$uri1 = $this->uri->segment(1);
$uri2 = end(explode('-',$this->uri->segment(2)));
$uri3 = end(explode('-', $this->uri->segment(3)));
$catid = $this->uri->segment(3);
	
if($uri1 == 'product'){
	$catid = $this->vdb->find_by_id("shop_product", array('productid'=>$uri3))->catid;
}

if(file_exists(ROOT."site/cache/features/feature_".$catid."_".$this->city_id.".db")){
	$filePath   = ROOT."site/cache/features/feature_".$catid."_".$this->city_id.".db";
	echo  @file_get_contents($filePath);	
}else{
  //$get_varian
  $get_varian = $this->input->get('varian');
  $ar_varian = explode(',',$get_varian);
  
  //get cat url 
  $catUrl    = $this->vdb->find_by_id("shop_cat", array('catid'=>$catid))->caturl;
		
  //get tinh nang
  $url_feature = explode('?',get_url());
  $this->db->select('shop_features.*, shop_features_cat.*');
  $this->db->join('shop_features','shop_features.feature_id = shop_features_cat.feature_id');
  
  $this->db->where('shop_features_cat.catid',$catid);
  $this->db->order_by('shop_features_cat.ordering','asc');
  $list = $this->db->get('shop_features_cat')->result();
  
  //*** get array feature_id *****************************
  $ar_id = array();
  foreach($list as $rs):
    array_push($ar_id, $rs->feature_id);
  endforeach;
  
  
?>
<?if(count($ar_id) > 0){
	  $this->db->where_in('parent_id',$ar_id);
	  $this->db->where('display_on_catalog',1); 
	  $this->db->order_by('ordering','asc');
	  $list_feature = $this->db->get('shop_features')->result();
	  if(count($list_feature) > 0){
	  	$strOptionsF  = '';
	  	$strOptionsF  .= '<div class="title-option">Theo tính năng</div>';
	  	foreach($list_feature as $rs):
			$listfea = get_feature_list($rs->feature_id);
		$strOptionsF .= '<h3 class="l_title">'.$rs->description.'</h3>';
		$strOptionsF .= '<ul class="left_func">';
		
		
		//get number product
		foreach($listfea as $val):
    	$sql = "
                SELECT 
                    pro.productid, pro.catid, shop_price.*
                FROM 
                    shop_product as pro LEFT JOIN shop_features_values as f ON pro.productid = f.product_id JOIN shop_price ON pro.productid = shop_price.productid
               WHERE 
                    pro.published = 1
                AND 
                    pro.catid = $catid";  
    	 $sql .= " AND shop_price.city_id =".$this->city_id;
       	 $sql .=" AND shop_price.giaban != 0";
    	// $sql .=" GROUP BY pro.productid ";
  		 $sql .=" AND f.variant_id IN ($val->variant_id)";
  		 $listCountVariant =  $this->db->query($sql)->result();
  		 //********checked ***************
  		 if($uri1 == 'hang-san-xuat'){
	        $check = (in_array($val->variant_id, $ar_varian) == true)?'checked="checked"':'';
	        
	    }else{
	        $check = ($val->variant_id == $uri2)?'checked="checked"':'';
	    }
	    //bold
	    $boldF	= ($val->variant_id == $uri2)?'class="bold"':'';
	    //name and count products
	    $nameFeatureCount = $val->variant;
	    
  		 //check condition
  		 if(sizeof($listCountVariant)>0){
	  		 $strOptionsF .= '<li>';	    
	  		 	//$strOptionsF .= '<input type="checkbox" class="variant" name="variant" title="'.$catid.'" id="catid_'.$catid.'" value="'.$val->variant_id.'" '.$check.'>';
	  		 	$strOptionsF .= '<a href="'.site_url('Tinh-nang/'.$catUrl.'-'.vnit_change_title($val->variant).'-'.$val->variant_id.'/'.$catid).'" '.$boldF.' title="'.$val->variant.'">'.$nameFeatureCount.'</a>'.' ('.count($listCountVariant).').';
	  		 $strOptionsF .= '</li>';
  		 }
	
		endforeach;
		endforeach;
		
	   $strOptionsF .= '</ul>';
  		 
	  //check $strOptions witr file
	 	if(!empty($strOptionsF)){
        	//Write **************
		     @file_put_contents(ROOT."site/cache/features/feature_".$catid."_".$this->city_id.".db", $strOptionsF);
             //Strign path 
             $filePath   = ROOT."site/cache/features/feature_".$catid."_".$this->city_id.".db";
             echo  @file_get_contents($filePath);            
		}
		
	  }//end count if
		
?>
<?php }?>
<?php }?>
