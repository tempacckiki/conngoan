<?php 
$imgPath   = base_url().'technogory/templates/default/images/';
$uriCatID	   = $this->uri->segment('3');
?>
<div class="box-head-top">
	<?php include_once($productIndexItem0); ?>
	
	<div class="right-deal-hot">
		 <?=$this->load->view("templates/default/html/box_top");?>
	</div>
	
</div>

<?php include_once($productCat); ?>


<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider();
});
</script>
