<?=form_open(uri_string(), array('id' => 'admindata'));
$user_id = $this->uri->segment(3);
?>
<input type="hidden" name="user_id" value="<?=$user_id?>">
<div class="pq">
	<div class="row0">
		<p class="pq_root" style="padding: 10px 0px;">&nbsp; Giá sản phẩm</p>
		<div style="padding-bottom: 10px;overflow: hidden;">
			<input type="checkbox" name="addPrice" value="0" <?=($addPrice != '')?'checked="checked"': '';?>> Add giá sản phẩm
			<input type="checkbox" name="editPrice" value="1" <?=($editPrice >0)?'checked="checked"': '';?>> Edit giá sản phẩm
		</div>
	</div>
	
<?php
  $k = 1;
  foreach($hethong as $ht):
  $list = $this->vdb->find_by_list('phanquyen',array('parentid'=>$ht->id),array('ordering'=>'asc'))
?>
<div style="padding: 10px;" class="row<?=$k?>">
<div class="pq_root"><input type="checkbox" name="all_list_<?=$ht->id?>" onclick="check_all_list(<?=$ht->id?>)"><?=$ht->name?></div>
<?foreach($list as $rs):
    $dschucnang = $this->vdb->find_by_list('phanquyen_chucnang',array('phanquyen_id'=>$rs->id),array('ordering'=>'asc'))
?>
    <div class="pq_parent"><input type="checkbox" class="item_<?=$ht->id?>" name="all_items_<?=$rs->id?>" onclick="check_all_items(<?=$rs->id?>)"><?=$rs->name?></div>
    <ul class="phanquyen">
    <?foreach($dschucnang as $val):
    $row = $this->vdb->find_by_id('phanquyen_user',array('function_id'=>$val->function_id,'user_id'=>$user_id));
    if($row){
        $check = 'checked="checked"';
    }else{
        $check = '';
    }
    ?>
        <li>
            <input type="checkbox" class="item_<?=$ht->id?> fnc_<?=$rs->id?>"  value="<?=$val->function_id?>" name="ar_id[]" <?=$check?>>
            <?=$val->function_notice?>
        </li>
    <?endforeach;?>
    </ul>
<?

endforeach;?>
</div>
<?
$k = 1 - $k; 
endforeach;?>
</div>
<input type="submit" class="save" name="bt_submit" value="<?=lang('sys.save')?>">
<?=form_close();?>
