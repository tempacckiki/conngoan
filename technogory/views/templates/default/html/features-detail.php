<?
$get_varian = $this->input->get('varian');
$ar_varian = explode(',',$get_varian);
$get_color = $this->input->get('color');
$ar_color = explode(',',$get_color);

if($get_varian != '' && $get_color == ''){
    $input_get = "?varian=".$get_varian;
}else if($get_color != '' && $get_varian ==''){
    $input_get = "?color=".$get_color;
}else if($get_color != '' && $get_varian != ''){
    $input_get = "?varian=".$get_varian.'&color='.$get_color;
}else{
    $input_get = "";
}

$uri1 = $this->uri->segment(1);
$uri2 = end(explode('-',$this->uri->segment(2)));
$uri3 = end(explode('-', $this->uri->segment(3)));
$catid = $this->uri->segment(3);

if($uri1 == 'product'){
	$catid = $this->vdb->find_by_id("shop_product", array('productid'=>$uri3))->catid;
}
?>
<div class="box_modules">
<?php $this->load->view("templates/default/html/manufacture");?>
</div>
<script type="text/javascript">
var cat_current_url = '<?=$catUrl;?>';
var cat_current_id = '<?=$catid;?>';
</script>