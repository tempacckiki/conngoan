<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Tên</td>
        <td><input type="text" name="name" value="<?=$popup_name?>" class="w300"></td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div class="hinhanh">
                <img height="100" src="<?=base_url_site()?>data/adv/popupfooter/<?=$popup_img?>" alt="">
            </div>
            <input type="file" name="userleft">
            <input type="hidden" name="anh" value="<?=$popup_img?>">
        </td>
    </tr>
    <tr>
        <td class="label">Link</td>
        <td>
            <input type="text" class="w300" name="link" value="<?=$popup_link?>">
        </td>
    </tr>
   
    <tr>
        <td class="label">Kích hoạt</td>
        <td>
            <input type="checkbox" name="active" value="1" <?=($popup_active == 1)?'checked="checked"':''?>> 
        </td>
    </tr>
   
</table>
<?=form_close();?>
