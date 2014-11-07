<link type="text/css" rel="stylesheet" href="<?echo base_url()?>site/views/modules/mod_lastnews/esset/lastnews.css?v=2.0" media="screen" />
<!--<script type="text/javascript" src="<?echo base_url()?>site/views/modules/mod_lastnews/esset/lastnews.js" charset="UTF-8"></script>-->
<script type="text/javascript" src="<?echo base_url()?>site/views/modules/mod_lastnews/esset/jcarousellite.js" charset="UTF-8"></script>
<?
$ar_cat = split(',',get_params('catid',$attr));
$length = get_params('string_length',$attr);
$max = get_params('max',$attr);
$max_show = get_params('max_show',$attr);
$speed = get_params('speed',$attr);
$show_img = get_params('show_img',$attr);
$width_img = get_params('width_img',$attr);
$height_img = get_params('height_img',$attr);
?>
<script type="text/javascript">
$(function() {
    $(".newsticker-item").jCarouselLite({
        vertical: true,
        hoverPause:true,
        visible: <?=$max_show?>,
        auto:500,
        speed:<?=$speed?>
    });
});
</script>
<?php
if(count($ar_cat) > 1){
$this->db->where_in('catid',$ar_cat);
}
$this->db->order_by('created','desc');
$this->db->where('lang',vnit_lang());
$this->db->limit($max);
$list = $this->db->get('content')->result();
?>
<div id="lastnews_ticker">    
    <div class="newsticker-item">
        <ul class="lastnews">
            <?php foreach($list as $rs):?>
            <li>
                <?php if($show_img == 1){
                    if($rs->images_thumb != ''){
                    ?>
                <div class="img" style="width:<?=$width_img?>; height:<?=$height_img?>">
                    <a href="<?=site_url('content/'.$rs->sections_alias.'/'.$rs->cat_alias.'/'.$rs->title_alias.'-'.$rs->id)?>"><img width="<?=$width_img?>" src="<?=base_url().$rs->images_thumb?>" alt=""></a>
                </div>
                <?php } }?>
                <a href="<?=site_url('content/'.$rs->sections_alias.'/'.$rs->cat_alias.'/'.$rs->title_alias.'-'.$rs->id)?>"><?php echo vnit_cut_string($rs->title,$length)?></a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
</div>

