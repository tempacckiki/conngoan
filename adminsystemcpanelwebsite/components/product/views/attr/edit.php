<?=form_open(uri_string(),array('id'=>'admindata'));?>
<input type="hidden" name="mainid" value="<?=$this->uri->segment(5)?>">
<input type="hidden" name="id" value="<?=$this->uri->segment(4)?>">
<table class="form">
    <tr>
        <td class="label">Tên thuộc tính</td>
        <td><input type="text" class="w300" name="attr[type_name]" value="<?=$rs->type_name?>"></td>
    </tr>
    <tr>
        <td class="label">Chuyên mục</td>
        <td>
            <select name="attr[parentid]" class="w200">
                <option value="0">Là thuộc tính chính</option>
                <?foreach($listcat as $cat):?>
                <option value="<?=$cat->type_id?>" <?=($cat->type_id == $rs->parentid)?'selected="selected"':''?>><?=$cat->type_name?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="attr[published]" value="1" <?=($rs->published==1)?'checked="checked"':'';?>></td>
    </tr>
</table>
<?=form_close();?>
