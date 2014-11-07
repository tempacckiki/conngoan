<?php if(isset($list)){?>
<ul class="photo">
<?foreach($list as $rs):?>
<li>
    <div class="img"><img src="<?=$rs->img_main?>" alt=""></div>
    <div class="photo-cat-name"><?=anchor('photo/'.$rs->caturl.'-'.$rs->catid,$rs->catname)?></div>
</li>
<?endforeach;?>
</ul>
<?}?>