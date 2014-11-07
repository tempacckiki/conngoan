$(document).ready(function(){
    var window_height = $(window).height();
    var window_width = $(window).width();
    var document_height = $(document).height();
    /****************
    * Menu Top
    
    $("ul#mainnavtop li").hover(function(){
        mainid = $(this).attr("rel").replace("main_", "");   
        w_menu = $("#menuitemchild_"+mainid).width();
        offset = $(this).position();
        p_left = offset.left;
        pleft = (window_width - 1000) / 2
        if(w_menu > 900){
            mleft = 0;
        }else if(p_left < 400 && w_menu < 500){
            if(p_left < 200){
                mleft = 0;
            }else{
                mleft = w_menu - p_left;    
            }
        }else{
            mleft = 1000 - 20 - w_menu;  
        }
        $("#menuitemchild_"+mainid).css({
            'left': mleft 
        });
        $(".submenu").hide();
        $("#menuitemchild_"+mainid).show();
        
    }, function(){
        $(".submenu").hide(); 
    }); 
    */
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
    
    
    
    /**************
    * Add To cart
    */
    $(".addtocart").live("click", function(){
        div_id = $(this).attr('id');
        productid = div_id.split('_');
        qty = $("#qty_"+productid[1]).val();
        $.post(site_url+"cart/add",{'productid':productid[1],'qty':qty},function(data){
              $("#total_product").html(data.total_product);
              $("#total_price").html(data.total_price);
              window_height = $(window).height();
              window_width = $(window).width();
              $("#cartcontent").html(data.html);
              h_box = $(".popcart").height();
              w_box = $(".popcart").width();
              $(".popcart").css({
                  'display':'block',
                  'top': (window_height - h_box)/2 - 100,
                  'left': (window_width - w_box)/2,
              });
              $(".popcart").show();
              
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
        auto_close_minicart();
        $(".minicart").show();
        $(".minicart").attr("show",'true');
        $.post(site_url+"cart/mini_cart", {},function(data){
            $("#scroll_minicart").html(data.list);
            $("#minicart").html(data.list);
        },"json");
    });
     
    $("#showminicart_scroll").click(function(){
        auto_close_minicart();  
        $(".minicart").show();
        $(".minicart").attr("show",'true');
        $.post(site_url+"cart/mini_cart", {},function(data){
            $("#scroll_minicart").html(data.list);
            $("#minicart").html(data.list);
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
    
    
    
    $("ul#thumb li .img").hover(function() {
        $('img#zoom').css({'z-index' : '5'});
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
                marginLeft: '0px',
                top: '0',
                left: '0',
                padding: '0', 
                width: '140px', 
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
   $("#productkey").Watermark("Nhập ít nhất 3 ký tự để tìm model sản phẩm!");
   
    $('.BoxLocation').mouseover(function(){ 
            $('#listlocation').addClass('active');
    }).mouseout(function(){ 

            $('#listlocation').removeClass('active');
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

});



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