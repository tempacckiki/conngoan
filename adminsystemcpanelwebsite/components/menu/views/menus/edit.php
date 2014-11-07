<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="menutype_id" value="<?=$rs->menutype_id?>">
<table class="form">
    <tr>
        <td class="label">Tên menu</td>
        <td><input type="text" name="menu[menutype_title]" value="<?php echo $rs->menutype_title?>" class="w300"></td>
    </tr>

    <tr>
        <td class="label">Miêu tả</td>
        <td><input type="text" name="menu[desc]" value="<?=$rs->desc?>" class="w300"></td>
    </tr>

</table>
<?php echo form_close();?>
