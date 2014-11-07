<html>
<head>
<title>404 Page Not Found</title>
<link rel="canonical" href="<?=base_url();?>" />
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
border:				none;
background-color:	#fff;
padding:			20px 20px 12px 20px;
}

h1 {
font-weight:		normal;
font-size:			14px;
color:				#990000;
margin:				0 0 4px 0;
}
</style>
</head>
<body>
	
	<div id="content" align="center">
		<div style="width: 1000px;margin: auto;" >
			<img alt="<?=$message;?>" src="<?=base_url();?>technogory/templates/default/images/not-found.jpg">
		
		</div>
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
			<h2><a href="<?=base_url();?>" title="ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nhà">ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nhà</a></h2>
	</div>
</body>
</html>