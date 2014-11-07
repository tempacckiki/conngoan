<div class="box-right-banner">
<link type="text/css" rel="stylesheet" href="<?=base_url()?>technogory/templates/default/css/slider_banner.css?v=2.0" media="screen" />
<script type="text/javascript" src="<?=base_url()?>technogory/templates/default/js/script_banner.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?=base_url()?>technogory/templates/default/js/jquery.easing_slder.js" charset="UTF-8"></script>
<script type="text/javascript">
 $(document).ready( function(){  	
     $('#lofslidecontent45').lofJSidernews( {         
         interval:3000,
         easing:'easeInOutQuad',
         duration:1000,
         auto:true
     }); 
     $('#bg').click(function() {
         $("#display").hide();
     });                       
});      
</script>


	<div id="lofslidecontent45" class="lof-slidecontent">
		<div class="preload"><div></div></div>
		<?php 
		if(file_exists(ROOT.'site/config/config_bannertop_deal.php')){
			include_once (ROOT.'site/config/config_bannertop_deal.php');
		}
		?>		
				  
	</div> 
</div>