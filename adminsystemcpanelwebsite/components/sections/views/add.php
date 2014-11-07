<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="sections_id" value="0">
<table class="form">
    <tr>
        <td class="label">Nhóm tin</td>
        <td><input type="text" name="sections[sections_title]" value="<?php echo set_value('sections[sections_title]')?>"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="radio" name="sections[published]" value="0" <?php echo (set_value('sections[published]') == 0)?'checked="checked"':'';?>> Không <input type="radio" name="sections[published]" value="1" <?php echo (set_value('sections[published]') == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>

    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="sections[ordering]" value="<?=set_value('sections[ordering]')?>"></td>
    </tr>
</table>
<?php echo form_close();?>
