function show_img(img){
    $("#show_mini_img").html('<img width="250" src="'+site_url+'data/img_product/500/'+img+'">');
}
$(document).ready(function(){
   // Gui link cho ban be
   
    $("#send_to_friend").validate({
        rules: {
            ten_nguoinhan: "required",
            email_nguoinhan: {
                required: true,
                email   : true
            },
            ten_cuaban: "required",
            email_cuaban:{
                required: true,
                email   : true
            },
            noidung   : "required",
            mabaove   : "required"
        },
        messages:{
            ten_nguoinhan: "Vui lòng nhập Tên người nhận",
            email_nguoinhan: {
                required: "Vui lòng nhập Email người nhận",
                email   : "Email không đúng định dạng"
            },
            ten_cuaban: "Vui lòng nhập Tên của bạn",
            email_cuaban:{
                required: "Vui lòng nhập Email của bạn",
                email   : "Email không đúng định dạng"
            },
            noidung   : "Vui lòng nhập nội dung",
            mabaove   : "Vui lòng nhập mã bảo vệ"
        }
        ,submitHandler: function(form) {
            dataString = $("#send_to_friend").serialize();
            $.ajax({
                type: "POST",
                url: site_url+'api/send_to_friend',
                data: dataString,
                dataType: "json",
                success: function(data) {
                    if(data.error == 0){
                        reset_captcha("send_to_friend_captcha");
                        clear_form_elements("#send_to_friend");
                    }
                    jAlert(data.msg,'Thông báo');
                }
            });
        }
    });
    

    // Send Comment
    $("#send_comment").validate({
        errorElement: "div",
        errorContainer: $("#warning, #summary"),
        errorPlacement: function(error, element) {
            error.appendTo("#warning");
        },
        rules: {
            title: {
                required: true,
                not_tieude: true  
            },
            fullname:{
                required: true,
                not_hoten: true  
            },
            email:{
                not_email: true,
                required: true,
                email   : true
            },
            content   : {
                required: true,
                not_content: true
            }
        },
        messages:{
            title: "Vui lòng nhập tiêu đề",
            fullname: "Vui lòng nhập họ tên",
            email:{
                required: "Vui lòng nhập Email của bạn",
                email   : "Email không đúng định dạng"
            },
            content   : "Vui lòng nhập Ý kiến của bạn"
        }
        ,submitHandler: function(form) {
            dataString = $("#send_comment").serialize();
            $.ajax({
                type: "POST",
                url: site_url+'api/send_comment',
                data: dataString,
                dataType: "json",
                success: function(data) {
                    if(data.error == 0){
                        clear_form_elements("#send_comment");
                        $("#lastPostsLoader").prepend(data.list);
                    }
                    jAlert(data.msg,'Thông báo');
                }
            });
        }
    });
    $.validator.addMethod("not_tieude", not_tieude, "Vui lòng nhập Tiêu đề.");
    $.validator.addMethod("not_hoten", not_hoten, "Vui lòng nhập Họ tên.");
    $.validator.addMethod("not_email", not_email, "Vui lòng nhập Email.");
    $.validator.addMethod("not_content", not_content, "Vui lòng nhập Ý kiến của bạn.");

    // Show, hide danh sach diem bao hanh
    $(".listiems").click(function(){
         city_id = $(this).attr('city_id');
         $(".listitem").slideUp();
         $("#city_"+city_id).slideDown();
    });
    
    $("#tang").click(function(){
        qty = parseInt($(".qty").val());
        $(".qty").val(qty + 1);
    })
    $("#giam").click(function(){
        qty = parseInt($(".qty").val());
        if(qty > 1)
        $(".qty").val(qty - 1);
    })
    // Tang giam so luong mua
    $('.quantity').each(function(){
        var up = $(this).find('.up');
        var down = $(this).find('.down');
        var input = $(this).find('input');
        up.bind('click', function(){
            var value = parseInt(input.val());
            value++;
            input.val(value);
        });
        down.bind('click', function(){
            var value = parseInt(input.val());
            if (value > 1){
                value--;
                input.val(value);
            }
        });
    });
    
    
});

function func_morecomment(page){
    $('div#show_more').html('<img src="'+site_url+'site/templates/fyi/images/loading-comment.gif">');
    productid = $("#productid").val();
    $.post(site_url+"api/loadcomment",{'page':page,'productid':productid},
    function(data){
        if (data.list != "") {
            $("#lastPostsLoader").append(data.list);      
            $("#show_more").html(data.show_more);
        }else{
            $("#show_more").html('');
        }

    },'json');
}

$(window).scroll(function(){
    if  ($(window).scrollTop() >= $(document).height() - $(window).height()-370){
        lastPostFunc();
        return false;
    }
});
function lastPostFunc() 
{ 
    var page_end = $("#page_end").val();
    if(page_end == 0){   
        $('div#show_more').html('<img src="'+site_url+'site/templates/fyi/images/loading-comment.gif">');
        var page_comment = $("#page_comment").val();
        productid = $("#productid").val();
        $.post(site_url+"api/loadcomment/",{'page':page_comment,'productid':productid},
        function(data){
            if (data.list != "") {
                $("#lastPostsLoader").append(data.list);      
                $("#page_comment").val(data.page_c);
                $("#page_end").val(data.page_end);
                
            }
            $('div#lastPostsLoader').empty();
            $('div#proce_comment').html('');
        },'json');
    return false;
    }
    return false;
}; 

function not_tieude(value, element){
    return value != 'Tiêu đề';
}

function not_hoten(value, element){
    return value != 'Họ tên';
}
function not_email(value, element){
    return value != 'Email';
}
function not_content(value, element){
    return value != 'Ý kiến của bạn';
}

