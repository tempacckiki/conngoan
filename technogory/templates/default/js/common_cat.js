$(document).ready(function(){
    $('input:checkbox[name=compare_id]').removeAttr('checked');
    $("#productCompareList").val(';');
    
    // Danh sach san pham theo thuoc tinh san pham
    $(".variant").click(function(){
       // show_loading();
        var hot = $("#vnit_hot").val();
        var view = $("#vnit_view").val();
        var order = $("#vnit_order").val(); 
        var variant = ar_variant();
       
        var color = get_color();
        var manuf = get_manuf(); 
        
      
       $.post(site_url+"api/ajax_filter", {"manufactureid": manuf,"color":color,"variant":variant,'catid':catid},function(data){  
    	   
    	   
    	   if(data.idManuface >0){
    		   window.open(site_url+"Hang-san-xuat/"+data.name_url+"-"+data.idManuface+"/"+data.catid+".html"+data.input_get,'_self');
    		   
    	   }else if(data.idVarian >0){
    		   window.open(site_url+"Tinh-nang/"+data.name_url+"-"+data.idVarian+"/"+data.catid+".html",'_self');
    		   
    	   }else{
    		   window.open(site_url+"category/"+cat_current_url+"/"+cat_current_id+".html",'_self');
    	   }
       },'json');
    });
    
    // Onlick in manufacture
    $(".manuf").click(function(){
       // show_loading();
        var hot = $("#vnit_hot").val();
        var view = $("#vnit_view").val();
        var order = $("#vnit_order").val(); 
        var variant = ar_variant();
       
        var color = get_color();
        if($(this).is(':checked')){
            var manuf = $(this).val(); 
        }else{
            var manuf = 0;
        }
        
      
       $.post(site_url+"api/ajax_manuf", {"manufactureid": manuf,"color":color,"variant":variant,'catid':catid},function(data){  
           
           if(data.maincat == 1){
               window.open(site_url+"Hang-san-xuat/"+data.name_url+"-"+data.idManuface+"/"+data.catid+".html",'_self');
           }else{
               window.open(site_url+"category/"+cat_current_url+"/"+cat_current_id+".html",'_self');
           }
       },'json');
    });

});

function ar_variant(){
    var selectedValues = '';
    var arttTite	   = '';
    var strAttr		   = '';
    $checkedCheckboxes = $("input:checkbox[name=variant]:checked");
    $checkedCheckboxes.each(function() {
    	//arttTite 		= $(this).attr("title");    	
        selectedValues  +=  $(this).val()+',';
    });
    strAttr     = selectedValues;// +','+arttTite;
    return strAttr;
}



function get_manuf(){
    var selectedValues = '';
    var arttTite	   = '';
    var strAttr		  = '';
    $checkedCheckboxes = $("input:checkbox[name=manuf]:checked");
  
    $checkedCheckboxes.each(function() {
    	//arttTite 		= $(this).attr("title");    	
        selectedValues  +=  $(this).val();
    });
    strAttr     = selectedValues;// +','+arttTite;
    return strAttr;
}

function get_color(){
    var selectedValues = '';
    var arttTite	   = '';
    var strAttr		  = '';
    $checkedCheckboxes = $("input:checkbox[name=color]:checked");
    $checkedCheckboxes.each(function() {
    	//arttTite 		= $(this).attr("title");  
        selectedValues +=  $(this).val()+',';
    });
    strAttr     = selectedValues; // +','+arttTite;
    return strAttr;
  
}

// Sap xep san pham

function change_order(order){
    show_loading(); 
    var hot = $("#vnit_hot").val();
    var view = $("#vnit_view").val();
    var variant = ar_variant();
    var manuf = get_manuf();
    
    $.post(site_url+"category/get_page_cat.html"+input_get, {"catid": catid,"hot":hot,"order":order,"view":view,'page_no':1,'variant':variant, 'manufacture':get_manuf},function(data){
        $("#vnit_page_cat").html(data);          
        hide_loading();
    });    
}
function change_hot(hot){
    show_loading();  
    var order = $("#vnit_order").val();
    var view = $("#vnit_view").val();
    var variant = ar_variant();
    var manuf = get_manuf();
    $.post(site_url+"category/get_page_cat.html"+input_get, {"catid": catid,"hot":hot,"order":order,"view":view,'page_no':1 ,'variant':variant, 'manufacture':get_manuf},function(data){
        $("#vnit_page_cat").html(data);         
        hide_loading();
    });    
}

function change_view(view){
    show_loading();  
    var hot = $("#vnit_hot").val();
    var order = $("#vnit_order").val();
    var variant = ar_variant();
    var manuf = get_manuf();
    $.post(site_url+"category/get_page_cat.html"+input_get, {"catid": catid,"hot":hot,"order":order,"view":view,'page_no':1,'variant':variant, 'manufacture':get_manuf },function(data){
        $("#vnit_page_cat").html(data);           
        hide_loading();
    });    
}
function catpage(page_no){
    show_loading();     
    var hot = $("#vnit_hot").val(); 
    var order = $("#vnit_order").val();
    var view = $("#vnit_view").val();
    var variant = ar_variant();
    var manuf = get_manuf();
    $.post(site_url+"category/get_page_cat.html"+input_get, {"catid": catid,"hot":hot,"order":order,"view":view,'page_no':page_no ,'variant':variant, 'manufacture':get_manuf},function(data){
        $("#vnit_page_cat").html(data);         
        hide_loading();
    });    
}

function catpageManufac(page_no){	
    show_loading();
    alert(catid);
    var hot = $("#vnit_hot").val(); 
    var order = $("#vnit_order").val();
    var view = $("#vnit_view").val();
    var variant = ar_variant();
    var manuf = get_manuf();
    $.post(site_url+"manufaceture/get_page_cat.html"+input_get, {"catid": catid,"hot":hot,"order":order,"view":view,'page_no':page_no ,'variant':variant, 'manufacture':get_manuf},function(data){
        $("#vnit_page_cat").html(data);         
        hide_loading();
    });    
}

// Them san pham vao muc so sanh

function addCompareList(productId) {
    // alert("Bạn chỉ có thể so sánh tối đa 3 sản phẩm\nDanh sách đã có đủ 3");
    var checked = document.getElementById("compareItem_" + productId).checked;
    var currentList = document.getElementById("productCompareList").value;
    var currentNumItem = currentList.split(";").length - 2;
    var productImageUrl = document.getElementById("productHiddenImage_" + productId).value;
    var iconHtml = "<img src=\"" + productImageUrl + "\" width=30>";
    if (checked) {
        if (currentNumItem > 2) {
            //Cho phep so sánh tối đa 3 sản phẩm
            document.getElementById("compareItem_" + productId).checked = "";
            alert("Bạn chỉ có thể so sánh tối đa 3 sản phẩm\nDanh sách đã có đủ 3");
        }
        else {
            document.getElementById("productCompareList").value = currentList + productId + ";";
            //Thêm tiếp ảnh
            nextContainer = currentNumItem + 1;
            document.getElementById("compareItemContain_" + nextContainer).innerHTML = iconHtml;
            document.getElementById("compareItemContain2_" + nextContainer).innerHTML = iconHtml;
            document.getElementById("productItemContain_" + nextContainer).value = productId;
        }
    } else {
        document.getElementById("productCompareList").value = currentList.replace(";" + productId + ";", ";");
        //Xóa bỏ ảnh
        var containId = 0;
        for (var i = 1; i <= currentNumItem; i++) {
            var productContainer = document.getElementById("productItemContain_" + i).value;
            if (productContainer != "") {
                if (productId == productContainer) {
                    document.getElementById("compareItemContain_" + i).innerHTML = "";
                    document.getElementById("compareItemContain2_" + i).innerHTML = "";
                    document.getElementById("productItemContain_" + i).value = "";
                    containId = i;

                    break;
                }
            }
        }
        //Sắp xếp lại ảnh
        if (containId != 0) {
            arrangeImageContainer(containId, 3);
        }
    }
}

//Sắp xếp lại ảnh trong các container đảm bảo các ảnh từ 1 -> n
//startId là ID của container có ảnh bị remove, do đó cần được bù bằng ảnh khác nằm ở container lớn hơn gần nhất nếu có
//rồi lặp lại quá trình này cho container vừa bị lấy ảnh

function arrangeImageContainer(startId, maxNum) {
    var nextStartId = 0;
    for (var i = startId + 1; i <= maxNum; i++) {
        var contentHtml = document.getElementById("compareItemContain_" + i).innerHTML;
        var productContainer = document.getElementById("productItemContain_" + i).value;
        if (contentHtml.length > 2) {
            document.getElementById("compareItemContain_" + startId).innerHTML = contentHtml;
            document.getElementById("productItemContain_" + startId).value = productContainer;
            document.getElementById("compareItemContain_" + i).innerHTML = "";
            document.getElementById("compareItemContain2_" + i).innerHTML = "";
            document.getElementById("productItemContain_" + i).value = "";
            nextStartId = i;
            arrangeImageContainer(nextStartId, maxNum);
            break;
        }
    }
}

function goComparePage(categoryId) {
    var compareList = document.getElementById("productCompareList").value;
    var numberProduct = compareList.split(';').length;
    if (numberProduct > 3) {
        var re_href = window.location.href;
        re_href = re_href.replace('#&Filter', '&Filter');
        window.location.href = site_url+"compare/action/?list=" + compareList + "&categoryid=" + categoryId + "&teturnurl=" + re_href + "";
        // alert(numberProduct);
    } else {
        alert("Bạn cần chọn ít nhất 2 sản phẩm để so sánh\nChọn sản phẩm bằng tích ô dưới ảnh sản phẩm");
    }
}
