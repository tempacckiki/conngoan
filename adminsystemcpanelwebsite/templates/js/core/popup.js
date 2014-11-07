function open_popup(data,w,h){
    var margin_top = -(h/2+15);
    var margin_left = -(w/2+24);
    var width = w+48;
    var height = h+48;
    var html = '<div id="close" onclick="close_pop();"></div>';
    html +='<div class="top-left"><div class="top-right"><div class="top-mid"></div></div></div>';
    html +='<div class="mid-left"><div class="mid-right"><div class="mid-center">';

    html +='<div id="pop_content" style="width:'+(w-10)+'px;height:auto">'+data+'</div>';
    html +='</div></div></div>';

    html +='<div class="bot-left"><div class="bot-right"><div class="bot-mid"></div></div></div>';
    $("#pop").html(html).fadeIn(300);
    $("#pop").css({'width':width+'px','height':'auto','margin-left':margin_left+'px','margin-top':margin_top+'px'});
    $("#pop_bg").show();
}
function close_pop(){
    $("#pop").fadeOut(400);
    $("#pop_bg").hide();
}