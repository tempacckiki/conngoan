
<div class="box-adv-news-head">
	<?php 
	$this->load->config("config_adsHorizontal");
	$linkAdsHoriZ    = $this->config->item("link-banner");
	$imgAdsHoriZ    = base_url().'alobuy0862779988/ads/full_images/'.$this->config->item("view-banner");
	?>
	<a href="<?=$linkAdsHoriZ;?>" target="_blank"><img src="<?=$imgAdsHoriZ;?>" width="1000" alt="alobuy.vn"></a>
	
	
</div>

<?php 
if($rs->catid == 172){
?>
<div>
	<h3 class="title-de"><?=$rs->title?></h3>
	<div class="plugin-date">
     	<p class="date">
     	Ngày đăng: <?=date('H:i d/m/Y',$rs->created)?> - Lượt xem: <?=$rs->hits?> (lần)
     	</p>
     	<div class="box-plugin">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			<a class="addthis_button_tweet" tw:related="addthis"></a> 
		</div>
		
		<!-- AddThis Button END -->
	</div> 
        
     </div>
     
      <div class="introtext-de"><?=$rs->introtext?></div>
      
      <div class="fulltext"><?=$rs->fulltext?></div>
       <div class="orther_news"><span>Tin khác..</span></div>
	    <ul class="list_orther">
	            <?foreach($listorther as $val):?>
	            <li><a href="<?=site_url('tin-tuc/'.$val->caturl.'/'.$val->title_alias.'-'.$val->newsid)?>" title="<?=$val->title?>"><?=$val->title?></a></li>
	            <?endforeach;?>
	        </ul>
	        
      
</div>

<?php 
}else{
?>
<div class="news-content">
   
     <h3 class="title-de"><?=$rs->title?></h3>
     <div class="plugin-date">
     	<p class="date">
     	Ngày đăng: <?=date('H:i d/m/Y',$rs->created)?> - Lượt xem: <?=$rs->hits?> (lần)
     	</p>
     	<div class="box-plugin">
		<!-- AddThis Button BEGIN -->
		<div class="addthis_toolbox addthis_default_style ">
			<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
			<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>
			<a class="addthis_button_tweet" tw:related="addthis"></a> 
		</div>
		
		<!-- AddThis Button END -->
	</div> 
     </div>
     <div class="introtext-de"><?=$rs->introtext?></div>
       
    <!--  box relative --> 
     <div class="sub-content-de">
	    <div class="box-relative">
	    	<p class="title">liên quan</p>
	    	<ul class="item-l">
	    		 <?foreach($listorther as $val):?>
	            <li><a href="<?=site_url('tin-tuc/'.$val->caturl.'/'.$val->title_alias.'-'.$val->newsid)?>" title="<?=$val->title?>"><?=$val->title?></a></li>
	            <?endforeach;?>
	    	</ul>
	    	
	    	<?php 
	    	if(count($listViewMax)>0){
	    	?>
	    	<div class="box-viewmax">
	    		<p class="title">Đọc nhiều nhất</p>
	    		<ul class="item-other">
	    		<?
	    			$stt = 1;
	    			$str0  = '';
	    			$strRelative  = '';
	    			foreach($listViewMax as $valMax):
	    			if($stt == 1){
	    				$nameMax0 = $valMax->title;
	    				$link0    = site_url('tin-tuc/'.$valMax->caturl.'/'.$valMax->title_alias.'-'.$valMax->newsid);
	    				$imgThumb0 = (!empty($valMax->images_thumb))? base_url().$valMax->images_thumb: base_url().'data/no_image.jpg';
	    				$str0 .='<li>';
	    				$str0 .='<div class="item0">';
	    				$str0 .='<a href="'.$link0.'"><img src="'.$imgThumb0.'" width="150" alt="'.$nameMax0.'"></a>';
	    				$str0 .='<p class="name"><a href="'.$link0.'">'.$nameMax0.'</a></p>';
	    				$str0 .='</div>';
	    				$str0 .='</li>';
	    				echo $str0;
	    			}else{
	    				$nameMax = $valMax->title;
	    				$link    = site_url('tin-tuc/'.$valMax->caturl.'/'.$valMax->title_alias.'-'.$valMax->newsid);
	    				$strRelative .='<li><a href="'.$link.'">'.$nameMax.'</a></li>';
	    			}
	    		?>
	           
	    			
	    		<?
	    			$stt++;
	    		endforeach;?>
	    		<?=$strRelative;?>
	    		</ul>
	    	</div>
	    	<?php }?>
	    	<!-- Part Ads -->
	    	<?php echo $this->load->view('templates/default/html/ads_newsdetail') ;?>
	    </div>
	    <div class="news_detail">
	        
	        <div class="fulltext"><?=$rs->fulltext?></div>
	        <!-- 
	        <div class="orther_news"><span>Tin khác..</span></div>
	        <ul class="list_orther">
	            <?foreach($listorther as $val):?>
	            <li><a href="<?=site_url('tin-tuc/'.$val->caturl.'/'.$val->title_alias.'-'.$val->newsid)?>" title="<?=$val->title?>"><?=$val->title?></a></li>
	            <?endforeach;?>
	        </ul>
	        
	         -->
	        
	    </div>
	    
	     </div>
	        <?php 
	        if (count($randCat)>0){
	        	foreach ($randCat as $valrandom):        	
	        		$listNewsthumb = $this->news->getNewsThumb($valrandom["catid"],4);
	        ?>
	         <div class="group-cat-de">     	
	        	<div class="title">
	        		<p class="text"><a href="<?=site_url('news/'.$valrandom["caturl"].'-'.$valrandom["catid"]);?>"><?=$valrandom["catname"];?></a></p>
	        	</div>
	        	
	        	<div class="sub-news-de">
	        		<?php 
	        		if(sizeof($listNewsthumb)){
	        		?>
	        		<ul class="items">
	        			<?php 
	        			foreach ($listNewsthumb as $valThumbRe): 
	        				$nameThumb = $valThumbRe->title;
	        				$imgThumb  = base_url().$valThumbRe->images_thumb;
	        			?>
	        			<li>
	        				<p class="img"><a href="<?=site_url('tin-tuc/'.$valThumbRe->caturl.'/'.$valThumbRe->title_alias.'-'.$valThumbRe->newsid);?>"><img src="<?=$imgThumb;?>" width="145" alt="<?=$nameThumb;?>"></a></p>
	        				<p class="name"><a href="<?=site_url('tin-tuc/'.$valThumbRe->caturl.'/'.$valThumbRe->title_alias.'-'.$valThumbRe->newsid);?>"><?=$nameThumb;?></a></p>
	        			</li>
	        			<?php endforeach;?>
	        		</ul>
	        		<?php }?>
	        	</div>
	        </div>
        <?php endforeach;}?>
        
       
</div>
<div class="news-right">
	<?php 
	$this->load->config("config_logo");
	$linkAdsTop    = $this->config->item("link-logo");
	$imgAdsTop    = base_url().'alobuy0862779988/ads/full_images/'.$this->config->item("view-logo");
	?>
	<p class="img-ads"><a href="<?=$linkAdsTop;?>" target="_blank"><img src="<?=$imgAdsTop;?>" width="296" alt="alobuy.vn"></a></p>
    <?=$this->load->view('tindocnhieu');?>
    <?php $this->load->view('videoclip');?>
    <?php $this->load->view('photo');?>
    
     <?if($this->config->item('advDeal_total') > 0){?>
	   <div class="box-quan-tam-news">
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
		        			<p class="img"><a href="<?=$link;?>" title="<?=$name;?>" target="_blank"><img src="<?=$img;?>" alt="<?=$name;?>" width="100"></a></p>
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
	        
   <?php 
	if(file_exists(ROOT.'technogory/config/home/bannerNews.db')){
		include_once (ROOT.'technogory/config/home/bannerNews.db');
	}
	?>
      
</div>

<?php }?>

<script type="text/javascript">var addthis_config = {"data_track_addressbar":false};</script>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js"></script>