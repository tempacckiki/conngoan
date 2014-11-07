$(document).ready(function() {
    $("#admin_phanquyen").validate({
        rules: {
            user_id: "required"
        },
        messages:{
            gv_cn_id :'Vui lòng chọn chi nhánh'
        }
        ,submitHandler: function(form) {
            load_show();
            dataString = $("#admin_phanquyen").serialize();
            $.ajax({
                type: "POST",
                url: $("#admin_phanquyen").attr('action'),
                data: dataString,
                dataType: "json",
                success: function(data) {
                    load_hide();
                    if(data.error == 0){
                        $.fancybox.close();  
                        reload(base_url+'hethong/phanquyen/edit/<?=$user_id?>','phanquyen');
                    }
                    show_msg(data.msg);
                }
            }); 
        }        
    });    
});

function check_all_list(id){
    if($('input[name=all_list_'+id+']').is(':checked')){
        $(".item_"+id).each(function(i){
            $(this).attr("checked","checked");
        });
    }else{
        $(".item_"+id).each(function(i){
            $(this).removeAttr("checked");
        });
    }        
}

function check_all_items(id){
    if($('input[name=all_items_'+id+']').is(':checked')){
        $(".fnc_"+id).each(function(i){
            $(this).attr("checked","checked");
        });
    }else{
        $(".fnc_"+id).each(function(i){
            $(this).removeAttr("checked");
        });
    }         
}

// Danh muc
function check_all_listdm(id){
    if($('#main1_'+id).is(':checked')){
        $(".item_"+id).each(function(i){
            $(this).attr("checked","checked");
        });
    }else{
        $(".item_"+id).each(function(i){
            $(this).removeAttr("checked");
        });
    }        
}

function check_all_itemsdm(id){
    if($('#main2_'+id).is(':checked')){
        $(".fnc_"+id).each(function(i){
            $(this).attr("checked","checked");
        });
    }else{
        $(".fnc_"+id).each(function(i){
            $(this).removeAttr("checked");
        });
    }         
}