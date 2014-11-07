<?php echo form_open(uri_string(), array('id'=>'admindata'));
$rand = rand(5,1000);
?>
<input type="hidden" name="cat_id" value="0">
<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input class="w250" type="text" name="video[video_title]" value="<?php echo set_value('video[video_title]')?>"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="radio" name="video[published]" value="0" <?php echo (set_value('video[published]') == 0)?'checked="checked"':'';?>> Không <input type="radio" name="video[published]" value="1" <?php echo (set_value('video[published]') == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this)">
                <img src="<?=base_url()?>templates/images/no-img.png" alt="">
            </div>
            <input type="hidden" name="video[video_img]" id="news_img" value="<?=set_value('images')?>">        
        </td>
    </tr>
    <tr>
        <td class="label">Link video</td>
        <td>
            <div>
                <input type="radio" name="tuychon" onclick="change_video('file')" <?php echo set_radio('tuychon', 'file', TRUE); ?> value="file">File
                <input type="radio" name="tuychon" onclick="change_video('url')"  <?php echo set_radio('tuychon', 'url'); ?> value="url">Url
            </div>
            <?$tuychon = set_value('tuychon');?>
            <div id="file" <?php echo ($tuychon=='file')?'style="display: block;"':'style="display: block;"'?>>
                <div style="cursor: pointer;padding: 10px 0px;" id="image" onclick="openfile(this)">
                    <b>Click để chọn video</b>
                </div>
                <div id="mediaspace<?php echo $rand?>"></div> 
                <input type="hidden" name="video_link" id="link_video" value="<?=set_value('video_link')?>">  
            </div>
            <div id="url" <?php echo ($tuychon=='url')?'style="display: block;"':'style="display: none;"'?>>
                <input type="text" name="video_url" class="w300" value="<?=set_value('video_url')?>">    
            </div>
        </td>
    </tr>
</table>
<?php echo form_close();?>
<script type='text/javascript'>
<?php 
$flashplayer = base_url().'templates/video/player.swf';
$skin = base_url().'templates/video/dangdang.swf';
$file = base_url_site().'data/media/demo.flv';
$skin ='';
$image = '';
$width = '242';
$height = '200';
$flashvideo ='  var so = new SWFObject(\''.$flashplayer.'\',\'mpl\',\''.$width.'\',\''.$height.'\',\'9\');
          so.addParam(\'allowfullscreen\',\'true\');
          so.addParam(\'allowscriptaccess\',\'always\');
          so.addParam(\'wmode\',\'opaque\');
          so.addVariable(\'controlbar.position\',\'over\');
          so.addVariable(\'stretching\',\'fill\');
          so.addVariable(\'autostart\',\'false\');
          so.addVariable(\'repeat\',\'always\');
          so.addVariable(\'file\',\''.$file.'\');
          so.addVariable(\'image\',\''.$image.'\');
          so.addVariable(\'skin\',\''.$skin.'\');
          var vnit = null;
          function playerReady(thePlayer) {
             vnit = window.document[\'mpl\'];
           }';
        echo $flashvideo;    
    ?>
</script>

<script type="text/javascript">
    function change_video(tuychon){
        if(tuychon == 'file'){
            $("#file").slideDown();
            $("#url").slideUp();
        }else{
            $("#file").slideUp();
            $("#url").slideDown();            
        }
    }
    
// Openr Images
function openfile(div) {
    window.KCFinder = {
        callBack: function(url) {
            window.KCFinder = null;
                base_url_str = base_url.replace('http://'+document.domain,'');
                base_url_str = base_url_str.replace('admin/','');
                $("#link_video").val(url.replace(base_url_str,''));
                playvideo(base_url_site + url.replace(base_url_str,''));

        }
    };
    window.open(base_url+'templates/ckeditor/kcfinder/browse.php?type=media','kcfinder_image', 'status=0, toolbar=0, location=0, menubar=0, ' +'directories=0, resizable=1, scrollbars=0, width=800, height=600');
}  
function playvideo(filename){   
    vnit.sendEvent('STOP');
    vnit.sendEvent('LOAD', filename);
    vnit.sendEvent('VOLUME', 50);
    vnit.sendEvent('PLAY');      
}     
</script>
<script type="text/javascript">
    so.write('mediaspace<?php echo $rand?>');
</script>

