<h3 class="content_detail_title"><?php echo $rs->title?></h3>
<div class="content_detail_api">
    <ul>
        <li class="fl"><?=lang('content.postedon')?>: <?php echo date('H:i:s d-m-Y',$rs->created)?></li>
        <li class="fl"><?=lang('content.writtenby')?>: admin</li>
        <li class="fr"><a href="javascript:;" onclick="printer()" ><img src="<?=base_url()?>site/templates/songdong/images/printer.png" alt=""></a></li>
        <li class="fr"><a id="print" href="<?=site_url('content/sendmail/'.$rs->title_alias.'-'.$rs->id)?>"><img src="<?=base_url()?>site/templates/songdong/images/e_mail.png" alt=""></a></li>
    </ul>
</div>
<div class="content_detail_intro"><?php echo $rs->introtext?></div>
<div class="content_detail_full"><?php echo $rs->fulltext?></div>
<?php if(count($list) > 0){?>
<div class="other-news cufon"><?=lang('content.other_news')?></div>
    <div class="list-other-news">
        <ul>
            <?php foreach($list as $val):?>
            <li><?php echo anchor('content/'.$val->sections_alias.'/'.$val->cat_alias.'/'.$val->title_alias.'-'.$val->id,$val->title)?></li>
            <?php endforeach;?>
        </ul>
    </div>
<?}?>

<script type="text/javascript">
$(document).ready(function() {
    $("a#print").fancybox({
        'overlayShow'    : false,
        'titlePosition'    : 'over',
        'transitionIn'    : 'elastic',
        'transitionOut'    : 'elastic'
    });
});
function printer(){
    var uri = base_url + '<?=vnit_lang()?>/content/printer/<?=$rs->title_alias.'-'.$rs->id?>';
    window.open( uri,"myWindow", "status = 1, height = auto, width = 940, resizable = 0,scrollbars=1" );     
}
</script>