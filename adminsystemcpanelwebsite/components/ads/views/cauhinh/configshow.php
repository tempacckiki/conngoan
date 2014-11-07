<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<table class="form">
    
    <tr>
        <td class="label">Hiển thị theo dạng:</td>
        <td>
            <input type="radio" name="view-banner" value="flash" <?=(isset($site_close))?($site_close == 'flash')?'checked="checked"':'':'';?>> Flash 
            <input type="radio" name="view-banner" value="photo" <?=(isset($site_close))?($site_close == 'photo')?'checked="checked"':'':'';?>> Hình ảnh
        </td>
    </tr>
   
</table>
<?php echo form_close();?>
