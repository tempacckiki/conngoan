<?=form_open_multipart(uri_string(),array('id'=>'admindata'))?>
<table class="form"> 
    <tr>
        <td class="label">Tên nhà sản xuất</td>
        <td><input type="text" name="nsx[name]" value="<?=set_value('nsx[name]')?>" class="w300"></td>
    </tr> 
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <input type="file" name="userfile">    
        </td>
    </tr>    
</table>
<?=form_close()?>