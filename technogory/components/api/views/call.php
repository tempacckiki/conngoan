<script type="text/javascript" src="<?=base_url()?>site/templates/system/js/jquery.validate.min.js" charset="UTF-8"></script>
<div style="width: 500px;">
    <div class="title_call">Dịch vụ hỗ trợ khách hàng - Gọi cho tôi</div>
    <div class="box_call">
        <div class="show_notice">
        Bạn đang quan tâm đến sản phẩm: <b><?=$rs->productname?></b>
        </div>
        <div>Nếu bạn cần tư vấn thêm về sản phẩm xin gửi thông tin đến chúng tôi.<br />
        Chúng tôi sẽ "Liên lạc & tư vấn miễn phí" với bạn trong vòng 1 giờ</div>
        <?=form_open(uri_string(),array('id'=>'callforme'))?>
        <input type="hidden" name="productid" value="<?=$this->uri->segment(3)?>">
        <table>
            <tr>
                <td><input type="text" id="call_fullname" name="fullname" style="width: 350px;"></td>
            </tr>
            <tr>
                <td><input type="text" id="call_phone" name="phone" style="width: 350px;"></td>
            </tr>
            <tr>
                <td>
                    <textarea style="width: 350px;height: 100px;" id="call_msg" name="content"></textarea>
                </td>
            </tr>
            <tr>
                <td><input type="button" id="callforme_bt" value="Gửi thông tin" class="submit"></td>
            </tr>
            <tr>
                <td>Tổng đài tư vấn và bán hàng: 1900 1870 </td>
            </tr>
        </table>
        <?=form_close();?>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){ 
   $("#call_fullname").Watermark("Nhập họ tên"); 
   $("#call_phone").Watermark("Nhập số điện thoại"); 
   $("#call_msg").Watermark("Nhập nội dung - Thông tin cần tư vấn"); 
   
   $("#callforme_bt").click(function() {
        var fullname = $("#call_fullname").val();
        var phone = $("#call_phone").val();
        var content = $("#call_msg").val();
        var msg = '';
        if(fullname == '' || fullname == 'Nhập họ tên'){
             msg +='Vui lòng nhập Họ tên<br />';
        }
        if(phone == '' || phone == 'Nhập số điện thoại'){
             msg +='Vui lòng nhập số điện thoại<br />';
        }
        if(content == '' || content == 'Nhập nội dung - Thông tin cần tư vấn'){
             msg +='Vui lòng Nhập nội dung - Thông tin cần tư vấn';
        }
        if(msg == ''){
            dataString = $("#callforme").serialize();
            $.ajax({
                type: "POST",
                url: site_url+'api/send_callforme',
                data: dataString,
                dataType: "json",
                success: function(data) {
                    if(data.error == 0){
                        clear_form_elements("#callforme");
                        $.fancybox.close();
                    }
                    jAlert(data.msg,'Thông báo');
                }
            });
        }else{
            jAlert(msg,'Thông báo');
            return false;
        }
    });  

});
</script>
