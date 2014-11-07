
<link type="text/css" rel="stylesheet" href="<?=base_url()?>components/vfile/views/esset/css/vfile.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?=base_url()?>templates/css/popup.css?v=2.0" media="screen" />
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>templates/js/core/popup.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/rightClick.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/jquery.contextMenu.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/treeview.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/vfile.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/swfobject.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
CKEditor = {};
CKEditor.funcNum = 2;
var opener_windows = '<?=$this->uri->segment(3)?>';
</script>
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
<div class="vfile-content">
    <div class="vfile-left">
        <div class="vfile-folder" style="height: 204px;">
            <div align="center" id="block_upload"></div>
            <div id="file_uploadQueue" class="uploadifyQueue"></div>
        </div>

        <div class="vfile-folder" style="height: 200px; overflow: auto;" id="tree_view">

            <?=$this->vfile->dir_vfile();?>
        </div>
    </div>
    <div class="vfile-right">
        <div id="toolbar">
            <a href="javascript:;" onclick="refresh_page();" class="refresh">Làm mới trang</a>
            <div >URL<input type="text" id="urlfile" style="width: 400px;"></div>
        </div>
        <div class="vfile-folder" style="height: 385px;overflow: auto;">
            
            <div id="gallery_picture">
            </div>
        </div>
    </div>
</div>
<ul id="myMenu" class="contextMenu">
    <li class="add"><a href="#add">Thêm mới</a></li>
    <li class="edit"><a href="#edit">Cập nhật</a></li>
    <li class="delete separator"><a href="#delete">Xóa</a></li>
    <li class="quit separator"><a href="#quit">Thoát</a></li>
</ul>
<ul id="myfle" class="contextMenu">
    <li class="edit"><a href="#info">Thông tin</a></li>
    <li class="delete"><a href="#delete">Xóa</a></li>
    <li class="quit separator"><a href="#quit">Thoát</a></li>
</ul>
