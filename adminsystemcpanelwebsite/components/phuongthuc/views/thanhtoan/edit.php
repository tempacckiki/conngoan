<script type="text/javascript" src="<?php echo base_url()?>templates/js/swfupload/swfupload.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/jquery.swfupload.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/js/swfupload/upload.css?v=2.0" media="screen" />

<script type="text/javascript">
$(document).ready(function(){
    $("ul.tab li").click(function () {
        $("ul.tab li.select").removeClass("select");
        $(this).addClass("select");
        $(".content").css('display','none');
        var content_show = $(this).attr("title");
        $("#"+content_show).css('display','block');
    });
});
</script>
<ul class="tab">
    <li class="select" title="thongtin"><a href="javascript:void(0)">Thông tin</a></li>
    <li title="chitiet"><a href="javascript:void(0)">Chi tiết</a></li>
</ul>
<?=form_open(uri_string(), array('id' => 'admindata'))?>
<div id="thongtin" class="content" style="display: block;">
<input type="hidden" name="payment_id" value="<?=$rs_vi->payment_id?>">
<table class="form"> 
	<tr>
        <td class="label">Phương thức vận chuyển:</td>
        <td>
            <select name="pay_vi[shipping_id]">
                <option value="">|-Chọn phương thức vận chuyển</option>
                <?foreach($listShipping as $valShip):?>
                <option value="<?=$valShip->shipping_id?>" <?=($rs_vi->shipping_id == $valShip->shipping_id)?'selected="selected"':''?>><?=$valShip->shipping_name?></option>
                <?endforeach;?>
            </select>
        </td>
        
    </tr>  
    <tr>
        <td class="label">Phương thức chính</td>
        <td>
            <select name="pay_vi[parentid]">
                <option value="">Là phương thức chính</option>
                <?foreach($list as $val):?>
                <option value="<?=$val->payment_id?>" <?=($rs_vi->parentid == $val->payment_id)?'selected="selected"':''?>><?=$val->payment_name?></option>
                <?endforeach;?>
            </select>
        </td>
        
    </tr>  
    <tr>
        <td class="label">Phương thức</td>
        <td>
             <input type="text" name="pay_vi[payment_name]" value="<?=$rs_vi->payment_name?>" class="w350">
        </td>
        
    </tr>

    <tr>
        <td class="label">Code</td>
        <td><input type="text" name="pay_vi[payment_code]" value="<?=$rs_vi->payment_code?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">User</td>
        <td><input type="text" name="pay_vi[merchant_id]" value="<?=$rs_vi->merchant_id?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Mật khẩu</td>
        <td colspan="2"><input type="text" name="pay_vi[access_code]" value="<?=$rs_vi->access_code?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Secure Hash</td>
        <td colspan="2"><input type="text" name="pay_vi[secure_hash]" value="<?=$rs_vi->secure_hash?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Url Pay</td>
        <td colspan="2"><input type="text" name="pay_vi[url_pay]" value="<?=$rs_vi->url_pay?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td colspan="2"><input type="text" name="ordering" value="<?=$rs_vi->ordering?>"></td>
    </tr>  
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
			<div id="swfupload-control">
				<p>Kiểu hình uploads:(jpg, png, gif), dung lượng tối đa: 1MB  - KT: W:1000px - H: 280px</p>
						<input type="button" id="button" />
						<p id="queuestatus" ></p>
						<ol id="log"></ol>
			</div>
			<!-- hien thi hình -->
			<div class="upload-img" id="imgBody">
				<?php
				$img	= (!empty($rs_vi->payment_img))? base_url_site().'alobuy0862779988/payment/bank/'.$rs_vi->payment_img:base_url_site().'technogory/templates/default/images/no_image.gif';
				?>
				<img src="<?=$img?>" width="85"><br>
				<input type="hidden" value="<?=$rs_vi->payment_img;?>" name="img"> 
			</div>
		</td>
    </tr>
    
    <tr>
        <td class="label">Giới thiệu</td>
        <td colspan="2">
            <?=vnit_editor_basic($rs_vi->payment_intro,'pay_vi[payment_intro]','intro_vi')?>
        </td>
    </tr>

</table>
</div>
<div id="chitiet" class="content">
<table class="form">
    <tr>
        <td class="label">Nội dung</td>
        <td>
            <?=vnit_editor_basic($rs_vi->payment_des,'pay_vi[payment_des]','full',false)?>
        </td>
    </tr>

</table>
</div>
<?=form_close();?>

<script type="text/javascript">
$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "<?php echo site_url('phuongthuc/thanhtoan/uploader');?>",
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
			var imgPath = '<?=base_url_site();?>alobuy0862779988/payment/bank/'+serverData;	
					
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