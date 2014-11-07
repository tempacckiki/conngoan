<script type="text/javascript" src="<?php echo base_url()?>templates/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/jquery.swfupload.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/js/swfupload/upload.css?v=2.0" media="screen" />

<?php echo form_open(uri_string(), array('id'=>'admindata'));
$rand = rand(5,1000);
?>
<input type="hidden" name="cat_id" value="0">
<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input class="w250" type="text" name="video[video_title]" value="<?php echo set_value('video[video_title]')?>"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="radio" name="video[published]" value="0" <?php echo (set_value('video[published]') == 0)?'checked="checked"':'';?>> Không <input type="radio" name="video[published]" value="1" <?php echo (set_value('video[published]') == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>
     <tr>
		<td class="label">Hình ảnh</td>
		<td>
			<div id="swfupload-control">
								<p>Kiểu hình uploads:(jpg, png, gif), dung lượng tối đa: 1MB  - KT: W:500px - H: 400px</p>
										<input type="button" id="button" />
										<p id="queuestatus" ></p>
										<ol id="log"></ol>
							</div>
							<!-- hien thi hình -->
							<div class="upload-img" id="imgBody">
								<?php
								
								$img		= base_url_site().'technogory/templates/default/images/no_image.gif';
								
								?>
								<img src="<?=$img?>" width="85"><br>
								<input type="hidden" value="" name="img"> 
			</div>
		</td>
	</tr>
	
    
    <tr>
        <td class="label">Link video</td>
        <td>
            <div>
                <input type="radio" name="tuychon" onclick="change_video('file')" <?php echo set_radio('tuychon', 'file', TRUE); ?> value="file">File
                <input type="radio" name="tuychon" onclick="change_video('url')"  <?php echo set_radio('tuychon', 'url'); ?> value="url">Url
            </div>
            <?$tuychon = set_value('tuychon');?>
            <div id="file" <?php echo ($tuychon=='file')?'style="display: block;"':'style="display: block;"'?>>
                <div style="cursor: pointer;padding: 10px 0px;" id="image" onclick="openfile(this)">
                    <b>Click để chọn video</b>
                </div>
                <div id="mediaspace<?php echo $rand?>"></div> 
                <input type="hidden" name="video_link" id="link_video" value="<?=set_value('video_link')?>">  
            </div>
            <div id="url" <?php echo ($tuychon=='url')?'style="display: block;"':'style="display: none;"'?>>
                <input type="text" name="video_url" class="w300" value="<?=set_value('video_url')?>">    
            </div>
        </td>
    </tr>
</table>
<?php echo form_close();?>

<script type="text/javascript">
$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "<?php echo site_url('videoclip/uploader');?>",
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
				var swfu = $.swfupload.getInstance('#swfupload-control');
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
			var imgPath = '<?=base_url_site();?>alobuy0862779988/videoclip/full_images/'+serverData;	
					
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


<script type='text/javascript'>
<?php 
$flashplayer = base_url().'templates/video/player.swf';
$skin = base_url().'templates/video/dangdang.swf';
$file = base_url_site().'data/media/demo.flv';
$skin ='';
$image = '';
$width = '242';
$height = '200';
$flashvideo ='  var so = new SWFObject(\''.$flashplayer.'\',\'mpl\',\''.$width.'\',\''.$height.'\',\'9\');
          so.addParam(\'allowfullscreen\',\'true\');
          so.addParam(\'allowscriptaccess\',\'always\');
          so.addParam(\'wmode\',\'opaque\');
          so.addVariable(\'controlbar.position\',\'over\');
          so.addVariable(\'stretching\',\'fill\');
          so.addVariable(\'autostart\',\'false\');
          so.addVariable(\'repeat\',\'always\');
          so.addVariable(\'file\',\''.$file.'\');
          so.addVariable(\'image\',\''.$image.'\');
          so.addVariable(\'skin\',\''.$skin.'\');
          var vnit = null;
          function playerReady(thePlayer) {
             vnit = window.document[\'mpl\'];
           }';
        echo $flashvideo;    
    ?>
</script>

<script type="text/javascript">
    function change_video(tuychon){
        if(tuychon == 'file'){
            $("#file").slideDown();
            $("#url").slideUp();
        }else{
            $("#file").slideUp();
            $("#url").slideDown();            
        }
    }
    
// Openr Images
function openfile(div) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
                base_url_str = base_url.replace('http://'+document.domain,'');
                base_url_str = base_url_str.replace('admin/','');
                $("#link_video").val(url.replace(base_url_str,''));
                playvideo(base_url_site + url.replace(base_url_str,''));

        }
    };
    window.open(base_url+'templates/ckeditor/kcfinder/browse.php?type=media','kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +'directories=0, resizable=1, scrollbars=0, width=800, height=600');
}  
function playvideo(filename){   
    vnit.sendEvent('STOP');
    vnit.sendEvent('LOAD', filename);
    vnit.sendEvent('VOLUME', 50);
    vnit.sendEvent('PLAY');      
}     
</script>
<script type="text/javascript">
    so.write('mediaspace<?php echo $rand?>');
</script>

