<link rel="stylesheet" type="text/css" href="<?=base_url();?>technogory/templates/default/css/my.css">
<script type="text/javascript" src="<?=base_url();?>technogory/templates/default/js/slideshow.js" charset="UTF-8"></script> 
<div class="box-photo"> 
<?
 $listPhoto = $this->news->get_listPhoto();   
 if(count($listPhoto)>0){
?>


	<div id="wrapper">
		<div class="title">
			<p class="text">Ảnh đẹp</p>
			<span class="text">&nbsp;</span>
		</div>
         <a href="javascript:;" class="next1" id="next2"></a>
         <a href="javascript:;" class="pre" id="prev2"></a>
         <div id="topnew_slideshow">
         	<?php 
         	$sttPhoto  = 1;
         	foreach ($listPhoto as $valPhoto){
         	?>
            <div id="topnew_slideshow_<?=$sttPhoto;?>" class="topnew_slideshow">
                <div class="img">
                   <a href="<?=site_url('tin-tuc/'.$valPhoto->caturl.'/'.$valPhoto->title_alias.'-'.$valPhoto->newsid)?>" title="<?=$valPhoto->title?>"><img src="<?=base_url().$valPhoto->images_330;?>" alt="<?=$valPhoto->title?>" width="290"></a>
                </div>
                <h3><a href="<?=site_url('tin-tuc/'.$valPhoto->caturl.'/'.$valPhoto->title_alias.'-'.$valPhoto->newsid)?>" title="<?=$valPhoto->title?>"><?=$valPhoto->title?></a></h3>
                
            </div> 
            <?php 
            $sttPhoto++;
         	}
            ?>
            
            
         </div>
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
    
    <?php }?>
</div>

