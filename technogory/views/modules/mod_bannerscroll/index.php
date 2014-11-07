<?php
$active = $this->config->item('bannertruot_active');
if($active == 1){
$file_img_l = $this->config->item('bannertruot_trai_anh');
$link_img_l = $this->config->item('bannertruot_trai_link');
$type_img_l = type_img($file_img_l);

$file_img_r = $this->config->item('bannertruot_phai_anh');
$link_img_r = $this->config->item('bannertruot_phai_link');
$type_img_r = type_img($file_img_r);
?>

<div id="vt_r" style="position: fixed; top: 0px; left: 1170px;display: none;">
    <?if($type_img_l == 'swf'){?>
        <embed width="125" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" wmode="transparent" quality="high" flashvars="clickTAG=<?=base_url()?>api/clickqc<?=$this->config->item('url_suffix')?>?link=<?=$link_img_l?>" src="<?=base_url()?>data/adv/bannertruot/<?=$file_img_l?>">
    <?}else{?>
    <a taget="_blank" href="<?=base_url()?>api/clickqc<?=$this->config->item('url_suffix')?>?link=<?=$link_img_l?>">
    <img width="125" border="0" class="imgbor" src="<?=base_url()?>data/adv/bannertruot/<?=$file_img_l?>">
    </a>
    <?}?>
</div>
<div id="vt_l" style="position: fixed; top: 0px; right: 1170px;display: none;">
    <?if($type_img_r == 'swf'){?>
        <embed width="125" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" wmode="transparent" quality="high" flashvars="clickTAG=<?=base_url()?>api/clickqc<?=$this->config->item('url_suffix')?>?link=<?=$link_img_r?>" src="<?=base_url()?>data/adv/bannertruot/<?=$file_img_r?>">
    <?}else{?>
    <a taget="_blank" href="<?=base_url()?>api/clickqc<?=$this->config->item('url_suffix')?>?link=<?=$link_img_r?>">
        <img width="125" border="0" class="imgbor" src="<?=base_url()?>data/adv/bannertruot/<?=$file_img_r?>">
    </a>
    <?}?>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        var window_width = $(window).width();
        if(window_width < 1024){
            $("#vt_l").css({
                'display':'none'
            });
            $("#vt_r").css({
                'display':'none'
            });
            
        }else{
            var window_w = $(window).width();
                min = ((window_w - 1000)/2) - 125;
                $("#vt_l").css({
                    'right':min
                });
                $("#vt_r").css({
                    'left':min
                });
                $("#vt_r,#vt_l").fadeIn(1000) ;
            $(window).scroll(function(){
                if  ($(window).scrollTop() > 120){
                    $("#vt_r,#vt_l").css({
                        'top':0
                    });
                }else{
                    $("#vt_r,#vt_l").css({
                        'top':0
                    });
                }
            });  
        }
        

    });
</script>
<?}?>