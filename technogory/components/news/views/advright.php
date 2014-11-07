<div class="ads-news-r">
    	<div class="title">Deal mua nhiều nhất</div>
    	<?php 
    	$listAdsRight    = $this->vdb->find_by_list("ads1",array('type'=>'R'), array('ordering'=>'ASC'));
    	?>
    	<ul class="items">
    		<?php 
    		$k =1;
    		foreach ($listAdsRight as $valAds):
    			$name  	 	= $valAds->name;
    			$summary  	= $valAds->summary;
    			$linAds  	= $valAds->url;
    			$img   	 	= base_url().'data/ads/300/'.$valAds->image;
    			$price  	= number_format($valAds->price,0,'.','.');
    			$priceOld  	= number_format($valAds->price_old,0,'.','.') ;
    			
    		?>
    		<li class="row<?=$k;?>">
    			<div class="sub-adv">
    			<p class="name"><a href="<?=$linAds;?>"><?=$name;?></a></p>
    			<p class="img"> 
    				<a href="<?=$linAds;?>" target="_blank"><img src="<?=$img;?>" width="115" alt="<?=$name;?>"></a>    
    			</p>	
    			<div class="info-adv">
    				<div class="summary">
    					<?=$summary;?> 
    				</div>
    				<p class="price">
    					Giá bán: <span><?=$price;?> đ</span>
    				</p>
    				<p class="price-old">
    					Giá bán: <span><?=$priceOld;?> đ</span>
    				</p>
    			</div>	
    			
    			</div>	
    		</li>
    		
    		
    		<?php 
    		$k = 1-$k;
    		endforeach;
    		?>
    	</ul>
    </div>