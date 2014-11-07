<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<input type="hidden" name="id" value="<?=$rs->id?>">
<table class="form">
    <tr>
        <td class="label">Tên quảng cáo</td>
        <td>
            <input type="text" class="w300" name="name" value="<?=$rs->name?>">
        </td>
        <td rowspan="5">
            <div class="img_news" id="image">
                <?=read_img($rs->images)?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="label">Link</td>
        <td>
            <input type="text" class="w300" name="link" value="<?=$rs->link?>">
        </td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <input type="file" name="userleft">
            <input type="hidden" name="img_old" value="<?=$rs->images?>">
           <br>Kích thước: W: 562px; H: 328px;
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td>
            <input type="text" name="ordering" value="<?=$rs->ordering?>">
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="checkbox" name="published" value="1" <?=($rs->published == 1)?'checked="checked"':''?>>
        </td>
    </tr>
</table>
<?=form_close();?>
