<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="id" value="<?=$rs->id?>">
<table class="form">
    <tr>
        <td class="label">Họ tên</td>
        <td><input type="text" name="contacts[hoten]" value="<?php echo $rs->hoten?>"></td>
    </tr>
     <tr>
        <td class="label">Chức vụ</td>
        <td><input type="text" name="contacts[chucvu]" value="<?php echo $rs->chucvu?>"></td>
    </tr>
    <tr>
        <td class="label">Địa chỉ</td>
        <td><input type="text" name="contacts[diachi]" value="<?php echo $rs->diachi?>"></td>
    </tr>
    <tr>
        <td class="label">Điện thoại nhà</td>
        <td><input type="text" name="contacts[dienthoai_nha]" value="<?php echo $rs->dienthoai_nha?>"></td>
    </tr>
    <tr>
        <td class="label">Điện thoại cơ quan</td>
        <td><input type="text" name="contacts[dienthoai_coquan]" value="<?php echo $rs->dienthoai_coquan?>"></td>
    </tr>
    <tr>
        <td class="label">Di động</td>
        <td><input type="text" name="contacts[didong]" value="<?php echo $rs->didong?>"></td>
    </tr>
    <tr>
        <td class="label">Email</td>
        <td><input type="text" name="contacts[email]" value="<?php echo $rs->email?>"></td>
    </tr>
    <tr>
        <td class="label">Hình đại diện</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this)">
            <?if($rs->anhdaidien != ''){?>
                <img src="<?=base_url_site().$rs->anhdaidien?>" alt="">
            <?}else{?>
                <img src="<?=base_url()?>templates/images/no-img.png" alt="">
            <?php }?>
            </div>
            <input type="hidden" name="contacts[anhdaidien]" id="news_img" value="<?=$rs->anhdaidien?>">
        </td>         
    </tr> 
</table>
<?php echo form_close();?>
