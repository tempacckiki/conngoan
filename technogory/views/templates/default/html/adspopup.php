<?php
    $now = time();
    $timeViewAdsPopup = $this->session->userdata('timeViewAdsPopup');
    if(false === $timeViewAdsPopup){
        // do nothing
        $timeViewAdsPopup = 0;
    }
    $timeViewAdsPopup = (int)$timeViewAdsPopup;
    $intervalTime = 1 * 60 * 60;
    $this->session->set_userdata('timeViewAdsPopup', $now . '');
    if($now - $timeViewAdsPopup > $intervalTime){
        $aBannerAds = $this->helper->getBannerAdsByPosition(4);
        if(isset($aBannerAds->id)){
?>
        <link rel="stylesheet" type="text/css" href="<?=base_url_static();?>technogory/templates/default/css/magnific-popup.css?v=congnoan">
        <script type="text/javascript" src="<?=base_url_static()?>technogory/templates/default/js/jquery190.js?v=congnoan" charset="UTF-8"></script> 
        <script type="text/javascript" src="<?=base_url_static()?>technogory/templates/default/js/jquery.magnific-popup.js?v=congnoan" charset="UTF-8"></script> 

        <script type="text/javascript">
            $(document).ready(function(){    
                var sHtml = '';
                sHtml += '<a href="http://local.dev/alobuyvn/adminsystemcpanelwebsite/quangcao/banner_news/adspopup" target="_blank">';
                    sHtml += '<img src="http://local.dev/alobuyvn/alobuy0862779988/bannerads/adspopup/full_images/1416240940.jpg" />';
                sHtml += '</a>';
                // Open directly via API
                $.magnificPopup.open({
                  items: {
                    type: 'inline',
                    closeOnContentClick: true,
                    src: '<div class="adspopup" style="text-align: center;" >' + sHtml + '</div>', // can be a HTML string, jQuery object, or CSS selector
                  }
                });   
            });
        </script>

<?php
        }    
    }
?>