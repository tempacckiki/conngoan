<?php 
	$imgPath   = base_url_static().'technogory/templates/default/images/';
?>
	
<div class="box-content-wapper">

<div class="col-1"> 
	<div class="block_detail">
		<div class="sp_d_img">
		    <link href="<?=base_url()?>/technogory/templates/default/images/images/cloud-zoom.css" rel="stylesheet" type="text/css" />
			<script type="text/javascript" src="<?=base_url()?>/technogory/templates/default/images/images/cloud-zoom.1.0.2.js"></script>
			<div class="zoom-section"> 
				<div class="zoom-small-image">
					<a href='<?=base_url_static()?>alobuy0862779988/0862779988product/500/<?=$rs->productimg;?>' title='<?=$rs->productname?>' class = 'cloud-zoom' id='zoom1' rel="adjustX: 10, adjustY:-4"><img src="<?=base_url_img()?>alobuy0862779988/0862779988product/500/<?=$rs->productimg?>" width="317" alt='<?=$rs->productname;?>' title="<?=$rs->productname;?>" /></a>
				</div>
				<div class="zoom-desc">
		        		<?
		        		$diemImg  = 1;
		        		foreach($listimg as $img):
		        		?>
							<a href='<?=base_url_static()?>alobuy0862779988/0862779988product/500/<?=$img->imagepath?>' class='cloud-zoom-gallery' title='<?=$rs->productname.'-'.$diemImg;?>' rel="useZoom: 'zoom1', smallImage: '<?=base_url_img()?>alobuy0862779988/0862779988product/500/<?=$img->imagepath?>' "><img class="zoom-tiny-image" src="<?=base_url_img()?>alobuy0862779988/0862779988product/80/<?=$img->imagepath?>"  width="35" height="30" alt = "<?=$rs->productname.'-'.$diemImg;?> "/></a>				
						<?
						$diemImg++;
						endforeach;
						?>			
				</div>
							  
			</div>    
			<div class="box-yahoo-skype">
				<p class="yahoo"><a onclick="_gaq.push(['_trackEvent', 'OnlineSupport', 'Click', 'Yahoo-chamsockhachhang']);" href="ymsgr:sendim?alobuy.vn_0919899779" title="true"><img align="absmiddle" src="http://opi.yahoo.com/online?u=alobuy.vn_0919899779&amp;m=g&amp;t=2" style="border: 0;"></a></p>
				<p class="skype">

				<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
				<a href="skype:thanhtuan1302?call"><img src="http://mystatus.skype.com/bigclassic/thanhtuan1302" style="border: none;" width="160" height="40" alt="My status" /></a>
					
					
			</div>
		</div>
		<div class="sp_d_info">
		    <div class="box-article">
		    
				<h1 class="name"><?=$rs->productname?></h1>		    	
		    	<div class="cm-d-rating">
				        <span class="text">Đánh giá:</span> 
				        <?$rating = $this->product->loadRating($rs->productid); ?>
				        <div style="width: 100px;float: left;">
				            <ul class="star-rating">
				                <li  style="width: <?=$rating?>%;" class="current-rating" id="current-rating_<?=$rs->productid?>"></li>
				                <?if($this->product->check_session_rating($rs->productid)==0){?>
				                <span id="ratelinks">
				                    <li><a class="one-star" rel="<?=$rs->productid?>" title="1 star out of 5" href="javascript:void(0)">1</a></li>
				                    <li><a class="two-stars" rel="<?=$rs->productid?>" title="2 stars out of 5" href="javascript:void(0)">2</a></li>
				                    <li><a class="three-stars" rel="<?=$rs->productid?>" title="3 stars out of 5" href="javascript:void(0)">3</a></li>
				                    <li><a class="four-stars" rel="<?=$rs->productid?>" title="4 stars out of 5" href="javascript:void(0)">4</a></li>
				                    <li><a class="five-stars" rel="<?=$rs->productid?>" title="5 stars out of 5" href="javascript:void(0)">5</a></li>
				                </span>
				                <?}?>
				            </ul>
				            <input type="hidden" value="<?=$rs->productid?>" id="ratingid_<?=$rs->productid?>">
				        </div>
				       
				    </div>
				    
				<div class="views"><span>Lượt xem: <strong><?=$rs->view?></strong> (lần) </span> - <span>Mã hàng: <?=$rs->barcode?></span></div> 
		          
		    </div>
		    
		    
		    
		    <div class="col2">
		        <div class="box-info-prod-de">
		        		<!-- BEGIN box-price -->
		        		<div class="box-price">
		        			<div class="price-sales">
			                    <span class="text">Giá bán:</span> 
			                    <span class="price"><?=number_format($giaban,0,'.','.')?> VND</span>
			                    
			                </div>
			                <div class="price-old-offer">
			            		<div class="price-old">
			            			<?=number_format($giathitruong,0,'.','.')?> VND
			            		</div>
				                <div class="offer-price">
				                    <span class="text">Tiết kiệm:</span> 
				                    <span class="price">
				                   	 <?=number_format($giamgia,0,'.','.')?> VND  = <?=$phantram?> %
				                    </span>
				                </div>
			                </div>
		               		<p class="cam-ket">&nbsp;</p>
		               	</div>
		                <!-- END box-price -->
		                
		                <div class="box_quantity-and-status">
		                	<div class="box-sub"> 
			                	<div class="box-quantity">
					                <div class="quantity">
					                	<span class="text">&nbsp;</span>
					                    <span class="giam" id="giam"></span>
					                    <input type="text" id="qty_<?=$rs->productid?>" class="qty" value="1">
					                    <span class="tang" id="tang"></span> 
					                </div>
					                
					        	</div>
					        	<div class="state">
							      		<?if($rs->tinhtrang == 1){?>
							      		<p class="info-status">&nbsp;</p>      				      			
							      		<p class="text">Còn hàng</p>		      		
							      		<?php }else{?>
							      		<p class="info-status-no">&nbsp	</p>	      			
							      		<p class="text">Hết hàng</p>		      		
							      		<?php }?>
							     </div>
				            </div>    
				                
				        </div>
				        <!-- END Quantily -->
		                <div class="box-buttom-cart">
				        	<?if($rs->tinhtrang == 1){?>				           				           
				             <div class="buttom-cart">
				                    <a onClick="_gaq.push(['_trackEvent', 'Addtocart', 'Click', 'Buynow', '<?=number_format($giaban,0,'.','.')?>']);" href="javascript:;" id="product_<?=$rs->productid?>" class="addtocart buynow">&nbsp;</a>				                   
				             </div>
				             
				            <?}else if($rs->tinhtrang == 2){?>
					            <div class="tinhtrangsanpham">Hết hàng</div>
					            <div class="buttom-cart-disable">
					                   &nbsp;				                   
					             </div>
				            <?}else if($tinhtrang == 3){?>
				            	<div class="tinhtrangsanpham">
				            		<?=$rs->tinhtrang_text;?>
				            	</div>
				            <?}?>
		        	
		        	
		        	</div> 
		        	
		            <div class="order-byphone">
				        	<p class="fb"> Đặt hàng qua điện thoại:</p>
				        	<p class="fs14">TP.Hồ Chí Minh: (08) 62 77 99 88  / 0919 899 779</p>	
				            <p class="fs14">Gia lai: (059) 3500 600 </p>				            			
				            <span class="arr-up">&nbsp;</span>
				    </div>
		           
		            <?if($rs->phukien != ''){?>
		                 <div class="box-phu-kien">
			            	<div class="title">Tính năng và phụ kiện đi kèm</div>
			                <ul class="items"><?=addli($rs->phukien);?></ul>
			             </div>
			        <?}?>
			            
		            
		      	</div>
		      	
		      	
				
				
		        				        
		   </div>
		        
		     
		   
		    
		    
		    
		</div>
	
	</div>

<!-- tab -->
<div class="tab-function">
      <ul class="ui-tabs-nav">
          <li class="select" title="thongsokythuat"><a href="javascript:;"><span>Thông tin sản phẩm</span></a></li>
           <li title="baiviet"><a href="javascript:;"><span>Điểm nổi bật</span></a></li>
           
           <li title="comment"><a href="javascript:;"><span>Đánh giá</span></a></li>
          
      </ul>
    </div>
<div class="shop-content">  
	<div class="content" id="thongsokythuat"><?=$rs->thongsokythuat?></div>
	<div class="content" id="baiviet" style="display: none;">
        	 <ul class="tinhnangnoibat">
            	<?echo $rs->baiviet;?>
            </ul>
     </div>  	
   
   <div class="content" id="comment" style="display: none;">
   	&nbsp;
   </div>
    
</div>
  
<?if(count($ds_sp_cunghang) > 0){?>
	<div class="box-relative-de-sample">    
		<div class="title-de-prd">
   			<span class="label">SẢN PHẨM CHUYÊN MỤC VỚI</span> <h4><?=$rs->productname?></h4>
	    </div> 
	     <div class="box-relative-sample">
			    	<ul class="items">
				    <?foreach($ds_sp_cunghang as $val):
				    	//$tangpham = $this->product->gettangpham($val->productid); 
				    	$giaban 	= $val->giaban; 
				    	$giabanOld 	= $val->giathitruong; 
				    ?>
			    	
			    		<li>
			    			<div class="info-prod-cat">
				    			<p class="img">
						            <a href="<?=site_url('san-pham/'.$val->producturl.'-'.$val->productid)?>" title="<?=$val->productname?>">
						                <img src="<?=base_url_static()?>alobuy0862779988/0862779988product/190/<?=$val->productimg?>" height="190" alt="<?=$val->productname?>">
						            </a>
					            </p>
				            	<p class="product-name">
					                <a href="<?=site_url('san-pham/'.$val->producturl.'-'.$val->productid)?>" title="<?=$val->productname?>">
					                <?=$val->productname?>
					                </a>
					            </p>
					            <div class="tangpham">
					            	 <ul class="tangpham-item"><?=addli($val->phukien);?></ul>
					            </div>
			            		<p class="price-old"><?=number_format($giabanOld,0,'.','.')?> vnd</p>
			            		<p class="price"><?=number_format($giaban,0,'.','.')?> vnd</p>
			            	</div>
			            	<div class="discount">
								<p class="lable">Tiết kiệm</p>
                                <p class="price-discount"><?=$val->phantram .' %';?></p>
                            </div>
			    		</li>
			    	
			    	
			        
			    	<?endforeach;?>
			    	</ul>
			    </div>
			   
	</div>                
 <?}?>   
    
    
    
</div>

<div class="col-2">
	<div class="box-plugin">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			<a class="addthis_button_tweet" tw:related="addthis"></a> 
		</div>
		<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
						
		<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
		<!-- AddThis Button END -->
	</div> 
	<div class="box-support-detail-r">
		<div class="cam-ket">
			<p class="title">Chúng tôi cam kết</p>
			<ul class="items-cam-ket">
				<li class="payment">Trả tiền khi nhận hàng</li>
				<li class="giao-hang">Giao hàng toàn quốc</li>
				<li class="dam-bao">Đảm bảo hàng hóa Đổi trả, hoàn tiền khi sản phẩm lỗi</li>
			</ul>
		</div>
		<div class="calculator">
			<p class="title">Tính phí vận chuyển</p>
			<div class="province">
				<select onchange="getDistrictRate(this.value);">
					<option value="0">|- Tỉnh / Thành Phố</option>
					<?php 
					foreach ($listcity as $valCity):
					?>
					<option value="<?=$valCity->city_id;?>">|- <?=$valCity->city_name;?></option>
					
					<?php 
					endforeach;
					?>
				</select>
			</div>
			
			
			<div class="province">
				<select  id="idDistrict" onchange="getShippingRate(this.value);">
					<option value="0">|- Quận / Huyện</option>
				</select>
			</div>
			
			<div class="shipping">
					<strong>Phí vận chuyển:</strong>  <span>0 đ</span>
			</div>
				
		 		
		 
		</div>
	</div>
	<div>
		<a href="#"><img src="<?=$imgPath;?>support-detail.jpg" alt=""></a>
	</div>
	
	<div class="box-quan-tam-de">
		<?if($this->config->item('advDeal_total') > 0){?>
	   		<div class="title"><p class="text">Có thể bạn quan tâm</p></div>
	        	<ul class="list-items">
	        		 <?php
	        		 $k = 0;
	        		 for($i = 1; $i <= $this->config->item('advDeal_total'); $i++){
	        		 	$name   		= $this->config->item('advDeal_name_'.$i);
	        		 	$discription   	= $this->config->item('advDeal_decription_'.$i);
	        		 	$price   		= number_format($this->config->item('advDeal_price_'.$i), 0, '.','.');
	        		 	$priceOld  		= number_format($this->config->item('advDeal_priceOld_'.$i), 0, '.','.');
	        		 	$link   		= $this->config->item('advDeal_link_'.$i);
	        		 	$img  			= base_url_static().'alobuy0862779988/adv/dealindex/thumb/'.$this->config->item('advDeal_img_'.$i);
	        		 ?>
	        		<li class="row<?=$k;?>">
	        			<div class="sub-row">
		        			<p class="name"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><?=$name;?></a></p>
		        			<p class="img"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><img src="<?=$img;?>" alt="<?=$name;?>" width="90"></a></p>
		        			<div class="info-deal-de">
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
	        
	        <?php }?>
	</div>
	
	
</div>

</div>

<div class="box-footer-ads">	
	<?if($this->config->item('advDeal_totalFooter') > 0){?>
	   		<div class="title-main"><p class="text">Có thể bạn quan tâm</p></div>
	        	<ul class="list-items">
	        		 <?php
	        		 $k = 0;
	        		 for($i = 1; $i <= $this->config->item('advDeal_totalFooter'); $i++){
	        		 	$name   		= $this->config->item('advDealFooter_name_'.$i);
	        		 	$discription   	= $this->config->item('advDealFooter_decription_'.$i);
	        		 	$price   		= number_format($this->config->item('advDealFooter_price_'.$i), 0, '.','.');
	        		 	$priceOld  		= number_format($this->config->item('advDealFooter_priceOld_'.$i), 0, '.','.');
	        		 	$link   		= $this->config->item('advDealFooter_link_'.$i);
	        		 	$img  			= base_url_static().'alobuy0862779988/adv/dealindexfooter/thumb/'.$this->config->item('advDealFooter_img_'.$i);
	        		 ?>
	        		<li>
	        			<div class="sub-row">
		        			<p class="name"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><?=$name;?></a></p>
		        			<p class="img"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><img src="<?=$img;?>" alt="<?=$name;?>" width="90"></a></p>
		        			<div class="info-deal-de">
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
	        
	        <?php }?>
	        
	        
</div>

<script type="text/javascript">
    $(document).ready(function(){             
        $("ul.ui-tabs-nav li").click(function () {
            $("ul.ui-tabs-nav li.select").removeClass("select");
            $(this).addClass("select");
            $(".content").css('display','none');
            var content_show = $(this).attr("title");
            $("#"+content_show).css('display','block');
        });   
    });
	//***
    function getDistrictRate(val){      
        $.post(site_url+"product/getDistricts", { "city_id": val },function(data){		         
            $("#idDistrict").html(data.info);
        }, "json");
    }

    //** get rate
    function getShippingRate(valDist){
    	$.post(site_url+"product/getShippingRate", {"city_id":valDist}, function(data){		
			$(".shipping").html(data.price);
		},"json");
    }
</script>