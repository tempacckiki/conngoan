<?=form_open(uri_string(),array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Tên thuộc tính</td>
        <td><input type="text" class="w300" name="attr[type_name]" value="<?=set_value('attr[type_name]')?>"></td>
    </tr>
    <tr>
        <td class="label">Chuyên mục</td>
        <td>
            <select name="attr[parentid]" class="w200">
                <option value="0">Là thuộc tính chính</option>
                <?foreach($listcat as $cat):?>
                <option value="<?=$cat->type_id?>" <?=($cat->type_id == set_value('parentid'))?'selected="selected"':''?>><?=$cat->type_name?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="attr[published]" value="1" <?=(set_value('attr[published]')==1)?'checked="checked"':'';?>></td>
    </tr>
</table>
<?=form_close();?>
