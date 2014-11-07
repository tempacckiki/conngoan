<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="contacts_id" value="0">
<table class="form">
    <tr>
        <td class="label">Họ tên</td>
        <td><input type="text" class="w200" name="contacts[hoten]" value="<?php echo set_value('contacts[hoten]')?>"></td>
    </tr>
    <tr>
        <td class="label">Chức vụ</td>
        <td><input type="text" class="w200" name="contacts[chucvu]" value="<?php echo set_value('contacts[chucvu]')?>"></td>
    </tr>

    <tr>
        <td class="label">Địa chỉ</td>
        <td><input type="text" class="w200" name="contacts[diachi]" value="<?=set_value('contacts[diachi]')?>"></td>
    </tr>
    
    <tr>
        <td class="label">Điện thoại nhà</td>
        <td><input type="text" class="w200" name="contacts[dienthoai_nha]" value="<?=set_value('contacts[dienthoai_nha]')?>"></td>
    </tr>
    <tr>
        <td class="label">Điện thoại cơ quan</td>
        <td><input type="text" class="w200" name="contacts[dienthoai_coquan]" value="<?=set_value('contacts[dienthoai_coquan]')?>"></td>
    </tr>
    <tr>
        <td class="label">Di động</td>
        <td><input type="text" class="w200" name="contacts[didong]" value="<?=set_value('contacts[didong]')?>"></td>
    </tr>
    <tr>
        <td class="label">Email</td>
        <td><input type="text" class="w200" name="contacts[email]" value="<?=set_value('contacts[email]')?>"></td>
    </tr>
    <tr>
        <td class="label">Hình đại diện</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this)">
            <img src="<?=base_url()?>templates/images/no-img.png" alt="">
            </div>
            <input type="hidden" name="contacts[anhdaidien]" id="news_img" value="<?=set_value('images')?>">
        </td>         
    </tr>   
</table>
<?php echo form_close();?>
