<script type="text/javascript" src="<?=base_url()?>templates/js/shop.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?=base_url()?>templates/js/core/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?=base_url()?>templates/js/shop_upload.js?v=2.0" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>templates/css/shop.css?v=2.0" media="screen" />

<!--- Script Upload Flash-->
<link type="text/css" rel="stylesheet" href="<?=base_url()?>components/product/views/esset/file.css?v=2.0" media="screen" />
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/swfobject.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript" >
 $(document).ready(function() {
    get_price(<?=$city_select?>);
    $('#file_upload').uploadify({
    onComplete: function (evt, queueID, fileObj, response, data){
        if(response != null){
            ar_file = response.split("|");
            var html ='<li id="ratore_'+ar_file[0]+'">';
                html += '<img src="'+base_url_site+ar_file[1]+'">';
                html += '<input type="hidden" name="ar_id_ratore[]" value="'+ar_file[0]+'">';
                html +='<div><input type="text" name="img_ratore_'+ar_file[0]+'" style="width: 30px;" class="required" value="'+ar_file[2]+'">' ;
                html +='<a href="javascript:;" onclick="del_ratore('+ar_file[0]+')"> Xóa</a>' ;
                html +='</div></li>';
            $("#list_img_rotare").append(html);
        }   
        
    },

    'uploader'  : base_url+'components/vfile/views/esset/swf/uploadify.swf',
    'script'    : base_url+'vfile/uploader_rotare',
    'cancelImg' : base_url+'components/vfile/views/esset/images/cancel.png',
    'buttonImg' : base_url+'components/vfile/views/esset/images/browse_file_upload.gif',
    'removeCompleted' : false,
    'width': 130,
    'queueID'        : 'file_uploadQueue',
    'queueSizeLimit' : 100,
    'scriptAccess'  : 'always',
    'scriptData': { 'productid': <?=$rs->productid?>}, 
    'fileDesc'  : '*.jpg;*.gif;*.png',
    'fileExt'  : '*.jpg;*.gif;*.png',
    'sizeLimit'  : (204800 * 1024),
    'multi'          : true,
    'auto'      : true
    });
});
</script>


<script type="text/javascript">
$(document).ready(function(){
    $("ul.tab li").click(function () {
        $("ul.tab li.select").removeClass("select");
        $(this).addClass("select");
        $(".content").css('display','none');
        var content_show = $(this).attr("title");
        $("#"+content_show).css('display','block');
    }); 
   
    CKEDITOR.replace('full',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    /* 
    CKEDITOR.replace('full_en',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    */
    CKEDITOR.replace('baiviet_full',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    /*
    CKEDITOR.replace('baiviet_full_en',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });*/
    CKEDITOR.replace('video_full',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    }); 
});
</script>
<script type="text/javascript" >
    $(function(){
        var btnUpload=$('#upload_button');
        var status=$('#status_message');
        new AjaxUpload(btnUpload, {
            action: base_url+'product/shop/uploader/<?=$rs->productid?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif|)$/.test(ext))){ 
                    status.text('File cho phép Upload JPG, PNG, JPEG, GIF');
                    return false;
                }
                status.text('Đang tải File lên. Vui lòng đợi');
            },
            onComplete: function(file, response){ 
                status.text('');
                if(response!="error"){
                    var str = response.split('|');             
                    $('<li id="img_'+str[1]+'"></li>').appendTo('#list_img').html('<div align="center"><img  onclick="chosen(\''+str[0]+'\')" src="'+base_url_site+'alobuy0862779988/0862779988product/80/'+str[0]+'" width="80" height="80"><a href="javascript:;"  onclick="del_img('+str[0]+')"> Xóa</a></div>').addClass('success');
                } else{
                    jAlert('Thêm ảnh không thành công','Thông báo');
                    return false;
                }
            }
        });
        
    });
</script>
<ul class="tab">
    <li class="select" title="thongtin"><a href="javascript:void(0)">Thông tin</a></li>
     <?php    
	  if(($editPrice == 1 && $this->session->userdata('user_id') == $user_idPrice) || $this->session->userdata('group_id') >=17){
	?>
    <li title="giaban"><a href="javascript:void(0)">Giá sản phẩm</a></li>
 	<?php }?>
 	<li title="thongsokythuat"><a href="javascript:void(0)">Thông tin sản phẩm</a></li>
    <li title="baiviet"><a href="javascript:void(0)">Điểm nổi bậc</a></li>
    <li title="tinhnang"><a href="javascript:void(0)">Tính năng nổi bật</a></li> 
    
    <li title="thuoctinh"><a href="javascript:void(0)">Thuộc tính</a></li>
    <li title="hinhanh"><a href="javascript:void(0)">Hình ảnh</a></li>
    <li title="hinh360"><a href="javascript:void(0)">Hình ảnh 360</a></li>
    <li title="video"><a href="javascript:void(0)">Video clip</a></li>
</ul>
<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="productid" id="productid" value="<?=$rs->productid?>">
<div class="gray">
        <div id="thongtin" class="content" style="display: block;">
            <table class="form">
                <tr>
                    <td class="label">Mã hàng</td>
                    <td><input type="text" name="barcode" value="<?=$rs->barcode?>" class="w200"></td>
                </tr>
                <tr>
                    <td class="label">Tên sản phẩm</td>
                    <td><input type="text" name="productname" value="<?=$rs->productname?>" class="w400"></td>
                </tr>
                <tr>
                    <td class="label">Danh mục sản phẩm</td>
                    <td>
                        <select name="catid" class="w250" onchange="get_manufacture_edit(this.value)" style="width: 500px;">
                            <?foreach($listcat as $cat):
                            $listsub = $this->shop->get_sub_cat($cat->catid);
                            ?>
                            <option style="font-size: 17px;color: #FF0000;font-weight: bold" value="<?=$cat->catid?>" <?=($cat->catid == $rs->catid)?'selected="selected"':''?>><?=$cat->catname?></option>
                            <?
                            foreach($listsub as $sub):
                            $listsub1 = $this->shop->get_sub_cat($sub->catid); 
                            ?>
                            <option style="font-size: 14px" value="<?=$sub->catid?>" <?=($sub->catid == $rs->catid)?'selected="selected"':''?>>|___<?=$sub->catname?></option>
                            
                            <?foreach($listsub1 as $val):
                            $listsub2 = $this->shop->get_sub_cat($val->catid); 
                            ?>
                            <option value="<?=$val->catid?>" <?=($val->catid == $rs->catid)?'selected="selected"':''?>>|___|___<?=$val->catname?></option>
                                <?foreach($listsub2 as $val1):
                                
                                ?>
                                <option value="<?=$val1->catid?>" <?=($val1->catid == $rs->catid)?'selected="selected"':''?>>|___|___|___<?=$val1->catname?></option>
                                <?endforeach;?>
                            <?endforeach;?>
                            <?endforeach;?>
                            <?endforeach;?>  
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">Nhà sản xuất</td>
                    <td>
                        <select name="manufactureid" id="manufacture" class="w250">
                            <?foreach($listmanufacture as $val):?>
                            <option value="<?=$val->manufactureid?>" <?=($rs->manufactureid == $val->manufactureid)?'selected="selected"':'';?>><?=$val->name?></option>
                            <?endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">Sản phẩm trả góp</td>
                    <td><input type="checkbox" name="tragop" value="1" <?=($rs->tragop == 1)?'checked="checked"':''?>></td>
                </tr> 
                <tr>
                    <td class="label">Tùy chọn</td>
                    <td>
                        Hot<input type="checkbox" name="sphot" value="1" <?=($rs->sphot == 1)?'checked="checked"':''?>> 
                        Mới<input type="checkbox" name="spmoi" value="1" <?=($rs->spmoi == 1)?'checked="checked"':''?>> 
                        Khuyến mãi<input type="checkbox" name="spkhuyenmai" value="1" <?=($rs->spkhuyenmai == 1)?'checked="checked"':''?>> 
                    </td>
                </tr>
                <tr>
                    <td class="label">Mầu sắc</td>
                    <td>
                        <ul class="icolor">
                            <?foreach($listcolor as $val):
                            $color = $this->vdb->find_by_id('shop_color_product',array('productid'=>$rs->productid,'icolor'=>$val->icolor));
                            $check = ($color)?'checked="checked"':'';
                            ?>
                            <li><input type="checkbox" name="ar_color[]" value="<?=$val->icolor?>" <?=$check?>>
                            <img src="<?=base_url_site()?>data/iconcolor/<?=$val->images?>" alt="">
                            <?=$val->color?>
                            </li>
                            <?endforeach;?>
                        </ul>
                    </td>
                </tr>

                <tr>
                    <td class="label">Bảo hành</td>
                    <td><input type="text" name="baohanh" value="<?=$rs->baohanh?>"> Tháng</td>
                </tr>
                
                <tr>
                    <td class="label">Mô tả phần giảm giá:</td>
                    <td>
                    	 <textarea style="height: 50px;width: 500px;" name="deal"><?=$rs->deal?></textarea>
                    	 
                    </td>
                </tr>
            </table>

            <table class="form">
                <tr>
                    <td class="label">Bộ sản phẩm đi kèm</td>
                    <td>
                        <textarea style="height: 50px;width: 500px;" name="phukien"><?=$rs->phukien?></textarea>
                    </td>
                </tr>
            </table>
        </div>

       
        <!-- Tinh nang noi bat --->
        <div id="tinhnang" class="content">
            <div class="show_notice_small">
            Mỗi tính năng được xác định bằng phím Enter xuống dòng
            </div>
            <p><textarea name="tinhnang" style="width: 500px; height: 200px"><?=$rs->tinhnang?></textarea></p>
        </div>
        <!-- Thuoc tinh-->
        <div id="thuoctinh" class="content">
             <input type="radio" name="show_attr" value="0" <?=($rs->show_attr == 0)?'checked="checked"':''?>> Chọn là hiển thị ngoài site<br />
             <div id="list_type">
                <table class="form">
                <?foreach($list_attr as $val):
                $list_fea  = $this->shop->get_item_features($val->feature_id);
                ?>
                    <tr>
                        <td class="label" colspan="2" style="text-align: left;"><?=$val->description?></td>
                    </tr>
                    <?foreach($list_fea as $val1):
                    $variant = $this->vdb->find_by_id('shop_features_values',array('product_id'=>$rs->productid,'feature_id'=>$val1->feature_id));
                    if($variant){
                        $variant_id = $variant->variant_id;
                        $variant_name = $variant->value;
                    }else{
                        $variant_id = 0;
                        $variant_name = '';
                    }
                    ?>
                    <tr>
                        <td class="label" style="font-weight: 100;"><?=$val1->description?></td>
                        <td>
                            <?=build_fea($val1->feature_id,$val1->feature_type,$variant_id,$variant_name)?>
                        </td>
                    </tr>
                    <?endforeach;?>
                <?endforeach;?>
                </table>
             </div>
        </div>
        <!-- Thong so ky thuat-->
        <div id="thongsokythuat" class="content">
            <input type="radio" name="show_attr" value="1" <?=($rs->show_attr == 1)?'checked="checked"':''?>> Chọn là hiển thị ngoài site<br />
            <textarea id="full" name="thongsokythuat"><?=$rs->thongsokythuat?></textarea>
        </div>
        
        <!---hinh anh-->
        <div id="hinhanh" class="content">
            <table class="form">
                <tr>
                    <td class="label">Hình chính</td>
                    <td>
                        <div id="main_img">
                            <?if($rs->productimg==''){?>
                            <img src="<?=base_url_site()?>alobuy0862779988/no_image.gif" alt="">
                            <?}else{?>
                            <img src="<?=base_url_site()?>alobuy0862779988/0862779988product/80/<?=$rs->productimg?>" style="width: 80px;" alt="">
                            <?}?>
                        </div>
                        <input type="hidden" id="productimg" value="<?=$rs->productimg?>" name="productimg">
                    </td>
                </tr>
                <tr>
                    <td class="label">Tải hình ảnh</td>
                    <td>
                        <div id="upload_button"><span>Chọn File Upload<span></div>
                        <div id="status_message">Click chọn hình để đưa vào hình chính của sản phẩm</div>   
                        <ul id="list_img">
                              <?
                              $i = 0;
                              foreach($list_img as $img):?>
                                <li class="success" id="img_<?=$img->imageid?>">
                                    <div align="center">
                                        <img width="80" height="80" src="<?=base_url_site()?>alobuy0862779988/0862779988product/80/<?=$img->imagepath?>" onclick="chosen('<?=$img->imagepath?>')">
                                        <a onclick="del_img(<?=$img->imageid?>)" href="javascript:;"><b>Xóa</b></a>
                                    </div>
                                </li>
                              <?
                              $i++;
                              endforeach;?>
                        </ul>                                             
                    </td>
                </tr>
            </table>
        </div>
        <!---Xoay hinh 360-->
        <div id="hinh360" class="content">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 250px; padding-right: 10px;">
                        <fieldset>
                            <legend>Upload hình</legend>
                                <div id="block_upload"><input id="file_upload" name="file_upload" type="file" /></div>
                                <div id="file_uploadQueue" class="uploadifyQueue"></div>  
                        </fieldset>
                    </td>
                    <td>
                        <fieldset>
                            <legend>Danh sách hình ảnh</legend>
                                <div class="show_notice_small">Hệ thống sẽ không tự động Resize hình ảnh. Vì thế bạn hãy căn chỉnh các hình theo 1 kích thước nhất định trước khi Upload lên. Kích thức chuẩn 450 x 400 pixcel</div>
                                <ul id="list_img_rotare">
                                    <?foreach($listimgratore as $val):?>
                                    <li id="ratore_<?=$val->id?>">
                                        <img src="<?=base_url_site().$val->imagepath?>" alt="">
                                        <input type="hidden" name="ar_id_ratore[]" value="<?=$val->id?>">
                                        <div><input type="text" name="img_ratore_<?=$val->id?>" value="<?=$val->ordering?>" style="width: 30px;"> <a href="javascript:;" onclick="del_ratore(<?=$val->id?>)">Xóa</a></div>
                                    </li>
                                    <?endforeach;?>
                                </ul>
                        </fieldset>
                    </td>
                    
                </tr>
            
            </table>
                 
        </div>  
        <!-- Video Clip-->
        <div id="video" class="content">
            <textarea id="video_full" name="video"><?=$rs->video?></textarea>
        </div>
          
        <!---Bài viet-->
        <div id="baiviet" class="content">
            <p><textarea id="baiviet_full" name="baiviet"><?=$rs->baiviet?></textarea></p><br />
        </div>
    <?=form_close()?>
    <!-- Giá bán-->
    <div id="giaban" class="content">
    <?=form_open(uri_string(),array('id'=>'adminform_price'))?>
    <input type="hidden" name="productid" value="<?=$rs->productid?>">
        <div style="margin-bottom: 10px;">Chọn Tỉnh, Thành phố: 
        <select name="city_id" id="city_id" onchange="get_price(this.value)">
            <option value="0">Chọn Tỉnh, Thành phố</option>
            <?foreach($listcity as $val):?>
            <option value="<?=$val->city_id?>" <?=($val->city_id == $city_select)?'selected="selected"':'';?>><?=$val->city_name?></option>
            <?endforeach;?>
        </select>
        </div>
        <div id="list_price">

        </div>
        <?=form_close()?>
    </div>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#adminform_price").validate({
            rules: {
                city_id: "required"
            }
            ,submitHandler: function(form) {
                load_show();
                dataString = $("#adminform_price").serialize();
                $.ajax({
                    type: "POST",
                    url: base_url+"product/shop/save_price",
                    data: dataString,
                    dataType: "json",
                    success: function(data) {
                        if(data.error == 0){
                            get_price(data.city_id);
                        }
                        jAlert(data.msg,'Thông báo');
                        load_hide();
                    }
                }); 
            }        
        });    
    });
    </script>
</div>




<script type="text/javascript">

$(function() {
    var i = $('div#tangpham_miennam').size()+ 1;
    $('a#add_miennam').click(function() {
        $('<div id="tangpham_miennam" style="padding:5px">'+

        '<input type="text" class="w300" name="tangpham_miennam_name[]"> Áp dụng từ <input type="text" name="tangpham_miennam_batdau[]" id="batdau'+i+'" class="w100" value="">'+
        ' <a href="javascript:;" onclick="javascript:NewCssCal (\'batdau'+i+'\',\'yyyyMMdd\')"><img src="<?=base_url()?>templates/icon/date.png" alt=""></a>'+
        ' Đến <input type="text" name="tangpham_miennam_ketthuc[]"  id="ketthuc'+i+'" class="w100" value="">'+
        ' <a href="javascript:;" onclick="javascript:NewCssCal (\'ketthuc'+i+'\',\'yyyyMMdd\')"><img src="<?=base_url()?>templates/icon/date.png" alt=""></a>'+
        '</div>').appendTo('#ds_tangpham_miennam');
        i++;
    });
    $('a#remove_miennam').click(function() {
        if(i > 2) {
            $('div#ds_tangpham_miennam #tangpham_miennam:last').remove();
            i--;
        }
    });
});

</script>
