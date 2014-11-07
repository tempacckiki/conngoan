<?=form_open(uri_string(),array('id'=>'create_account_pay'))?>
<script type="text/javascript">
$(document).ready(function() {  
  $("#email_login_pay").val($("#emaildangnhap").val());
});
</script>
<div style="padding: 10px;background: #e5e5e5;">
<table>
    <tr>
        <td style="width: 100px; vertical-align: top;"><?=lang('emaildangnhap')?></td>
        <td><input type="text" id="email_login_pay" name="email_login_pay" style="width: 200px;"></td>
    </tr>
    <tr>
        <td style="vertical-align: top;"><?=lang('matkhau')?></td>
        <td><input type="password" name="pass_pay" id="pass_pay"  style="width: 200px;"></td>
    </tr>
    <tr>
        <td style="vertical-align: top;"><?=lang('nhaplaimatkhau')?></td>
        <td><input type="password" name="re_pass_pay"  style="width: 200px;"></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="Tạo" class="submit" style="margin-left: 0px;padding: 3px;"></td>
    </tr>
</table>
</div>
<?=form_close()?>
<script type="text/javascript">
$(document).ready(function() {
    $("#create_account_pay").validate({
        rules: {
            email_login_pay: {
                required: true,
                email: true  
            },
            pass_pay: "required",
            re_pass_pay:{
                required: true,
                equalTo: "#pass_pay"
            }
        },
        messages :{
            email_login_pay: {
                required: "Vui lòng nhập Email",
                email: "Email không đúng định dạng"  
            },
            pass_pay: "Vui lòng nhập mật khẩu",
            re_pass_pay:{
                required: "Mật khẩu nhập lại không để trống",
                equalTo: "Mật khẩu nhập lại khác Mật khẩu"
            }
        }
        ,submitHandler: function(form) {
            dataString = $("#create_account_pay").serialize();
            $.ajax({
                type: "POST",
                url: $("#create_account_pay").attr('action'),
                data: dataString,
                dataType: "json",
                success: function(data) {
                    if(data.error == 0){
                        $.fancybox.close();
                        $("#haspass").val(data.passwd);
                        $("#emaildangnhap").val(data.email);
                    }
                    jAlert(data.msg,'Thông báo');
                }
            }); 
        }        
    });    
});
</script>
