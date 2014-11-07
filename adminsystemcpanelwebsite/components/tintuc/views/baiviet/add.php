<script type="text/javascript" src="<?php echo base_url()?>templates/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/jquery.swfupload.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/js/swfupload/upload.css?v=2.0" media="screen" />


<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="id" value="0">
<div class="gray">
    <table class="table_">
        <tr>
            <td valign="top">
                <table class="form">
                    <tr>
                        <td class="label">Tiêu đề</td>
                        <td><input type="text" name="con[title]" value="<?php echo set_value('con[title]')?>" class="w400"></td>
                        
                    </tr>
                    <tr>
                        <td class="label">Chủ đề</td>
                        <td>
                            <select name="catid">
                                <?foreach($listcat as $val):
                                $listsub = $this->vdb->find_by_list('news_cat',array('parentid'=>$val->catid));
                                ?>
                                <option value="<?=$val->catid?>"><?=$val->catname?></option>
                                    <?php foreach($listsub as $val1):?>
                                        <option value="<?php echo $val1->catid?>">|__<?=$val1->catname?></option>
                                    <?php endforeach;?>
                                <?endforeach;?>
                            </select>

                        </td>
                    </tr>
                    <tr>
                        <td class="label">Hiển thị</td>
                        <td>
                            <input type="radio" name="con[published]" value="0" <?php echo (set_value('con[published]') == 0)?'checked="checked"':'';?>> Không 
                            <input type="radio" name="con[published]" value="1" <?php echo (set_value('con[published]') == 1)?'checked="checked"':'checked="checked"';?>>Có                        
                        </td>
                    </tr>                    
                    <tr>
                        <td class="label">Tùy chọn</td>
                        <td>
                            <input type="checkbox" name="hot" value="1"> Nổi bật
                            <input type="checkbox" name="is_thumb" value="1"> Hiện thumb
                        </td>
                    </tr>
                    
                    <tr>
				        <td class="label">Hình ảnh</td>
				        <td>
							<div id="swfupload-control">
								<p>Kiểu hình uploads:(jpg, png, gif), dung lượng tối đa: 1MB - KT: W:1000px - H: 280px</p>
										<input type="button" id="button" />
										<p id="queuestatus" ></p>
										<ol id="log"></ol>
							</div>
							<!-- hien thi hình -->
							<div class="upload-img" id="imgBody">
								<?php
								$img	= base_url_site().'site/templates/fyi/images/no_image.gif';
								?>
								<img src="<?=$img?>" width="85"><br>
								<input type="hidden" value="" name="img"> 
							</div>
						</td>
				    </tr>
                    <tr>
                        <td colspan="4">Nội dung ngắn</td>
                    </tr>
                    <tr>
                        <td colspan="4"><textarea cols="" rows="" style="width:99%; height: 100px;" name="con[introtext]"></textarea></td>
                    </tr>     
                    
                    <tr>
                        <td colspan="4">Nội dung</td>
                    </tr>
                    <tr>
                        <td colspan="4"><?=vnit_editor(set_value('content'),'content','full')?></td>                    
                    </tr>
                </table>
            </td>
            <td style="width: 300px;" valign="top">
                <div class="content-right">
                    <table>
                        <tr>
                            <td class="label">Trạng thái</td>
                            <td>Đã được bật</td>
                        </tr>
                        <tr>
                            <td>Lần xem</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Đã tạo</td>
                            <td>Thứ 5, 15 Tháng 9 2011 07:44 </td>
                        </tr>
                        <tr>
                            <td>Đã được sửa</td>
                            <td>Chưa được chỉnh sửa </td>
                        </tr>
                    </table>
                </div>
                <div class="panel">
                    <h3 id="info" class="title vpanel_arrow_down"><span>Các thông số - bài viết</span></h3>
                    <div class="panel_content" id="info_content" style="display: block;">
                        <table>
                            <tr>
                                <td class="_key">Phần mở đầu</td>
                                <td class="_value">
                                    <select name="attr[show_intro]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Tên tác giả</td>
                                <td class="_value">
                                    <select name="attr[show_author]">
                                        <option value="1">Hiện</option>
                                        <option value="0" selected="selected">Ẩn</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Ngày và giờ tạo</td>
                                <td class="_value">
                                    <select name="attr[show_date]">
                                        <option value="1">Hiện</option>
                                        <option value="0" selected="selected">Ẩn</option>
                                    </select>
                                </td>
                            </tr>   
                            <tr>
                                <td class="_key">Ngày và giờ sửa</td>
                                <td class="_value">
                                    <select name="attr[show_editdate]">
                                        <option value="1">Hiện</option>
                                        <option value="0" selected="selected">Ẩn</option>
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td class="_key">Biểu tượng In</td>
                                <td class="_value">
                                    <select name="attr[show_print]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr> 
                            <tr>
                                <td class="_key">Biểu tượng email</td>
                                <td class="_value">
                                    <select name="attr[show_email]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr>                                                                                                                                 <tr>
                                <td class="_key">Bình luận</td>
                                <td class="_value">
                                    <select name="attr[show_comment]">
                                        <option value="1">Hiện</option>
                                        <option value="0">Ẩn</option>
                                    </select>
                                </td>
                            </tr>                                      
                        </table>
                    </div>
                </div>
                <div class="panel">
                    <h3 id="meta" class="title vpanel_arrow" ><span>Thông tin Metadata</span></h3>
                    <div class="panel_content" id="meta_content">
                        <table>
                            <tr>
                                <td class="_key">Miêu tả</td>
                                <td class="_value">
                                    <textarea rows="5" cols="30" name="con[metadesc]"></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td class="_key">Từ khóa</td>
                                <td class="_value">
                                    <textarea rows="5" cols="30" name="con[metakey]"></textarea>
                                </td>
                            </tr>
                                      
                        </table>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</div>

<script type="text/javascript">
$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "<?php echo site_url('tintuc/uploader');?>",
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
			var imgPath = '<?=base_url_site();?>alobuy0862779988/news/full_images/'+serverData;	
					
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