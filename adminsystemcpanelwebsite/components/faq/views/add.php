<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="user_id" value="0">
<table class="form">   
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input type="text" class="w200" name="title" value="<?php echo set_value('title')?>"></td>
    </tr>
     <tr>
        <td class="label">Nội dung</td>
        <td><?=vnit_editor(set_value('content'),'content','full',false)?></td>                    
    </tr>

</table>
<?php echo form_close();?>
