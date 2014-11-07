<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<table class="form">
    <tr>
        <td class="label">Tên website</td>
        <td><input class="w350" type="text" name="site_name" value="<?php echo(isset($site_name))?$site_name:''?>"></td>
    </tr>
    <tr>
        <td class="label">Đóng website</td>
        <td>
            <input type="radio" name="site_close" value="0" <?=(isset($site_close))?($site_close == 0)?'checked="checked"':'':'';?>> Không
            <input type="radio" name="site_close" value="1" <?=(isset($site_close))?($site_close == 1)?'checked="checked"':'':'';?>> Có
        </td>
    </tr>
    <tr>
        <td class="label">Thông báo đóng website</td>
        <td>
            <textarea style="width: 350px;height: 100px;" name="site_message_close"><?php echo(isset($site_message_close))?$site_message_close:''?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Miêu tả</td>
        <td>
            <textarea style="width: 350px;height: 100px;" name="site_des"><?php echo(isset($site_des))?$site_des:''?></textarea>
        </td>
    </tr> 
    <tr>
        <td class="label">Từ khóa</td>
        <td>
            <textarea style="width: 350px;height: 100px;" name="site_keyword"><?php echo(isset($site_keyword))?$site_keyword:''?></textarea>
        </td>
    </tr>    
</table>
<?php echo form_close();?>
