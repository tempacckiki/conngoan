<?
if(!isset($catmenu)){
    $catmenu = 0;
}
?>
<ul id="nv_ac" class="nv-ac">
	<li><a href="">DEAL HOT</a></li>
<?
for($c1=1; $c1 <= $this->config->item('total_menu'); $c1++){
    $total_cap1 = $this->config->item('menu_total_leve_1_'.$c1);
    $dir = ($total_cap1 > 0)?'class="dir"':'';   
?>
<li class="level_0 <?=($catmenu == $this->config->item('menu_id_leve_1_'.$c1))?'current':'';?>">
<a href="<?=site_url('category/'.$this->config->item('menu_alias_leve_1_'.$c1).'/'.$this->config->item('menu_id_leve_1_'.$c1))?>"><?=$this->config->item('menu_name_leve_1_'.$c1)?></a>
    <?if($total_cap1 > 0){?>
        <ul id="item<?=$this->config->item('menu_id_leve_1_'.$c1)?>" style="<?=($catmenu == $this->config->item('menu_id_leve_1_'.$c1))?'display:block':'display:none';?>">
            <?for($c2=1;$c2<=$this->config->item('menu_total_leve_1_'.$c1);$c2++){?>
            <li class="level_1">
                <a class="sub" href="<?=site_url('category/'.$this->config->item('menu_alias_leve_2_'.$c1.'_'.$c2).'/'.$this->config->item('menu_id_leve_2_'.$c1.'_'.$c2))?>"><?=$this->config->item('menu_name_leve_2_'.$c1.'_'.$c2)?></a>
                
            </li>
            <?}?>
        </ul>
    <?}?>
</li>
<?}?>
</ul>
