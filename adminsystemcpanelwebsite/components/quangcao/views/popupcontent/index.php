<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div class="hinhanh"></div>
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
    <tr>
        <td class="label">Chiều rộng</td>
        <td>
            <input type="text" class="w300" name="width" value="<?=$popup_width?>">
        </td>
    </tr>
    <tr>
        <td class="label">Chiều cao</td>
        <td>
            <input type="text" class="w300" name="height" value="<?=$popup_height?>">
        </td>
    </tr>
</table>
<?=form_close();?>
