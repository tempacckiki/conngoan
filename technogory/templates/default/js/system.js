$(document).ready(function(){
	//** box login sucess		
	$(".login-success").click(function(){
	    var myDiv = $(".box-login-success").fadeIn();
	    $(document.body).not(myDiv.children().get()).one('click',function(e) {
	        myDiv.hide();     
	    });
	    return false;   
	});
	
	//** login ajax
	$("#login-ajax").click(function(){
		var email  = $("#email").val();
		var pass  = $("#password").val();		
		$.post(site_url+"api/ajax_login_fyi", {'email':email,'pass':pass},function(data){			
			if(data.error == 0){
				//hidden form
				$(".popup-login").hide();
				$(".login-mask").fadeOut();
				//alert
				 jAlert(data.msg,'Thông báo');
				
			}else{
				//alert
				 jAlert(data.msg,'Thông báo');
			}
		 },'json');
	});
	/*//** body click
	 $("body").live("click",function(event){
		 elementTag = event.target.nodeName;
		
		var target = $(event.target);  
		alert(target.is("#bd"));
		  //if (target.is("#popup")) {
		  //}
	     //**  
	     if($(""+elementTag).attr('id') != undefined){
	            //divID = $(""+elementTag).attr('id');
	            //if(divID != 'popcart_close'){
	                $("#search_result").hide();
	            //}

	        }
	    });*/
	    
	    
	 //**
    var window_height = $(window).height();
    var window_width = $(window).width();
    var document_height = $(document).height();
    
    $("ul#navleft li.root").hover(function(){
        mainid = $(this).attr("rel").replace("main_", "");
        w_menu = $("#menuitemchild_"+mainid).width();
        $(".ddcm_root").removeClass('active');
        $("a#"+$(this).attr("rel")).addClass('active');
        $(".ddcm_ul_child").hide();
        $("#menuitemchild_"+mainid).show();
        
    }, function(){
        $(".ddcm_ul_child").hide(); 
        $(".ddcm_root").removeClass('active');
    });  
    
    
    // support online
	$(".suport-new").hover(function(){			
		statusSupport =  $(".suport-new a").attr("title");							
		if(statusSupport == 'true'){
			$("#box-info-support-new").show();
			$(".suport-new a").attr('title','false');
		}else{
			$("#box-info-support-new").hide();
			$(".suport-new a").attr('title','true');				
		}
		
	});
	
    
    // Show, Hide mini menu
    $(".readmore").hover(function(){
        mini_id = $(this).attr("id").replace("mini_", "");
        $(this).find('a.removelink').hide();
        $(".contentmini").hide();
        $("#larger_"+mini_id).show();
    },function(){
       $(".contentmini").hide();   
       $(".readmore a.removelink").show();   
    });
    
    // Menu in Cat, detail ...
    $(".mlist-cat").hover(function(){
         $("#navleft").slideDown();
    },function(){
         $("#navleft").slideUp(200);
    });
    
    // Lay thong tin chi nhanh
    $("#market").change(function(){
        show_loading();
        id = $(this).val();
        $.post(site_url+"api/getmarket", {'id':id},function(data){
            $("#market_address").html(data.address);
            $("#market_phone").html(data.phone);
            $("#market_fax").html(data.fax);
            $("#market_email").html(data.email);
            $("#map_link").html('<a href="javascript:popup_win(\'api/get_map_market/'+id+'\')" id="p_map">Xem bản đồ đường đi</a>');
            hide_loading();
        },"json"); 
    });
    
    $("a.grouped_elements").fancybox({
        'padding'            : 0,
        'titleShow' : false ,
        'autoScale'            : false,
        'transitionIn'        : 'elastic',
        'transitionOut'        : 'elastic',
        'hideOnOverlayClick' : false,
        'hideOnContentClick' : false,
        'overlayShow' : true,
        'opacity' : false,
        'type'                : 'ajax'
    });
    
    /*--------------------------+
     * Popup login 
     +--------------------------*/
    $(".login-popup-show").live("click", function(){
    	$(".login-mask").fadeIn();
    	$(".popup-login").fadeIn();
    });
    
    $(".closepop").live("click", function(){
    	$(".popup-login").fadeOut();
    	$(".login-mask").fadeOut();
    });
    
    
    /****************************
    buttom buy
    +---------------------------*/
    $("#items-index li").hover(function(){   	
		$(this).find('.buttom-buy-prod').css({
			'display': 'block'
		});
	    	
	  },function(){
			$(this).find('.buttom-buy-prod').css({
				'display':'none'
			});
	  });
    
    /**************
    * Add To cart
    */
    $(".addtocart").live("click", function(){
    	//show
    	show_loading();
        div_id 		= $(this).attr('id');
       
        productid 	= div_id.split('_');
        qty 		= $("#qty_"+productid[1]).val();
        if(qty != ''){
        	qty  = 1;
        }
        $.post(site_url+"cart/add",{'productid':productid[1],'qty':qty},function(data){            
             //am thogn bao
        	 hide_loading();
        	 window.location = site_url+"thanh-toan/gio-hang.html";
        },'json');
    
       
    });
    
    
    $("#popcart_close").live("click", function(){
         $(".popcart").hide();
         $("#cartcontent").html('');
    });
    
    /************
    * Mini cart
    */
    $("#showminicart").click(function(){
        show_loading();
        auto_close_minicart();
        $(".minicart").show();
        $(".minicart").attr("show",'true');
        $.post(site_url+"cart/mini_cart", {},function(data){
            $("#scroll_minicart").html(data.list);
            $("#minicart").html(data.list);
            $("#bot_minitop").html(data.checkout);
            $("#bot_minicenter").html(data.checkout);
            hide_loading();
        },"json");
    });
     
    $("#showminicart_scroll").click(function(){
        show_loading();
        auto_close_minicart();  
        $(".minicart").show();
        $(".minicart").attr("show",'true');
        $.post(site_url+"cart/mini_cart", {},function(data){
            $("#scroll_minicart").html(data.list);
            $("#minicart").html(data.list);
            $("#bot_minitop").html(data.checkout); 
            $("#bot_minicenter").html(data.checkout);
            hide_loading();
        },"json"); 
    });
    /**************
    * Cart scroll
    */
     //giohang_scroll = document_height - 40;
    /*$("#shopcart").css({
                'right':min
    }); */
    
    $(window).scroll(function(){
        if  ($(window).scrollTop() > 30){
            w_b_cart = (window_width - 230)/2
            $("#shopcart").hide();
            $("#shopcart_scroll").css({
                'top':0,
                'position':'fixed',
                'left':w_b_cart,
                'z-index' : '110'
            });
            $("#shopcart_scroll").show(); 
        }else{
            $("#shopcart").show(); 
            $("#shopcart_scroll").hide();
        }
    });  
    
    /*
    
    $("ul#thumb li .img").hover(function() {
        $('img#zoom').css({'z-index' : '25'});
        $(this).find('img#zoom').addClass("hover").stop()
            .animate({
                marginTop: '-150px', 
                marginLeft: '-110px', 
                top: '50%', 
                left: '50%', 
                width: '200px', 
                height: '200px',
                padding: '10px'
            }, 200);
        
        } , function() {
        $('img#zoom').css({'z-index' : '0'});
        $(this).find('img#zoom').removeClass("hover").stop()
            .animate({
                marginTop: '0px', 
                marginLeft: '10px',
                top: '0',
                left: '0',
                padding: '0', 
                width: '120px', 
                height: '120px'
            }, 200);
    });
    
    $("ul#thumbs li .img").hover(function() {
        $('img#zoom').css({'z-index' : '2000'});
        $(this).find('img#zoom').addClass("hover").stop()
            .animate({
                marginTop: '-150px', 
                marginLeft: '-110px', 
                top: '50%', 
                left: '50%', 
                width: '200px', 
                height: '200px',
                padding: '10px'
            }, 200);
        
        } , function() {
        $('img#zoom').css({'z-index' : '0'});
        $(this).find('img#zoom').removeClass("hover").stop()
            .animate({
                marginTop: '20px', 
                marginLeft: '15px',
                top: '0',
                left: '0',
                padding: '0', 
                width: '120px', 
                height: '120px'
            }, 200);
    });
    
    */
    /*************
    * Support Yahoo And Skype
    */
    $("#yahoo").hover(function(){
        status = $("#yahoo_box").attr('show');
        $(".boxsupport").hide();
        if(status == 'true'){
            $("#yahoo_box").show();
            $("#yahoo_box").attr('show','false');
        }else{
            $("#yahoo_box").hide();
            $("#yahoo_box").attr('show','true');
        }
    });
    $("#sky").hover(function(){
        status = $("#sky_box").attr('show');
        $(".boxsupport").hide();
        if(status == 'true'){
            $("#sky_box").show();
            $("#sky_box").attr('show','false');
        }else{
            $("#sky_box").hide();
            $("#sky_box").attr('show','true');
        }
    });

   $("#email_login").Watermark("Email đăng nhập");
   $("#pass_login").Watermark("Nhập mật khẩu");
   $("#input_deals").Watermark("Vui lòng nhập Email để nhận Deal");
   $("#keyword").Watermark("Nhập tên sản phẩm");
   $("#productkey").Watermark("Bố mẹ muốn tìm gì hôm nay?");
   
    $('.BoxLocation').mouseover(function(){ 
            $('#listlocation').addClass('active');
    }).mouseout(function(){ 

            $('#listlocation').removeClass('active');
    });       
    
    $("a#choice_city").click(function(){
        city_id = $(this).attr('city_id');
        $.post(site_url+"api/closepopcity", { "city_id": city_id },function(data){
            //window.location.replace(site_url);
        	
        	location.reload();
       }, "json");
    });
    
    $("ul.tabheader li a").hover(function () {
        $("ul.tabheader li a.select").removeClass("select");
        $(this).addClass("select");
        $(".hide-huser").css('display','none');
        var content_show = $(this).attr("title");
        $("#"+content_show).css('display','block');
    });
    
    $("#nhandeal").click(function(){
        var email = $("#input_deals").val();
        $.post(site_url+"api/dangkynhandeal",{'email':email},function(data){
            jAlert(data.msg,'Thông báo');
            $("#input_deals").val('Vui lòng nhập Email để nhận Deal');
            return false;
        },'json');
    });
    
    // Js menu top left
    $('ul#drop_menu li').mouseover(function(){
        resetLeftMenuDrop();
        $(this).addClass('active_drop');
        $(".left_menu_drop").hide();
        $("#vdata_"+$(this).attr('vdata')).show();
    }).mouseout(function(){ 
        $(this).removeClass('active_drop');
        resetcontentMenuDrop();
    });
    
    // Xem them danh muc
    $("#show_more").click(function(){
        $("#show").slideDown();
        $("#hide_more").show();
        $(this).hide();
    });
    $("#hide_more").click(function(){
        $("#show").slideUp();
        $("#show_more").show();
        $(this).hide();

    });
    
    $("#dichvu").hover(function(){
        $("#dichvu_show").show();
        $(this).addClass('select');
    },function(){
        $("#dichvu_show").hide();
        $(this).removeClass('select');
    });
    
    // Click Rating
    $('#ratelinks li a').click(function(){
        proid = $(this).attr('rel');
        var id = $("#ratingid_"+proid).val();
        $.ajax({
            type: "POST",
            url: site_url+"api/rating/",
            data: "rating="+$(this).text()+"&id="+id,
            cache: false,
            async: false,
            success: function(result) {
                jAlert('Bạn đã đánh giá sản phẩm này thành công','Thông báo');
                $("#ratelinks").remove();
                // get rating after click
                 getRating(id);
            },
            error: function(result) {
                jAlert('Có lỗi trong quá trình xử lý đánh giá.','Thông báo');
            }
        });
        
    });
    
    /// Auto search product
    $('#productkey').keyup(function() {
        str = $(this).val();
        str_length = str.length;
        if(str_length >= 3){
            dataString = "productkey="+str;
                $.ajax({
                    type: "POST",
                    url: site_url+'product/autosearch',
                    data: dataString,
                    dataType: "html",
                    success: function(data) {
                        $("#search_result").html(data);
                        $("#search_result").show();
                    }
            });           
        }
    });
    
    $("#productkey").keydown(function(){
        str = $(this).val();
        str_length = str.length;
        if(str_length >= 3){
            dataString = "productkey="+str;
                $.ajax({
                    type: "POST",
                    url: site_url+'product/autosearch',
                    data: dataString,
                    dataType: "html",
                    success: function(data) {
                        $("#search_result").html(data);
                        $("#search_result").show();
                    }
            });           
        }else{
            $("#search_result").html('Nhập từ khóa tìm kiếm lớn hơn 3 ký tự'); 
        }
    });

   
    // Dang mo quang cao Footer Left
    $("#close_f").click(function(){
        close_f();
    });
    $("#open_f").click(function(){
        open_f();
    });
    //auto_open_close();
    
    //ham pho to anh
    $(".zoom-section").live("click", function(){
    	window_height = $(window).height();    	
        window_width = $(window).width();
             
        h_box = $(".zoom-section").height();        
        w_box = $(".zoom-section").width();      
        $(".popslideshow").css({
           'display':'block',
           'top': (window_height - 450)/2,
           'left': (window_width - w_box)/2
        });
        $(".popslideshow").show();
        
    });
    //close album
    $("#slideshow_close").live("click", function(){
        $(".popslideshow").hide();
       
   });

});

// Show Loading
function show_loading(){
    $("#bg_load").show();
    $("#ajax_load").show();
}
function hide_loading(){
    $("#bg_load").hide();
    $("#ajax_load").hide(); 
}
// Hide Loading

//Link search Product
function search_product(){
    productkey = $("#productkey").val();   
    window.location.href = site_url+'search/result.html?p='+productkey
}


// Get Rating
function getRating(id){
    $.ajax({
        type: "POST",
        url: site_url+"api/getrating/"+id,
        cache: false,
        async: false,
        success: function(result) {
            // apply star rating to element
            $("#current-rating_"+id).css({ width: "" + result + "%" });
        },
        error: function(result) {
            jAlert('Có lỗi trong quá trình xử lý đánh giá.','Thông báo');
        }
    });
}

// ReCaptcha
function reset_captcha(id_captcha){
   $.post(site_url+"api/reset_captcha",function(data){
        $("#"+id_captcha).html(data.captcha);
   }, "json");
}

// Clear Form
function clear_form_elements(ele) {
    $(ele).find(':input').each(function() {
        switch(this.type) {
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'text':
            case 'textarea':
                $(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });

}
function auto_close_minicart(){
    setTimeout(close_minicart, 5000);
}
function close_minicart(){
   $(".minicart").hide();
}

function close_pop(){
    $(".popcart").hide();
    $("#cartcontent").html('');
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


function resetLeftMenuDrop(){
    $("ul#drop_menu li").removeClass("active_drop");
}
function resetcontentMenuDrop(){
    $(".left_menu_drop").hide();
}

function change_tab(content,catid,per1,per2){
    //show_v();
    $("ul#"+content+" li a").removeClass('active');
    $(".tabhome li a#"+content+"_"+catid).addClass('active');
    $.post(site_url+"vnit/getproduct",{'catid':catid,'per1':per1,'per2':per2},function(data){
        $("div#content_"+content).html(data.list);
        //hide_v();
    },'json');   
}

function close_pop_city(){
    var city_id = $("#pop_city_id").val();
    $.post(site_url+"api/closepopcity",{'city_id':city_id},function(data){
           if(data.error == 1){
               jAlert(data.msg);
           }else{
                $("#bg_pop_city").hide();
                $("#pop_city").hide();
                $.cookie('fyi_pop_city',2);
                $(window.location).attr('href', site_url);
           }
    },'json');
}

function popup_win(url){
    var window_height = $(window).height();
    var window_width = $(window).width();
    var left = (window_width - 650)/2;
    var top = (window_height - 400)/2;
    win2 = window.open(site_url+url, "Window2", "width=650,height=400,scrollbars=yes,left="+left+",top="+top); 
}