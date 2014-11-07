function sgr_guighichu(){
    cart_id = $("#cart_id").val();
    ghichukh = $("#ghichukh").val();
    if(ghichukh == ''){
        jAlert('Vui lòng nhập nghi chú trước khi gửi Email','Thông báo');
        return false;
    }
    $.post(base_url+"sangiare/donhang/guiemail",{'cart_id':cart_id,'ghichukh':ghichukh},function(data){ 
        jAlert(data.msg);
    },'json');
}