/******
* Lay danh sach thuoc tinh san pham theo thuoc tinh chinh
*/
function get_list_attr(type_id){
    $("#ajax-load").css('display','none'); 
    $.post(base_url+"product/shop/get_list_ajax_attr",{'type_id':type_id},function(data){ 
            $("#list_type").html(data.list);
            $("#ajax-load").css('display','none');                                              
    },'json');
}

// Chon hinh chinh cho san pham
function chosen(img){
    if(img){
        $('#productimg').val(img);
        $('#main_img').html('<img src="' + base_url_site +'alobuy0862779988/0862779988product/80/' + img + '" width="80" height="80" />');
    }
    else{
        return false;
    }
} 
// Convert To Number
function ToNumber(nStr) {
    if (nStr != null && nStr != NaN) {
        var rgx = /[₫\s.]/;
        while (rgx.test(nStr)) {
            nStr = nStr.replace(rgx, '');
        }
        return eval(nStr) + 0;
    }
    return 0;

}

//formatCurrency
function formatCurrency(num) {
    num = num.toString().replace(/\$|\,/g, '');
    if (isNaN(num))
        num = "0";
    sign = (num == (num = Math.abs(num)));
    num = Math.floor(num * 100 + 0.50000000001);
    cents = num % 100;
    num = Math.floor(num / 100).toString();
    if (cents < 10)
        cents = "0" + cents;
    for (var i = 0; i < Math.floor((num.length - (1 + i)) / 3); i++)
        num = num.substring(0, num.length - (4 * i + 3)) + '.' +
    num.substring(num.length - (4 * i + 3));
    var currency = (((sign) ? '' : '-') + num);
    return currency;
}

