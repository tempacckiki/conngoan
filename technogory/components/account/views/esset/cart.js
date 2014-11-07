$(document).ready(function() {
    $("#xacnhandonhang").click(function() {
        dataString = 'cart_id='+$("#cart_id").val();
        $.ajax({
            type: "POST",
            url: site_url+'account/cart/xacnhandonhang',
            data: dataString,
            dataType: "json",
            success: function(data) {
                if(data.error == 0){
                    $("#status_text").html(data.tinhtrangdonhang);
                    $("#show_notice").remove();
                }
                jAlert(data.msg,'Thông báo');
            }
        });
    });
});