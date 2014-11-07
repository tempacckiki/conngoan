<script type="text/javascript" src="<?php echo base_url()?>templates/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/jquery.swfupload.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/js/swfupload/upload.css?v=2.0" media="screen" />

<?php echo form_open_multipart(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="newsid" value="<?=$rs->id?>">
<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input type="text" name="con[name]" value="<?php echo $rs->name?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Chọn file:</td>
        <td>
			<div id="swfupload-control">
				<p>Kiểu hình uploads:(word, pdf, excel), dung lượng tối đa: 1MB  - KT: W:1000px - H: 280px</p>
						<input type="button" id="button" />
						<p id="queuestatus" ></p>
						<ol id="log"></ol>
			</div>
			<!-- hien thi hình -->
			<div class="upload-img" id="imgBody">
				<?php
				$extDocument   = substr($rs->file, -3, 3);
    			switch( $extDocument )
				{
					case 'pdf':
					{
						$imgDocument		=  base_url_site()."site/templates/fyi/images/pdf.png"; 
						break; 
					}
					case 'pdfx':
					{
						$imgDocument		=  base_url_site()."site/templates/fyi/images/pdf.png"; 
						break; 
					}
					case 'xls':
					{
						$imgDocument 		=  base_url_site()."site/templates/fyi/images/excel.png"; 
						break; 
					}
					case 'xlsx':
					{
						$imgDocument 		=   base_url_site()."site/templates/fyi/images/excel.png"; 
						break; 
					}
					case 'docx':
					{
						$imgDocument 		=   base_url_site()."site/templates/fyi/images/word.png"; 
						break; 
					}
					default:
					{
						$imgDocument 		=   base_url_site()."site/templates/fyi/images/word.png"; 
						break; 
					}
				}
					$img	= (!empty($rs->file))? base_url_site().'data/documents/full_images/'.$rs->file:base_url_site().'site/templates/fyi/images/noimage.png';
				?>
				<img src="<?=$imgDocument;?>" width="90">
				<input type="hidden" value="<?=$rs->file;?>" name="img"> 
			</div>
		</td>
    </tr>
    
    <tr>
        <td class="label">Hình ảnh:</td>
        <td>
           <input type="file" name="file_photo">   KThước: Width:164px - Height: 140px;  
           <input type="hidden" name="img_old" value="<?=$rs->image;?>">   <br>
           <img src="<?=base_url_site().'data/documents/full_images/'.$rs->image;?>">
                      
        </td>
    </tr>   
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="radio" name="con[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không 
            <input type="radio" name="con[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'';?>>Có                        
        </td>
    </tr>                    
    <tr>
        <td class="label">Sắp sếp</td>
        <td>
            <input type="text" name="con[ordering]" value="<?=$rs->ordering?>">
        </td>
    </tr>

  
</table>

<?php echo form_close();?>

<script type="text/javascript">
$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "<?php echo site_url('list_documents/uploader');?>",
		file_post_name: 'uploadfile',
		file_size_limit : "10024",
		file_types : "*.doc;*.pdf;*.xls;*.docx;*.pdfx;*.xlsx",
		file_types_description : "Image files",
		file_upload_limit : 5,
		flash_url : "<?php echo base_url()?>templates/js/swfupload/swfupload.swf",
		button_image_url : '<?php echo base_url()?>templates/js/swfupload/XPButtonUploadText_61x22.png',
		button_text: "<span class='swfuText'>Chọn file</span>",
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
			var imgPath = '<?=base_url_site();?>data/ads/full_images/'+serverData;	
					
			$('#imgBody').html('<span>Upload File là: '+serverData+'</span><input type="hidden" name="img" value="'+serverData+'">');

			
			
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