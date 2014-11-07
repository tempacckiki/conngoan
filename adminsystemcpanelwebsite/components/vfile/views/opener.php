<link type="text/css" rel="stylesheet" href="<?=base_url()?>components/vfile/views/esset/css/vfile.css?v=2.0" media="screen" />
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/jquery.cookie.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/treeview.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/vfile.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/swfobject.js"></script>
<script type="text/javascript" src="<?=base_url()?>components/vfile/views/esset/js/jquery.uploadify.v2.1.4.min.js"></script>
<script type="text/javascript">
CKEditor = {};
CKEditor.funcNum = 2;
</script>

<div class="vfile-content">
    <div class="vfile-left">
        <div class="vfile-folder" style="height: 204px;">
            <div align="center" id="block_upload"></div>
            <div id="file_uploadQueue" class="uploadifyQueue"></div>
        </div>

        <div class="vfile-folder" style="height: 200px; overflow: auto;">
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
