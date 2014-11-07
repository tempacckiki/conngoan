<div style="width: 640px; height: 480px;">
    <script type="text/javascript" src="<?=base_url()?>site/templates/fyi/js/j360.js" charset="UTF-8"></script>

    <script type="text/javascript">
       jQuery(document).ready(function() {
            jQuery('#product_rotare').j360();
        });
    </script>
    
    <div id="product_rotare" style="width: 640px; height: 480px; overflow: hidden;cursor: move;">
        <?foreach($list as $val):?>
        <img src='<?=base_url().$val->imagepath?>' alt="" style="cursor: move;" />
        <?endforeach;?>
     </div>
</div>