<?php 
	$imgPath   		= base_url().'technogory/templates/default/images/';
?>
<?=form_open(uri_string(),array('id'=>'reg_fyi'))?> 
<div class="register-box-member">
    
    <div class="row-frm-member">
        <label>Email đăng nhập: (*)</label>
        <input type="text" name="email" value="<?=set_value('email')?>">
    </div>
    <div class="row-frm-member">
        <label>Mật khẩu: (*)</label>
       <input type="password" id="password" name="password" value="">
    </div>
    <div class="row-frm-member">
         <label>Nhập lại mật khẩu: (*)</label>
        <input type="password" name="re_password" value="">
    </div>
    <div class="row-frm-member">
         <label>Họ & tên: (*)</label>
        <div class="text"><input type="text" name="fullname" value="<?=set_value('fullname')?>"></div>
    </div>
    <div class="row-frm-member">
        <label>Điện thoại: (*)</label>
        <div class="text"><input type="text" name="phone" value="<?=set_value('phone')?>"></div>
    </div>
    <div class="row-frm-member">
         <label>Địa chỉ: (*)</label>
        <div class="text"><input type="text" name="address" value="<?=set_value('address')?>"></div>
    </div>
    <div class="row-frm-member">
         <label>Tỉnh/TP: (*)</label>
        <div class="text">
            <select name="city_id" id="city_id" class="select">
                <option value=""><?=lang('chonthanhpho')?></option>
                <?foreach($listcity as $val):?>
                <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                <?endforeach;?>
            </select>
        </div>
    </div>
    <div class="row-frm-member">
         <label>Quận/Huyện: (*)</label>
        <div class="text">
            <select name="district_id" id="get_district" class="select">
                <option value=""><?=lang('chonquanhuyen')?></option>
            </select>
        </div>
    </div>
     <div class="row-frm-member">
         <label>Mã bảo vệ: (*)</label>
        <div class="text">
            <input type="text" name="code" value="" style="width: 100px;text-transform: uppercase;">
            <?=$img?> <a href="javascript:;"><img src="<?=$imgPath;?>icon-refresh.gif" alt="" align="absmiddle"> Frefesh</a>
        </div>
    </div>
     <div class="row-frm-member">
        <label>&nbsp;</label>
        
          <input type="checkbox" name="readok" value="1" checked="checked"> Tôi đã đọc và đồng ý với <a href="<?=site_url('Huong-dan/quy-dinh-dang-ky-thanh-vien-14')?>"> <b>Thỏa ước thành viên của</b></a> của WWW.ALOBUY.VN
        
    </div>

     <div class="row-frm-member">
       	<label>&nbsp;</label>
        <input type="submit" class="submit" value="Đăng ký" style="padding: 5px 10px;">
    </div>
    
</div>
<div class="box-login-member">	
	<div class="box-openid">
       <p class="title">Kết nối tài khoản</p>
        <a href="<?=site_url('account/openid/connect_google?login=true.fyi')?>" class="google"><img src="<?=base_url()?>technogory/templates/default/images/google.png" alt=""></a>
        <a href="<?=site_url('account/openid/connect_yahoo?login=true.fyi')?>" class="yahoo"><img src="<?=base_url()?>technogory/templates/default/images/facebook.png" alt=""></a>
        <a href="<?=site_url('account/openid/connect_fb')?>"><img src="<?=base_url()?>technogory/templates/default/images/yahoo.png" alt=""></a>
    </div>
    
    <div class="login-this">
    	<p class="title">ĐĂNG NHẬP HỆ THỐNG</p>
    	<form action="">
    		<div class="row-item">
    			<label>Email:</label>
    			<input type="text" value="" name="">
    		</div>
    		<div class="row-item">
    			<label>Mật khẩu:</label>
    			<input type="text" value="" name="">
    		</div>
    		
    		<div class="row-item">
    			<label>&nbsp;</label>
    			<input type="submit" value="Đăng nhập" name="submit">
    		</div>
    	</form>
    </div>
   
    <div id="warning"></div>
</div>
<?=form_close();?>  

<script type="text/javascript">
$(document).ready(function() {
    $("#reg_fyi").validate({
        errorElement: "div",
        errorContainer: $("#warning"),
        errorPlacement: function(error, element) {
            error.insertBefore("#warning");
        },
        rules: {
            email:      {
                required: true,
                email: true  
            },
            password:   "required",
            re_password:{
                required: true,
                equalTo: "#password"                
            },
            fullname:   "required",
            phone:      "required",
            address:    "required",
            city_id:    "required",
            district_id:    "required",
            code:    "required",
            readok:    "required"
        },
        messages:{
            email:{
                required: "<?=lang('vuilongnhapemail')?>",
                email: "<?=lang('emailnhapkhongdung')?>"                
            },
            password:   "<?=lang('vuilongnhapmatkhau')?>",
            re_password:{
                required: "Vui lòng nhập Nhập lại mật khẩu",
                equalTo: "<?=lang('matkhaunhaplaikhongdung')?>"                
            },
            fullname:   "<?=lang('vuilongnhaphoten')?>",
            phone:      "<?=lang('vuilongnhapdienthoai')?>",
            address:    "<?=lang('vuilongnhapdiachi')?>",
            city_id:    "<?=lang('vuilongchontinh')?>",
            district_id:    "<?=lang('vuilongchonquanhuyen')?>",
            code:    "Vui lòng nhập mã bảo vệ",
            readok:    "Quý khách phải đồng ý với quy định của www.alobuy.vn"
        }
        
    });    
});
</script>
