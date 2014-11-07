<script type="text/javascript" src="<?php echo base_url().'site/views/modules/mod_video/esset/swfobject.js'; ?>"></script>
<script type="text/javascript">
document.write('<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>site/views/modules/mod_video/esset/video.css" media="screen" />');
</script>
<?php     
$flashplayer = base_url().'site/views/modules/mod_video/esset/player.swf';
$skin = base_url().'site/views/modules/mod_video/esset/dangdang.swf';
$rand = rand(5,10);
$width = get_params('w_video',$attr);
$height = get_params('h_video',$attr);
// Ket noi video table
$this->db->order_by('video_id','desc');
$this->db->limit(get_params('v_limit',$attr));
$list = $this->db->get('video')->result();
?>
<?if(count($list) > 0){
    $file = ($list[0]->tuychon ==1) ? base_url().$list['0']->video_link : $list[0]->video_url;
    $image = base_url().$list[0]->video_img;
?>
<script type='text/javascript'>
<?php 
$data ='  var so = new SWFObject(\''.$flashplayer.'\',\'mpl\',\''.$width.'\',\''.$height.'\',\'9\');
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
        echo $data;    
    ?>
</script>
<div id="channel-title"></div>
<table class="video">
    <tr>
        <td class="last">
            <div id="mediaspace<?php echo $rand?>"></div>    
        </td>
    </tr>
    <?
    $k = 1;
    $j = 1;
    for($i= 0; $i < count($list); $i++){
        $rs = $list[$i];
        $filevideo = ($rs->video_link !='') ? base_url().$rs->video_link : $rs->video_url;
    ?>
    <tr class="row<?=$j?>">
        <td>
        <script type="text/javascript">
            function playvideo<?=$rs->video_id?>(){
                vnit.sendEvent('STOP');
                vnit.sendEvent('LOAD', '<?=$filevideo?>');
                vnit.sendEvent('VOLUME', 80);
                vnit.sendEvent('PLAY');       
                $(".video_item").css({
                    'font-weight':'100',
                    'color':"#000000"
                });
                $("#video_<?=$rs->video_id?>").css({
                    'font-weight':'bold',
                    'color':"#FF0000"
                });
            }            
            
        </script>       
        <?if($i == 0){
            $style = 'style="font-weight:bold; color: #FF0000"';
        }else{
            $style = '';
        }?>  
        <a href="javascript:;" onclick="playvideo<?=$rs->video_id?>()" <?=$style?> class="video_item" id="video_<?=$rs->video_id?>"><b><?php echo $k?></b>. <?php echo $rs->video_title?></a>
        
        </td>
    </tr>
    <?php
    $j = 1 - $j;
    $k ++; 
    }?>
</table>

<script type="text/javascript">
    so.write('mediaspace<?php echo $rand?>');
</script>

<?php }?>