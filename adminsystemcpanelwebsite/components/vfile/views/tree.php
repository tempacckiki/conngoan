<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/treeview.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/vfile.js"></script>
<script type="text/javascript">
    $(document).ready( function() {
        // Show menu when a list item is clicked
        $("ul#browser li").contextMenu({
            menu: 'myMenu'
        }, function(action, el, pos) {
            id = $(el).attr('id');
            if(action=='add'){
                content_edit ='<form action="#">';
                        content_edit +='<div style="width:350px;padding:5px">';
                            content_edit +='<div>Thư mục gốc <select id="parentid"><option value="1">images</option><option value="2">file</option><option value="3">media</option></select></div>';
                            content_edit +='<div>Tên thư mục <input type="text" id="foler_name" value="" style="width:200px"><input  type="button" onclick="save_add()" value="Lưu"></div>';
                        content_edit +='</div>';
                        content_edit +='</form>';
                vnit_pop('Thêm mới thư mục',content_edit);                                          
            }else if(action=='edit'){
                $.post(base_url+"vfile/edit_folder",{'id':id},function(data){
                    content_edit ='<form action="#">';
                            content_edit +='<div style="width:350px;padding:5px"><input type="hidden" id="vfile_id" value="'+data.id+'">';
                            content_edit +='<div>Tên thư mục <input type="text" id="foler_name" name="foler_name" value="'+data.name+'" style="width:200px"><input type="button" onclick="save_edit()" value="Lưu"></div>';
                            content_edit +='</div>';
                            content_edit +='</form>';
                    vnit_pop('Cập nhật thư mục',content_edit);                                          
                },'json');
            }else if(action == 'delete'){
                $.post(base_url+"vfile/delete_folder",{'id':id},function(data){     
                    if(data.error == 0){
                        path = 'data/images';
                        $("#block_upload").html('');
                        $("#block_upload").html('<input id="file_upload" name="file_upload" type="file" />');
                        $.post(base_url+"vfile/get_dir",{'path':path},function(data){
                            $("#root_dir").val('data/'+path);
                            path_thumb = 'data/thumbs_/'+path;
                            $("#root_dir_thumb").val(path_thumb);
                            $("#gallery_picture").html(data);                                            
                        });
                        load_tree();
                    } 
                    jAlert(data.msg);
                },'json');
            }
        });
    });
</script>
<?=$this->vfile->dir_vfile();?>
