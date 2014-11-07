<?=form_open(uri_string(), array('id' => 'admindata'))?>
<input type="hidden" name="catid" value="<?=$rs->catid?>">
<input type="hidden" name="page" value="<?=$this->uri->segment(5)?>">
<table class="form">
    <tr>
        <td class="label">Tên chuyên mục</td>
        <td><input type="text" class="w500" name="catname" value="<?=$rs->catname?>"></td>
        <td rowspan="6">
            Nhà sản xuất
            <table class="admindata">
                <thead>
                    <tr>
                        <th style="width: 20px;"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
                        <th>Tên nhà sản xuât</th>
                    </tr>
                </thead>
            </table>
            <div style="height: 211px;overflow: auto;">
            <table class="admindata">
                <?
                $k=1;
                foreach($listnxs as $val):?>
                <tr class="row<?=$k?>">
                    <td style="width: 20px;"><input  type="checkbox" name="ar_id[]" <?=($this->shop->get_manufacture_by_id($rs->catid,$val->manufactureid))?'checked="checked"':'';?> value="<?=$val->manufactureid?>"></td>
                    <td><?=$val->name?></td>
                </tr>
                <?
                $k=1-$k;
                endforeach;?>
            </table>
            </div>
        </td>        
    </tr>
    <tr>
        <td class="label">Chuyên mục chính</td>
        <td>
            <select name="cat[parentid]" class="w200">
                <option value="0">Là chuyên mục chính</option>
                <?foreach($listcat as $cat):?>
                <option value="<?=$cat->catid?>" <?=($cat->catid == $rs->parentid)?'selected="selected"':''?>><?=$cat->catname?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="cat[ordering]" value="<?=$rs->ordering?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Từ khóa</td>
        <td><input type="text" name="cat[catkeyword]" class="w500" value="<?=$rs->catkeyword?>"></td>
    </tr>
    <tr>
        <td class="label">Miêu tả</td>
        <td>
            <textarea style="width: 500px;height: 100px;" name="cat[catdes]"><?=$rs->catdes?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this,'img_main')">
                <?if($rs->img_main!=''){?>
                   <img src="<?=base_url_site().'data/shop/cat/118_98/'.$rs->img_thumb?>" alt="">     
                <?}else{?>
                    <img src="<?=base_url()?>templates/images/no_img.jpg" alt="">   
                <?}?>
            </div>
            <input type="hidden" name="img_main" id="img_main" value="<?=$rs->img_main?>" class="w350">     
        </td>
    </tr>    
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="cat[published]" value="1" <?=($rs->published==1)?'checked="checked"':'';?>></td>
    </tr>
</table>
<?=form_close();?>
<script type="text/javascript">

function openKCFinder(div) {
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