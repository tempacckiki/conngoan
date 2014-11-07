$(function() {   
    var link = '';
    $('.delete_button_edit').live("click", function(){   
        idimg = $(this).attr('id');


        if(idimg !=0){
            jConfirm('Bạn có chắc chắn muốn xóa ảnh đã chọn.<br />Chọn <b>Đồng ý</b> hoặc <b>Hủy bỏ</b>','Thông báo',function(r) {
                if(r){
                    $.post(base_url+"daugia/shop/del_img",{'idimg':idimg},function(data){ 
                        if(data.error == 0){
                            $("ul#list_img li#"+idimg).remove();
                        }
                    },'json');
                }
            });           
        }
        return false;
    });
      
});

$(function() {   
    var link = '';
    $('.delete_button').live("click", function(){
        idimg = $(this).attr('id');

        if(idimg !=0){
            jConfirm('Bạn có chắc chắn muốn xóa ảnh đã chọn.<br />Chọn <b>Đồng ý</b> hoặc <b>Hủy bỏ</b>','Thông báo',function(r) {
                $("ul#list_img li#"+idimg).remove();
            });           
        }
        return false;
    });
      
});

function chosen(img){
    if(img){
        $('#productimg').val(img);
        $('#main_img').html('<img src="' + base_url_img +'daugia/200/' + img + '" width="85" height="85" />');
    }
    else{
        return false;
    }
}
function chosen_add(img){
    if(img){
        $('#productimg').val(img);
        $('#main_img').html('<img src="' + base_url_img +'temp/' + img + '" width="80" height="80" />');
    }
    else{
        return false;
    }
}
function get_manufacture(catid){
    $.post(base_url+"product/shop/get_manufacture",{'catid':catid},function(data){
        $("#manufacture").html(data.list);                                            
    },'json');
}

//Them tang pham mien nam

