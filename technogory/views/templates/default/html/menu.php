<?
$this->load->config('technogory/config_menu');
?>
<?
$listnhomhang = $this->vdb->find_by_list('shop_cat',array('parentid'=>0,'published'=>1),array('ordering'=>'asc'));
?>
<ul id="menu">
    <li class="select">
        <a class="" href="<?=base_url()?>">Trang chủ</a>
    </li>
    <?
    for($c1=1; $c1 <= $this->config->item('total_menu'); $c1++){
        $total_cap1 = $this->config->item('menu_total_leve_1_'.$c1);
        $dir = ($total_cap1 > 0)?'class="dir"':'';   
    ?>
    <li><a href="<?=site_url('category/'.$this->config->item('menu_alias_leve_1_'.$c1).'/'.$this->config->item('menu_id_leve_1_'.$c1))?>"><?=$this->config->item('menu_name_leve_1_'.$c1)?></a>
        <?if($total_cap1 > 0){?>
            <ul>
                <?for($c2=1;$c2<=$this->config->item('menu_total_leve_1_'.$c1);$c2++){?>
                <li>
                    <a href="<?=site_url('category/'.$this->config->item('menu_alias_leve_2_'.$c1.'_'.$c2).'/'.$this->config->item('menu_id_leve_2_'.$c1.'_'.$c2))?>"><?=$this->config->item('menu_name_leve_2_'.$c1.'_'.$c2)?></a>
                    <?
                    $total_cap2 = $this->config->item('menu_total_leve_2_'.$c1.'_'.$c2);
                    if($total_cap2 > 0){
                    ?>
                        <ul>
                            <?for($c3=1;$c3 <= $total_cap2;$c3++){?>
                            <li><a  href="<?=site_url('category/'.$this->config->item('menu_alias_leve_3_'.$c1.'_'.$c2.'_'.$c3).'/'.$this->config->item('menu_id_leve_3_'.$c1.'_'.$c2.'_'.$c3))?>"><?=$this->config->item('menu_name_leve_3_'.$c1.'_'.$c2.'_'.$c3)?></a></li>
                            <?}?>
                        </ul>
                    <?}?>
                </li>
                <?}?>
            </ul>
        <?}?>
    </li>
    <?}?>
</ul>
