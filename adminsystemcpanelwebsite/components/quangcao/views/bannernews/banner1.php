<script type="text/javascript" src="<?php echo base_url()?>templates/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/jquery.swfupload.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/js/swfupload/upload.css?v=2.0" media="screen" />


<form accept-charset="utf-8" method="post" action="<?php echo base_url()?>quangcao/banner_news/banner1">
	<table class="form">
	    <tr>
	        <td class="label">Link</td>
	        <td>
	            <input type="text" class="w300" name="link" value="<?php 
	            		if(isset($aBannerAds)){
	            			echo $aBannerAds->link;
	            		}
	            	?>">
	        </td>
	    </tr>
	    <tr>
	        <td class="label">Hình ảnh</td>
	        <td>
				<div id="swfupload-control1">
					<p>Kiểu hình uploads:(jpg, png, gif), dung lượng tối đa: 1MB</p>
							<input type="button" id="button" />
							<p id="queuestatus" ></p>
							<ol id="log"></ol>
				</div>
				<!-- hien thi hình -->
				<?php if(isset($aBannerAds)) { ?>
					<div class="upload-img" id="imgBody">
						<?php
						$img	= base_url_site().'alobuy0862779988/bannerads/banner1/full_images/' . $aBannerAds->images;
						?>
						<img src="<?=$img?>" width="85"><br>
						<input type="hidden" value="<?=$aBannerAds->images;?>" name="img"> 
					</div>
				<?php } else { ?>
					<div class="upload-img" id="imgBody">
						<?php
						$img	= base_url_site().'technogory/templates/default/images/no_image.gif';
						?>
						<img src="<?=$img?>" width="85"><br>
						<input type="hidden" value="" name="img"> 
					</div>
				<?php } ?>
			</td>
	    </tr>
	    <tr>
	        <td class="label">Hiển thị</td>
	        <td>
	            <input type="checkbox" value="1" 
	            <?php
	        		if(isset($aBannerAds) && $aBannerAds->published){
	        			echo 'checked="checked"';
	        		}
	            ?>
	             name="published">
	        </td>
	    </tr>
	    <tr>
	    	<td></td>
	    	<td><input type="submit" value="Lưu" /></td>
	    </tr>
	</table>
</form>
<script type="text/javascript">
            $(document).ready(function() {
            });
      </script>
            
<script type="text/javascript">
$(function(){
	$('#swfupload-control1').swfupload({
		upload_url: "<?php echo site_url('quangcao/banner_news/uploader_banner1');?>",
		file_post_name: 'uploadfile',
		file_size_limit : "5024",
		file_types : "*.jpg;*.png;*.gif",
		file_types_description : "Image files",
		file_upload_limit : 5,
		flash_url : "<?php echo base_url()?>templates/js/swfupload/swfupload.swf",
		button_image_url : '<?php echo base_url()?>templates/js/swfupload/XPButtonUploadText_61x22.png',
		button_text: "<span class='swfuText'>Chọn ảnh</span>",
		button_text_style: '.swfuText {color:#003399;font-family:verdana; font-size: 12px; text-align: center;margin-top:10px;}',
		button_width : 100,
		button_height : 30,
		button_placeholder : $('#button')[0],
		debug: false
	})
		.bind('fileQueued', function(event, file){
			var listitem='<li id="'+file.id+'" >'+
				'File: <em>'+file.name+'</em> ('+Math.round(file.size/1024)+' KB) <span class="progressvalue" ></span>'+
				'<div class="progressbar" ><div class="progress" ></div></div>'+
				'<p class="status" >Pending</p>'+
				'<span class="cancel" >&nbsp;</span>'+
				'</li>';
			$('#log').append(listitem);
			$('li#'+file.id+' .cancel').bind('click', function(){
				var swfu = $.swfupload.getInstance('#swfupload-control1');
				swfu.cancelUpload(file.id);
				$('li#'+file.id).slideUp('fast');
			});
			// start the upload since it's queued
			$(this).swfupload('startUpload');
		})
		.bind('fileQueueError', function(event, file, errorCode, message){
			alert('Size of the file '+file.name+' is greater than limit');
		})
		.bind('fileDialogComplete', function(event, numFilesSelected, numFilesQueued){
			$('#queuestatus').text('Files Selected: '+numFilesSelected+' / Queued Files: '+numFilesQueued);
		})
		.bind('uploadStart', function(event, file){
			$('#log li#'+file.id).find('p.status').text('Uploading...');
			$('#log li#'+file.id).find('span.progressvalue').text('0%');
			$('#log li#'+file.id).find('span.cancel').hide();
		})
		.bind('uploadProgress', function(event, file, bytesLoaded){
			//Show Progress
			var percentage=Math.round((bytesLoaded/file.size)*100);
			$('#log li#'+file.id).find('div.progress').css('width', percentage+'%');
			$('#log li#'+file.id).find('span.progressvalue').text(percentage+'%');
		})
		.bind('uploadSuccess', function(event, file, serverData){
			var item	= $('#log li#'+file.id);
			var imgPath = '<?=base_url_site();?>alobuy0862779988/bannerads/banner1/full_images/'+serverData;	
					
			$('#imgBody').html('<img width="85" height="85" src="'+imgPath+'" alt="Hình đại diện"/> <br><input type="hidden" name="img" value="'+serverData+'">');

			
			
			item.find('div.progress').css('width', '100%');
			item.find('span.progressvalue').text('100%');
			var pathtofile='<a href= "'+imgPath+'" target="_blank" >view &raquo;</a>';
			item.addClass('success').find('p.status').html('Thành công!!! | '+pathtofile);
		})
		.bind('uploadComplete', function(event, file){
			// upload has completed, try the next one in the queue
			$(this).swfupload('startUpload');
		})
	
});	

</script>
