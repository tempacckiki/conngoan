<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<input type="hidden" name="user_id" value="<?php echo $rs->user_id?>">
<table class="form">   

    <tr>
        <td class="label">Tên thành viên</td>
        <td><input type="text" class="w200" name="user[fullname]" value="<?php echo $rs->fullname?>"></td>
    </tr>
    <tr>
        <td class="label">Email</td>
        <td><input type="text" class="w200" name="user[email]" value="<?php echo $rs->email?>"></td>
    </tr>  
    <tr>
        <td class="label">Tên đăng nhập</td>
        <td><input type="text" class="w200" name="user[username]" value="<?php echo $rs->username?>"></td>
    </tr>
    <tr>
        <td class="label">Mật khẩu</td>
        <td><input type="password" class="w200" name="password" value=""></td>
    </tr>  
    <tr>
        <td class="label">Mật khẩu nhắc lại</td>
        <td><input type="password" class="w200" name="re_password" value=""></td>
    </tr> 


</table>
<?php echo form_close();?>
