<script type="text/javascript" src="<?=base_url()?>templates/js/shop_upload.js?v=2.0" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>templates/css/shop.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?=base_url()?>components/import/views/esset/import.css?v=2.0" media="screen" />
<fieldset>
    <legend>Import sản phẩm</legend>
    <table class="tuychon">
        <tr>
            <td>
                Chọn File 
                
            </td>
            <td>
                <div id="upload_button"><span>Chọn File Upload<span></div>
                <div id="status_message"></div>            
            </td>
        </tr>
    </table>
</fieldset>
<div id="filecontent"></div>
<script type="text/javascript" >
    $(function(){
        var btnUpload=$('#upload_button');
        var status=$('#status_message');
        new AjaxUpload(btnUpload, {
            action: base_url+'import/uploader/',
            name: 'uploadfile',
            onSubmit: function(file, ext){
                 if (! (ext && /^(xls|)$/.test(ext))){ 
                    status.text('File cho phép Upload xls');
                    return false;
                }
                status.text('Đang tải File lên. Vui lòng đợi');
            },
            onComplete: function(file, response){ 
                status.text('');
                if(response == "error"){
                    status.text('Tải File lên không thành công');
                }else if(response == 'MAX_SIZE'){
                    status.text('Fil Upload quá lớn');
                }else{
                    
                    dataString = "file="+response;
                    $.ajax({
                        type: "POST",
                        url: base_url+"import/docfile/",
                        data: dataString,
                        dataType: "html",
                        success: function(data) { 
                            $("#filecontent").html(data);

                        }
                    }); 
                                      
                }
            }
        });
        
    });
</script>