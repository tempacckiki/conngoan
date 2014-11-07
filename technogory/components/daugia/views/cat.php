<?php 
$imgPath   = base_url().'site/templates/fyi/images/';
$uriCatID	   = $this->uri->segment('3');
?>
<!-- 
<div class="ads-deal">
 <a href=""><img src="<?=$imgPath;?>top-banner.jpg" alt=""></a>
</div>
 -->
<link type="text/css" rel="stylesheet" href="<?=base_url();?>/site/templates/fyi/css/deal.css?v=2.0" media="screen">
<div class="box-hd-list">
	<?php include_once($productCat); ?>
</div>



