<?php 
$imgPath   		= base_url().'technogory/templates/default/images/';
$uriCatID		= end(explode('-', $this->uri->segment('2')));
$uri3			= (int)$this->uri->segment('3');
?>


<?php if(count($aProducts) > 0) {
		$base_url_static = $this->config->item('base_url_static');
		$base_url_site = $this->config->item('base_url_site');
?>
<div id="vnit_page_cat">
    <div class="head-order-cat">
    	<h2 class="cat-head">Tìm thấy <?=$num?> sản phẩm <?=$catinfo->catname;?></h2>
<!--         <ul class="ordering">  
        	         
            <li class="fr">
            	Giá: 
                <select onchange="change_order(this.value)" id="vnit_order">
                    <option value="price_desc">Giá giảm dần</option>
                    <option value="price_asc" selected="selected">Giá tăng dần</option>
                    <option value="name_asc">Từ A-Z</option>
                    <option value="name_desc">Từ Z-A</option>
                </select>
            </li>            
            <li class="fr">
            	Sắp xếp:
                <select onchange="change_hot(this.value)" id="vnit_hot" style="width: 120px;">
                    <option value="all">Tất cả</option>
                    <option value="hot">Sản phẩm hot</option>
                    <option value="new">Sản phẩm mới</option>
                    <option value="promotion">Sản phẩm khuyến mãi</option>
                </select>
            </li>
        </ul> -->
    </div>

    <div>
		<ul>
			<?php
				foreach ($aProducts as $key => $aProduct) {
					$tangpham 		= addli($aProduct->phukien);
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
			<?php
				}
			?>
		</ul>
    </div>
    
    <div class="clear"></div>
    <div class="div_page pages" style="padding: 0px;"><?=$pagination?></div>
    
</div>

<?}else{?>
<div class="infomation-show">
	<span>Không tìm thấy sản phẩm.</span>
</div>
<?php }?>

<?=$this->load->view("templates/default/html/otherblocks");?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".info-prod-cat").hover(function(){
			$(this).find(".buttom-buy-prod").css({
				'display':'block'
			});
		},function(){
			$(this).find(".buttom-buy-prod").css({
				'display':'none'
			});
		});
	});
</script>


