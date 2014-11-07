<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="sections_id" value="<?=$rs->sections_id?>">
<table class="form">
    <tr>
        <td class="label">Nhóm tin</td>
        <td><input type="text" name="sections[sections_title]" value="<?php echo $rs->sections_title?>"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="radio" name="sections[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không <input type="radio" name="sections[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>

    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="sections[ordering]" value="<?=$rs->ordering?>"></td>
    </tr>
</table>
<?php echo form_close();?>
