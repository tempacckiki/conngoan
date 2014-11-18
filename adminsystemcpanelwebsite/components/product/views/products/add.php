<?
$random_img = createRandom(20);
$random_img_ratore = createRandom(20);
?>
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
  $('#file_upload').uploadify({     
    onComplete: function (evt, queueID, fileObj, response, data){
        if(response != null){
            ar_file = response.split("|");
            var html ='<li id="ratore_'+ar_file[0]+'">';
                html += '<img src="'+base_url_site+ar_file[1]+'">';
                html += '<input type="hidden" name="ar_id_ratore[]" value="'+ar_file[0]+'">';
                html +='<div><input type="text" name="img_ratore_'+ar_file[0]+'" style="width: 30px;" class="required" value="'+ar_file[2]+'">' ;
                html +='<a href="javascript:;" onclick="del_ratore_tmpl('+ar_file[0]+')"> Xóa</a>' ;
                html +='</div></li>';
            $("#list_img_rotare").append(html);
        }           
    },

    'uploader'  : base_url+'components/vfile/views/esset/swf/uploadify.swf',
    'script'    : base_url+'vfile/uploader_rotare_tmpl',
    'cancelImg' : base_url+'components/vfile/views/esset/images/cancel.png',
    'buttonImg' : base_url+'components/vfile/views/esset/images/browse_file_upload.gif',
    'removeCompleted' : false,
    'width': 130,
    'queueID'        : 'file_uploadQueue',
    'queueSizeLimit' : 100,
    'scriptAccess'  : 'always',
    'scriptData': { 'productid': '<?=$random_img_ratore;?>'}, 
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
    });/*
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
    });
    */
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
            action: base_url+'product/shop/uploader_templ/<?=$random_img?>',
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
                    //var str = response.split('|');             
                    $('<li></li>').appendTo('#list_img').html('<div align="center"><img  onclick="chosen_tmpl(\''+response+'\')" src="'+base_url_site+'alobuy0862779988/templ/'+response+'" width="80" height="80"><a href="javascript:;" class="del_img_add"> Xóa</a> <input type="hidden" name="ar_img[]" value="'+response+'"></div>').addClass('success');
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
<!--     <li title="tinhnang"><a href="javascript:void(0)">Tính năng nổi bật</a></li>
   
    <li title="thuoctinh"><a href="javascript:void(0)">Thuộc tính</a></li>
 -->    <li title="hinhanh"><a href="javascript:void(0)">Hình ảnh</a></li>
<!--     <li title="hinh360"><a href="javascript:void(0)">Hình ảnh 360</a></li>
    <li title="video"><a href="javascript:void(0)">Video clip</a></li>
 -->
</ul>
<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="random_img" value="<?=$random_img?>">
<input type="hidden" name="random_img_ratore" value="<?=$random_img_ratore?>">
<div class="gray">
    <div id="thongtin" class="content" style="display: block;">
        <table class="form">
            <tr>
                <td class="label">Mã hàng</td>
                <td><input type="text" name="barcode" value="<?=set_value('barcode')?>" class="w200"></td>
            </tr>
            <tr>
                <td class="label">Tên sản phẩm</td>
                <td><input type="text" name="productname" value="<?=set_value('productname')?>" class="w400"></td>
            </tr>
            <!--
            <tr>
                <td class="label">Tên sản phẩm - en</td>
                <td><input type="text" name="productname_en" value="<?=set_value('productname_en')?>" class="w400"></td>
            </tr>
            -->
            <tr>
                <td class="label">Danh mục sản phẩm</td>
                <td>
                    <select name="catid" class="w250" onchange="get_manufacture_add(this.value)">
                        <?foreach($listcat as $cat):
                        $listsub = $this->shop->get_sub_cat($cat->catid);?>
                        <option value="<?=$cat->catid?>" <?=($cat->catid == set_value('catid'))?'selected="selected"':'';?>><?=$cat->catname?></option>
                            <?foreach($listsub as $sub):
                            $listsub1 = $this->shop->get_sub_cat($sub->catid);
                            ?>
                            <option value="<?=$sub->catid?>" <?=($sub->catid == set_value('catid'))?'selected="selected"':'';?>>|___<?=$sub->catname?></option>
                            
                                <?foreach($listsub1 as $val):
                                $listsub2 = $this->shop->get_sub_cat($val->catid);  
                                ?>
                                <option value="<?=$val->catid?>">|___|___<?=$val->catname?></option>
                                    <?foreach($listsub2 as $val1):?>
                                    <option value="<?=$val1->catid?>">|___|___|___<?=$val1->catname?></option>
                                    <?endforeach;?>
                                <?endforeach;?>
                            <?endforeach;?>
                        
                        <?endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
<!--                 <td class="label">Nhà sản xuất</td>
                <td>
                
                    <select name="manufactureid" id="manufacture" class="w250">
                    </select>
                </td>
 -->            </tr>
                <tr>
<!--                     <td class="label">Sản phẩm trả góp</td>
                    <td><input type="checkbox" name="tragop" value="1"></td>
 -->                </tr>
            <tr>
                <td class="label">Tùy chọn</td>
                <td>
                    Hot<input type="checkbox" name="sphot" value="1"> 
<!--                     Mới<input type="checkbox" name="spmoi" value="1"> 
                    Khuyến mãi<input type="checkbox" name="spkhuyenmai" value="1"> 
 -->                    Bán chạy<input type="checkbox" name="spbanchay" value="1"> 
                </td>
            </tr>
            <tr>
<!--                 <td class="label">Mầu sắc</td>
                <td>
                    <ul class="icolor">
                        <?foreach($listcolor as $val):?>
                        <li><input type="checkbox" name="ar_color[]" value="<?=$val->icolor?>">
                        <img src="<?=base_url_site()?>alobuy0862779988/iconcolor/<?=$val->images?>" alt="">
                        <?=$val->color?>
                        </li>
                        <?endforeach;?>
                    </ul>
                </td>
 -->            </tr>

            <tr>
<!--                 <td class="label">Bảo hành</td>
                <td><input type="text" name="baohanh" value="12"> Tháng</td>
 -->            </tr>
			<tr>
<!--                     <td class="label">Mô tả phần giảm giá:</td>
                    <td>
                    	 <textarea style="height: 50px;width: 500px;" name="deal"></textarea>
                    	 
                    </td>
 -->               </tr>
        </table>

            <table class="form">
                <tr>
<!--                     <td class="label">Bộ sản phẩm đi kèm</td>
                    <td>
                        <textarea style="height: 50px;width: 500px;" name="phukien"><?=set_value('phukien')?></textarea>
                    </td>
 -->                </tr>

            </table>
        </div>
        <!-- Tinh nang noi bat --->
        <div id="tinhnang" class="content">
            <div class="show_notice_small">
                Mỗi tính năng được xác định bằng phím Enter xuống dòng
            </div>
            <p><textarea name="tinhnang" style="width: 500px; height: 200px"></textarea></p>
        </div>

        <!-- Thuoc tinh-->
        <div id="thuoctinh" class="content">
            <div class="show_notice_small">
                Vui lòng chọn danh mục. Hệ thống sẽ tự động lấy thuộc tính theo danh mục
            </div>
            <input type="radio" name="show_attr" value="0"> Chọn là hiển thị ngoài site
             <div id="list_type">

             </div>
        </div>
        <!-- Thong so ky thuat-->
        <div id="thongsokythuat" class="content">
            <input type="radio" name="show_attr" value="1" checked="checked"> Chọn là hiển thị ngoài site<br />
            <textarea id="full" name="thongsokythuat"></textarea>
        </div>
           
        <!---hinh anh-->
        <div id="hinhanh" class="content">
            <div class="show_notice_small">
                Tên hình ảnh vui lòng không để Tiếng Việt có dấu
            </div>
            <table class="form">
                <tr>
                    <td class="label">Hình chính</td>
                    <td>
                        <div id="main_img">
                            <img src="<?=base_url_site()?>alobuy0862779988/no_image.gif" alt="">
                        </div>
                        <input type="hidden" id="productimg" value="" name="productimg">
                    </td>
                </tr>
                <tr>
                    <td class="label">Tải hình ảnh</td>
                    <td>
                        <div id="upload_button"><span>Chọn File Upload<span></div>
                        <div id="status_message">Click chọn hình để đưa vào hình chính của sản phẩm</div>   
                        <ul id="list_img">

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

                                </ul>
                        </fieldset>
                    </td>
                    
                </tr>
            
            </table>
                 
        </div>   
        
        <!-- Gia ban-->
        <div id="giaban" class="content">
        <div style="display: none; margin-bottom: 10px;">Chọn Tỉnh, Thành phố: 
            <select name="city_id" id="city_id">

                <?foreach($listcity as $val):?>
                <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                <?endforeach;?>
            </select>
            </div>
            <script type="text/javascript" src="<?=base_url()?>components/product/views/esset/add_product.js" charset="UTF-8"></script>
            <table class="form">
                <tr>
                    <td class="label">Giá sản phẩm</td>
                    <td>
                        <table>
                            <tr>
                                <td align="right">
                                    Giá bán 
                                    <input type="text" class="w100" name="giathitruong" id="giathitruong_miennam" value="0">
                                    VAT <input type="checkbox" name="vat" value="1" checked="checked">
                                </td>

                                <td align="right">
                                    Giá khuyến mãi 
                                    <input type="text" class="w100" name="giaban" id="giaban_miennam" value="0">
                                </td>

                                <td>Giảm giá <input type="text" class="w100" name="giamgia" id="giamgia_miennam" value="0"> = <input type="text" id="per_miennam" name="per_miennam" style="width: 50px;" value="0">%</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
<!--                     <td class="label">Tặng phẩm miền nam</td>
                    <td>
                        <div>
                            <a href="javascript:;" id="add_miennam"><img height="16" width="16" src="<?=base_url()?>templates/icon/them.png"></a>
                            <a href="javascript:;" id="remove_miennam"><img height="16" width="16" src="<?=base_url()?>templates/icon/xoa.png"></a>
                        </div>

                        <div id="tangpham_miennam" style="padding: 5px;">
                            <input type="text" class="w500" name="tangpham_miennam_name[]"> 
                        </div>

                        <div id="ds_tangpham_miennam"></div>
                    </td>
 -->                </tr>
                <tr>
                    <td class="label">Tình trạng</td>
                    <td>
                        <select name="tinhtrang_miennam" onchange="change_tinhtrang_miennam(this.value)">
                            <option value="1">Còn hàng</option>
                            <option value="2">Hết hàng</option>
                            <option value="3">Tùy chọn</option>
                        </select>
                        <div id="tinhtrang_miennam_text" style="display: none;padding: 5px 0px;">
                        <input type="text" name="tinhtrang_miennam_text" value="" class="w300">
                        </div>
                    </td>
                </tr>

            </table>
            <script type="text/javascript">
            /************
            * Tang pham mien nam
            */
            $(function() {
                var i = $('div#tangpham_miennam').size()+ 1;
                $('a#add_miennam').click(function() {
                    $('<div id="tangpham_miennam" style="padding:5px">'+

                    '<input type="text" class="w500" name="tangpham_miennam_name[]">'+
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
        </div>
        
        <!-- Mo ta-->
        <div id="mota" class="content">
            <p><textarea id="full" name="mieuta"></textarea></p>
        </div> 
        <!---Bài viet-->
        <div id="baiviet" class="content">
            <p><textarea id="baiviet_full" name="baiviet"></textarea></p>
        </div>   
        <!-- Video Clip-->
        <div id="video" class="content">
            <textarea id="video_full" name="video"></textarea>
        </div>
         
</div>
<?=form_close()?>
