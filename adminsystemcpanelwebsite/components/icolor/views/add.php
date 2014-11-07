<?=form_open_multipart(uri_string(),array('id'=>'admindata'))?>
<table class="form"> 
    <tr>
        <td class="label">Tên mầu</td>
        <td><input type="text" name="name" value="<?=set_value('name')?>" class="w300"></td>
    </tr> 
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <input type="file" name="userfile">    
        </td>
    </tr>    
</table>
<?=form_close()?>