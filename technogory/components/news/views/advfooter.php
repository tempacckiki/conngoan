<div class="ads-footer-bg-detail">
	<div>
		<div class="title-left">Có thể bạn quan tâm ?</div>
	</div>
	<?php 
    	$listAdsFooter    = $this->vdb->find_by_list("ads1",array('type'=>'F'), array('ordering'=>'ASC'));
    ?>
    	
	<ul class="item-ads-f">
		<?php 
    		
    		foreach ($listAdsFooter as $valAds):
    			$name  	 	= $valAds->name;
    			$summary  	= $valAds->summary;
    			$linAds  	= $valAds->url;
    			$img   	 	= base_url().'data/ads/300/'.$valAds->image;
    			
    			$price  	= number_format($valAds->price,0,'.','.');
    			$priceOld  	= number_format($valAds->price_old,0,'.','.') ;
    		?>
    		
		<li>
			<p class="name"><a href="<?=$linAds;?>"><?=$name;?></a></p>
			<p class="img"><a href="<?=$linAds;?>"><img src="<?=$img;?>"  width="90" alt="<?=$name;?>"/></a></p>	
			<div class="summary-info">
				<div class="intro">
					<?=$summary;?>			
				</div>
				<p class="price">Giá bán: <strong><?=$price;?> đ</strong></p>
				<p class="price-old">Giá cũ: <strong><?=$priceOld;?> đ</strong></p>
			</div>			
		</li>
		<?php 
    		
    		endforeach;
    	?>
		
	</ul>
</div>