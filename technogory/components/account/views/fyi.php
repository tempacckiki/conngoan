<div class="pathway">
    <ul>
        <li><a href="<?=base_url()?>" class="homepage">Trang chủ</a></li>
        <li><a href="#">Đăng ký thành viên</a></li> 
    </ul>
</div>
<?=form_open(uri_string(),array('id'=>'reg_fyi'))?> 
<div class="register">
    
    <div class="box-openid">
        <div class="title-openid"><?=lang('dangkyquaopenid')?></div>
        <a href="<?=site_url('account/openid/connect_google?login=true.fyi')?>" class="google"><img src="<?=base_url()?>site/templates/fyi/images/google_32.png" alt=""></a>
        <a href="<?=site_url('account/openid/connect_yahoo?login=true.fyi')?>" class="yahoo"><img src="<?=base_url()?>site/templates/fyi/images/yahoo-32.png" alt=""></a>
        <a href="<?=site_url('account/openid/connect_fb')?>"><img src="<?=base_url()?>site/templates/fyi/images/facebook_32.png" alt=""></a>
    </div>
    <div class="v_reg">
        <div class="label"><?=lang('emaildangnhap')?>:</div>
        <div class="text"><input type="text" name="email" value="<?=set_value('email')?>"></div>
    </div>
    <div class="v_reg">
        <div class="label"><?=lang('matkhau')?>:</div>
        <div class="text"><input type="password" id="password" name="password"></div>
    </div>
    <div class="v_reg">
        <div class="label"><?=lang('nhaplaimatkhau')?>:</div>
        <div class="text"><input type="password" name="re_password"></div>
    </div>
    <div class="v_reg">
        <div class="label"><?=lang('hovaten')?>:</div>
        <div class="text"><input type="text" name="fullname" value="<?=set_value('fullname')?>"></div>
    </div>
    <div class="v_reg">
        <div class="label"><?=lang('dienthoai')?>:</div>
        <div class="text"><input type="text" name="phone" value="<?=set_value('phone')?>"></div>
    </div>
    <div class="v_reg">
        <div class="label"><?=lang('diachi')?>:</div>
        <div class="text"><input type="text" name="address" value="<?=set_value('address')?>"></div>
    </div>
    <div class="v_reg">
        <div class="label"><?=lang('tinhthanhpho')?>:</div>
        <div class="text">
            <select name="city_id" id="city_id" class="select">
                <option value=""><?=lang('chonthanhpho')?></option>
                <?foreach($listcity as $val):?>
                <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                <?endforeach;?>
            </select>
        </div>
    </div>
    <div class="v_reg">
        <div class="label"><?=lang('quanhuyen')?>:</div>
        <div class="text">
            <select name="district_id" id="get_district" class="select">
                <option value=""><?=lang('chonquanhuyen')?></option>
            </select>
        </div>
    </div>
    <div class="v_reg">
        <div class="label">Mã bảo vệ:</div>
        <div class="text">
            <input type="text" name="code" value="" style="width: 100px;text-transform: uppercase;">
            <?=$img?>
        </div>
    </div>
    <div class="v_reg">
        <div class="label"></div>
        <div class="text">
            <input type="checkbox" name="readok" value="1"> Đồng ý với <a href="<?=site_url('faq/quy-dinh-dang-ky-thanh-vien-14')?>"> <b>Quy định đăng ký thành viên</b></a> của FYI.VN
        </div>
    </div>

    <div class="v_reg">
        <div class="label"></div>
        <div><input type="submit" class="submit" value="Đăng ký" style="padding: 5px 10px;"></div>
    </div>
    
</div>
<div class="register-right">
    Xin Quý khách vui lòng điền đẩy đủ thông tin đăng ký trong Form đăng ký thành viên
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
            readok:    "Quý khách phải đồng ý với quy định của FYI.VN"
        }
        
    });    
});
</script>
