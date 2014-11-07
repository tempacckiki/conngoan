<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="newsid" value="<?=$rs->id?>">
<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input type="text" name="con[name]" value="<?php echo $rs->name?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="radio" name="con[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không 
            <input type="radio" name="con[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'';?>>Có                        
        </td>
    </tr>                    
    <tr>
        <td class="label">Sắp sếp</td>
        <td>
            <input type="text" name="con[ordering]" value="<?=$rs->ordering?>">
        </td>
    </tr>

    <tr>
        <td colspan="2">Nội dung</td>
    </tr>
    <tr>
        <td colspan="2"><?=vnit_editor($rs->content,'content','full',false)?></td>                    
    </tr>
</table>

<?php echo form_close();?>

