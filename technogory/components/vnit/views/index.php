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
	 		//load config 
	 		$this->load->config("config_dealindex_".$this->session->userdata('city_site'));
	 		if($this->config->item('advDeal_total') > 0){
			
			?>
			
			<?php 
		   if($this->session->userdata('city_site') == 26){
		   ?>
		   <div class="support-onnline-index"><img src="<?php echo $imgPath;?>support-index_26.jpg" alt="ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nơi."></div>
		   <?php }elseif($this->session->userdata('city_site') == 197){?>
		    <div class="support-onnline-index"><img src="<?php echo $imgPath;?>support-index_197.jpg" alt="ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nơi."></div>
		   <?php }else{?>
		   <div class="support-onnline-index"><img src="<?php echo $imgPath;?>support-index.jpg" alt="ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nơi."></div>
		   <?php }?>
	    	
	        
	        <div class="box-quan-tam">
	        	<div class="title"><p class="text">Có thể bạn quan tâm</p></div>
	        	<ul class="list-items">
	        		 <?php
	        		 $k = 0;
	        		 for($i = 1; $i <= $this->config->item('advDeal_total'); $i++){
	        		 	$name   		= $this->config->item('advDeal_name_'.$i);
	        		 	$discription   	= $this->config->item('advDeal_decription_'.$i);
	        		 	$price   		= number_format($this->config->item('advDeal_price_'.$i),0,'.','.');
	        		 	
	        		 	$priceOld  		= number_format($this->config->item('advDeal_priceOld_'.$i),0,'.','.');
	        		 	$link   		= $this->config->item('advDeal_link_'.$i);
	        		 	$img  			= base_url_static().'alobuy0862779988/adv/dealindex/thumb/'.$this->config->item('advDeal_img_'.$i);
	        		 ?>
	        		<li class="row<?=$k;?>">
	        			<div class="sub-row">
		        			<p class="name"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><?=$name;?></a></p>
		        			<p class="img"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><img src="<?=$img;?>" alt="<?=$name;?>" width="60"></a></p>
		        			<div class="info-deal-index">
		        				<p class="description"><?=$discription;?></p>
		        				<p class="price-old"><?=$priceOld;?> ₫</p>
		        				<p class="price"><?=$price;?> ₫</p>
		        			</div>
	        			</div>
	        		</li>
	        		<?php 
					$k  = 1 - $k;
					}
					?>
	        		
	        	</ul>
	        </div>
	        <?php }?>
	   </aside>
	   <!-- END RIGHT -->
	   
	</div>