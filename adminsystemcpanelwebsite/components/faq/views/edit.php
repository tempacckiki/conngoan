<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="id" value="<?=$rs->id?>">

<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input type="text" name="title" value="<?php echo $rs->title?>" class="w200"></td>
    </tr>
     <tr>
        <td class="label">Nội dung</td>
        <td><?=vnit_editor($rs->content,'content','full',false)?></td>                    
    </tr>
</table>

<?php echo form_close();?>

