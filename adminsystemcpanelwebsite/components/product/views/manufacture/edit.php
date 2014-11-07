<?=form_open_multipart(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="id" value="<?=$rs->manufactureid?>">
<table class="form"> 
    <tr>
        <td class="label">Tên nhà sản xuất</td>
        <td><input type="text" name="nsx[name]" value="<?=$rs->name?>" class="w300"></td>
    </tr> 
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div><input type="file" name="userfile"></div>
            <div id="image" class="img_news">
                <?if($rs->images_small !=''){?>
                <img src="<?=base_url_site().'data/img_manufacture/'.$rs->images_small?>" alt="">
                <?}else{?>
                <img src="<?=base_url()?>templates/images/no_img.jpg" alt="">  
                <?}?>
            </div>
            <input type="hidden" name="img_old" value="<?=$rs->images_small?>">
        </td>
    </tr>    
</table>
<?=form_close()?>
