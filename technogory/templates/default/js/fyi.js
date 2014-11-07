$(document).ready(function(){
    $("#subscriptions").validate({
        rules:{
            email:{
                required: true,
                email   : true  
            }
        },
        messages:{
            email:{
                required: 'Vui lòng nhập Email',
                email   : 'Email không đúng định dạng'  
            }
        },
        submitHandler: function(form) {
            dataString = $("#subscriptions").serialize();
            $.ajax({
                type: "POST",
                url: site_url+'api/subscriptions',
                data: dataString,
                dataType: "json",
                success: function(data) {
                    if(data.error == 0){
                        clear_form_elements("#subscriptions");
                    }
                    jAlert(data.msg,'Thông báo');
                }
            });
        }
    });
});

