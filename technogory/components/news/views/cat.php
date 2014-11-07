<div class="box-adv-news-head">
	<a href="http://deal247.net" target="_blank"><img src="<?=base_url()?>technogory/templates/default/images/top-banner.jpg" width="1000" alt=""></a>
</div>


    
    
<div class="news-content">  
	<?if(count($list_noibat) >0){?>
    <div class="noibat">
    	<div class="box-left">
	        <div class="top">
	            <a href="<?=site_url('tin-tuc/'.$list_noibat[0]->caturl.'/'.$list_noibat[0]->title_alias.'-'.$list_noibat[0]->newsid)?>" title="<?=$list_noibat[0]->title?>">
	            <img src="<?=base_url_static().$list_noibat[0]->images_330;?>" alt="">
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
                	$str0  .= '<p class="img"><a href="'.$link0.'"><img src="'.$imgThumb0.'" width="150" alt="'.$title0.'"></a></p>';
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
        	 		$str .=' <a href="'.$link1.'"> <img src="'.$imgThumb1.'" alt="'.$title1.'" width="80"></a>';                        
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
    <?}?>
	

 
    <div id="conten_cat">
        <?foreach($list as $rs):?>
        <div class="list-news">
            <div class="img">
                <a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>" title="<?=$rs->title?>"><img alt="<?=$rs->title?>" src="<?=base_url_static().$rs->images_thumb?>"></a>
            </div>
            <div class="title"><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>" title="<?=$rs->title?>"><?=$rs->title?></a></div>
            <div class="date">Ngày đăng: <?=date('H:i d/m/Y',$rs->created)?> - Lượt xem: <?=$rs->hits?></div>
            <div><?=$rs->introtext?></div>
        </div>
        <?endforeach;?>
        <div class="pages"><?=$pagination?></div>
    </div>
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
<script type="text/javascript">
function news_page(page_no){  
    //load_show();   
    $.post(site_url+"news/catpage/<?=$catinfo->catid?>",{'page_no':page_no},function(data){
        $("#conten_cat").html(data);                                            
        //load_hide();
    });
}
</script>

