    <?php
	$imgPath   = base_url_static().'technogory/templates/default/images/';
	?>

	<!-- Group index -->

	<div class="group-index-box">
		<div>
            <div id="conngoan_bannerads2">
	            <?php
	                $aBannerAds2 = $this->helper->getBannerAdsByPosition(2);
	                if(isset($aBannerAds2->id)){
	                    $img    = base_url_site().'alobuy0862779988/bannerads/banner2/full_images/' . $aBannerAds2->images;
	            ?>
	                    <div>
	                        <a target="_blank" href="<?=$aBannerAds2->link?>"><img src="<?=$img?>" /></a>
	                    </div>
	            <?php } ?>
            </div>
            <div id="conngoan_bannerads3">
	            <?php
	                $aBannerAds3 = $this->helper->getBannerAdsByPosition(3);
	                if(isset($aBannerAds3->id)){
	                    $img    = base_url_site().'alobuy0862779988/bannerads/banner3/full_images/' . $aBannerAds3->images;
	            ?>
	                    <div>
	                        <a target="_blank" href="<?=$aBannerAds3->link?>"><img src="<?=$img?>" /></a>
	                    </div>
	            <?php } ?>
            </div>
		</div>
		<div id="box-left-index">
			<?php foreach($listtab as $tab): ?>
	        	<aside class="col-mid-i">
	            	<div class="title-content"> <!-- title-content -->
			            <div class="mang">
				            <a href="<?=site_url('chuyen-muc/'.$tab->caturl.'-'.$tab->catid)?>" title="<?=$tab->catname?>">
				            	<img src="<?=base_url_static().'alobuy0862779988/0862779988cat/'.$tab->img_main?>" width="18" height="18"  align="absmiddle" alt="<?=$tab->catname?>"/> <?=$tab->catname?>
				            </a>

				            <p class="more"><a href="<?=site_url('chuyen-muc/'.$tab->caturl.'-'.$tab->catid)?>">Xem thêm</a></p>
			            </div>

			            <?if(file_exists(ROOT."technogory/config/tabhome/tab_".$tab->catid.".db")){
			                require_once(ROOT."technogory/config/tabhome/tab_".$tab->catid.".db");
			            }?>


			        </div> <!-- End title-content -->

			        <div>
			        	<?php
			        		$aProducts = $this->helper->getProductByMainCatId($tab->catid);
			        		if(count($aProducts)){
			        			$base_url_static = $this->config->item('base_url_static');
			        			$base_url_site = $this->config->item('base_url_site');
	        			?>
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
			        		}
	        			?>
	        					</ul>
			        </div>

	                <?if(file_exists(ROOT."technogory/config/home/productcat/".$tab->catid."/cat_".$tab->catid."_".$this->city_id.".db")){
	                    require_once(ROOT."technogory/config/home/productcat/".$tab->catid."/cat_".$tab->catid."_".$this->city_id.".db");
	                }?>
	            </aside>

	            <div class="box-ads-index">
	            	<ul class="items">
	                    <?for($i = 1; $i <= $this->config->item('advcat_tota_'.$tab->catid); $i++){?>
	                    <li <?=($i == 1)?'class="padding-r"':'';?>>
	                        <a href="<?=$this->config->item('advcat_link_'.$tab->catid.'_'.$i)?>" title="<?=$this->config->item('advcat_name_'.$tab->catid.'_'.$i)?>">
	                        	<img src="<?=base_url_static()?>alobuy0862779988/adv/danhmuc/<?=$this->config->item('advcat_img_'.$tab->catid.'_'.$i)?>" alt="<?=$this->config->item('advcat_name_'.$tab->catid.'_'.$i)?>" width="390" height="70" />
	                        </a>
	                    </li>
	                    <?}?>
	                </ul>
	            </div>
	       <?endforeach;?>

	 	</div>

	 	<!-- BEGIN RIGHT -->
	 	<aside id="col-right-i">
 			<?php
 				$aRandomProducts = $this->helper->getRandomProduct();
 				if(count($aRandomProducts) > 0){
			        $imgPath   = base_url_static().'technogory/templates/default/images/';
			        $base_url_static = $this->config->item('base_url_static');
			        $base_url_site = $this->config->item('base_url_site');
			?>
	        	<div class="box-quan-tam">
	        		<ul class="list-items">
	        			<?php
	        				foreach ($aRandomProducts as $key => $aProduct) {
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
	        				<li>
	        					<div>
	        						<div>
					                    <a title="<?=$productname?>" href="<?=$base_url_site.'san-pham/'.$producturl.'-'.$productid?>.html">
					                        <img height="190" src="<?=$imgPath?>placeholder.gif" data-original="<?=$productimg?>"  alt="<?=$productname?>">
					                    </a>                    
	        						</div>
	        						<div><?=$productname?></div>
	        						<div><?=$aProduct->barcode?></div>
	        						<div>
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
	        				</li>
	        			<?php
	        				}
	        			?>
	        		</ul>
	        	</div>

			<?php
 				}
 			?>
	   </aside>
	   <!-- END RIGHT -->

	</div>