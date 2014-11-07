<script type="text/javascript" src="<?=base_url()?>site/views/modules/mod_customer/esset/jquery.easing.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=base_url()?>site/views/modules/mod_customer/esset/carouFredSel.js" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>site/views/modules/mod_customer/esset/customer.css?v=2.0" media="screen" />
<script type="text/javascript">
$(function() {
    $('ul#user_interaction').carouFredSel({
        auto: true,
        prev: "#prev",
        width : 910,
        visible : 11,
        items: 1,
        duration : 700,
        start: 0,
        next: "#next"
    });
});
</script>
<?
$this->db->order_by('kh_id','desc');
$list = $this->db->get('khachhang')->result();
?>

<div class="image_carousel">
<ul id="user_interaction" style="width: 100%;">
    <?foreach($list as $rs){?>
        <li>
            <?if($rs->links !=''){?>
            <a href="<?=$rs->links?>" target="_blank">
                <img src="<?=base_url().$rs->images?>" alt="">
            </a>
            <?}else{?>
                <img src="<?=base_url().$rs->images?>" alt="">
            <?}?>
        </li>
    <?}?>  
</ul>
<div class="clearfix"></div>
<a id="prev" class="prev" href="#"></a>
<a id="next" class="next" href="#"></a>
</div>