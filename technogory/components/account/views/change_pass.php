<div class="uleft">
    <?=$this->load->view('html/uleft')?>
</div>

<div class="ucontent">
    <div class="pathway" style="margin-bottom: 10px;">
        <ul>
            <li><a href="<?=base_url()?>" class="homepage">Trang chủ</a></li>
            <li><a href="<?=site_url('u/thong-tin-tai-khoan')?>">Tài khoản</li> 
            <li><a href="#" class="active">Đổi mật khẩu</a></li> 
        </ul>
    </div>

    <div class="clear"></div>
    <?if($rs->password != ''){?>
    <?=form_open(uri_string(),array('id'=>'fyi_change_pass'))?>
    <div class="v_reg">
        <div class="label" style="width: 185px;"><?=lang('matkhaucu')?>: (<span class="required">*</span>)</div>
        <div class="text"><input type="password" style="width: 200px;" value="" name="pass_old"></div>
    </div>
    <div class="v_reg">
        <div class="label" style="width: 185px;"><?=lang('matkhaumoi')?>: (<span class="required">*</span>)</div>
        <div class="text"><input type="password" style="width: 200px;" value="" id="password" name="pass_new"></div>
    </div>
    
    <div class="v_reg">
        <div class="label" style="width: 185px;"><?=lang('nhapmatkhaumoi')?>: (<span class="required">*</span>)</div>
        <div class="text"><input type="password" style="width: 200px;" value="" name="re_pass_new"></div>
    </div>

    <div class="v_reg">
        <div class="label" style="width: 185px;"></div>
        <div><input type="submit" class="submit" value="<?=lang('doimatkhau')?>" style="padding: 5px 10px;"></div>
    </div>
    <?}else{?>
        <div class="show_error">Bạn đang đăng nhập bằng Openid vì thế không thể đổi mật khẩu được</div>
    <?}?>
    <?=form_close();?>
    <script type="text/javascript">
    $(document).ready(function() {
        $("#fyi_change_pass").validate({
            rules: {
                pass_old:   "required",
                pass_new:   "required",
                re_pass_new:{
                    required: true,
                    equalTo: "#password"                
                }
            },
            messages:{
                pass_old:   "<?=lang('vuilongnhapmatkhaucu')?>",
                pass_new:   "<?=lang('vuilongnhapmatkhaumoi')?>",
                re_pass_new:{
                    required: "<?=lang('vuilongnhaplaimatkhaumoi')?>",
                    equalTo: "<?=lang('matkhaumoinhaplaikhongdung')?>"                
                }
            }
            
        });    
    });
    </script>
    
</div>
