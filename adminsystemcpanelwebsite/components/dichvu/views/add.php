<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="id" value="0">
<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input type="text" name="con[name]" value="<?php echo set_value('con[name]')?>" class="w400"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="radio" name="con[published]" value="0" <?php echo (set_value('con[published]') == 0)?'checked="checked"':'';?>> Không 
            <input type="radio" name="con[published]" value="1" <?php echo (set_value('con[published]') == 1)?'checked="checked"':'checked="checked"';?>>Có                        
        </td>
    </tr>                    
    <tr>
        <td class="label">Sắp sếp</td>
        <td>
            <input type="text" name="con[ordering]" value="">
        </td>
    </tr>

    <tr>
        <td colspan="2">Nội dung</td>
    </tr>
    <tr>
        <td colspan="2"><?=vnit_editor(set_value('content'),'content','full',false)?></td>                    
    </tr>
</table>

