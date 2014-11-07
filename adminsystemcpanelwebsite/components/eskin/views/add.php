<?php echo form_open(uri_string(), array('id'=>'admindata'));?>
<table class="form">   

    <tr>
        <td class="label">Code</td>
        <td><input type="text" class="w200" name="e[slug]" value="<?php echo set_value('e[slug]')?>"></td>
    </tr>
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input type="text" class="w500" name="e[subject]" value="<?php echo set_value('e[subject]')?>"></td>
    </tr>
    <tr>
        <td class="label">Nội dung</td>
        <td>
            <?=vnit_editor(set_value('e[content]'),'e[content]','full',FALSE)?>        
        </td>
    </tr>  

 </table>
<?php echo form_close();?>
