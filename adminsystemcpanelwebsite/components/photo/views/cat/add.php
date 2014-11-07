<?=form_open(uri_string(),array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Tên chuyên mục</td>
        <td><input type="text" class="w500" name="catname" value="<?=set_value('catname')?>"></td>
    </tr>
    <tr>
        <td class="label">Ảnh đại diện</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this,'img_main')">
                <?if(set_value('img_main')!=''){?>
                   <img src="<?=base_url_site().set_value('img_main')?>" alt="">     
                <?}else{?>
                    <img src="<?=base_url()?>templates/images/no_img.jpg" alt="">   
                <?}?>
            </div>
            <input type="hidden" name="img_main" id="img_main" value="<?=set_value('img_main')?>" class="w350">     
        </td>
    </tr>    
    <tr>
        <td class="label">Từ khóa</td>
        <td><input type="text" name="keyword" class="w500" value="<?=set_value('keyword')?>"></td>
    </tr>
    <tr>
        <td class="label">Miêu tả</td>
        <td>
            <textarea style="width: 500px;height: 100px;" name="des"><?=set_value('des')?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="ordering" value="<?=set_value('ordering')?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="IsActive" value="1" <?=(set_value('IsActive')==1)?'checked="checked"':'';?>></td>
    </tr>

</table>
<?=form_close();?>
<script type="text/javascript">

function openKCFinder(div,id) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            div.innerHTML = '<div style="margin:5px">Đang tải ảnh...</div>';
            var img = new Image();
            img.src = url;
            img.onload = function() {
                div.innerHTML = '<img id="img" src="' + url + '" />';
                base_url_str = base_url.replace('http://'+document.domain,'');
                base_url_str = base_url_str.replace('admin/','');
                $("#img_main").val(url.replace(base_url_str,''));
                var img = document.getElementById('img');
                var o_w = img.offsetWidth;
                var o_h = img.offsetHeight;
                var f_w = div.offsetWidth;
                var f_h = div.offsetHeight;
                if ((o_w > f_w) || (o_h > f_h)) {
                    if ((f_w / f_h) > (o_w / o_h))
                        f_w = parseInt((o_w * f_h) / o_h);
                    else if ((f_w / f_h) < (o_w / o_h))
                        f_h = parseInt((o_h * f_w) / o_w);
                    //img.style.width = f_w + "px";
                    //img.style.height = f_h + "px";
                } else {
                   // f_w = o_w;
                   // f_h = o_h;
                }
                //img.style.marginLeft = parseInt((div.offsetWidth - f_w) / 2) + 'px';
                //img.style.marginTop = parseInt((div.offsetHeight - f_h) / 2) + 'px';
                img.style.visibility = "visible";
            }
        }
    };
    window.open(base_url+'templates/ckeditor/kcfinder/browse.php?type=images&dir=images/news',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=800, height=600'
    );
}

</script>