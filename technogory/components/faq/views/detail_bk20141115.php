<?php 
	$imgPath   		= base_url().'technogory/templates/default/images/';
?>
<!-- left -->
<div id="left-faq">
    
    <div class="faq-content">
    	<?=$rs->content?>
    </div>
</div>

<div id="right-faq">
	<div class="box-cam-ket-faq">
		<p class="title">Chúng tôi cam kết</p>
		<div>
			<ul>
				<li class="payment">Trả tiền khi nhận hàng</li>
				<li class="shipping">Giao hàng toàn quốc</li>
				<li class="modifier">Đảm bảo hàng hóa Đổi trả, hoàn </li>
			</ul>
		</div>
	</div>
	<div>
		<a href="<?=site_url('huong-dan/huong-dan-mua-hang-online-23.html');?>"><img src="<?=$imgPath;?>support-detail.jpg"></a>
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