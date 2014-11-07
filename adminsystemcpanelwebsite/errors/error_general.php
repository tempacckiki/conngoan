<html>
<head>
<title><?=$heading?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<style type="text/css">

body {
background-color:	#fff;
margin:				40px;
font-family:		Lucida Grande, Verdana, Sans-serif;
font-size:			12px;
color:				#000;
}

#content  {
    border:				1px dashed #fdb10d;
    background-color:	#f9f1e0;
    padding:			20px 20px 12px 20px;
}

h1 {
    color: #990000;
    font-size: 23px;
    font-weight: bold;
    margin: 0 0 4px;
}
p.text{
    margin: 0;
    padding: 3px 0;
}
p.redirect{
    margin-top: 5px;
}
p.redirect a{
    text-decoration: none;
}
</style>
</head>
<script type="text/javascript">
$(document).ready(function() {
    setInterval("goBack()", 5000);
});
function goBack(){
  window.history.back()
}
</script>
<body>
	<div id="content">
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>