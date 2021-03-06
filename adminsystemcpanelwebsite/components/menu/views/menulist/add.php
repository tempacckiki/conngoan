<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="menu[menutype]" value="<?=$menutype?>">
<input type="hidden" name="id" value="0">
<table class="form">
    <tr>
        <td class="label">Tên menu</td>
        <td><input type="text" name="menu[name]" value="<?php echo set_value('menu[name')?>" class="w300"></td>
    </tr>
    <tr>
        <td class="label">Link</td>
        <td><input type="text" name="menu[link]" value="<?php echo set_value('menu[link')?>" class="w300"></td>
    </tr> 
    <tr>
        <td class="label">Liên kết ngoài</td>
        <td>
            <input type="checkbox" name="menu[target]" value="1">
        </td>
    </tr>
    <tr>
        <td class="label">Danh mục menu</td>
        <td>
            <select name="menu[parent_id]">
                <option value="0">--Là menu gốc--</option>
                <?php foreach($listmenu as $menu):?>
                <option value="<?php echo $menu->id?>"><?php echo $menu->name?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="menu[ordering]" value="<?=set_value('menu[ordering]')?>"></td>
    </tr>

</table>
<?php echo form_close();?>
