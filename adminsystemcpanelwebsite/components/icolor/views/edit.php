<?=form_open_multipart(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="id" value="<?=$rs->icolor?>">
<input type="hidden" name="img_old" value="<?=$rs->images?>">
<table class="form"> 
    <tr>
        <td class="label">Tên mầu</td>
        <td><input type="text" name="name" value="<?=$rs->color?>" class="w300"></td>
    </tr> 
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <img src="<?=base_url_site()?>data/iconcolor/<?=$rs->images?>" alt=""> <input type="file" name="userfile">    
        </td>
    </tr>    
</table>
<?=form_close()?>