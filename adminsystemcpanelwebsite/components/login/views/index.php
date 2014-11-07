<div id="login_form">
<?=form_open(uri_string())?> 
<div class="swap_input" style="margin-top: 52px; ">
    <div class="label">Email đăng nhập</div>
    <input type="text" name="username" id="username" value="">
</div>
<div class="swap_input">
    <div class="label">Mật khẩu</div>
    <input type="password" name="password" id="password" value="">            
</div>
<div class="account_login">
    <a href="javascript:;" onclick="forgot_pass();">Quên mật khẩu</a>
</div>
<input type="submit" class="button_login" title="Đăng nhập" id="btnDangnhap" value="Đăng nhập" name="btnDangnhap">
<?=form_close()?>
</div>
<div id="forgot_pass" style="display: none;">
<div class="swap_input" style="margin-top: 82px;margin-bottom: 22px;">
    <div class="label">Địa chỉ Email</div>
    <input type="text" name="email" id="email" value="">
</div>

<div class="account_login">
    <a href="javascript:;" onclick="form_login();">Màn hình đăng nhập</a>
</div>
<input type="submit" class="button_login" title="Quên mật khẩu" id="btnDangnhap" onclick="send_pass();" value="Gửi mật khẩu" name="btnDangnhap">
</div>
