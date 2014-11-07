<script type="text/javascript">
document.write('<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>site/views/modules/mod_headline/headline.css" media="screen" />');
</script>
<?php
$data['category'] = get_params('category',$attr);
$data['catid'] =split(',',get_params('catid',$attr));
$data['max'] = get_params('max',$attr);
if($data['category'] == 1){
    $this->load->view('modules/mod_headline/category',$data);
}else{
    $this->load->view('modules/mod_headline/sections',$data);
}
?>