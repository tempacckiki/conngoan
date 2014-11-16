<?php 
	require_once (ROOT . 'debug/debug.php');
	// lytk_log_message(ROOT . 'debug/logs/', "error", 'tkly --  -- $listimg -- ' . print_r($listimg, true));
	// lytk_log_message(ROOT . 'debug/logs/', "error", 'tkly --  -- $rs -- ' . print_r($rs, true));

	$imgPath   = base_url_static().'technogory/templates/default/images/';
	// $listimg : list image in below folder 
	// /alobuy0862779988/0862779988product
	// 		40/80/190/300/500
?>
	
<div class="box-content-wapper">
	<div class="col-1"> 
		<div>
			<!-- images -->
			<div>
				<?php
        		foreach($listimg as $img){
        		?>
        			<?=base_url_static()?>alobuy0862779988/0862779988product/500/<?=$img->imagepath?> <br />
        			<?=base_url_static()?>alobuy0862779988/0862779988product/40/<?=$img->imagepath?> <br />
				<?php
				}
				?>
			</div>
			<!-- basic info -->
			<div>
				<!-- name -->
				<div><?=$rs->productname;?></div>
				<!-- status: con/het hang -->
				<div>
					<?php
					if($rs->tinhtrang == 1){
					?>
						Còn hàng
					<?php
					} else {
					?>
						Hết hàng						
					<?php
					}
					?>
				</div>
				<!-- barcode -->
				<div>ID #: <?=$rs->barcode;?></div>
				<!-- gia/size/mausac -->
				<div>
					<div>
						<span>Giá: </span>
						<span><?=$rs->giaban;?> ₫</span>
						<span><?=$rs->giathitruong;?> ₫</span>
					</div>
					<!-- size/mausac: se duoc dua vao other info -->
					<div>
						<div></div>
						<div></div>
					</div>
				</div>
				<!-- other info -->
				<div><?=$rs->baiviet?></div>
			</div>
		</div>
		<div>
			<!-- thong tin sp - title -->
			<div>Thông tin sản phẩm</div>
			<!-- thong tin sp - content -->
			<div><?=$rs->thongsokythuat;?></div>
		</div>
		<div>
			<!-- sp huu dung -->
			<!-- sp da xem -->
            <?=$this->load->view("templates/default/html/otherblocks");?>
		</div>
	</div>

	<div class="col-2">
	     <div>
	       <?=$this->load->view("templates/default/html/box_top");?>
	    </div>
	    <div>
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
<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#click_baohang").click(function(){
            if(typeof(baohanh_id) != 'undefined'){
                get_address(baohanh_id); 
            }
        });
        $("#page_comment").val(1);
        $("#page_end").val(0);
       
    });
   
</script>

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