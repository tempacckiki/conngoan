    <?php 
	$imgPath   = base_url_static().'technogory/templates/default/images/';
	?>
	<div class="box-buy-hot">
		<!-- 
		<div class="title-main">
			Sản phẩm <span>mua nhiều nhất</span>
		
		</div>
		 -->
		<div class="box-tab">
			<ul class="item-tab">
				<?php 
					foreach($listtab as $key1=>$tab1):
				?>
				<li <?=($key1 ==0)?'class="select"':'';?>><a href="javascript:;" onclick="getProdHot(<?=$tab1->catid;?>);"> <img src="<?=base_url_img().'alobuy0862779988/0862779988cat/'.$tab1->img_main?>" width="18" height="18"  align="absmiddle" alt="<?=$tab1->catname?>"/><?=$tab1->catname;?></a></li>
				<?php endforeach;?>
			</ul>
		</div>
		
		
		
		
		<div class="group-item-project">
			<script type="text/javascript" src="<?=base_url_static()?>technogory/templates/default/js/jquery.easing.js?v=alobuy.vn" charset="UTF-8"></script>
			<script type="text/javascript" src="<?=base_url_static()?>technogory/templates/default/js/caroufredsel.js?v=alobuy.vn" charset="UTF-8"></script>
			<link type="text/css" rel="stylesheet" href="<?=base_url_static()?>technogory/templates/default/css/tabscroll.css?v=alobuy.vn" media="screen" />
			<script type="text/javascript">
				$(document).ready(function(){
					$(".box-tab ul.item-tab li").click(function(){
						$(".box-tab ul.item-tab li").removeClass("select");
						$(this).addClass("select");
						
					});

				});

				function getProdHot(catID){
					show_loading(); 
					$.post(site_url+"vnit/getListProductCatHot",{'catid':catID}, function(data){
						$("#mod_hethong").html(data);
						 hide_loading();
					});
			
				}
				//****************************
				$(function() {
					$('ul#mod_hethong').carouFredSel({
						auto: true,
						prev: "#prev_ht",
						width : 980,
						visible : 10,
						items: 1,
						duration : 1000,
						start: 0,
						next: "#next_ht"
						});
					});
			</script>
			<div class="image_hethong">
				<script type="text/javascript">
					$(document).ready(function(){					
						//** hover
						$("#mod_hethong li div.box-info-index").hover(function(){
							$(this).find('.buttom-buy').css({
								 'display': 'block'
							});
						},function(){
							$(this).find('.buttom-buy').css({
								'display': 'none'
							});
						});
	
						
					});
				</script>
				<ul id="mod_hethong" style="width: 100%;">
				<?if(file_exists(ROOT.'technogory/config/home/hot/hot_4'.'city_'.$this->session->userdata('city_site').'.db')){
	           		require_once(ROOT.'technogory/config/home/hot/hot_4'.'city_'.$this->session->userdata('city_site').'.db'); 
	            }?>
	            </ul>   
				
				<div class="clearfix"></div>
				<a id="prev_ht" class="prev" href="#"></a>
				<a id="next_ht" class="next" href="#"></a>
			</div>			
							
							
		</div>			
	</div>
	
	<!-- Group index -->
	
	<div class="group-index-box">
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