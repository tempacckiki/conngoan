<?
$this->session->set_userdata('root_dir_thumb',str_replace('data','data/thumbs_',$path));
$this->session->set_userdata('root_dir',$path);
?>
<?
$domain = $_SERVER['HTTP_HOST'];
$root_vfile = str_replace(array('http://wwww.'.$domain,'http://'.$domain,'foldersystemcpanel/'),array('','',''),base_url()).$path;
?>
<script type="text/javascript">
    var root_vfile = '<?=$root_vfile.$path?>';
</script>
<input type="hidden" id="dir_vfile" value="<?=$path?>">
<?php
$ar_text = array('../','data');
$ar_replace = array('','data/thumbs_');
$ar_type_img = array('jpg','jpeg','gif','bmp','png');
$dir = ROOT.$path;

if($handle = opendir($dir))
{
    while($file = readdir($handle))
    {
        if ($file != "." && $file != "..") {
        clearstatcache();
        if(is_file($dir.'/'.$file)){
            $type_img = strtolower(end(explode('.',$file)));
        if($type_img =='jpg' || $type_img =='jpeg' || $type_img == 'jpg' || $type_img =='png' || $type_img =='gif'){
            $dir_file = base_url_site().str_replace($ar_text,$ar_replace,$dir).'/'.$file;
        }else{
            $dir_file = base_url().'components/vfile/views/esset/files/big/'.$type_img.'.png';
        }

            ?>
                <!--<a href="javascript:;" id="dbclick" onclick="add_to_editor('<?=$root_vfile.'/'.$file?>')">-->
                <a href="javascript:;" rel="<?=$root_vfile.'/'.$file?>" class="dbclick">
                <div class="file">
                <div style="background-image:url('<?=$dir_file?>')" class="thumb"></div>
                <div class="name" style="display: block;"><?=$file?></div>  

                </div>
                </a>

        <?}
        }
    }
    closedir($handle);
}

?> 
<script type="text/javascript">
 var file ='';
 $(document).ready(function() {
     
     /**************
     * Click And DBclick
     */
    var clicktimer;
    var e_click;
    var id_click;
     
    $('a.dbclick').live('click', function(ev)
    {
        file = $(this).attr('rel');
        var browser=navigator.appName;
        var b_version=navigator.appVersion;
        var version=parseFloat(b_version);
        $("div.file").css({
            'background-color': '#FFFFFF',
            'border-color': '#AAAAAA',
            'color': '#333333'
        });
        $(this).find("div.file").css({
            'background-color': '#5B9BDA',
            'border-color': '#2973BD',
            'color': '#FFFFFF'
        });
        e_click = ev;
        id_click = this.id;
        clicktimer = window.setTimeout(function () {
            if(e_click)
            {
                SingleClickAction(file);
                clearTimeout(clicktimer);
                clicktimer = null;
            }}, 300);

    }).dblclick(function(ev)
    {        
        window.clearTimeout(clicktimer);        
        e_click = null;
        id_click = null;
        DoubleClickAction($(this).attr('rel'));    
    });
  /****************
  * Upload FIle
  */
  $('#file_upload').uploadify({
    onComplete: function (evt, queueID, fileObj, response, data){
        if(response != null){
            ar_file = response.split("|");
            if(ar_file[2] == 'jpg' || ar_file[2] == 'png' || ar_file[2] == 'gif' || ar_file[2] == 'jpeg' ){
                dir_file = ar_file[0];
            }else{
                dir_file =  base_url+'components/vfile/views/esset/files/big/'+ar_file[2]+'.png';
            }
            var html ='<a href="javascript:;" class="dbclick" rel="'+ar_file[3]+'">';
                html += '<div class="file">';
                html +='<div style="background-image:url(\''+dir_file+'\')" class="thumb"></div>' ;
                html +='<div class="name" style="display: block;">'+ar_file[1]+'</div>' ;
                html +='</div>';
                html +='</a>';
            $("#gallery_picture").prepend(html);
        }
    },
    'uploader'  : base_url+'components/vfile/views/esset/swf/uploadify.swf',
    'script'    : base_url+'vfile/vupload',
    'cancelImg' : base_url+'components/vfile/views/esset/images/cancel.png',
    'buttonImg' : base_url+'components/vfile/views/esset/images/browse_file_upload.gif',
    'removeCompleted' : true,
    'folder'    : '<?=$this->session->userdata('root_dir')?>',
    'width': 130,
    'queueID'        : 'file_uploadQueue',
    'queueSizeLimit' : 100,
    'scriptAccess'  : 'always',
    'scriptData': { 'root_dir': '<?=$this->session->userdata('root_dir')?>','root_dir_thumb':'<?=$this->session->userdata('root_dir_thumb')?>', 'session_id': '<?=$this->session->userdata('session_id')?>'}, 
    'fileDesc'  : '*.jpg;*.gif;*.png,*.zip,*.rar,*.doc,*.xls,*.pdf,*.avi,*.mp3,*.flv',
    'fileExt'  : '*.jpg;*.gif;*.png;*.zip;*.rar;*.doc;*.xls;*.pdf;*.avi;*.mp3;*.flv',
    'sizeLimit'  : (204800 * 1024),
    'multi'          : true,
    'auto'      : true
  });
  
    $("a.dbclick").contextMenu({
        menu: 'myfle'
    },
    function(action, el, pos) {
        file = $(el).attr('rel');
        if(action=='delete'){
            $.post(base_url+"vfile/delete",{'file':file},function(data){
                if(data.error == 0){
                    $(el).remove();
                }                                          
            },'json');
        }
    });

});

function SingleClickAction(file){
   $("#urlfile").val(file);
}
function DoubleClickAction(file){
    if(opener_windows==1){
        var img = new Image();
        img.src = file;
        img.onload = function() {
            base_url_str = base_url.replace('http://'+document.domain,'');
            base_url_str = base_url_str.replace('foldersystemcpanel/','');
            window.opener.document.getElementById("news_img").value =file.replace(base_url_str,'');
            window.opener.document.getElementById("image").innerHTML = '<img id="img" src="' + file + '" />';
            window.close();
        }
    }else{
        var fileURL =file;
        window.opener.CKEDITOR.tools.callFunction(CKEditor.funcNum,fileURL);
        window.close();
    }
}
</script>