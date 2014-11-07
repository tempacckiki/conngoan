<?
$list_drop = $this->vdb->find_by_list('shop_cat',array('parentid'=>0,'published'=>1),array('ordering'=>'asc'));
?>
<ul class="blockmenu" id="drop_menu">
    <?foreach($list_drop as $val){
        $listsub = $this->vdb->find_by_list('shop_cat',array('parentid'=>$val->catid,'published'=>1),array('ordering'=>'asc'));
        ?>
    <li vdata="<?=$val->catid?>">
        <a href="" class="drop_main"><?=$val->catname?></a>
        <div class="left_menu_drop" style="display: none;" id="vdata_<?=$val->catid?>">
                <?foreach($listsub as $val1):?>
                <div><a href="<?=($val1->nolink==1)?'#':site_url('category/'.$val1->caturl.'-'.$val1->catid)?>"><?=$val1->catname?>(5)</a></div>
                <?endforeach;?>
        </div>
    </li>
    <?}?>
</ul>

