<script type="text/javascript">
    var base_url = '<?=base_url()?>';
    var base_url_site = '<?=base_url_site()?>';
</script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/jquery-1.7.1.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/jquery-ui-1.8.6.custom.min.js" charset="UTF-8"></script>

<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/360vnit.alert.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/jquery.colorbox.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/ddsmoothmenu.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/ZeroClipboard.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/function.admin.app.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/jquery.validate.min.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/price_format.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/shop.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/sangiare.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/jquery.ui.core.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/jquery.dialog.extra.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/jquery.ui.datepicker.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?php echo base_url()?>templates/js/core/jquery.ui.widget.js?v=2.0" charset="UTF-8"></script>

<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/css/styles.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/css/colorbox.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/css/360vnit.alert.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/css/menu.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/css/jquery-ui.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/css/datepicker.css?v=2.0" media="screen" />
<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>templates/css/datetheme.css?v=2.0" media="screen" />
<script type="text/javascript" src="<?=base_url()?>templates/ckeditor/ckeditor.js"></script>
<?
if(!$this->session->userdata('group_id') && ($this->session->userdata('active_shop') == 1)){
    redirect();
}

$this->esset->display();
?> 
<script type="text/javascript">

    ddsmoothmenu.init({
    arrowimages: {down: ['downarrowclass', base_url+'templates/images/menu_down.png', 23], right: ['rightarrowclass', base_url+'templates/images/menu_right.png']},
    mainmenuid: "slidemenu", //Menu DIV id
    orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
    classname: 'ddsmoothmenu', //class added to menu's outer DIV
    //customtheme: ["#804000", "#482400"],
    contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
})
$(document).ready(function() {
$.ajax({
   type: "GET",
   url: base_url+"templates/js/copy.js",
   dataType: "script"
 });    
});
</script>
