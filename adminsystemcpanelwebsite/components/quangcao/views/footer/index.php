<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<fieldset style="width: 500px;">
    <legend>Quản cáo 1</legend>
    <table class="form">
        <tr>
            <td class="label">Quảng cáo</td>
            <td> 
                <input type="text" class="w300" name="name1" value="<?=$f1->name?>">
            </td>
        </tr>
        <tr>
            <td class="label">Link redirect</td>
            <td>
                <input type="text" class="w300" name="link1" value="<?=$f1->link?>">
            </td>
        </tr>
        <tr>
            <td class="label">Link hiển thị</td>
            <td>
                <input type="text" class="w300" name="linkmain1" value="<?=$f1->link_main?>">
            </td>
        </tr>
        <tr>
            <td class="label">Hình ảnh</td>
            <td>
                <input type="file" name="userfile1">
                <input type="hidden" name="images1" value="<?=$f1->images?>">
            </td>
        </tr>
        <tr>
            <td class="label">Giới thiệu</td>
            <td>
                <textarea style="width: 300px; height: 50px;" name="intro1"><?=$f1->intro?></textarea>
            </td>
        </tr>
    </table>
</fieldset>
<fieldset style="width: 500px;">
    <legend>Quản cáo 2</legend>
    <table class="form"> 
        <tr>
            <td class="label">Quảng cáo</td>
            <td> 
                <input type="text" class="w300" name="name2" value="<?=$f2->name?>">
            </td>
        </tr>
        <tr>
            <td class="label">Link redirect</td>
            <td>
                <input type="text" class="w300" name="link2" value="<?=$f2->link?>">
            </td>
        </tr>
        <tr>
            <td class="label">Link hiển thị</td>
            <td>
                <input type="text" class="w300" name="linkmain2" value="<?=$f2->link_main?>">
            </td>
        </tr>
        <tr>
            <td class="label">Hình ảnh</td>
            <td>
                <input type="file" name="userfile2">
                <input type="hidden" name="images2" value="<?=$f2->images?>">
            </td>
        </tr>
        <tr>
            <td class="label">Giới thiệu</td>
            <td>
                <textarea style="width: 300px; height: 50px;" name="intro2"><?=$f2->intro?></textarea>
            </td>
        </tr>
    </table> 
</fieldset>
<fieldset style="width: 500px;">
    <legend>Quản cáo 3</legend>
    <table class="form">
        <tr>
            <td class="label">Tiêu đề</td>
            <td> 
                <input type="text" class="w300" name="name3" value="<?=$f3->name?>">
            </td>
        </tr>
        <tr>
            <td class="label">Link redirect</td>
            <td>
                <input type="text" class="w300" name="link3" value="<?=$f3->link?>">
            </td>
        </tr>
        <tr>
            <td class="label">Link hiển thị</td>
            <td>
                <input type="text" class="w300" name="linkmain3" value="<?=$f3->link_main?>">
            </td>
        </tr>
        <tr>
            <td class="label">Hình ảnh</td>
            <td>
                <input type="file" name="userfile3">
                <input type="hidden" name="images3" value="<?=$f3->images?>">
            </td>
        </tr>
        <tr>
            <td class="label">Giới thiệu</td>
            <td>
                <textarea style="width: 300px; height: 50px;" name="intro3"><?=$f3->intro?></textarea>
            </td>
        </tr>
    </table> 
</fieldset>
<table class="form" style="width: 510px;" align="left"> 
    <tr>
        <td class="label">Kích hoạt</td>
        <td>
            <input type="checkbox" name="published" value="1" <?=($f1->published == 1)?'checked="checked"':''?>> 
        </td>
    </tr>
</table>
<?=form_close();?>
