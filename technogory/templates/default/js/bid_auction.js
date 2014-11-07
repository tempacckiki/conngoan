var param = null;
var _ajax_ab_set         = null;
var _ajax_ab_unset         = null;
$(document).ready(function() { 
    $("a#click_bid").live("click", function(){
          au_id = $(this).attr('bid_id');
          if(user_id != 0){
                //display();
                $.post(site_url+"daugia/actionbid",{'au_id':au_id},function(data)
                {             
                    if(data.error == 0){
                        /*
                        total_bid = $("#total_bid_of_bidder");
                        if(price_use){
                            price_use_text = ToNumber(price_use.text());
                            var total_price_user = ToNumber(price_use_text) + ToNumber(data.price_increase);
                            price_use.html(formatCurrency(total_price_user)+' <span>₫</span>');                     
                        }*/
                        $("#PriceNow_"+au_id).html(formatCurrency(data.price)+' <span>₫</span>');
                        SetBackground("#PriceNow_"+au_id);
                        SetColor("#TimeRemain_"+au_id);
                        $("#bt_"+au_id).html(dis_bt_bid_small());
                        $("#Bidder_"+au_id).html(data.bidder);
                        Bid_Show_Msg(au_id,data.msg,1000);
                    }else{
                        Bid_Show_Msg(au_id,data.msg,2000);
                    }
                    //nodisplay();
                },'json');         
            }else{
                alert('Vui lòng đăng nhập trước khi thực hiện đặt giá');
            }
    });
});

/*******
* Thục hien việc đặt giá cho san pham
* var au_id;
*/


/*****
* An button Bid
*/

function dis_bt_bid_small(){
    return '<a href="javascript:;" class="booking_dis">Đặt giá</a>'; 
}
function bt_bid_small(auid){
    return '<a href="javascript:;" id="click_bid" bid_id="'+auid+'" class="booking">Đặt giá</a>';
}



/*************END***************************/

function UpdateAuctions(param) {
    $.ajax({
        type: "GET",
        url: auction_url+"auction/probid.php?param=" + param,
        contentType: "application/json; charset=utf-8",
        cache: false,
        dataType: "json",
        success: function(data) {


                for (var i = 0; i < data.ai.length; i++) {
                    var TotalSecond = data.ai[i].t;
                    var Daban               = '#daban_' + data.ai[i].id;
                    var TotalSecondOld      = '#TotalSecond_' + data.ai[i].id;
                    var TimeRemain          = '#TimeRemain_' + data.ai[i].id;
                    if (parseInt(TotalSecond) <= parseInt(data.ai[i].trs))
                        $(TimeRemain).attr("style", "color:#CA0909");
                    var PriceNow            = '#PriceNow_' + data.ai[i].id;
                    var PerSave                 = '#Per_' + data.ai[i].id;
                    var PriceOld            = '#PriceOld_' + data.ai[i].id;
                    var Bidder              = '#Bidder_' + data.ai[i].id;
                    var Bt_bid              = '#bt_' + data.ai[i].id;
                    var PriceNowOld         = $(PriceOld).html();
                    var Stop                = data.ai[i].stop;

                        
                        var PriceNowNew = data.ai[i].p;
                        $(TotalSecondOld).html(TotalSecond);
                        $(PerSave).html(data.ai[i].save);

                        $(PriceNow).html(formatCurrency(data.ai[i].p) + " ₫");
                        if(data.ai[i].b!=null){

                            if(user_id == data.ai[i].bid || data.ai[i].sold == 1){
                                $(Bt_bid).html(dis_bt_bid_small());
                            }else{
                                $(Bt_bid).html(bt_bid_small(data.ai[i].id));
                            }
                        }else{
                            $(Bt_bid).html(bt_bid_small(data.ai[i].id));
                        }
                        
                        if(data.ai[i].b == null)
                             $(Bidder).html('Hãy trở thành người đầu tiên đặt giá');
                        else $(Bidder).html(data.ai[i].b);

                        $(TimeRemain).html(CaculatorTime(TotalSecond));
                        if (data.ai[i].p != PriceNowOld) {

                            SetColor(TimeRemain);
                            SetBackground(PriceNow);
                            $(PriceOld).html(data.ai[i].p); 
                        }
                   
                    if (TotalSecond <= 60) {

                        //var div = document.getElementById("imgBid_" + data.ai[i].id).getElementsByTagName('img');
                        $(TimeRemain).css("color", '#FF0000');
                        //var imgSold = document.getElementById('imgSold_' + data.ai[i].id);
                        //imgSold.style.display = 'block'
                        //var priceNow = document.getElementById('PriceNow_' + data.ai[i].id);
                        //if (priceNow != null && priceNow.className != 'numberprice')
                           // priceNow.parentNode.parentNode.className = 'bgaddprice2';
                        /*if (div != null) {
                            div[0].src = '/images/bid_btn2.jpg';
                            div.disabled = true;
                        } */
                    }
                    
                    if(TotalSecond <= 0 || (data.ai[i].p >= data.ai[i].pold) ){
                       $(TimeRemain).css("color", '#FF0000');
                       $(Daban).show(); 
                       $(Bt_bid).html(dis_bt_bid_small());
                    }
                }
            
        }
    });
}

function Bid_Show_Msg(divID,msg,timeout){
    $("#Bid_msg_"+divID).html(msg);
    $("#Bid_msg_"+divID).slideDown();
    setTimeout('Bid_Hide_Msg("' + divID + '")', timeout);
}

function Bid_Hide_Msg(div){
   $("#Bid_msg_"+div).slideUp();
}

function SetColor(divID){
    $(divID).css("color", "#FF0000");
    setTimeout('ClearColor("' + divID + '")', 500);
}

function ClearColor(div){
   $(div).css("color", "#333333");   
}

function SetBackground(divID) {
    $(divID).css("background-Color", "#F5A9F2");
    setTimeout('ClearBack("' + divID + '")', 500);
}
function ClearBack(div) {
    $(div).css("background-Color", "#FFFFFF");
}
var interval = null;
function GetAuctionsInfo(param) {
    if (param != "") {
        interval = setInterval("UpdateAuctions('" + param + "')", 1000);
    }
}
function GetAuctionsDetailInfo(param) {
    if (param != '0|0') {
        setInterval("UpdateAuctionDetail('" + param + "')", 1000);
    }
}
function ClearInterval() {
    window.clearInterval(interval);
}
/*
 * HIỆN THÔNG BÁO NHỎ
 */
function ShowData(data, toSelector) {
    $(".msgsmall").remove();
    var html = "<div class='msgsmall border_red red padding8'>" + data + "<div>";
    $(html).prependTo(toSelector);
}
// Check Number
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
// Gio he thong cua chonmua24h.com
function ServerTime(){
    var mydate = new Date()
    var year = mydate.getYear()
    if (year < 1000)
        year += 1900
    var month = mydate.getMonth() + 1
    if (month < 10)
        month = "0" + month
    var day = mydate.getDate()
    if (day < 10)
        day = "0" + day
    var dayw = mydate.getDay()
    var hour = mydate.getHours()
    if (hour < 10)
        hour = "0" + hour
    var minute = mydate.getMinutes()
    var seconds = mydate.getSeconds();
    if (minute < 10)
        minute = "0" + minute
    if (seconds < 10)
        seconds = "0" + seconds
    //var dayarray = new Array("Chủ Nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7")
    var time = hour + ":" + minute + ":" + seconds + " | " + day + "/" + month + "/" + year
    if (document.getElementById('ServerTime') != null)
        document.getElementById('ServerTime').innerHTML = time;    
    window.setTimeout("ServerTime()", 1000);
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
//Chuyển thời gian từ định dạng ss sang hh : mm : ss
function CaculatorTime(totalSeconds) {
    if (totalSeconds <= 0)
        return "00 : 00 : 00";
day = parseInt((totalSeconds / 86400));         
hour = parseInt( totalSeconds / 3600 ) % 24;
minute = parseInt( totalSeconds / 60 ) % 60;
second = totalSeconds % 60;



    


    if (hour < 10)
        _hour = "0" + hour.toString();
    else _hour = hour.toString();
    if (minute < 10)
        _minute = "0" + minute.toString();
    else _minute = minute.toString();
    if (second < 10)
        _second = "0" + second.toString();
    else _second = second.toString();
    //if(totalSeconds < 36000){
        //return  _minute + " phút, " + _second + " s";
    //}else if(totalSeconds < 86400){
        //return _hour + " giờ, " + _minute + " phút, " + _second + " s";
    //}else{
        return day + " ngày, "+_hour + " giờ, " + _minute + " phút, " + _second + " s";    
    //}
    
    
}
//End Update Auctions
//-----------------------------------



/*
//Begin Update Bid
function UpdateBid(param) {
    $.ajax({
        type: "GET",
        url: "/GetBid.ashx?param=" + param + "",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
            var BidType = data[0].t;
            var message = 'div#message_' + data[0].id;
            if (BidType == -3) {

                $(message).attr("innerHTML", "Bạn không được bids 2 lần<br>liên tiếp");
                ShowMessage(message);
            }
            else if (BidType == -1) {

                $(message).attr("innerHTML", "Số Bid hiện tại của bạn đã hết");
                ShowMessage(message);
            }
            else if (BidType == -4) {

                $(message).attr("innerHTML", "Đấu giá hiện tại đã kết thúc");
                ShowMessage(message);
            }
            else if (BidType == -5) {

                $(message).attr("innerHTML", "Bạn không được tham gia bid<br>khi đã mua sản phẩm");
                ShowMessage(message);
            }
            else if (BidType == -6) {
                $(message).attr("innerHTML", "Bạn đã hết lượt thắng trong ngày(trong tháng)");
                ShowMessage(message);
            }
            else if (BidType == -7) {
                $(message).attr("innerHTML", "Bạn không được tham gia phiên đấu giá này");
                ShowMessage(message);
            }
            else if (BidType == -8) {
                $(message).attr("innerHTML", "Số lượt bid cho phiên này đã hết");
                ShowMessage(message);
            }
        },
        failure: function(msg) {
            alert(msg);
        }
    });
}
function UpdateAuctionDetail(param) {
    $.ajax({
        type: "GET",
        url: "/GetDataAuction.ashx?param=" + param,
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
            if (data == null) return false;
            if (!checkLogin()) {
                $("a#aMyBid").attr("style", "display:none");
            }
            else $("a#aMyBid").attr("style", "display:block");
            if (data.ai.length > 0)
                timeRemail = data.ai[0].t;
            if (parseInt(timeRemail) <= parseInt(data.ai[0].trs))
                $("#timeRemain").attr("style", "color:#CA0909");
            //********************* Kết thúc đấu giá *******************
            if (timeRemail <= -5) {
                $("#imageAuctionSold").attr("style", "display:block");
                $("#bgAddPrice").addClass("bgaddprice_detail2");
                //Hiển thị thời điểm kết thúc đấu giá
                //var now = new Date();
                //$("#timeEnded").attr("innerHTML", "Kết thúc lúc " + now.format("dd/MM/yyyy HH:mm:ss"));
                //$("#timeEnded").attr("style", "display:block");

                $("#timeRemain").attr("innerHTML", "00 : 00 : 00");
                $("#imageBid").attr("style", "display:none");
                $("#imageBidSold").attr("style", "display:block");

                if (data.ai[0].b != '')
                    $("#lastestBidder").attr("innerHTML", "Người thắng: " + data.ai[0].b);

                //Disable bidagent

                $("#ctl00_ContentPlaceHolder2_ucAuctionDetail1_txtBidNumber").attr("disabled", true);
                $("#ctl00_ContentPlaceHolder2_ucAuctionDetail1_txtMaximumPrice").attr("disabled", true);

                //window.location.reload(true);
                return false;
            }
            //******************************************************************
            $("#timeRemain").attr("innerHTML", CaculatorTime(timeRemail));
            var priceClient = $("#priceNowClient").attr("innerHTML");
            if (data.ai.length > 0) {
                if (data.ai[0].p != priceClient) {
                    var priceOld = jQuery.trim($("#priceNow").attr("innerHTML").replace(" VNĐ", "").replace(/./gi, ''));
                    var priceNew = jQuery.trim(data.ai[0].p);
                    var priceTotal = parseInt(priceNew.replace(".", "").replace(".", ""));
                    var save = parseInt($("#priceRetail").children()[0].innerHTML.replace(".", "").replace(".", "")) - priceTotal;
                    save = formatCurrency(save);
                    $("#priceNow").attr("innerHTML", priceNew + " VNĐ");
                    $("#priceNowClient").attr("innerHTML", priceNew);
                    $("#price").attr("innerHTML", priceNew);
                    //$("#priceTotal").attr("innerHTML", priceTotal);
                    $("#priceSave").attr("innerHTML", save);
                    $("#ctl00_ucAccount_lblBidNumber").attr("innerHTML", data.ttb);
                    $("#ctl00_ContentPlaceHolder2_ucAutionHorizontalDetail1_bidUse").attr("innerHTML", data.bus);
                    if ((priceNew != priceOld) && (data.atb.length > 0)) {
                        SetBackground("#timeRemain");
                        //Cộng tổng số bid đc refund cho mỗi lần Bid thành công
                        if (jQuery.trim($("#ctl00_ucAccount1_lblPaygateName").attr("innerHTML")) == jQuery.trim(data.ai[0].b)) {
                            percentRefund = parseInt($("#ctl00_ContentPlaceHolder2_ucAuctionDetail1_hdfPercentRefund").val());
                            bidRefund = parseInt($("#ctl00_ContentPlaceHolder2_ucAuctionDetail1_hdfRefund").val()) + 1;
                            bidRefund = parseInt(bidRefund * percentRefund / 100);
                            $("#ctl00_ContentPlaceHolder2_ucAuctionDetail1_lblRefund").attr("innerHTML", bidRefund.toString());
                        }
                    }

                    //********************** Lịch sử bid ************************
                    if (data.atb.length > 0) {
                        $("#lastestBidder").attr("innerHTML", 'Người đặt: <a id="aBidder" href="#">' + data.ai[0].b + '</a>');
                        SetBackground("#aBidder");
                        bidHistory = '<ul>';
                        for (i = 0; i < data.atb.length; i++) {
                            //if (data.atb[i].bt == "0")
                            typeBid = "1 bid";
                            //else typeBid = "tự động";
                            if (data.atb[i].b.length > 15)
                                bidder = data.atb[i].b.substr(0, 15);
                            else bidder = data.atb[i].b;
                            bidHistory += '<li style="width:50px">' + data.atb[i].t + '</li><li style="width:60px">' + data.atb[i].p + '</li><li style="width:85px;text-align:left">' + bidder + '</li><li style="width:40px">' + typeBid + '</li>';
                        }
                        bidHistory += "</ul>";
                        $("#history").attr("innerHTML", bidHistory);
                    }
                }
                $("#divHeaderTime").attr("innerHTML", data.dt);
            }
            //********************** Thống kê số lượng Bidder trong 15 phút
            if (data.rb.length > 0) {
                if ((data.atb.length > 0) && (data.atb[0].p != priceClient)) {
                    reportBidder = data.rb;
                    $("#report").attr("innerHTML", "Những người bid trong 15 phút gần đây nhất" + '<p><b><div stype="padding-top:10px">' + reportBidder + '</div></b></p>');
                }
            }
            //********************** Lịch sử bid của tôi ***********************
            if (data.amb.length > 0) {
                if ((data.atb.length > 0) && (data.atb[0].p != priceClient)) {
                    myHistory = '<ul>';
                    for (i = 0; i < data.amb.length; i++) {
                        if (data.amb[i].bt == "0")
                            typeBid = "1 lần";
                        else
                            typeBid = "tự động";
                        if (data.amb[i].b.length > 15)
                            bidder = data.amb[i].b.substr(0, 15);
                        else bidder = data.amb[i].b;
                        myHistory += '<li style="width:50px">' + data.amb[i].t + '</li><li style="width:60px">' + data.amb[i].p + '</li><li style="width:85px;text-align:left">' + bidder + '</li><li style="width:40px">' + typeBid + '</li>';
                    }
                    myHistory += "</ul>";
                    $("#myBid").attr("innerHTML", myHistory);
                    //Tính lại tổng số bids tự động còn lại sau mỗi lần bid
                    if ((jQuery.trim($("#ctl00_ucAccount1_lblPaygateName").attr("innerHTML")) == jQuery.trim(data.ai[0].b)) && (data.amb[0].bt == "1")) {
                        bidToPlace = parseInt($("#ctl00_ContentPlaceHolder2_ucAuctionDetail1_txtBidNumber").val()) - 1;
                        $("#ctl00_ContentPlaceHolder2_ucAuctionDetail1_txtBidNumber").val(bidToPlace.toString());
                    }
                }
            }
            //********************** Sản phẩm quan tâm **************************
            for (var i = 1; i < data.ai.length; i++) {
                var TotalSecond = data.ai[i].t;
                var TotalSecondOld = '#TotalSecond_' + data.ai[i].id;
                var TimeRemain = 'div#TimeRemain_' + data.ai[i].id;
                if (parseInt(TotalSecond) <= parseInt(data.ai[i].trs))
                    $(TimeRemain).attr("style", "color:#CA0909");
                var PriceNow = 'div#PriceNow_' + data.ai[i].id;
                var Bidder = 'div#Bidder_' + data.ai[i].id;
                var MyBidder = 'div#MyBidder_' + data.ai[i].id;
                var PriceNowOld = $(PriceNow).attr("innerHTML");
                if (PriceNowOld != null) {
                    PriceNowOld = jQuery.trim(PriceNowOld.replace(" VNĐ", ""));
                    var PriceNowNew = data.ai[i].p;
                    $(TotalSecondOld).attr("innerHTML", TotalSecond);
                    $(TimeRemain).attr("innerHTML", CaculatorTime(TotalSecond));
                    $(PriceNow).attr("innerHTML", data.ai[i].p + " VNĐ");
                    $(Bidder).attr("innerHTML", data.ai[i].b);
                    $(MyBidder).attr("innerHTML", 'Người đặt: <span id="spanMyBidder_' + data.ai[i].id + '" class="namewinner"><a href="#">' + data.ai[i].b + '</a></span>');

                    if (PriceNowNew != PriceNowOld) {
                        SetBackground(TimeRemain);
                        SetBackground("span#spanMyBidder_" + data.ai[i].id);
                    }
                }
            }
        },
        failure: function(msg) {
            alert(msg);
        }
    });
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

function UpdateBidAuction(param) {
    $.ajax({
        type: "GET",
        url: "/GetBid.ashx?param=" + param + "",
        contentType: "application/json; charset=utf-8",
        dataType: "json",
        success: function(data) {
            if (checkLogin()) {
                var BidType = data[0].t;
                if (BidType == -3) {
                    $("#divMessageAuctionDetail").attr("innerHTML", "Bạn không được bids 2 lần liên tiếp");
                    ShowMessage("#divMessageAuctionDetail");
                }
                else if (BidType == -1) {
                    $("#divMessageAuctionDetail").attr("innerHTML", "Số bids hiện tại của bạn đã hết");
                    ShowMessage("#divMessageAuctionDetail");
                }
                else if (BidType == -5) {
                    $("#divMessageAuctionDetail").attr("innerHTML", "Bạn không được tham gia bid<br>khi đã mua sản phẩm");
                    ShowMessage("#divMessageAuctionDetail");
                }
                else if (BidType == -4) {
                    $("#divMessageAuctionDetail").attr("innerHTML", "Đấu giá hiện tại đã kết thúc");
                    ShowMessage("#divMessageAuctionDetail");
                }
                else if (BidType == -6) {
                    $("#divMessageAuctionDetail").attr("innerHTML", "Bạn đã hết lượt thắng trong ngày(trong tháng)");
                    ShowMessage("#divMessageAuctionDetail");
                }
                else if (BidType == -7) {
                    $("#divMessageAuctionDetail").attr("innerHTML", "Bạn không được tham gia phiên đấu giá này");
                    ShowMessage("#divMessageAuctionDetail");
                }
                else if (BidType == -8) {
                    $("#divMessageAuctionDetail").attr("innerHTML", "Số lượt bid trong phiên này đã hết");
                    ShowMessage("#divMessageAuctionDetail");
                }
            }
        },
        failure: function(msg) {
            alert(msg);
        }
    });
}
function ShowMessage(divID) {
    $(divID).attr("style", "display:block");
    setTimeout('HideMessage("' + divID + '")', 4000);
}
function HideMessage(divID) {
    $(divID).attr("style", "display:none");
}
//End Update Bid
//-------------------------------
// begin tu dong logout
startday = new Date();

clockStart = startday.getTime() + (60 * 1000 * 15);

function initStopwatch() {
    var myTime = new Date();
    return ((clockStart - myTime.getTime()) / 1000);
}

function toggle(id) {
    el = document.getElementById(id);

    if (el.style.display == 'none')
    { el.style.display = 'block'; }
    else
    { el.style.display = 'none'; }
}
// End tu dong logout

function DisplayTime() {

    var mydate = new Date()
    var year = mydate.getYear()
    if (year < 1000)
        year += 1900
    var month = mydate.getMonth() + 1
    if (month < 10)
        month = "0" + month
    var day = mydate.getDate()
    if (day < 10)
        day = "0" + day
    var dayw = mydate.getDay()
    var hour = mydate.getHours()
    if (hour < 10)
        hour = "0" + hour
    var minute = mydate.getMinutes()
    var seconds = mydate.getSeconds();
    if (minute < 10)
        minute = "0" + minute
    if (seconds < 10)
        seconds = "0" + seconds
    var dayarray = new Array("Chủ Nhật", "Thứ 2", "Thứ 3", "Thứ 4", "Thứ 5", "Thứ 6", "Thứ 7")
    var time = hour + ":" + minute + ":" + seconds + " - " + dayarray[dayw] + " - " + day + "/" + month + "/" + year
    if (document.getElementById('divHeaderTime') != null)
        document.getElementById('divHeaderTime').innerHTML = time;
}

function showHide(img, content) {
    var divContent = document.getElementById(content);
    var divImage = document.getElementById(img);
    if (divContent != null) {
        if (divContent.className == 'divExpand') {
            divContent.className = 'divCollapse';
            divImage.src = '/images/bullet_2.png';
        }
        else {
            divContent.className = 'divExpand';
            divImage.src = '/images/bullet_1.png';
        }
    }
}
*/
function trunc(i) {
    var j = Math.round(i * 100);
    return Math.floor(j / 100) + (j % 100 > 0 ? "." + p(j % 100) : "");
}

function calculate(date1, date2) {
    var date1 = new Date(date1);
    var date2 = new Date(date2);
    var sec = date2.getTime() - date1.getTime();
    if (isNaN(sec)) {
        return 0;
    }
    if (sec < 0) {
        return 0;
    }

    var second = 1000, minute = 60 * second, hour = 60 * minute, day = 24 * hour;
    return trunc(sec / second);
    var days = Math.floor(sec / day);
    sec -= days * day;
    var hours = Math.floor(sec / hour);
    sec -= hours * hour;
    var minutes = Math.floor(sec / minute);
    sec -= minutes * minute;
    var seconds = Math.floor(sec / second);
    return seconds;
}
