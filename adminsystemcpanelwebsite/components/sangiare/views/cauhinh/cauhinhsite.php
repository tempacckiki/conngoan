<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<table class="form">
    <tr>
        <td class="label" style="width: 200px;">Tên website - vi</td>
        <td><input class="w500" type="text" name="site_name_vi" value="<?php echo(isset($site_name_vi))?$site_name_vi:''?>"></td>
    </tr>
    <tr>
        <td class="label" style="width: 200px;">Tên website - en</td>
        <td><input class="w500" type="text" name="site_name_en" value="<?php echo(isset($site_name_en))?$site_name_en:''?>"></td>
    </tr>
    <tr>
        <td class="label">Đóng website</td>
        <td>
            <input type="radio" name="site_close" value="0" <?=(isset($site_close))?($site_close == 0)?'checked="checked"':'':'';?>> Không
            <input type="radio" name="site_close" value="1" <?=(isset($site_close))?($site_close == 1)?'checked="checked"':'':'';?>> Có
        </td>
    </tr>
    <tr>
        <td class="label">Thông báo đóng website - vi</td>
        <td>
            <textarea style="width: 500px;height: 50px;" name="site_message_close_vi"><?php echo(isset($site_message_close_vi))?$site_message_close_vi:''?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Thông báo đóng website - en</td>
        <td>
            <textarea style="width: 500px;height: 50px;" name="site_message_close_en"><?php echo(isset($site_message_close_en))?$site_message_close_en:''?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Miêu tả - vi</td>
        <td>
            <textarea style="width: 500px;height: 50px;" name="site_des_vi"><?php echo(isset($site_des_vi))?$site_des_vi:''?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Miêu tả - en</td>
        <td>
            <textarea style="width: 500px;height: 50px;" name="site_des_en"><?php echo(isset($site_des_en))?$site_des_en:''?></textarea>
        </td>
    </tr> 
    <tr>
        <td class="label">Từ khóa - vi</td>
        <td>
            <textarea style="width: 500px;height: 50px;" name="site_keyword_vi"><?php echo(isset($site_keyword_vi))?$site_keyword_vi:''?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Từ khóa - en</td>
        <td>
            <textarea style="width: 500px;height: 50px;" name="site_keyword_en"><?php echo(isset($site_keyword_en))?$site_keyword_en:''?></textarea>
        </td>
    </tr>
</table>
<?php echo form_close();?>
