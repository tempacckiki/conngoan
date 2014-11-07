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

<div class="box-left-content">
	<?php $this->load->view("templates/default/html/manufacture");?>
<?
$this->db->select('shop_color.*, shop_color_product.*');
$this->db->join('shop_color','shop_color.icolor = shop_color_product.icolor');
$this->db->where('shop_color_product.catid',$catid);
$this->db->group_by('shop_color_product.icolor');
$listcolor = $this->db->get('shop_color_product')->result();
?>
<?if(count($listcolor) > 0){?>
<div class="title-option">Theo mầu sắc</div> 
<div class="box-m"> 
    <ul class="left_func">
    <?foreach($listcolor as $val):?>
    <li>        
        <img src="<?=base_url()?>data/iconcolor/<?=$val->images?>"  align="absmiddle" alt="">
        <a href="<?=site_url('San-pham/'.vnit_change_title($val->color).'-'.$val->icolor.'/'.$catid);?>"><?=$val->color?></a>
       
    </li>
    <?endforeach;?>
    </ul>
</div>
<?}?>
<?$this->load->library('price');
	$mucgia = $this->price->get_min_max($catid);
if($mucgia != ''){
?>
<p class="title">Theo giá</p> 

<div class="box-m"> 
    <ul class="sub-left-items">
        <?echo $mucgia;?>
    </ul>
</div>
<?}?>

<?php $this->load->view("templates/default/html/feauter_box");?>


</div>
<?//}?>

<script type="text/javascript">
var cat_current_url = '<?=$catUrl;?>';
var cat_current_id = '<?=$catid;?>';

</script>