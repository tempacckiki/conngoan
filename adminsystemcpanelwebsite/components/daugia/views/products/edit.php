<script type="text/javascript" src="<?=base_url()?>templates/js/shop.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?=base_url()?>templates/js/core/datetimepicker_css.js"></script>
<script type="text/javascript" src="<?=base_url()?>templates/js/shop_upload.js?v=2.0" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>templates/css/shop.css?v=2.0" media="screen" />
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

//Xoa anh san pham

function del_img(idimg){ 
    $.post(base_url+"daugia/shop/del_img_product",{'idimg':idimg},function(data){
       $("ul#list_img li#img_"+idimg).remove();
    },'json');
}

</script>

<script type="text/javascript" >
    $(function(){
        var btnUpload=$('#upload_button');
        var status=$('#status_message');
        new AjaxUpload(btnUpload, {
          
            action: '<?php echo base_url();?>daugia/shop/uploader_edit/<?=$rs->productid?>',
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
              	           
                  $('<li id="img_'+str[1]+'"></li>').appendTo('#list_img').html('<div align="center"><img  onclick="chosen_tmpl(\''+str[0]+'\')" src="'+base_url_site+'alobuy0862779988/daugia/full_images/'+str[0]+'" width="80" height="80"><a href="javascript:;"  onclick="del_img('+str[1]+')"> Xóa</a></div>').addClass('success');
                	//$('<li></li>').appendTo('#list_img').html('<div align="center"><img  onclick="chosen_tmpl(\''+response+'\')" src="'+base_url_site+'alobuy0862779988/daugia/full_images/'+response+'" width="80" height="80"><a href="javascript:;" class="del_img_add"> Xóa</a> <input type="hidden" name="ar_img[]" value="'+response+'"></div>').addClass('success');
                	//var str = response.split('|');
                	//var last_li = $('ul#list_img li:last').attr('id'); 
                   // last_id = (last_li)?parseInt(last_li + 1):0;                
                   // $('<li id="'+str[1]+'"></li>').appendTo('#list_img').html('<div  align="center"><img  onclick="chosen(\''+str[0]+'\')" src="'+base_url_img+'daugia/200/'+str[0]+'" width="85" height="85"><a href="javascript:;" id="'+str[1]+'" class="delete_button_edit"> Xóa</a><span id="v'+str[0]+'" style="display: none;">'+str[0]+'</span><input type="hidden" name="ar_img[]" value="'+str[0]+'"></div>').addClass('success');
                } else{
                    $('<li></li>').appendTo('#list_img').text(file).addClass('error');
                }
            }
        });
        
    });
</script>
<ul class="tab">
    <li class="select" title="thongtin"><a href="javascript:void(0)">Thông tin</a></li>
    <li title="hinhanh"><a href="javascript:void(0)">Hình ảnh</a></li>
</ul>
<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="productid" value="<?=$rs->productid?>">
<div class="gray">
        <div id="thongtin" class="content" style="display: block;">
            <table class="form">
                <tr>
                    <td class="label">Mã hàng</td>
                    <td><input type="text" name="sp[barcode]" value="<?=$rs->barcode?>" class="w200"></td>
                </tr>
                <tr>
                    <td class="label">Tên sản phẩm:</td>
                    <td><input type="text" name="sp[productname]" value="<?=$rs->productname?>" class="w400"></td>
                </tr>
               
                <tr>
                    <td class="label">Nhà sản xuất</td>
                    <td>
                        <select name="sp[manufactureid]" id="manufacture" class="w250">
                            <?foreach($listmanufacture as $val):?>
                            <option value="<?=$val->manufactureid?>" <?=($rs->manufactureid == $val->manufactureid)?'selected="selected"':'';?>><?=$val->name?></option>
                            <?endforeach;?>
                        </select>
                    </td>
                </tr> 

                <tr>
                    <td class="label">Giá bán</td>
                    <td><input type="text" id="price" name="sp[price]" value="<?=number_format($rs->price,0,'.','.')?>"></td>
                </tr>

            </table>

        </div>

        <!---hinh anh-->
        <div id="hinhanh" class="content">
            <table class="form">
                <tr>
                    <td class="label">Hình chính</td>
                    <td>
                        <div id="main_img">
                            <?if($rs->productimg==''){?>
                            <img src="<?=base_url_site()?>data/no_image.gif" alt="">
                            <?}else{?>
                            <img src="<?=base_url_img()?>alobuy0862779988/daugia/200/<?=$rs->productimg?>" width="85" alt="">
                            <?}?>
                        </div>
                        <input type="hidden" id="productimg" value="<?=$rs->productimg?>" name="sp[productimg]">
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
                              <li class="success" id="img_<?=$img->id;?>">
                                    <div align="center">
                                        <img width="85" height="85" src="<?=base_url_img()?>alobuy0862779988/daugia/200/<?=$img->imagepath?>" onclick="chosen_tmpl('<?=$img->imagepath?>')">
                                       <!-- <a class="delete_button_edit" rel="<?=$i?>" id="<?=$img->imageid?>" href="javascript:;"> Xóa</a> --> 
                                        <a onclick="del_img(<?=$img->id;?>)" href="javascript:;"><b>Xóa</b></a>
                                        <!-- <input type="hidden" name="ar_img[]" value="<?=$img->imagepath?>"> -->
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
</div>
<?=form_close()?>
<script type="text/javascript">
$(function(){
    $("#price").priceFormat();
});
//chosen_tmpl
function chosen_tmpl(img){ 
    if(img){
        $('#productimg').val(img);
        $('#main_img').html('<img src="' + base_url_site +'alobuy0862779988/daugia/200/' + img + '" width="80" height="80" />');
    }
    else{
        return false;
    }
}

</script>
