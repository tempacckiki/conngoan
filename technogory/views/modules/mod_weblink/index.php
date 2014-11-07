<?php
$show = get_params('shows',$attr); 
$list = $this->vdb->find_by_list('weblink',0,array('weblink_id'=>'desc'));
?>
<?if($show == 1){?>
<select name="" style="width: 99%;">
    <?foreach($list as $rs):?>
    <option onclick="window.open('<?=$rs->link?>');"><?=$rs->name?></option>
    <?endforeach;?>
</select>   
<?}else{?>
    <?foreach($list as $rs):?>
        <div><a href="<?=$rs->link?>" target="_blank"><?=$rs->name?></a></div>
    <?endforeach;?>
<?}?>
