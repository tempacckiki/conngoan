// Load Form Lost Pass
function forgot_pass(){
    $("#login_form").slideUp();
    $("#forgot_pass").slideDown();
}
function form_login(){
    $("#forgot_pass").slideUp();
    $("#login_form").slideDown();
}
function send_pass(){
    var email = $("#email").val();
    if(!checkEmail(email) || email ==''){
        jAlert('Vui lòng nhập đúng địa chỉ Email','Thông báo');
    }else{
        $.post(base_url+"dangnhap/sendpass/",{'email':email},function(data)
        {
               if(data.error == 0){
                  form_login(); 
               }               
               jAlert(data.msg,'Thông báo');                             
        },'json');     
    }
}

function checkEmail(email) {
    if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email)){
        return true
    }else{
        return false;
    }
}