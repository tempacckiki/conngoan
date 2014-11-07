$(document).ready(function(){  
    $("#btnConfirm").live('click',function(){
        var i = 0; 
        $('input[type="radio"]').each(function(){            
            
            if($(this).is(":radio:checked")) {
                id = $(this).val();
                i = i +1;
            }
        });
        if( i == 0){
            jAlert('Vui lòng chọn 1 chương trình ở mục đồng ý vay','Thông báo');
            return false;
        }else{
            $("#form_tragop").submit();
        }
    });
});

function load_action(level,op_id){
    show_loading();
    $.post(site_url+"tragop/load_level", {'level':level,'op_id':op_id},function(data){
        $("#level"+level).html(data);
        hide_loading();
    }); 
}

function dels(id){
    show_loading();
    $.post(site_url+"tragop/delcart", {'id':id},function(data){
        location.reload();
        hide_loading();
    }); 
}

function tinhtien(){
     var totalprice = $("#totalprice").val();
     var phantram = $("#phamtram").val();
     var tratuoc = (totalprice * phantram)/100;
     $.post(site_url+"tragop/tinhlai", {'totalprice':totalprice,'phantram':phantram,'tratuoc':tratuoc},function(data){
        $("#box_tinhlai").html(data);
     });
     $("#tratuoc").html(tratuoc);
     $("#tratruoc_label").html(formatCurrency(tratuoc));
}

function dongy(id){
    $("table.tragop td").removeClass("select_row");
    $("table.tragop tr#"+id+" td").addClass("select_row");
}
 function formatCurrency(num) {
        num = num.toString().replace(/\$|\,/g,'');
        if(isNaN(num))
        num = "0";
        sign = (num == (num = Math.abs(num)));
        num = Math.floor(num*100+0.50000000001);
        cents = num%100;
        num = Math.floor(num/100).toString();
        if(cents<10)
        cents = "0" + cents;
        for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
        num = num.substring(0,num.length-(4*i+3))+','+
        num.substring(num.length-(4*i+3));
        return (((sign)?'':'-')  + num);
}
