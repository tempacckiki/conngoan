<div class="ads-main-news-left">
		<!-- Quang cao-->
		<?php 
		$idNews  			= end(explode('-', $this->uri->segment('3')));		
		$total_advLeft 		= $this->config->item('advdetail_total_'.$idNews);
		if($total_advLeft > 0){ 
			$k = 0;
			for($i = 1; $i <= $total_advLeft; $i++){
				$name   		= $this->config->item('advdetail_name_'.$idNews.'_'.$i);
				$discription   	= $this->config->item('advdetail_summary_'.$idNews.'_'.$i);
				$price   		=  $this->config->item('advdetail_price_'.$idNews.'_'.$i);
				 
				$link   		= $this->config->item('advdetail_link_'.$idNews.'_'.$i);
				$img  			= base_url().'alobuy0862779988/adv/detailnews/'.$this->config->item('advdetail_img_'.$idNews.'_'.$i);

		?>
		
		<div class="item-ads-left<?php echo $k;?>">
			<p class="name"><a href="<?php echo $link;?>" target="_blank" title="<?php echo $name;?>"><?php echo $name;?></a></p>
		    	<p class="img">
				    <a href="<?php echo $link;?>" target="_blank" title="<?php echo $name;?>">
				        <img width="130" src="<?php echo $img;?>" alt="<?php echo $name;?>">
				    </a>
			    </p>
			    <div class="info">				
					<p class="summary"><?php echo $discription;?></p>
					<p class="price">Giá: <span><?php echo $price;?> đ</span></p>
				</div>
		 </div>
		
		<?php 
			$k= 1-$k;	
			}
		}
		?>
		
	<!-- End QUang cao-->
</div>