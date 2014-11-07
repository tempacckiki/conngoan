<div class="box-content-wapper">
	<div class="box-dathang">
		<p class="title-info show_notice">Vui lòng nhập địa chỉ email của bạn. Chúng tôi sẽ gửi lại mật khẩu qua email cho bạn.</p>
	</div>
	<div class="box-login-alobuy">
		<p class="title">Đổi mật khẩu người dùng hệ thống</p>
		<?=form_open(uri_string(),array('id'=>'fyi_find_pass'))?>
		
		<div class="item">
		    <p class="label">Email:</p>
		   <input type="text" name="email">
		</div>
		<div class="item">
		    <p class="label">&nbsp;</p>
		    <input type="submit" value="" class="reset-pass">
		</div>
		<?=form_close()?>
	</div>
</div>

<script type="text/javascript">
$(document).ready(function() {
    $("#fyi_find_pass").validate({
        rules: {
            email:      {
                required: true,
                email: true  
            }
        },
        messages:{
            email:{
                required: "Vui lòng nhập Email",
                email: "Email nhập vào không đúng định dạng"                
            }
        }
        
    });    
});
</script>