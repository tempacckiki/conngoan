<?php
$popup_img = $this->config->item('popup_img');
$popup_link = $this->config->item('popup_link');
$popup_active = $this->config->item('popup_active');
$popup_width = $this->config->item('popup_width');
$popup_height = $this->config->item('popup_height');
?>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>site/views/modules/mod_pop_content/esset/popcontent.css?v=2.0" media="screen" />
<script type="text/javascript">
$(document).ready(function(){ 
    var pop_width = <?=$popup_width?>;
    var pop_height = <?=$popup_height?>;
    var window_height = $(window).height();
    var window_width = $(window).width();
    var document_height = $(document).height();
    pop_c_cookie = $.cookie('fyi_pop_content');
    if(pop_c_cookie == null || pop_c_cookie == 1){
        $("#pop_content").css({
            left: (window_width - pop_width )/2,
            top : (window_height - pop_height)/2,
            width: pop_width,
            height: pop_height 
        });
        $(".pop_content_bg").css({
            height: document_height
        });
        $.cookie('fyi_pop_content',2);
    }
    
    $("#p_c_close").click(function(){
        $.cookie('fyi_pop_content',2);
        $("#pop_content").hide();
        $(".pop_content_bg").hide();
    });
}); 

</script>
<div class="pop_content" id="pop_content">
    <div class="close" id="p_c_close"></div>
    <a href="<?=$popup_link?>" target="_blank"><img src="<?=base_url()?>data/adv/popupcontent/<?=$popup_img?>" alt=""></a>
</div>
<div class="pop_content_bg"></div>