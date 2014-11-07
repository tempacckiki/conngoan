<?php echo form_open(uri_string(), array('id'=>'admindata'));

?>
<input type="hidden" name="cat_id" value="0">
<table class="form">
    <tr>
        <td class="label">Tiêu đề - vi</td>
        <td><input type="text" name="cat[cat_title]" value="<?php echo set_value('cat[cat_title]')?>" class="w300"></td>
    </tr>
    <tr>
        <td class="label">Tiêu đề - en</td>
        <td><input type="text" name="cat_en[cat_title]" value="<?php echo set_value('cat_en[cat_title]')?>" class="w300"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="radio" name="cat[published]" value="0" <?php echo (set_value('cat[published]') == 0)?'checked="checked"':'';?>> Không <input type="radio" name="cat[published]" value="1" <?php echo (set_value('cat[published]') == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>
    <tr>
        <td class="label">Chủ đề</td>
        <td>
            <select name="cat[parent_id]" style="padding: 4px;font-size: 11px;" class="w300">
                <option value="0">Chủ đề chính</option>
                <?foreach($list as $val):?>
                <option value="<?php echo $val->cat_id?>"><?php echo $val->cat_title?></option>
                <?=$this->danhmuc->ar_option_cat($val->cat_id)?>
                <?endforeach;?>
                
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="cat[ordering]" value="<?=$this->vdb->find_by_order('category','ordering',array('site'=>2))?>"></td>
    </tr>
</table>
<?php echo form_close();?>