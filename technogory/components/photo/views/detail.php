<?php if(isset($list)){?>
<script type="text/javascript">
    $(document).ready(function() {
        var tn1 = $('.mygallery').tn3({
        skinDir:"skins",
        imageClick:"fullscreen",
        image:{
        maxZoom:1.5,
        crop:true,
        clickEvent:"dblclick",
        transitions:[{
        type:"blinds"
        },{
        type:"grid"
        },{
        type:"grid",
        duration:460,
        easing:"easeInQuad",
        gridX:1,
        gridY:8,
        // flat, diagonal, circle, random
        sort:"random",
        sortReverse:true,
        diagonalStart:"bl",
        // fade, scale
        method:"scale",
        partDuration:360,
        partEasing:"easeOutSine",
        partDirection:"left"
        }]
        }
        });
    });
</script>
    <div class="mygallery">
    <div class="tn3 album">
        <ol>
        <?foreach($list as $rs):?>
        <li>
            <a href="<?=base_url()?>data/album/500/<?=$rs->imagepath?>">
            <img src="<?=base_url()?>data/album/210/<?=$rs->imagepath?>" />
            </a>
        </li>
        <?endforeach;?>                      
        </ol>
    </div>
    </div>
<?}?>