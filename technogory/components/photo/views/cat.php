<?php if(isset($list)){?>
<ul class="listalbum">
    <?
    $i = 1;
    foreach($list as $rs):?>
    <li id="photo_<?=$i?>">
        <div class="item">
        <a href="<?=site_url('photo/'.$rs->caturl.'-'.$rs->catid.'/'.$rs->album_url.'-'.$rs->albumid)?>">
        <div class="img">
            <img src="<?=base_url()?>data/album/210/<?=$rs->album_img?>" alt="">
            <div class="title-album" id="title_<?=$i?>"><?=$rs->album_name?></div>
        </div>
        
        </a>
        </div>
        <div class="item_bot"></div>
    </li>
    <?
    $i++;
    endforeach;?>
</ul>
<div class="clear"></div>
<div class="pages" style="margin: 20px;"><?=$pagination?></div>
<script type="text/javascript">
$(document).ready(function() {
    $("ul.listalbum li").hover(function () {
        $("#title_"+$(this).attr('id').replace('photo_','')).slideDown();
      },function () {
          
        $(".title-album").slideUp();
        
      }
    );    
});
</script>
<?}?>