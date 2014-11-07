<table style="width: 500px;">
    <tr>
        <td>
            <div align="center" style="font-size: 14px;font-weight: bold; margin-bottom: 10px;"> Gửi liên kết này qua email cho bạn</div>
        </td>
        
    </tr>
    <tr>
        <td>
        <?=form_open(uri_string(),array('id'=>'sendmail'))?>
            <table>
                <tr>
                    <td style="width: 120px;">Họ tên bạn</td>
                    <td><input type="text" style="width: 300px;" name="fullname_from" value=""></td>
                </tr>
                <tr>
                    <td>E-mail của bạn</td>
                    <td><input type="text" style="width: 300px;" name="email_from"></td>
                </tr>               
                <tr>
                    <td>E-mail người nhận</td>
                    <td><input style="width: 300px;" type="text" name="email_to"></td>
                </tr>
                <tr>
                    <td>Tiêu đề</td>
                    <td><input type="text" style="width: 300px;" name="subject" value="<?=$rs->title?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" name="url_send" value="<?=site_url('content/article/'.$this->uri->segment(3))?>">
                        <input type="submit" id="bt_sendmail" name="bt_sendmail" value="Gửi E-mail" class="button">
                    </td>
                </tr>
            </table>
            <?php echo form_close()?>
        </td>
    </tr>
</table>
<?

?>
<script type="text/javascript">
$(document).ready(function() { 
    $("#bt_sendmail").click(function(){
             $("#sendmail").validate({
                rules: {
                    fullname_from:{required: true},
                    email_from:{required: true,email: true},            
                    email_to:{required: true,email: true},                                                        
                    subject:{required: true}                                                        
                },
                messages: {
                    fullname_from: { required: "Vui lòng nhập Họ tên bạn"},
                    email_from: {required: "Vui lòng nhập E-mail của bạn",email: "Vui lòng nhập đúng định dạng Email" },            
                    email_to: { required: "Vui lòng nhập E-mail người nhận",email: "Vui lòng nhập đúng định dạng Email"},
                    subject: { required: "Vui lòng nhập Tiêu đề"}                      
                }
                ,submitHandler: function(form) {
                    dataString = $("#sendmail").serialize();
                    $.ajax({
                        type: "POST",
                        url: base_url+"api/sendmail_content",
                        data: dataString,
                        dataType: "json",
                        success: function(data) {
                            alert(data.msg);  
                            $.fancybox.close();                                            
                        }
                    }); 
                }
             });
    });   
});
</script>
