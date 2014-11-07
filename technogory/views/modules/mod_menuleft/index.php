<?
$list = $this->vdb->find_by_list('menu',array('menutype'=>'Leftmenu','lang'=>vnit_lang()),array('ordering'=>'asc'));
?>
<ul class="menuleft">
    <?php foreach($list as $rs):?>
    <li><a href="<?=site_url($rs->link)?>"><?=$rs->name?></a></li>
    <?endforeach;?>
</ul>