<?foreach($list as $rs):?>
<div class="list-news">
    <div class="img">
        <a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>" title="<?=$rs->title?>"><img alt="<?=$rs->title?>" src="<?=base_url().$rs->images_thumb?>"></a>
    </div>
    <div class="title"><a href="<?=site_url('tin-tuc/'.$rs->caturl.'/'.$rs->title_alias.'-'.$rs->newsid)?>" title="<?=$rs->title?>"><?=$rs->title?></a></div>
    <div class="date">Ngày đăng: <?=date('H:i d/m/Y',$rs->created)?> - Lượt xem: <?=$rs->hits?></div>
    <div><?=$rs->introtext?></div>
</div>
<?endforeach;?>
<div class="pages"><?=$pagination?></div>