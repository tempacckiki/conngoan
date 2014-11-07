<?=form_open(uri_string(),array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Tên liên hệ - vi</td>
        <td><input type="text" class="w500" name="contact[name]" value="<?=$rs->name?>"></td>
    </tr>
    <tr>
        <td class="label">Tên liên hệ - en</td>
        <td><input type="text" class="w500" name="contact_en[name]" value="<?=$rs_en->name?>"></td>
    </tr>
    <tr>
        <td class="label">Địa chỉ - vi</td>
        <td>
            <input type="text" class="w300" name="contact[address]" value="<?=$rs->address?>">
            <div>Ví dụ: phường 25, Bình Thạnh, TPHCM, Việt Nam</div>
        </td>
    </tr>
    <tr>
        <td class="label">Địa chỉ - en</td>
        <td>
            <input type="text" class="w300" name="contact_en[address]" value="<?=$rs_en->address?>">
        </td>
    </tr>
    <tr>
        <td class="label">Điện thoại</td>
        <td><input type="text" name="contact[phone]" class="w300" value="<?=$rs->phone?>"></td>
    </tr>
    <tr>
        <td class="label">Fax</td>
        <td><input type="text" name="contact[fax]" class="w300" value="<?=$rs->fax?>"></td>
    </tr>
    <tr>
        <td class="label">Email</td>
        <td><input type="text" name="contact[email]" class="w300" value="<?=$rs->email?>"></td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
                        <td>
                            <div id="image" class="img_news" onclick="openKCFinder(this)">
                            <?if($rs->img != ''){?>
                            <img src="<?=base_url_site().$rs->img?>" alt="">    
                            <?}else{?>
                            <img src="<?=base_url()?>templates/images/no-img.png" alt="">
                            <?}?>
                            </div>
                            <input type="hidden" name="contact[img]" id="news_img" value="<?=$rs->img?>">
                        </td>
    </tr>    

</table>
<?=form_close();?>
