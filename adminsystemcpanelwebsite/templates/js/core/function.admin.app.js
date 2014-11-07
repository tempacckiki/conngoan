function show_v(){
    $("#ajax-load").show();
    $("#overlay-popup").show();
}
function hide_v(){
    $("#ajax-load").hide();
    $("#overlay-popup").hide();
}
$(document).ready(function() {
    hide_msg();  
    /******************
    * Show - Hien Panel
    */
    $('.title').click(function() {
        var display = $(this).attr('display');

        $(".panel_content").slideUp();
        $(".title").removeClass('vpanel_arrow_down');
        $(".title").addClass('vpanel_arrow');
        $(this).removeClass('vpanel_arrow');
        $(this).addClass('vpanel_arrow_down');
        $("#"+$(this).attr('id')+"_content").slideDown();

        
    });
 
});
// Ẩn. Hiển thị Menu trái
function clickHide(type){
    if (type == 1){
        $('td.colum_left_lage').css('display','none');
        $('td.colum_left_small').css('display','table-cell');
    }
    else {
        if (type == 2){
            $('td.colum_left_small').css('display','none');
            $('td.colum_left_lage').css('display','table-cell');
        }
    }
}
// show or hide menu
function show_menu(){
    var showmenu = ( nv_getCookie( 'colum_left_lage' ) ) ? ( nv_getCookie('colum_left_lage')) : '1';
    if (showmenu == '1') {
        $('td.colum_left_small').hide();
        $('td.colum_left_lage').show();
    }else {
        $('td.colum_left_small').show();
        $('td.colum_left_lage').hide();
    }
}

// Ẩn thông báo

function hide_msg(){
    setTimeout(RemoveMes, 5000);    
}
// Ham An noi dung thong bao
function RemoveMes(){
    var id_msg = $("#msg");
    if(id_msg.length > 0){
        $("#msg").slideUp("fast", function() {
            $(this).hide();
        });        
    }
}
// SET checkbox, uncheck
function setCheckboxes(the_form, id, do_check)
{
    var elts      = (typeof(document.forms[the_form].elements[id]) != 'undefined')
                  ? document.forms[the_form].elements[id]
                  : 0;
    var elts_cnt  = (typeof(elts.length) != 'undefined')
                  ? elts.length
                  : 0;

    if (elts_cnt) {
        for (var i = 0; i < elts_cnt; i++) {
            elts[i].checked = do_check;
        }
    } else {
        elts.checked        = do_check;
    }
return true; 
}

function check_chose(id, arid, the_form)
{
    var n = $('#'+id+':checked').val();
    if(n)
        setCheckboxes(the_form, arid, true);
    else
        setCheckboxes(the_form, arid, false);
}

/************************
*  Begin Tool Bar
***************************/
// Action save
function action_save()
{
    $('#admindata').append('<input type="hidden" name="option" value="save">');
    $('#admindata').submit();
   return true;
}

// Action save
function action_apply()
{
    $('#admindata').append('<input type="hidden" name="option" value="apply">');
    $('#admindata').submit();
   return true;
}

// Ajax hien thi trang thai cua ban ghi
function publish(table,field,id,status,link){
    $("#publish"+id).html('<image src="'+base_url+'templates/images/loading1.gif">');
    $.post(base_url+"api/publish/",{'table':table,'field':field,'id':id,'status':status,'link':link},function(data)
    {
        $("#publish"+id).html(data);                                               
    });     
}

function action_del()
{
    var res;
    var checked = $('input[type=checkbox]').is(':checked');
    if(!checked){
        jAlert('Vui lòng chọn một mục để xóa','Thông báo');
        return false;
    }else{    
        jConfirm('Bạn có chắc chắn muốn xóa  mục đã chọn.<br />Chọn <b>Đồng ý</b> hoặc <b>Không đồng ý</b>','Thông báo',function(r) {
          if(r){
              $('#admindata').submit();
          }
        });
        return false;
    }
}
/************************
*  End Tool Bar
***************************/

function change_feature(feature_id){
    var_id = $("#feature_"+feature_id).val();
    if(var_id=='select_disable'){
        $("#input_"+feature_id).show();
    }else{
        $("#input_"+feature_id).hide();
    }
}

$(function() {   
    var link = '';
    $('.delete_record').click(function() {
        link = $(this).attr('href');
        if(link !=''){
            jConfirm('Bạn có chắc chắn muốn xóa mục đã chọn.<br />Chọn <b>Đồng ý</b> hoặc <b>Hủy bỏ</b>','Thông báo',function(r) {
                if(r){
                  window.location.href = link;
                }
            });           
        }
        return false;
    });
      
});
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

// Format Money
function format_money(Amount){
    var DecimalSeparator = Number("1.2").toLocaleString().substr(1,1);

    var AmountWithCommas = Amount.toLocaleString();
    var arParts = String(AmountWithCommas).split(DecimalSeparator);
    var intPart = arParts[0];
    var decPart = (arParts.length > 1 ? arParts[1] : '');
    decPart = (decPart + '00').substr(0,0);

    return intPart /*+ DecimalSeparator + decPart;*/;

};
// String Replace
function str_replace (search, replace, subject, count) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Gabriel Paderni
    // +   improved by: Philip Peterson
    // +   improved by: Simon Willison (http://simonwillison.net)
    // +    revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // +   bugfixed by: Anton Ongson
    // +      input by: Onno Marsman
    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +    tweaked by: Onno Marsman
    // +      input by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   input by: Oleg Eremeev
    // +   improved by: Brett Zamir (http://brett-zamir.me)
    // +   bugfixed by: Oleg Eremeev
    // %          note 1: The count parameter must be passed as a string in order
    // %          note 1:  to find a global variable in which the result will be given
    // *     example 1: str_replace(' ', '.', 'Kevin van Zonneveld');
    // *     returns 1: 'Kevin.van.Zonneveld'
    // *     example 2: str_replace(['{name}', 'l'], ['hello', 'm'], '{name}, lars');
    // *     returns 2: 'hemmo, mars'
    var i = 0,
        j = 0,
        temp = '',
        repl = '',
        sl = 0,
        fl = 0,
        f = [].concat(search),
        r = [].concat(replace),
        s = subject,
        ra = Object.prototype.toString.call(r) === '[object Array]',
        sa = Object.prototype.toString.call(s) === '[object Array]';
    s = [].concat(s);
    if (count) {
        this.window[count] = 0;
    }

    for (i = 0, sl = s.length; i < sl; i++) {
        if (s[i] === '') {
            continue;
        }
        for (j = 0, fl = f.length; j < fl; j++) {
            temp = s[i] + '';
            repl = ra ? (r[j] !== undefined ? r[j] : '') : r[0];
            s[i] = (temp).split(f[j]).join(repl);
            if (count && s[i] !== temp) {
                this.window[count] += (temp.length - s[i].length) / f[j].length;
            }
        }
    }
    return sa ? s : s[0];
}

// Set language

function set_lang(lang){
    $.post(base_url+"api/setlang/",{'lang':lang},function(data){
      window.location.href = base_url+'admincp';   
    });     
}
// Openr Images
// Openr Images
function openKCFinder(div) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
            div.innerHTML = '<div style="margin:5px">Đang tải ảnh...</div>';
            var img = new Image();
            img.src = url;
            img.onload = function() {
                div.innerHTML = '<img id="img" src="' + url + '" />';
                base_url_str = base_url.replace('http://'+document.domain,'');
                base_url_str = base_url_str.replace('admin/','');
                $("#news_img").val(url.replace(base_url_str,''));
                var img = document.getElementById('img');
                var o_w = img.offsetWidth;
                var o_h = img.offsetHeight;
                var f_w = div.offsetWidth;
                var f_h = div.offsetHeight;
                if ((o_w > f_w) || (o_h > f_h)) {
                    if ((f_w / f_h) > (o_w / o_h))
                        f_w = parseInt((o_w * f_h) / o_h);
                    else if ((f_w / f_h) < (o_w / o_h))
                        f_h = parseInt((o_h * f_w) / o_w);
                    //img.style.width = f_w + "px";
                    //img.style.height = f_h + "px";
                } else {
                   // f_w = o_w;
                   // f_h = o_h;
                }
                //img.style.marginLeft = parseInt((div.offsetWidth - f_w) / 2) + 'px';
                //img.style.marginTop = parseInt((div.offsetHeight - f_h) / 2) + 'px';
                img.style.visibility = "visible";
            }
        }
    };
    window.open(base_url+'templates/ckeditor/kcfinder/browse.php?type=images&dir=images/news',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=800, height=600'
    );
}
/*
function openKCFinder(div) {
    window.open(base_url+'vfile/vfile_dir/1',
        'kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +
        'directories=0, resizable=1, scrollbars=0, width=830, height=440'
    );
} */

//
function load_show(){
    $("#ajax-load").fadeIn();
    $("#overlay-popup").show();
}

function load_hide(){
    $("#ajax-load").fadeOut();
    $("#overlay-popup").hide();
}
                
function insertReadmore(editor) {
    contents =  cke.getData();
    if (contents.match(/<hr\s+id=(\"|')system-readmore(\"|')\s*\/*>/i)) {
        alert('Đọc thêm đã được thêm vào');
        return false;
    } else {
        jInsertEditorText('<hr id=\"system-readmore\" />', editor);
    }
}
function jInsertEditorText( text,editor ) {
    CKEDITOR.instances[editor].insertHtml( text);
}

