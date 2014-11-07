<div class="box-content-wapper">
	<div class="box-dathang">
		<p class="title-info">Bạn vui lòng đăng nhập hoặc điền thêm thông tin trước khi tiếp tục thanh toán</p>
	</div>
	<div class="box-more-cart">
		<div class="box-login-alobuy">
			<p class="title">Đăng nhập hệ thống</p>
		    <?=form_open(uri_string(),array('id'=>'user_login_fyi'))?>
		     
		   <div class="item" style="margin-top: 10px;">
		       <p class="label">Email:</p>
		        <input type="text" name="email">
		    </div>
		    <div class="item">
		         <p class="label"><?=lang('matkhau')?>:</p>
		       	<input type="password"  id="password" name="password">
		    </div>
		    <div class="no-remember">		        
		       <a href="<?=site_url('u/quen-mat-khau')?>"><input type="checkbox" value="1">Bạn quên mật khẩu?.</a>
		    </div>
		    
		   <div class="item">
				<p class="label">&nbsp;</p>		            
		         <input type="submit"  value="">
		    </div>
	   		 <?=form_close();?>
	   		 <div class="item-login-orther"> 
				<p class="label">Hoặc đăng nhập bằng:</p>
				<p class="col"><a href="<?php echo site_url('account/openid/connect_fb')?>">&nbsp;</a></p>
				<p class="col1"><a href="<?php echo site_url('account/openid/connect_google?login=true')?>">&nbsp;</a></p>
				<p class="col2"><a href="<?php echo site_url('account/openid/connect_yahoo?login=true');?>">&nbsp;</a></p>
			</div>
			
	    </div>
	    
	    <div class="box-no-login-more"> 
			<p class="title">Tiếp tục không cần đăng nhập</p>
			<p class="amonymos">
				<br><br><br>
				Bạn chưa có tài khoản? <br>
				Thanh toán không cần đăng nhập
			</p>
			<div class="buttom-no-login"><a href="<?php echo site_url('thanh-toan/thong-tin-giao-nhan');?>">&nbsp;</a></div>
		</div>
		
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("#user_login_fyi").validate({
        rules: {
            email:      {
                required: true,
                email: true  
            },
            password:   "required"
        },
        messages:{
            email:{
                required: "<?=lang('vuilongnhapemail')?>",
                email: "<?=lang('emailnhapkhongdung')?>"                
            },
            password:   "<?=lang('vuilongnhapmatkhau')?>"
        }
        
    });    
});
</script>