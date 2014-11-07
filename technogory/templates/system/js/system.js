// Gio he thong cua chonmua24h.com
function ServerTime(){
    var mydate = new Date()
    var year = mydate.getYear()
    if (year < 1000)
        year += 1900
    var month = mydate.getMonth() + 1
    if (month < 10)
        month = "0" + month
    var day = mydate.getDate()
    if (day < 10)
        day = "0" + day
    var dayw = mydate.getDay()
    var hour = mydate.getHours()
    if (hour < 10)
        hour = "0" + hour
    var minute = mydate.getMinutes()
    var seconds = mydate.getSeconds();
    if (minute < 10)
        minute = "0" + minute
    if (seconds < 10)
        seconds = "0" + seconds
    //var dayarray = new Array("Chủ Nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7")
    var time = hour + ":" + minute + ":" + seconds + " | " + day + "/" + month + "/" + year
    if (document.getElementById('ServerTime') != null)
        document.getElementById('ServerTime').innerHTML = time;    
    window.setTimeout("ServerTime()", 1000);
}

function set_lang(lang){
    $.post(base_url+"api/setlang/",{'lang':lang},function(data){
      window.location.href = base_url;   
    });     
}

function show_msg(msg){
    html ='<div class="_error">';
        html +='<div>'+msg+'</div>';
        //html +='<div class="_close"><a onclick="close_msg()">Đóng</a></div>';
    html +='</div>';
    $('#show_msg').html(html).slideDown("slow");
    auto_close_msg();

}
function auto_close_msg(){
    setTimeout(remove_msg, 5000); 
}

function remove_msg(){
    if($("#show_msg").length > 0){
        $("#show_msg").slideUp("slow");
        $("#show_msg").html('');
    }
}

function close_msg(){
    $("#show_msg").slideUp("slow");
}
