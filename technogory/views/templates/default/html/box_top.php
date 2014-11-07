<div id="box-head-wapper">
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
    <!-- BEGIN NOTE -->    
    <div class="note-right">
			<div class="sub-note">
				<div class="content">
					<ul class="items">
						<li>Hàng hóa đúng mô tả</li>
						<li>Thái độ phục vụ tân tình</li>
						<li>Cam kết giao hàng đúng hẹn</li>
					</ul>
				</div>
			</div>
			
			<div class="kep"></div>
	</div>
	<!-- END NOTE -->    
		
</div>
    <script type="text/javascript">
       $('#topnew_slideshow').cycle({ 
        fx:     'fade',        
        speed: 1000, 
        pause:   1,
        speed:   300,
        timeout: 5000,
        next:   '#next2', 
        prev:   '#prev2' 
    });
    </script>