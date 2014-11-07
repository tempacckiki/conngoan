<script type="text/javascript" src="<?=base_url()?>templates/js/shop_upload.js?v=2.0" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>templates/css/photo.css?v=2.0" media="screen" />
<?=form_open(uri_string(),  array('id' => 'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Chuyên mục</td>
        <td>
            <select name="catid" class="w250">
            <?foreach($listcat as $val):?>
            <option value="<?=$val->catid?>" <?=($rs->catid ==$val->catid)?'selected="selected"':''?>><?=$val->catname?></option>
            <?endforeach;?>
            </select>
        </td>
    <tr> 
    <tr>
        <td class="label">Tên Album</td>
        <td><input type="text" class="w400" name="album_name" value="<?=$rs->album_name?>"></td>
    <tr>
    <tr>
        <td class="label">Hình đại diện</td>
        <td>
            <div id="main_img">
            <?if($rs->album_img==''){?>
                Click hình tải lên để làm hình đại diện cho Album
            <?}else{?>
                <img src="<?=base_url_site()?>data/album/210/<?=$rs->album_img?>"width="85" height="85">
            <?}?>
            </div>
            <input type="hidden" id="productimg" value="<?=$rs->album_img?>" name="album_img">
        </td>
    </tr>     
    <tr>
        <td class="label">Tải hình ảnh</td>
        <td>
            <div id="upload_button"><span>Chọn File Upload<span></div>
            <div id="status_message"></div>   
            <ul id="list_img">
            <?foreach($listimg as $img):?>
                <li class="success" id="li_<?=$img->imageid?>">
                    <div align="center">
                        <img width="85" height="85" src="<?=base_url_site()?>data/album/500/<?=$img->imagepath?>" onclick="chosen(<?=$img->imageid?>)">
                        <a class="delete_button" id="<?=$img->imageid?>" href="javascript:;" onclick="del_img(<?=$img->imageid?>)"> Xóa</a>
                        <span style="display: none;" id="v<?=$img->imageid?>"><?=$img->imagepath?></span>
                    </div>
                </li>
            <?endforeach;?>                                
            </ul>                                             
        </td>
    </tr>    
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="IsActive" value="1" <?=($rs->IsActive==1)?'checked="checked"':'';?>></td>
    </tr>

</table>
<?=form_close();?>
<script type="text/javascript">
 function del_img(id){
    jConfirm('Bạn có chắc chắn muốn xóa  mục đã chọn.<br />Chọn <b>Đồng ý</b> hoặc <b>Không đồng ý</b>','Thông báo',function(r) {
    if(r){
        var dataString = 'id='+ id ;  
        $.ajax({
               type: "POST",
               url: base_url + "photo/del_file",
               data: dataString,
               cache: false,
               dataType: "json",
               success: function(data){
                   if(data.error==0){
                    $("#li_"+id).remove();
                   }
                   
                
              }   
        });
    }
    });
    return false;
 }
 function chosen(id){
    if(id){
        var vl = $('#v'+id).text();
        $('#productimg').val(vl);
        $('#main_img').html('<img src="' + base_url_site +'data/album/210/' + vl + '" width="85" height="85" />');
    }
    else{
        return false;
    }
} 
           
</script>
<script type="text/javascript" >
    $(function(){
        var btnUpload=$('#upload_button');
        var status=$('#status_message');
        new AjaxUpload(btnUpload, {
            action: base_url+'photo/uploader/<?=$rs->albumid?>',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(jpg|png|jpeg|gif|)$/.test(ext))){ 
                    status.text('File cho phép Upload JPG, PNG, JPEG, GIF');
                    return false;
                }
                status.text('Đang tải File lên. Vui lòng đợi');
            },
            onComplete: function(file, response){ 
                status.text('');
                if(response!="error"){
                var str = response;
                var exploded = str.split(',');
                    $('<li id="li_'+exploded[0]+'"></li>').appendTo('#list_img').html('<div  align="center"><img  onclick="chosen('+exploded[0]+')" src="'+base_url_site+'data/album/500/'+exploded[1]+'" width="85" height="85"><a href="javascript:;" onclick="del_img('+exploded[0]+')" id="'+exploded[0]+'" class="delete_button"> Xóa</a><span id="v'+exploded[0]+'" style="display: none;">'+exploded[1]+'</span></div>').addClass('success');
                } else{
                    $('<li></li>').appendTo('#list_img').text(file).addClass('error');
                }
            }
        }); 
    });
</script>
