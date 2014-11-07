<?php
$popup_active = $this->config->item('popup_f_active');
$popup_link = $this->config->item('popup_f_link');
$popup_name = $this->config->item('popup_f_name');
$popup_img_file = $this->config->item('popup_f_img');
$popup_img  = base_url().'data/adv/popupfooter/'.$this->config->item('popup_f_img');
$type_img = type_img($popup_img_file);
if($popup_active == 1){
?>

<script language="javascript">
$(document).ready(function(){
    if($.cookie('fyi_pop_f') == 2){
        $("#box_p_f").hide();
    }else{
        $("#box_p_f").show();
    }
    
    setTimeout("showsmall()",10000) ;
    $("#smallcorner").click(function(){
        showlarger() ;
        setTimeout("showsmall()",10000) ;
    });
    $("#remove_f").click(function(){
        $("#box_p_f").hide();
        $.cookie('fyi_pop_f',2,{ path: site_url }); 
    });
});
function showlarger()
{
    $("#largecorner").slideDown(500);
    $("#smallcorner").slideUp(200);
}
function showsmall()
{
    $("#largecorner").slideUp(300);
    $("#smallcorner").slideDown(500);
}
function hideme()
{
    $("#divcorner").slideDown(200);
}
</script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>site/views/modules/mod_popf/esset/popf.css?v=2.0" media="screen" /></script>
<div id="box_p_f" style="display: none;">
<div class="pop_f" id="largecorner">
    <div class="mid-pop" id="f-pop" style="display: block;">
        <div class="pop-content">
            <div class="action">
                <a href="javascript:showsmall();" class="down"></a>
                <a href="javascript:;" id="remove_f" class="remove"></a>
            </div>
            <?if($type_img == 'swf'){?>
            <embed width="260" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash" wmode="transparent" quality="high" flashvars="clickTAG=<?=base_url()?>api/clickqc<?=$this->config->item('url_suffix')?>?link=<?=$popup_link?>" src="<?=$popup_img?>">
            <?}else{?>
                <a target="_blank" href="<?=base_url()?>api/clickqc<?=$this->config->item('url_suffix')?>?link=<?=$popup_link?>">
                <img src="<?=$popup_img?>" alt="<?=$popup_name?>" width="260">
                </a>
            <?}?>
        </div>
    </div>
</div>
<div class="pop_f" id="smallcorner" style="display: none; height: 30px;">
    <div class="top-pop">
        <div class="title">
        <marquee style="padding-left: 5px" width="200" direction="left" onmouseover="this.stop();" onmouseout="this.start();"><?=$popup_name?></marquee>
        </div>
        <div class="close_f_p">
            <a href="javascript:showlarger();" class="down"></a>
            <a href="javascript:;" id="remove_f" class="remove"></a>
        </div>
    </div>
</div>
</div>
<?}?>
