<?php echo form_open(uri_string(), array('id'=>'admindata'));
$rand = rand(5,1000);
?>
<input type="hidden" name="id" value="<?=$rs->video_id?>">
<table class="form">
    <tr>
        <td class="label">Tiêu đề</td>
        <td><input class="w250" type="text" name="video[video_title]" value="<?php echo $rs->video_title?>"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="radio" name="video[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không <input type="radio" name="video[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'checked="checked"';?>>Có</td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <div id="image" class="img_news" onclick="openKCFinder(this)">
            <?if($rs->video_img !=''){?>
                <img src="<?=base_url_site().$rs->video_img?>" alt="">
            <?}else{?>
                <img src="<?=base_url()?>templates/images/no-img.png" alt="">
            <?}?>
            </div>
            <input type="hidden" name="video[video_img]" id="news_img" value="<?=$rs->video_img?>">        
        </td>
    </tr>
    <tr>
        <td class="label">Link video</td>
        <td>
            <div>
                <input type="radio" name="tuychon" onclick="change_video('file')" <?php echo ($rs->tuychon==1)?'checked="checked"':
                '' ?> value="file">File
                <input type="radio" name="tuychon" onclick="change_video('url')"  <?php echo ($rs->tuychon == 0)?'checked="checked"':'' ?> value="url">Url
            </div>
            <?$tuychon = set_value('tuychon');?>
            <div id="file" <?php echo ($rs->tuychon == 1)?'style="display: block;"':'style="display: none;"'?>>
                <div style="cursor: pointer;padding: 10px 0px;" id="image" onclick="openfile(this)">
                    <b>Click để chọn video</b>
                </div>
                <div id="mediaspace<?php echo $rand?>"></div> 
                <input type="hidden" name="video_link" id="link_video" value="<?=$rs->video_link?>">  
            </div>
            <div id="url" <?php echo ($rs->tuychon == 0)?'style="display: block;"':'style="display: none;"'?>>
                <input type="text" name="video_url" value="<?=$rs->video_url?>" class="w300">    
            </div>
        </td>
    </tr>
</table>
<?php echo form_close();?>
<script type='text/javascript'>
<?php 
$flashplayer = base_url().'templates/video/player.swf';
$skin = base_url().'templates/video/dangdang.swf';
$file = ($rs->video_link =='' && $rs->video_url=='')?base_url_site().'data/media/demo.flv':($rs->tuychon == 1 ) ? base_url_site().$rs->video_link : $rs->video_url;
$skin ='';
$image = base_url_site().$rs->video_img;
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

