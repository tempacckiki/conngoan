$(function(){
    $('#addrate').click(function(){
        show_v();
        shipping_id = $(this).attr('rel');
        $.ajax({
            type: "GET",
            url: base_url+"phuongthuc/vanchuyen/addrate/"+shipping_id,
            dataType: "html",
            success: function(data) {
                hide_v();
                var div = $('<div id="form_addrate" />').html(data)
                div.dialog({
                    canMinimize:true,
                    canMaximize:true,
                    title:'',
                    width: 400
                })
            }
        });

    });
});

function save_add_rate(){
    show_v();
    shipping_id = $("#shipping_id").val();
    rate_cost = $("#rate_cost").val();
    rate_price = $("#rate_price").val();
    rate_price_type = $("#rate_price_type").val();
    if(rate_cost == '' || rate_price == ''){
        jAlert('Vui lòng nhập giá trị đơn hàng, phí vận chuyển','Thông báo');
        return false;
    }
    $.post(base_url+"phuongthuc/vanchuyen/save_add_rate/",{'shipping_id':shipping_id,'rate_cost':rate_cost,'rate_price':rate_price,'rate_price_type':rate_price_type},function(data)
    {
        $("table#admindata tbody").append(data.html); 
        hide_v();
    },'json');
}
function save_rate(rate_id){
    show_v();
    shipping_id = $("#shipping_id").val();
    rate_cost = $("#rate_cost_"+rate_id).val();
    rate_price = $("#rate_price_"+rate_id).val();
    rate_price_type = $("#rate_price_type_"+rate_id).val();
    $.post(base_url+"phuongthuc/vanchuyen/save_rate_edit",{'shipping_id':shipping_id,'rate_cost':rate_cost,'rate_price':rate_price,'rate_price_type':rate_price_type,'rate_id':rate_id},function(data)
    {
        hide_v();
        jAlert(data.msg,'Thông báo');
    },'json');
}

function del_rate(rate_id){
    show_v();
    $.post(base_url+"phuongthuc/vanchuyen/del_rate",{'rate_id':rate_id},function(data)
    {
        hide_v();
        $("#rate_"+rate_id).remove();
        jAlert(data.msg,'Thông báo');
    },'json');
}
