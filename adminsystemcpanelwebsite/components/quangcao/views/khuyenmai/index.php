<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Khuyến mãi 1</td>
        <td> 
            <input type="text" class="w300" name="name1" value="<?=$khm1->name?>">
        </td>
    </tr>
    <tr>
        <td class="label">Link 1</td>
        <td>
            <input type="text" class="w300" name="link1" value="<?=$khm1->link?>">
        </td>
    </tr>
    <tr>
        <td class="label">Hình ảnh 1</td>
        <td>
            <input type="file" name="userfile1">
            <br>Kích thước: W: 390px; H: 80px;
            <input type="hidden" name="images1" value="<?=$khm1->images?>">
        </td>
    </tr>
    <tr>
        <td class="label">Khuyến mãi 2</td>
        <td> 
            <input type="text" class="w300" name="name2" value="<?=$khm2->name?>">
        </td>
    </tr>
    <tr>
        <td class="label">Link 1</td>
        <td>
            <input type="text" class="w300" name="link2" value="<?=$khm2->link?>">
        </td>
    </tr>
    <tr>
        <td class="label">Hình ảnh 2</td>
        <td>
            <input type="file" name="userfile2">
             <br>Kích thước: W: 390px; H: 80px;
            <input type="hidden" name="images2" value="<?=$khm2->images?>">
        </td>
    </tr> 
    <tr>
        <td class="label">Kích hoạt</td>
        <td>
            <input type="checkbox" name="published" value="1" <?=($khm1->published == 1)?'checked="checked"':''?>> 
        </td>
    </tr>
</table>
<?=form_close();?>
