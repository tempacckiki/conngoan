<?php 
	$listVideo 	  = $this->vdb->find_by_list("video_news", array('published'=>1),array('created'=>'DESC'));
?>
<script language="javascript" src="<?=base_url()?>technogory/templates/default/js/jwplayer.js"></script>
<script type="text/javascript">
function getvideo(id){
	$.post("<?=base_url()?>vnit/ajaxvideo",{'id':id},function(data){							
		$(".sub-box-video").html(data.fileVideo);	
		$(".item-relative").html(data.relativeItems);	
	},'json');									
					
	}	
</script>
<div class="box-video">
	<!-- 
	<div class="title">
			<p class="text">Video clip</p>
			<span class="text">&nbsp;</span>
	</div>
	 -->
	<div class="sub-box-video">
		
		<?php 
		if (sizeof($listVideo)>0){
			$i  = 1;
			$strRelative = '';
			foreach ($listVideo as $valVideo):
				if($i== 1){
					$video_url  = (!empty($valVideo->video_url))?$valVideo->video_url:$valVideo->video_link;
					$videoName  = $valVideo->video_title;
					$imgThumb 	= $valVideo->video_img;
		?>
				
				<div id="video">
					<p class="name-vd"><?=$videoName;?></p>					
					<div id="videoList">
						loadding ....
					</div>
					
					<script type="text/javascript">				
							jwplayer("videoList").setup({
							'flashplayer':"<?=base_url()?>technogory/templates/default/js/player.swf",
							'file':"<?=$video_url;?>",
							'autostart':false,
							'width':300,
							'height':240,
							'controlbar':"bottom",				
							'Smoothing': true,
							'image':"<?=base_url().'alobuy0862779988/videoclip/thumb/'.$imgThumb;?>"
							});
	
									
					</script>
				</div>
				
		
		<?php }else{
			
				$strRelative  .= '<li><a href="javascript:;" onclick="getvideo('.$valVideo->video_id.');">'.$valVideo->video_title.'</a></li>'; 		
			}
			$i++;
			endforeach;
			}	
		?>
		
		
		
	    
	       
		
		
		
	</div> 
	
	 <ul class="item-relative">
	 	<?=$strRelative;?>	             	
	 </ul>
	      
	
	
	
				
</div>

