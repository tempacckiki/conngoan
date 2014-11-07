<div class="col1">
    <img src="<?=base_url()?>data/adv/footer/24_02_2012_09_58_33_BannerWeb_TietKiemThongMinh.jpg" alt="">
</div>
<div class="col2">
    <img src="<?=base_url()?>data/adv/footer/30_04_2012_11_38_38_DM-TiviSamsung-205x205.jpg" alt="">
</div>
<div class="col3">
    <img src="<?=base_url()?>data/adv/footer/30_04_2012_11_39_38_DM-Báº¿pÄiá»‡nMidea-205x205.jpg" alt="">
</div>
<script type="text/javascript">
$(document).ready(function(){
    auto_open_close  
});
// Auto dong mo quang cao by Cookie
function close_f(){
    $(".box_ads_footer").slideUp();
    $("#close_f").hide();
    $("#open_f").show();
    $.cookie("fyi_pop_fl","dong",{ path: site_url });
}

function open_f(){
    $(".box_ads_footer").slideDown();
    $("#close_f").show();
    $("#open_f").hide();
    $.cookie("fyi_pop_fl","mo",{ path: site_url });
}

function auto_open_close(){
    if($.cookie("fyi_pop_fl") == "" || $.cookie("fyi_pop_fl") == "dong"){   
        $(".box_ads_footer").hide();
        $("#close_f").hide();
        $("#open_f").show();

    }else{
        $(".box_ads_footer").show();
        $("#close_f").show();
        $("#open_f").hide();

    }
}
</script>
