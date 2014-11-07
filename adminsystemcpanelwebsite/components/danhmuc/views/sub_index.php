<?
$catid = $this->uri->segment(3);
echo form_open('danhmuc/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$catid?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="10">
                Xem theo nhóm hàng 
                <select name="viewcat" onchange="window.open(this.value,'_self');">
                    <option value="<?=base_url()?>danhmuc/ds/0/">Tất cả nhóm hàng</option>
                    <?foreach($listmaincat as $val):?>
                    <option value="<?=base_url()?>danhmuc/get_subcat/<?=$val->catid?>" <?=($catid == $val->catid)?'selected="selected"':''?>><?=$val->catname?></option>
                    <?endforeach;?>
                </select>
            </th>
        </tr>

    </thead>

    <thead>

        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Danh mục</th>

            <th style="width: 50px;">Hiển thị</th>
            <th style="width: 50px;">Trang chủ</th>
            <th style="width: 50px;">Tab ngang</th>
            <th style="width: 50px;">Ẩn menu</th>

            <th style="width: 100px;">Chức năng</th>
        </tr>        
    </thead>
    <?

    foreach($list as $sub):
    $listsub = $this->danhmuc->get_sub_cat($sub->catid);
    ?>
    <tr class="row0">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$sub->catid?>"></td>
        <td><?=$sub->catid?></td>
        <td style="padding-left: 10px; font-weight: bold;font-size: 18px;text-transform: uppercase;color: #FF0000;"><?=$sub->catname?></td>

        <td align="center"><?=$sub->ordering?></td>

        <td align="center"><input type="checkbox" name="ishome_<?=$sub->catid?>" onchange="change_status('ishome',<?=$sub->catid?>)" value="1" <?=($sub->ishome==1)?'checked="checked"':''?>></td>

        <td align="center"><input type="checkbox" name="istab_<?=$sub->catid?>" onchange="change_status('istab',<?=$sub->catid?>)" value="1" <?=($sub->istab==1)?'checked="checked"':''?>></td>
        <td align="center">&nbsp;</td>


        <td align="left">
            <?=icon_nsx('danhmuc/nsx/'.$sub->catid.'/'.base64_encode(uri_string()))?>
            <?=icon_edit('danhmuc/edit/'.$sub->catid.'/'.$catid)?>
            <span id="publish<?=$sub->catid?>"><?=icon_active("'shop_cat'","'catid'",$sub->catid,$sub->published,'danhmuc/published')?></span>
            <?=icon_del('danhmuc/del/'.$sub->catid.'/'.$catid)?>        
            <?=icon_add_small('danhmuc/add/'.$sub->catid.'/'.$catid)?>        
        </td>
    </tr> 
    <?foreach($listsub as $val): 
    $listsub2 = $this->danhmuc->get_sub_cat($val->catid);
    ?>
    
    <tr class="row1">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$val->catid?>"></td>
        <td><?=$val->catid?></td>
        <td style="padding-left: 10px;font-weight: bold;font-size: 15px;color: #0082C9;text-transform: uppercase;">|____ <?=$val->catname?></td>

        <td align="center"><?=$val->ordering?></td>

        <td align="center"><input type="checkbox" name="ishome_<?=$val->catid?>" onchange="change_status('ishome',<?=$val->catid?>)" value="1" <?=($val->ishome==1)?'checked="checked"':''?>></td>

        <td align="center"><input type="checkbox" name="istab_<?=$val->catid?>" onchange="change_status('istab',<?=$val->catid?>)" value="1" <?=($val->istab==1)?'checked="checked"':''?>></td>
        <td align="center"><input type="checkbox" name="no_menu_<?=$val->catid?>" onchange="change_status('no_menu',<?=$val->catid?>)" value="1" <?=($val->no_menu==1)?'checked="checked"':''?>></td>

        <td align="left">
            <?=icon_nsx('danhmuc/nsx/'.$val->catid.'/'.base64_encode(uri_string()))?>
            <?=icon_edit('danhmuc/edit/'.$val->catid.'/'.$catid)?>
            <span id="publish<?=$val->catid?>"><?=icon_active("'shop_cat'","'catid'",$val->catid,$val->published,'danhmuc/published')?></span>
            <?=icon_del('danhmuc/del/'.$val->catid.'/'.$catid)?>        
        </td>
    </tr> 
    
    
    <?foreach($listsub2 as $val1): 
    
    ?>
    
    <tr class="row1">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$val1->catid?>"></td>
        <td><?=$val1->catid?></td>
        <td style="padding-left: 10px;">|____|____ <?=$val1->catname?></td>

        <td align="center"><?=$val1->ordering?></td>

        <td align="center"><input type="checkbox" name="ishome_<?=$val1->catid?>" onchange="change_status('ishome',<?=$val1->catid?>)" value="1" <?=($val1->ishome==1)?'checked="checked"':''?>></td>

        <td align="center"><input type="checkbox" name="istab_<?=$val1->catid?>" onchange="change_status('istab',<?=$val1->catid?>)" value="1" <?=($val1->istab==1)?'checked="checked"':''?>></td>

        <td align="left">
            <?=icon_nsx('danhmuc/nsx/'.$val1->catid.'/'.base64_encode(uri_string()))?> 
            <?=icon_edit('danhmuc/edit/'.$val1->catid.'/'.$catid)?>
            <span id="publish<?=$val1->catid?>"><?=icon_active("'shop_cat'","'catid'",$val1->catid,$val1->published,'danhmuc/published')?></span>
            <?=icon_del('danhmuc/del/'.$val1->catid.'/'.$catid)?>        
        </td>
    </tr> 
    <?endforeach;?>
    <?endforeach;?>
    <?endforeach;?>

</table>
<?=form_close()?>
<script type="text/javascript">
function change_status(thuoctinh,catid){
    if($('input[name='+thuoctinh+'_'+catid+']').is(':checked')){
        giatri = 1;
    }else{
        giatri = 0;
    }
   
    $.post(base_url+"danhmuc/change_status",{'thuoctinh':thuoctinh,'giatri':giatri,'catid':catid},function(data){ 
        
    },'json');
    return false;
}
</script>