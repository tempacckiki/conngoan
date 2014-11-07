$(document).ready(function() {
    $("#show_mienbac").click(function(){
        if($('input[name=mienbac]').is(':checked')){
            $("fieldset#mienbac").show();
        }else{
            $("fieldset#mienbac").hide();
        }
    });
    $("#show_miennam").click(function(){
        if($('input[name=miennam]').is(':checked')){
            $("fieldset#miennam").show();
        }else{
            $("fieldset#miennam").hide();
        }
    });
    
    $('#giaban_mienbac').priceFormat({
        centsSeparator: '.', 
        thousandsSeparator: ',',
        centsLimit: 2
    });
    $('#giathitruong_mienbac').priceFormat({
        centsSeparator: '.', 
        thousandsSeparator: ',',
        centsLimit: 2
    });
    $('#giaban_miennam').priceFormat({
        centsSeparator: '.', 
        thousandsSeparator: ',',
        centsLimit: 2
    });
    $('#giathitruong_miennam').priceFormat({
        centsSeparator: '.', 
        thousandsSeparator: ',',
        centsLimit: 2
    });
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
    if(tinhtrang == -1){
        $("#tinhtrang_mienbac_text").show();
    }else{
        $("#tinhtrang_mienbac_text").hide();
    }
}
function change_tinhtrang_miennam(tinhtrang){
    if(tinhtrang == -1){
        $("#tinhtrang_miennam_text").show();
    }else{
        $("#tinhtrang_miennam_text").hide();
    }
}

function get_manufacture(catid){
    $.post(base_url+"product/shop/get_manufacture",{'catid':catid},function(data){
        $("#manufacture").html(data.list);                                            
    },'json');
}

//Them tang pham mien nam

