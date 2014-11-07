<?
$catid = $this->uri->segment(3);
echo form_open('danhmuc/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
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
    <?
    $k=1;
    foreach($list as $rs):
    $listsub  = $this->danhmuc->get_sub_cat($rs->catid);
    ?>
    <thead>
        <tr>
            <th class="head" colspan="10" style="font-weight: bold;font-size: 14px;"><?=$rs->catname?></th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Danh mục</th>

            <th style="width: 50px;">Hiển thị</th>
            <th style="width: 50px;">Trang chủ</th>
            <th style="width: 50px;">Tab ngang</th>

            <th style="width: 100px;">Chức năng</th>
        </tr>        
    </thead>
    <?
    $j=1;
    foreach($listsub as $sub):?>
    <tr class="row<?=$j?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$sub->catid?>"></td>
        <td><?=$sub->catid?></td>
        <td style="padding-left: 10px;"><?=$sub->catname?></td>

        <td align="center"><?=$sub->ordering?></td>

        <td align="center"><input type="checkbox" name="ishome_<?=$sub->catid?>" onchange="change_status('ishome',<?=$sub->catid?>)" value="1" <?=($sub->ishome==1)?'checked="checked"':''?>></td>

        <td align="center"><input type="checkbox" name="istab_<?=$sub->catid?>" onchange="change_status('istab',<?=$sub->catid?>)" value="1" <?=($sub->istab==1)?'checked="checked"':''?>></td>


        <td align="center">
            <?=icon_nsx('danhmuc/nsx/'.$sub->catid.'/'.base64_encode(uri_string()))?>
            <?=icon_edit('danhmuc/edit/'.$sub->catid)?>
            <span id="publish<?=$sub->catid?>"><?=icon_active("'shop_cat'","'catid'",$sub->catid,$rs->published,'danhmuc/published')?></span>
            <?=icon_del('danhmuc/del/'.$sub->catid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr> 
       
    <?

    $j = 1-$j;
    endforeach;
    
    $k=1-$k;
    endforeach;
    ?>

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