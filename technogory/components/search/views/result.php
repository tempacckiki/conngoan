
<?php 
	$imgPath   		= base_url_static().'technogory/templates/default/images/';
	$base_url_static = $this->config->item('base_url_static');
	$base_url_site = $this->config->item('base_url_site');
?>
<div id="left-faq">
    <div class="headcat">
        <ul class="ordering"> 
            <li class="fl">Tìm thấy <span id="num"><b><?=$total?></b></span> sản phẩm với từ khóa : <b><?=$productkey?></b></li>            
          
        </ul>
    </div>
    
		<div class="clear">
		    <ul class="cat-p-items">
		    <?php
		    $i = 1;
		    foreach($list as $aProduct):
		    	// $nxs = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$rs->manufactureid));
                $productid  	= $aProduct->productid;
                $productname 	= $aProduct->productname;
                $producturl 	= $aProduct->producturl;
                $aImg = $this->helper->getProductImageByProductId($productid);
                if(count($aImg) > 0){
                    $productimg 	= $base_url_static.'alobuy0862779988/0862779988product/190/' . $aImg[0]->imagepath;
                } else {
                    $productimg 	= $imgPath . 'no_image.gif';
                }
                $giathitruong 	= number_format($aProduct->giathitruong,0,'.','.');
                $phantram 		= $aProduct->phantram .' %';
                $giaban 		= number_format($aProduct->giaban,0,'.','.');		    		    
		    ?>
		        <li>    
					<div>
						<div class="div-info">
							<div>
                                <a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html">
                                    <img height="190" src="<?=$imgPath?>placeholder.gif" data-original="<?=$productimg?>"  alt="<?=$productname?>">
                                </a>
							</div>
							<div><a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html"><?=$productname?></a></div>
							<div><span><?=$aProduct->barcode?></div>
							<div><span><?=$giaban?> ₫</div>
						<?php
							if((double)$aProduct->phantram > 0){
						?>
								<div><span><?=$giathitruong?> ₫</div>
						<?php
							}
						?>
						</div>
						<?php
							if((double)$aProduct->phantram > 0){
						?>
    							<div class="discount">-<?=$phantram?></div>
						<?php
							} else if($aProduct->sphot) {
						?>
    							<div class="discount">HOT</div>
						<?php		
							}
						?>
					</div>
		        </li>
		    <?endforeach;?>
		    </ul>
	    </div>
   
    <div class="clear-paginator">
     	<div class="pages" style="padding: 0px;"><?=$pagination?></div>
     </div>
</div>
<div id="right-faq">
    <div>
       <?=$this->load->view("templates/default/html/randomproduct");?>
    </div>
</div>
<script type="text/javascript">
function searchresult_page(page_no){ 
    $.post(site_url+"search/result.html?p=<?=$productkey?>",{'page_no':page_no,'ajax':1},function(data){
        $("#vnit_page_cat").html(data);                                      
    });
}
</script>
