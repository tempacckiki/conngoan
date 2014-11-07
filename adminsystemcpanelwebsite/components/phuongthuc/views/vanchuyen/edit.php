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
    <!--<li title="phivanchuyen"><a href="javascript:void(0)">Phí vận chuyển</a></li>-->
</ul>
<?=form_open(uri_string(), array('id' => 'admindata'))?>
<div id="thongtin" class="content" style="display: block;">
<input type="hidden" name="shipping_id" id="shipping_id" value="<?=$rs_vi->shipping_id?>">
<table class="form">   
    <tr>
        <td class="label">Phương thức</td>
        <td>
             <input type="text" name="pay_vi[shipping_name]" value="<?=$rs_vi->shipping_name?>" class="w350">
        </td>
    </tr>

    <tr>
        <td class="label">Miễn phí vận chuyển</td>
        <td>
             <input type="checkbox" name="pay_vi[shipping_free]" value="1" <?=($rs_vi->shipping_free == 1)?'checked="checked"':''?>>
        </td>
    </tr>
    <!--  
    <tr>
        <td class="label">Chọn phương thức thanh toán</td>
        <td>
            <?foreach($payment as $val):
            $check = $this->vanchuyen->check_payment($rs_vi->shipping_id, $val->payment_id);
            ?>
             <div>
                <input <?=($check)?'checked="checked"':'';?> type="checkbox" name="ar_pay[]" value="<?=$val->payment_id?>"> <?=$val->payment_name?>
             </div>
            <?endforeach;?>
        </td>
    </tr>
    -->
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="ordering" value="<?=$rs_vi->ordering?>"></td>
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
				$img	= (!empty($rs_vi->shipping_img))? base_url_site().'alobuy0862779988/payment/shipping/'.$rs_vi->shipping_img:base_url_site().'technogory/templates/default/images/no_image.gif';
				?>
				<img src="<?=$img?>" width="85"><br>
				<input type="hidden" value="<?=$rs_vi->shipping_img;?>" name="img"> 
			</div>
		</td>
    </tr>
    <tr>
        <td class="label">Giới thiệu</td>
        <td>
            <?=vnit_editor_basic($rs_vi->shipping_intro,'pay_vi[shipping_intro]','intro_vi',false)?>
        </td>
    </tr>

</table>
</div>
<div id="chitiet" class="content">
<table class="form">
    <tr>
        <td class="label">Nội dung - vi</td>
        <td>
            <?=vnit_editor($rs_vi->shipping_des,'pay_vi[shipping_des]','full',false)?>
        </td>
    </tr>
    
</table>
</div>
<div id="phivanchuyen" class="content">
    <table class="admindata" id="admindata">
        <thead>
            <th style="width: 150px;">Giá đơn hàng</th>
            <th style="width: 100px;">Phí vận chuyển</th>
            <th style="width: 100px;">Kiểu</th>
            <th align="right"><a href="javascript:;" rel="<?=$rs_vi->shipping_id?>" id="addrate"><img src="<?=base_url()?>templates/icon/add.png" align="right"></a></th>
        </thead>
        <tbody>
        <?foreach($listrate as $val):?>
        <tr class="row1" id="rate_<?=$val->rate_id?>">
        <?if($val->rate_default == 1){?>
            <td>Lớn hơn 0</td>
            <td><input type="text" id="rate_cost_<?=$val->rate_id?>" value="<?=$val->rate_price?>" style="width: 100px;"></td>
            <td>
                <select id="rate_price_type_<?=$val->rate_id?>">
                    <option value="1" <?=($val->rate_price_type == '1')?'selected="selected"':''?>> VNĐ</option>
                    <option value="2" <?=($val->rate_price_type == '2')?'selected="selected"':''?>> %</option>
                </select>
            </td>
            <td style="padding-right: 21px;"><a href="" title="Lưu"><img src="<?=base_url()?>templates/icon/save.png" align="right"></a>   </td>
        <?}else{?>
            <td>Lớn hơn <input type="text" id="rate_cost_<?=$val->rate_id?>" value="<?=$val->rate_cost?>" style="width: 70px;"></td>
            <td><input type="text" id="rate_price_<?=$val->rate_id?>" value="<?=$val->rate_price?>" style="width: 100px;"></td>
            <td>
                <select id="rate_price_type_<?=$val->rate_id?>">
                    <option value="1" <?=($val->rate_price_type == '1')?'selected="selected"':''?>> VNĐ</option>
                    <option value="2" <?=($val->rate_price_type == '2')?'selected="selected"':''?>> %</option>
                </select>
            </td>
            <td align="right">
                <a href="javascript:;" title="Xóa" onclick="del_rate(<?=$val->rate_id?>)"><img src="<?=base_url()?>templates/icon/del.png" align="right"></a> 
                <a href="javascript:;" onclick="save_rate(<?=$val->rate_id?>)" title="Lưu"><img src="<?=base_url()?>templates/icon/save.png" align="right"></a>
            </td>
        <?}?>
        </tr>
        <?endforeach;?>
        </tbody>
    </table>
</div>
<?=form_close();?>

<script type="text/javascript">
$(function(){
	$('#swfupload-control').swfupload({
		upload_url: "<?php echo site_url('phuongthuc/vanchuyen/uploader');?>",
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
			var imgPath = '<?=base_url_site();?>alobuy0862779988/payment/shipping/'+serverData;	
					
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