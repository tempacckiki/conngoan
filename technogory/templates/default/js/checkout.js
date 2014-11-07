$(document).ready(function(){
    $("#city_id").change(function(){
        city_id = $(this).val();
        $.post(site_url+"checkout/districts", { "city_id": city_id },function(data){
            $("#districts_id").html(data.info);
        }, "json");
    }); 
    // Cai dat mat khau
    $("#create_ac").live("click", function(){
        email = $("#email").val();
        password = $("#pass_templ").val();
        if(email == '' || email == 'Email dùng để đăng nhập www.alobuy.vn'){
            jAlert('Vui lòng nhập Email','Thông báo');
            return false;
        }else if(echeck(email) == false){
            return false;
        }
        $.post(site_url+"checkout/set_pass",{'email':email,'password':password},function(data){

              window_height = $(window).height();
              window_width = $(window).width();
              $("#cartcontent").html(data.html);
              $("#cartcontent").css({
                  'width':350
              });
              h_box = $(".popcart").height();
              w_box = $(".popcart").width();
              $(".popcart").css({
                  'display':'block',
                  'top': (window_height - h_box)/2 - 100,
                  'left': (window_width - w_box)/2
              });
              $(".popcart").show();
              
        },'json');
    });
    
    $(".payment").live("click", function(){ 
         shipping_id = $("input[name='shipping_id']:checked").val();
         if(shipping_id){
             payment_id = $(this).attr('id');
             $(".listsub_pay").hide();
             $("#subpayment_"+payment_id).show();
             $(".choice_subbank").removeAttr("checked");
         }else{
             $(this).removeAttr("checked");
             jAlert("Vui lòng chọn phương thức vận chuyển trước",'Thông báo');
         }
    });
    
    $(".choice_subbank").live("click", function(){ 
         payment_id = $(this).attr('id');
         $(".choice_sub_content").hide();
         $("#choice_sub_"+payment_id).show();
    });
    
});
function add_pass(){
    password = $("#pass_c").val();
    email = $("#email_c").val();
    $.post(site_url+"checkout/checkmail",{'email':email},function(data){
        if(data.error == 1){
            jAlert('Email đã tồn tại trên hệ thống. Vui lòng chọn Email khác','Thông báo');
            return false;
        }else{
            $("#pass_templ").val(password);
            $("#email").val(email);
            $(".popcart").hide();
            $("#cartcontent").html('');
        }
    },'json');
}

function echeck(str) {
        var at="@"
        var dot="."
        var lat=str.indexOf(at)
        var lstr=str.length
        var ldot=str.indexOf(dot)
        if (str.indexOf(at)==-1){
           jAlert("Email không đúng định dạng",'Thông báo');
           return false
        }

        if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
           jAlert("Email không đúng định dạng",'Thông báo');
           return false
        }

        if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
            jAlert("Email không đúng định dạng",'Thông báo');
            return false
        }

         if (str.indexOf(at,(lat+1))!=-1){
            jAlert("Email không đúng định dạng",'Thông báo');
            return false
         }

         if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
            jAlert("Email không đúng định dạng",'Thông báo');
            return false
         }

         if (str.indexOf(dot,(lat+2))==-1){
            jAlert("Email không đúng định dạng",'Thông báo');
            return false
         }
        
         if (str.indexOf(" ")!=-1){
            jAlert("Email không đúng định dạng",'Thông báo');
            return false
         }

         return true                    
}
function change_ship(shipping_id, order_id){
  
   price_ship = $("#ship_"+shipping_id).html();
   $("#price_ship").html(price_ship);
    $.post(site_url+"checkout/get_payment", { "shipping_id": shipping_id,'order_id':order_id },function(data){
    	var showShipID =  $("#payment_list_"+shipping_id);
    	$(".payment_list").css({
            'display':'none'
        });
    	
    	if(showShipID != 0){
    		$("#description-img_"+shipping_id).css({
    			'display':'none'
    		});
    		
	    	$("#payment_list_"+shipping_id).css({
	            'display':'block'
	        });
	    	
	    	//show data
	    	$("#payment_list_"+shipping_id).html(data);
    	}
    	
        
    });
}

function apply_discount(){
    discount_code = $("#discount_code").val();
    if(discount_code == ''){
        jAlert('Vui lòng nhập mã khuyến mãi','Thông báo');
        return false;
    }else{
        $.post(site_url+"checkout/check_discount", { "discount_code": discount_code },function(data){
            if(data.error == 0){
                $("#discount_code").val('');
                location.reload();
            }else{
                jAlert(data.msg,'Thông báo');
            }
        },'json'); 
    }
}

function remove_discount(id){
    $.post(site_url+"checkout/remove_discount", { "id": id },function(data){
        if(data.error == 0){
            location.reload();
        }
    },'json');
}