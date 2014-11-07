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
    
    CKEDITOR.replace('full',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('en_full',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('baiviet_full',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
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
            action: base_url+'sangiare/shop/uploader/<?=$rs->productid?>',
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
                var str = response;
                var last_li = $('ul#list_img li:last').attr('id'); 
                    last_id = (last_li)?parseInt(last_li + 1):0;                
                    $('<li id="'+last_id+'"></li>').appendTo('#list_img').html('<div  align="center"><img  onclick="chosen(\''+str+'\')" src="'+base_url_site+'data/shop/product/500/'+str+'" width="85" height="85"><a href="javascript:;" id="'+str+'" class="delete_button"> Xóa</a><span id="v'+str+'" style="display: none;">'+str+'</span><input type="hidden" name="ar_img[]" value="'+str+'"></div>').addClass('success');
                } else{
                    $('<li></li>').appendTo('#list_img').text(file).addClass('error');
                }
            }
        });
        
    });
</script>
<ul class="tab">
    <li class="select" title="thongtin"><a href="javascript:void(0)">Thông tin</a></li>
    <li title="mota"><a href="javascript:void(0)">Mô tả chi tiết</a></li>
    <!--<li title="baiviet"><a href="javascript:void(0)">Bài viết</a></li>-->
    <li title="thuoctinh"><a href="javascript:void(0)">Thuộc tính</a></li>
    <li title="hinhanh"><a href="javascript:void(0)">Hình ảnh</a></li>
    <!--
    <li title="hinh360"><a href="javascript:void(0)">Hình ảnh 360</a></li>
    <li title="video"><a href="javascript:void(0)">Video clip</a></li>
    <li title="baohanh"><a href="javascript:void(0)">Bảo hành</a></li>-->
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
                    <td class="label">Tên sản phẩm - vi</td>
                    <td><input type="text" name="sp[productname]" value="<?=$rs->productname?>" class="w400"></td>
                </tr>
                <tr>
                    <td class="label">Tên sản phẩm - en</td>
                    <td><input type="text" name="sp_en[productname]" value="<?=$rs_en->productname?>" class="w400"></td>
                </tr>
                <tr>
                    <td class="label">Danh mục sản phẩm</td>
                    <td>
                            <select name="sp[catid]" class="w250" onchange="get_manufacture(this.value)">
                                <?foreach($listcat as $cat):
                                $listsub = $this->shop->get_sub_cat($cat->catid);
                                ?>
                                <option value="<?=$cat->catid?>" <?=($cat->catid == $rs->catid)?'selected="selected"':'';?>><?=$cat->catname?></option>
                                <?foreach($listsub as $sub):?>
                                <option value="<?=$sub->catid?>" <?=($sub->catid == $rs->catid)?'selected="selected"':'';?>>|__<?=$sub->catname?></option>
                                <?endforeach;?>
                                <?endforeach;?>
                            </select>
                    </td>
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
                    <td class="label">Loại hàng</td>
                    <td><input type="text" name=""></td>
                </tr>
                <tr>
                    <td class="label">Bảo hành</td>
                    <td><input type="text" name="sp[baohanh]" value="<?=$rs->baohanh?>"> Tháng</td>
                </tr>
                <tr>
                    <td class="label">Giá bán</td>
                    <td><input type="text" id="giathitruong_miennam" name="sp[giathitruong_miennam]" value="<?=number_format($rs->giathitruong_miennam,0,'.','.')?>"></td>
                </tr>

            </table>

        </div>
        <!-- Mo ta-->
        <div id="mota" class="content">
            <p>Tiếng Việt</p>
            <textarea id="full" name="sp[mieuta]"><?=$rs->mieuta?></textarea>
            <p>Tiếng Anh</p>
            <textarea id="en_full" name="sp_en[mieuta]"><?=$rs_en->mieuta?></textarea>
        </div>  
        <!-- Thuoc tinh-->
        <div id="thuoctinh" class="content">
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
                            <img src="<?=base_url_site()?>data/sangiare/200/<?=$rs->productimg?>" width="85" alt="">
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
                                <li class="success" id="<?=$i?>">
                                    <div align="center">
                                        <img width="85" height="85" src="<?=base_url_site()?>data/sangiare/200/<?=$img->imagepath?>" onclick="chosen('<?=$img->imagepath?>')">
                                        <a class="delete_button" id="<?=$img->imageid?>" href="javascript:;"> Xóa</a>
                                        <input type="hidden" name="ar_img[]" value="<?=$img->imagepath?>">
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
            Xoay hinh 360
                
        </div>  
        <!-- Video Clip-->
        <div id="video" class="content">
            <textarea id="video_full" name="video"><?=$rs->video?></textarea>
        </div>
          
        <!---Bài viet-->
        <div id="baiviet" class="content">
            <textarea id="baiviet_full" name="baiviet"><?=$rs->baiviet?></textarea>
        </div>          
        <!---San pham-->
        <div id="baohanh" class="content">
            bao hanh
        </div>          
</div>
<?=form_close()?>
<script type="text/javascript">
$(function(){
    $("#giathitruong_miennam").priceFormat();
});

/************
* Tang pham mien nam
*/

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
/************
* Tang pham mien bac
*/

$(function() {
    var i = $('div#tangpham_mienbac').size()+ 1;
    $('a#add_mienbac').click(function() {
        $('<div id="tangpham_mienbac" style="padding:5px">'+

        '<input type="text" class="w300" name="tangpham_mienbac_name[]"> Áp dụng từ <input type="text" name="tangphan_mienbac_batdau[]" id="batdau_mienbac'+i+'" class="w100" value="">'+
        ' <a href="javascript:;" onclick="javascript:NewCssCal (\'batdau_mienbac'+i+'\',\'yyyyMMdd\')"><img src="<?=base_url()?>templates/icon/date.png" alt=""></a>'+
        ' Đến <input type="text" name="tangphan_mienbac_ketthuc[]"  id="ketthuc_mienbac'+i+'" class="w100" value="">'+
        ' <a href="javascript:;" onclick="javascript:NewCssCal (\'ketthuc_mienbac'+i+'\',\'yyyyMMdd\')"><img src="<?=base_url()?>templates/icon/date.png" alt=""></a>'+
        '</div>').appendTo('#ds_tangpham_mienbac');
        i++;
    });
    $('a#remove_mienbac').click(function() {
        if(i > 2) {
            $('div#ds_tangpham_mienbac #tangpham_mienbac:last').remove();
            i--;
        }
    });
});
</script>
