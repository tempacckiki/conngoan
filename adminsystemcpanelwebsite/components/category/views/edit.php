<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="cat_id" value="<?php echo $rs->cat_id?>">
<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input type="text" name="cat[cat_title]" value="<?php echo $rs->cat_title?>"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="radio" name="cat[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không <input type="radio" name="cat[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>
    <tr>
        <td class="label">Chủ đề</td>
        <td>
            <select name="cat[section]">
                <?foreach($list as $val):?>
                <option value="<?php echo $val->sections_id?>" <?php echo ($val->sections_id == $rs->section)?'selected="selected"':'';?>><?php echo $val->sections_title?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="cat[ordering]" value="<?=$rs->ordering?>"></td>
    </tr>
</table>
<?php echo form_close();?>