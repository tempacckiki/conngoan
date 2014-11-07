<?php 
$imgPath   = base_url().'technogory/templates/default/images/';
?>
<div class="box-content-wapper">
<div class="box-adv-news-head">
	<?php 
	$this->load->config("config_adsHorizontal");
	$linkAdsHoriZ    = $this->config->item("link-banner");
	$imgAdsHoriZ    = base_url().'alobuy0862779988/ads/full_images/'.$this->config->item("view-banner");
	?>
	<a href="<?=$linkAdsHoriZ;?>" target="_blank"><img src="<?=$imgAdsHoriZ;?>" width="1000" alt="alobuy.vn"></a>
	
	
</div>
<div class="news-content">

 <?if(count($list_noibat) > 0){?>
    <div class="noibat">
    	<div class="sub-noi-bac">
    	<div class="box-left">
	        <div class="top">
	            <a href="<?=site_url('tin-tuc/'.$list_noibat[0]->caturl.'/'.$list_noibat[0]->title_alias.'-'.$list_noibat[0]->newsid)?>" title="<?=$list_noibat[0]->title?>">
	            <img src="<?=$imgPath;?>placeholder.gif" data-original="<?=base_url_static().$list_noibat[0]->images_330;?>"  alt="">
	            </a>
	            <div class="title">
	                <a href="<?=site_url('tin-tuc/'.$list_noibat[0]->caturl.'/'.$list_noibat[0]->title_alias.'-'.$list_noibat[0]->newsid)?>" title="<?=$list_noibat[0]->title?>" class="link">
	                <?=$list_noibat[0]->title?>
	                </a>
	                <a href="<?=site_url('tin-tuc/'.$list_noibat[0]->caturl.'/'.$list_noibat[0]->title_alias.'-'.$list_noibat[0]->newsid)?>" title="<?=$list_noibat[0]->title?>">
	                <div><?=vnit_cut_string($list_noibat[0]->introtext,200)?></div>
	                </a>
	            </div>
	            
	          
	        </div>
        	
        	 <?
        	 	$str0  = '';
        	 	$str  = '';
        	 	for($i = 1; $i < count($list_noibat); $i++){
        	 	if($i == 1){
                	$val0 	   = $list_noibat[$i];
                	
                	$title0    = $val0->title;
                	$imgThumb0 = (!empty($val0->images_thumb))? base_url_static().$val0->images_thumb: base_url().'data/no_image.jpg';
                	$summay0   = vnit_cut_string($val0->introtext,220);                	
                	$link0    	= site_url('tin-tuc/'.$val0->caturl.'/'.$val0->title_alias.'-'.$val0->newsid);
                	
                	$str0  .= '<div class="item-1">';
                	$str0  .= '<p class="img"><a href="'.$link0.'"><img src="'.$imgPath.'placeholder.gif" data-original="'.$imgThumb0.'" width="150" alt="'.$title0.'"></a></p>';
                	$str0  .= '<div class="info-item1">';
                	$str0  .= '<p class="name"><a href="'.$link0.'">'.$title0.'</a></p>';
                	$str0  .= '<div class="info">
			           				'.$summay0.'
			           			</div>';
                	$str0  .= '</div>';
                	$str0  .= '</div>';
                	
                	echo $str0;
        	 	}else{
        	 		$val 	   = $list_noibat[$i];
        	 		$link1    	= site_url('tin-tuc/'.$val->caturl.'/'.$val->title_alias.'-'.$val->newsid);
        	 		$title1    	= $val->title;
                	$imgThumb1 	= (!empty($val->images_thumb))? base_url_static().$val->images_thumb: base_url().'data/no_image.jpg';
                	$summay1   	= vnit_cut_string($val->introtext,200);
                	
        	 		$str .='<li>';
        	 		$str .='<div class="img">';
        	 		$str .=' <a href="'.$link1.'"> <img src="'.$imgPath.'placeholder.gif" data-original="'.$imgThumb1.'"  alt="'.$title1.'" width="80"></a>';                        
        	 		$str .='</div>';
        	 		$str .='<a href="'.$link1.'">'.$title1.'</a>';
        	 		$str .='</li>';
        	 		
        	 		
        	 	}
        	 }
            ?>
        	 
	           		
	           		
	           		
	           			
	         
        </div>
        
        <div class="list-noibat">
        	
            <ul class="lb">
           	<?php echo $str;?>
           
            </ul>                                         
        </div>
        
        </div>
        
        
    </div>
    <?}?>
    
    <?php 
    if(sizeof($list_noibatNext)>0){
    ?>
    <div class="box-index-hot">
    	<div class="title">
        	<div class="text"><a href="#">Bài ảnh và video</a></div>
        	<span>&nbsp;</span>
        </div>
    	<ul class="item-hot">
    		<?php 
    		foreach ($list_noibatNext as $valNext):
    			$linkDetail  	= site_url('tin-tuc/'.$valNext->caturl.'/'.$valNext->title_alias.'-'.$valNext->newsid);
    			$nameTitle   	= $valNext->title;
    			$imgThumbNext 	= (!empty($valNext->images_thumb))? base_url_static().$valNext->images_thumb: base_url().'data/no_image.jpg';
    		?>
    		<li>	
    			<p class="img"><a href="<?=$linkDetail;?>"><img src="<?=$imgPath;?>placeholder.gif" data-original="<?=$imgThumbNext;?>"  width="150" alt="<?=$nameTitle;?>"></a></p>
    			<p class="name"><a href="<?=$linkDetail;?>"><?=$nameTitle;?></a></p>
    		</li>
    		
    		<?php endforeach;?>
    		
    	</ul>
    
    
    </div>
    
    <?php }?>
    
    
    
    <?
    //$catStt  = 1;
    foreach($listcat as $val):
    	$listproduct = $this->news->get_list_product($val->productcat);
    	$listsub = $this->news->get_all_cat($val->catid);
    	$lastnews = $this->news->get_lastnew_by_cat($val->catid);
    	
    ?>
    <div class="h-new-top">
        <h2><a href="<?=site_url('tin-tuc/'.$val->caturl.'-'.$val->catid)?>"><?=$val->catname?></a>
        <?if(count($listsub) > 0){?>
        <ul>
                <?foreach($listsub as $val1):?>
                <li><a href="<?=site_url('tin-tuc/'.$val1->caturl.'-'.$val1->catid)?>"><?=$val1->catname?></a></li>
                <?endforeach;?>
            </ul>
        <?}?>
        </h2>
    </div>
    
    <?php 
    if(($val->catid == 45) || ($val->catid == 91) || ($val->catid == 97) || ($val->catid == 128) || ($val->catid == 175)){
    ?>
    <div class="h-new-mid">
    	<div class="box-thumb-item0">
    		<p class="img-thumb">
    			<a href="<?=site_url('tin-tuc/'.$lastnews[0]->caturl.'/'.$lastnews[0]->title_alias.'-'.$lastnews[0]->newsid)?>"><img src="<?=$imgPath;?>placeholder.gif" data-original="<?=base_url_static().$lastnews[0]->images_330;?>"  width="328" alt="<?=$lastnews[0]->title?>"></a>
    		</p>
    		<p class="name"><a href="<?=site_url('tin-tuc/'.$lastnews[0]->caturl.'/'.$lastnews[0]->title_alias.'-'.$lastnews[0]->newsid)?>"><?=$lastnews[0]->title?></a></p>
    	</div>
    	
    	<div class="item-col-list">
    		<?if(count($lastnews)> 2){
    		 	for($i = 1; $i <count($lastnews); $i++){
	                $rs = $lastnews[$i];
	                if($i== 1 || $i== 2){
	             ?>
	             <div class="item-col">
	    			<a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"><img src="<?=$imgPath;?>placeholder.gif" data-original="<?=base_url_static().$rs->images_thumb?>"  width="150" alt="<?=$rs->title?>"></a>
	    			
	    			<p class="name-col"><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"><?=$rs->title?></a></p>
    			</div>
    		
	             <?php }else{?>
	            	<p class="item-relative-thumb"><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"><?=$rs->title?></a></p>
	            <?php 
	             } 
	            }
	            ?>
	            
    		
    		<?php }?>
    	</div>
    </div>
    
    <?php }else if(($val->catid == 206) || ($val->catid == 111) || ($val->catid == 141 || ($val->catid == 79) || ($val->catid == 199) )){    
    	?>
    <div class="h-new-mid-1">
        <div class="colnews">
        <?if(count($lastnews) > 0){?>
        <div class="topnews">
            <div class="img">
              <a href="<?=site_url('tin-tuc/'.$lastnews[0]->caturl.'/'.$lastnews[0]->title_alias.'-'.$lastnews[0]->newsid)?>">
               <img src="<?=$imgPath;?>placeholder.gif" data-original="<?=base_url_static().$lastnews[0]->images_thumb?>"  width="130" alt="<?=$lastnews[0]->title?>">
              </a>
            </div>
            <div class="introtext">
            <div class="title"><a href="<?=site_url('tin-tuc/'.$lastnews[0]->caturl.'/'.$lastnews[0]->title_alias.'-'.$lastnews[0]->newsid)?>"><?=$lastnews[0]->title?></a></div>
            <?=vnit_cut_string($lastnews[0]->introtext,200)?>                     
            </div>
        </div>
       
        
        <?}?>
        </div>
        
        <div class="box-items-right">
        	 <?if(count($lastnews)> 2){?>
        	
        	 
        	
	        <ul class="top-lastnew">
	            <?for($i = 1; $i <count($lastnews); $i++){
	                $rs = $lastnews[$i];
	                if($i== 1){
	             ?>
			             <li class="item0">
			             	<p class="img"><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"> <img src="<?=$imgPath;?>placeholder.gif" data-original="<?=$rs->images_thumb?>"  width="80" alt="<?=$rs->title?>"></a></p>
			             	<div class="info">
			             		<p class="name"><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"><?=$rs->title?></a></p>
			             	</div>
			             	
			             </li>
	             <?php }else{?>
	            		<li><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"><?=$rs->title?></a></li>
	            <?php 
	             } 
	            }
	            ?>
				
	            
	            
	           
	            
	        </ul>
        
        	<?}?>
        </div>
    </div>
    
    
    
     <div class="h-new-mid">
     	<ul class="thumb-col-index">
     		<?php 
     		$lastnewsthumb  =  $this->news->get_lastnew_by_catThumb($val->catid);
     		for($j = 0; $j <count($lastnewsthumb); $j++){
     			 $rsThumb  = $lastnewsthumb[$j];
     		?>
     		<li>
     			<p class="index-thumb-img">
     				<a href="<?=site_url('tin-tuc/'.$rsThumb->caturl.'/'.$rsThumb->title_alias.'-'.$rsThumb->newsid)?>"><img src="<?=$imgPath;?>placeholder.gif" data-original="<?=base_url_static().$rsThumb->images_thumb?>" width="100" alt="<?=$rsThumb->title?>"></a>
     			</p>
     			<p class="name-thumb-in"><a href="<?=site_url('tin-tuc/'.$rsThumb->caturl.'/'.$rsThumb->title_alias.'-'.$rsThumb->newsid)?>"><?=vnit_cut_string($rsThumb->title, 50);?></a></p>
     		</li>
     		<?php }?>
     	</ul>
     </div>
    
    <?php }else{?>
    <div class="h-new-mid">
        <div class="colnews">
        <?if(count($lastnews) > 0){?>
        <div class="topnews">
            <div class="img">
              <a href="<?=site_url('tin-tuc/'.$lastnews[0]->caturl.'/'.$lastnews[0]->title_alias.'-'.$lastnews[0]->newsid)?>">
               <img src="<?=$imgPath;?>placeholder.gif" data-original="<?=base_url_static().$lastnews[0]->images_thumb?>"  width="130" alt="<?=$lastnews[0]->title?>">
              </a>
            </div>
            <div class="introtext">
            <div class="title"><a href="<?=site_url('tin-tuc/'.$lastnews[0]->caturl.'/'.$lastnews[0]->title_alias.'-'.$lastnews[0]->newsid)?>"><?=$lastnews[0]->title?></a></div>
            <?=vnit_cut_string($lastnews[0]->introtext,200)?>                     
            </div>
        </div>
       
        
        <?}?>
        </div>
        
        <div class="box-items-right">
        	 <?if(count($lastnews)> 1){?>
        	        	
        	
	        <ul class="top-lastnew">
	            <?for($i = 1; $i <count($lastnews); $i++){
	                $rs = $lastnews[$i];
	                if($i== 1){
	             ?>
			             <li class="item0">
			             	<p class="img"><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"> <img src="<?=$imgPath;?>placeholder.gif" data-original="<?=$rs->images_thumb?>" width="80" alt="<?=$rs->title?>"></a></p>
			             	<div class="info">
			             		<p class="name"><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"><?=$rs->title?></a></p>
			             	</div>
			             	
			             </li>
	             <?php }else{?>
	            		<li><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>"><?=$rs->title?></a></li>
	            <?php 
	             } 
	            }
	            ?>
				
	            
	            
	           
	            
	        </ul>
        
        	<?}?>
        </div>
    </div>
    <?php }?>
    <?
   // $catStt++;
    endforeach;?>

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



</div>