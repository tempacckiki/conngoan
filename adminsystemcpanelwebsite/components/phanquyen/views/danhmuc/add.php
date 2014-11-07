
<div class="show_notice">Ghi chú: Hệ thống chỉ phân quyền tới danh mục cấp 3</div>
<?=form_open(uri_string(), array('id' => 'admindata'));
$user_id = $this->uri->segment(3);
?>
<input type="hidden" name="user_id" value="<?=$user_id?>">
<div class="pq">
<?php
  $k = 1;
  foreach($list as $val):
  $listsub1 = $this->phanquyen->get_all_danhmuc($val->catid);
  $check1 = ($this->phanquyen->check_dm($user_id, $val->catid))?'checked="checked"':'';
?>
<div style="padding: 10px;" class="row<?=$k?>">
<div class="pq_root">
<input type="checkbox" id="main1_<?=$val->catid?>" name="ar_id[]"  value="<?=$val->catid?>" <?=$check1?> onclick="check_all_listdm(<?=$val->catid?>)"><?=$val->catname?>
<input type="hidden" name="cap_<?=$val->catid?>" value="cap1">
</div>
<?foreach($listsub1 as $val1):
    $listsub2 = $this->phanquyen->get_all_danhmuc($val1->catid);
    $check2 = ($this->phanquyen->check_dm($user_id, $val1->catid))?'checked="checked"':'';
?>
    <div class="pq_parent">
    <input type="checkbox" id="main2_<?=$val1->catid?>" <?=$check2?>  name="ar_id[]" value="<?=$val1->catid?>" class="item_<?=$val->catid?>" onclick="check_all_itemsdm(<?=$val1->catid?>)"><?=$val1->catname?>
    <input type="hidden" name="cap_<?=$val1->catid?>" value="cap2">
    </div>
    <ul class="phanquyen">
    <?foreach($listsub2 as $val2):
      $check3 = ($this->phanquyen->check_dm($user_id, $val2->catid))?'checked="checked"':'';
    ?>
        <li>
            <input type="checkbox" class="item_<?=$val->catid?> fnc_<?=$val1->catid?>" <?=$check3?>  value="<?=$val2->catid?>" name="ar_id[]" <?//=$check?>>
            <input type="hidden" name="cap_<?=$val2->catid?>" value="cap3">
            <?=$val2->catname?>
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
