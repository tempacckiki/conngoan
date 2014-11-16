<!-- <div id="box-head-wapper">
	<div class="title-hot-head"><?php if($this->uri->segment('1') != 'gia-re-moi-ngay'){?>&nbsp; <?php }else{?>Deal hot<?php }?></div>
	<?php if($this->uri->segment('1') != 'gia-re-moi-ngay'){?>
	<link rel="stylesheet" type="text/css" href="<?=base_url_static();?>technogory/templates/default/css/slide_deal.css?v=alobuy.vn">
	<?php }else{?>
	<link rel="stylesheet" type="text/css" href="<?=base_url_static();?>technogory/templates/default/css/slide_deal_hot.css?v=alobuy.vn">
	<?php }?>
	<script type="text/javascript" src="<?=base_url_static()?>technogory/templates/default/js/slideshow.js?v=alobuy.vn" charset="UTF-8"></script> 
	
         <a href="javascript:;" class="next1" id="next2"></a>
         <a href="javascript:;" class="pre" id="prev2"></a>
    	
    	<div id="topnew_slideshow">
    		 <?php
	         	
	        	for($i = 1; $i <= $this->config->item('advDeal_totalTop'); $i++){
	        	 	$name   		= $this->config->item('advDealTop_name_'.$i);
	        	 	$discription   	= $this->config->item('advDealTop_decription_'.$i);
	        	 	$price   		= number_format($this->config->item('advDealTop_price_'.$i), 0, '.','.');
	        	 	$priceOld  		= number_format($this->config->item('advDealTop_priceOld_'.$i), 0, '.','.');
	        	 	$link   		= $this->config->item('advDealTop_link_'.$i);
	        	 	$img  			= base_url_static().'alobuy0862779988/adv/dealindextop/thumb/'.$this->config->item('advDealTop_img_'.$i);
	       	?>
	        		 
            <div id="topnew_slideshow_<?=$i;?>" class="topnew_slideshow">
                <div class="img-thumb">
                    <a href="<?=$link;?>" target="_blank">
                    <?php if($this->uri->segment('1') != 'gia-re-moi-ngay'){?>
                    <img src="<?=$img;?>" width="200" height="170">
                    <?php }else{?>
                    <img src="<?=$img;?>" width="290" height="170">
                    <?php }?>
                    </a>
                    <h<?php echo $i;?> class="name"><a href="<?=$link;?>" target="_blank"><?=$name;?></a></h<?php echo $i;?>>
                </div>
                <div class="box-price">
                	<p class="price-old"><?=$priceOld;?> ₫</p>
                	<p class="price"><?=$price;?> ₫</p>
                </div>
                
            </div> 
            <?php 
					
				}
			?>
            
            
         </div>		
</div> -->

<!-- SAN PHAM NOI BAT -->
<?php
    $aHotProducts = $this->helper->getProductByStatus('hot');
    if(count($aHotProducts) > 0){
        $imgPath   = base_url_static().'technogory/templates/default/images/';
        $base_url_static = $this->config->item('base_url_static');
        $base_url_site = $this->config->item('base_url_site');
?>
    <div id="box-head-wapper">
        <div>SẢN PHẨM NỔI BẬT</div>  
        <div id="sphot_slideshow">
        <?php
            foreach ($aHotProducts as $key => $aProduct) {
                $productid      = $aProduct->productid;
                $productname    = $aProduct->productname;
                $producturl     = $aProduct->producturl;
                $aImg = $this->helper->getProductImageByProductId($productid);
                if(count($aImg) > 0){
                    $productimg     = $base_url_static.'alobuy0862779988/0862779988product/190/' . $aImg[0]->imagepath;
                } else {
                    $productimg     = $imgPath . 'no_image.gif';
                }
                $giathitruong   = number_format($aProduct->giathitruong,0,'.','.');
                $phantram       = $aProduct->phantram .' %';
                $giaban         = number_format($aProduct->giaban,0,'.','.');
        ?>
            <div>
                <div><?=$productname?></div>
                <div>
                    <a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html">
                        <img height="190" src="<?=$productimg?>" data-original="<?=$productimg?>"  alt="<?=$productname?>">
                    </a>                    
                </div>
                <div>
                    <div>Giá:</div>
                    <div><?=$giaban?></div>
                    <?php
                        if((double)$aProduct->phantram > 0){
                    ?>
                        <div><?=$giathitruong?></div>
                    <?php
                        }
                    ?>
                </div>
            </div>    
        <?php
            }
        ?>  
        </div>
        <div>
             <a href="javascript:;" class="next1" id="sphot_next2"></a>
             <a href="javascript:;" class="pre" id="sphot_prev2"></a>            
        </div>    
    </div>
<?php
    } 
?>

<!-- SAN PHAM BAN CHAY -->
<?php
    $aBanChayProducts = $this->helper->getProductByStatus('banchay');
    if(count($aBanChayProducts) > 0){
        $imgPath   = base_url_static().'technogory/templates/default/images/';
        $base_url_static = $this->config->item('base_url_static');
        $base_url_site = $this->config->item('base_url_site');
?>
    <div id="box-head-wapper">
        <div>SAN PHAM BAN CHAY</div>  
        <div id="spbanchay_slideshow">
        <?php
            foreach ($aBanChayProducts as $key => $aProduct) {
                $productid      = $aProduct->productid;
                $productname    = $aProduct->productname;
                $producturl     = $aProduct->producturl;
                $aImg = $this->helper->getProductImageByProductId($productid);
                if(count($aImg) > 0){
                    $productimg     = $base_url_static.'alobuy0862779988/0862779988product/190/' . $aImg[0]->imagepath;
                } else {
                    $productimg     = $imgPath . 'no_image.gif';
                }
                $giathitruong   = number_format($aProduct->giathitruong,0,'.','.');
                $phantram       = $aProduct->phantram .' %';
                $giaban         = number_format($aProduct->giaban,0,'.','.');
        ?>
            <div>
                <div><?=$productname?></div>
                <div>
                    <a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html">
                        <img height="190" src="<?=$productimg?>" data-original="<?=$productimg?>"  alt="<?=$productname?>">
                    </a>                    
                </div>
                <div>
                    <div>Giá:</div>
                    <div><?=$giaban?></div>
                    <?php
                        if((double)$aProduct->phantram > 0){
                    ?>
                        <div><?=$giathitruong?></div>
                    <?php
                        }
                    ?>
                </div>
            </div>    
        <?php
            }
        ?>  
        </div>
        <div>
             <a href="javascript:;" class="next1" id="spbanchay_next2"></a>
             <a href="javascript:;" class="pre" id="spbanchay_prev2"></a>            
        </div>    
    </div>
<?php
    } 
?>

<link rel="stylesheet" type="text/css" href="<?=base_url_static();?>technogory/templates/default/css/slide_deal_hot.css?v=congnoan">
<script type="text/javascript" src="<?=base_url_static()?>technogory/templates/default/js/slideshow.js?v=congnoan" charset="UTF-8"></script> 

<script type="text/javascript">
   $('#sphot_slideshow').cycle({ 
        fx:     'fade',        
        speed: 1000, 
        pause:   1,
        speed:   300,
        timeout: 5000,
        next:   '#sphot_next2', 
        prev:   '#sphot_prev2' 
    });
   $('#spbanchay').cycle({ 
        fx:     'fade',        
        speed: 1000, 
        pause:   1,
        speed:   300,
        timeout: 5000,
        next:   '#spbanchay_next2', 
        prev:   '#spbanchay_prev2' 
    });
</script>