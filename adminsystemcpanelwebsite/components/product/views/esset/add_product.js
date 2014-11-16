$(document).ready(function() {

    /*************
    * Mien Nam
    */
    // Tinh toan giam gia Mien nam và % giam gia
    $("#giathitruong_miennam").keyup(function(){
        giathitruong = ToNumber($(this).val());
        giaban = ToNumber($("#giaban_miennam").val());
        giamgia = giathitruong - giaban;
        per_giamgia = (giamgia * 100)/ giathitruong;   
        $("#giamgia_miennam").val(formatCurrency(giamgia));
        $("#per_miennam").val(formatCurrency(per_giamgia));
    });
    
    $("#giaban_miennam").keyup(function(){
        giathitruong = ToNumber($("#giathitruong_miennam").val());
        giaban = ToNumber($(this).val()); 
        giamgia = giathitruong - giaban;
        per_giamgia = (giamgia * 100)/ giathitruong;
        $("#giamgia_miennam").val(formatCurrency(giamgia));
        $("#per_miennam").val(formatCurrency(per_giamgia));
    });
    
    $('#giaban_miennam').priceFormat({});
    $('#giathitruong_miennam').priceFormat({});
});

$(function() {
    $(".low input[type='button']").click(function(){
        var arr = $(this).attr("name").split("2");
        var from = arr[0];
        var to = arr[1];
        $("#" + from + " option:selected").each(function(){
            $("#" + to).append($(this).clone());
            $(this).remove();
        });
    });
})



function change_tinhtrang_mienbac(tinhtrang){
    if(tinhtrang == 3){
        $("#tinhtrang_mienbac_text").show();
    }else{
        $("#tinhtrang_mienbac_text").hide();
    }
}
function change_tinhtrang_miennam(tinhtrang){
    if(tinhtrang == 3){
        $("#tinhtrang_miennam_text").show();
    }else{
        $("#tinhtrang_miennam_text").hide();
    }
}

function get_manufacture_add(catid){
    load_show();
    $.post(base_url+"product/shop/get_manufacture",{'catid':catid},function(data){
        $("#manufacture").html(data.list);
        get_feature_add(catid); 
        load_hide();                                           
    },'json');
}
function get_feature_add(catid){
    load_show();
    $.post(base_url+"product/shop/get_feature_add",{'catid':catid},function(data){
        $("#list_type").html(data);
        load_hide();
    });     
}

function get_manufacture_edit(catid){
    load_show();
    var productid = $("#productid").val();
    $.post(base_url+"product/shop/get_manufacture",{'catid':catid},function(data){
        $("#manufacture").html(data.list);
        get_feature_edit(catid, productid);
        load_hide();
    },'json');
}
function get_feature_edit(catid,productid){
    load_show();
    $.post(base_url+"product/shop/get_feature_edit",{'catid':catid,'productid':productid},function(data){
        $("#list_type").html(data);
        load_hide();
    });     
}

// Gia san pham theo tinh, Thanh pho
function get_price(city_id){
    if(city_id != 0){
        load_show();
        var productid = $("#productid").val();
        $.post(base_url+"product/shop/getprice",{'city_id':city_id,'productid':productid},function(data){
            $("#list_price").html(data);
            load_hide();
        }); 
    }else{
        $("#list_price").html('Vui lòng chọn Tỉnh, Thành phố');
    }
}


// Xoa anh san pham

function del_img(idimg){
    $.post(base_url+"product/shop/del_img_product",{'idimg':idimg},function(data){
       $("ul#list_img li#img_"+idimg).remove();
    },'json');
}

// Xóa ảnh Ratore

function del_ratore(idimg){
    $.post(base_url+"product/shop/del_ratore",{'idimg':idimg},function(data){
       $("ul#list_img_rotare li#ratore_"+idimg).remove();
    },'json'); 
}

// Chọn ảnh Add

function chosen_tmpl(img){
    if(img){
        $('#productimg').val(img);
        $('#main_img').html('<img src="' + base_url_site +'alobuy0862779988/templ/' + img + '" width="80" height="80" />');
    }
    else{
        return false;
    }
}

// Xóa ảnh Ratore

function del_ratore_tmpl(idimg){
    // $.post(base_url+"product/shop/del_ratore_tmpl",{'idimg':idimg},function(data){
       $("ul#list_img_rotare li#ratore_"+idimg).remove();
    // },'json'); 
}
$(document).ready(function() { 
    $(".del_img_add").live("click", function(){
        $(this).parent('div').parent('li').remove();
    });
});