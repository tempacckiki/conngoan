<div>
    Xem theo Nhóm hàng:
    <select name="" onchange="window.open(this.options[this.selectedIndex].value,'_self');">
        <?foreach($listmaincat as $val):?>
        <option value="<?=site_url('features/manage/feature_cat/'.$val->catid)?>" <?=($val->catid == $cat_id)?'selected="selected"':''?>><?=$val->catname?></option>
        <?endforeach;?>
    </select>
</div>
<?
$catid = (int)$this->uri->segment(4);
echo form_open('product/shop/delscat',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<div class="show_notice_small">
Để thực hiện điều chỉnh cho thuộc tính sản phẩm. Vui lòng click vào Icon cập nhật
</div>
<table class="admindata">

    <?
    $k=1;
    foreach($list as $rs):
   	 $listsub  = $this->manage->get_all_main_category($rs->catid);
    ?>
    <thead>
        <tr>
            <th colspan="3" align="left">
            	<div style="float: left;text-transform: uppercase;color: #fff;"><?=$rs->catname;?></div>
            </th>
            <th>
            <?=icon_add1('features/manage/add_features_cat/'.$rs->catid.'/'.$cat_id);?>  
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Danh mục</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $j=1;
    foreach($listsub as $sub):
    	$listsub1  = $this->manage->get_all_main_category($sub->catid);
    ?>
    <tr class="row<?=$j?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$sub->catid?>"></td>
        <td><?=$sub->catid?></td>
        <td style="padding-left: 10px;"><?=$sub->catname?></td>

        <td align="center">
            <?if(count($listsub1) ==0){?>
            <?=icon_add1('features/manage/add_features_cat/'.$sub->catid.'/'.$cat_id)?>      
            <?}?>
        </td>
    </tr>
    <?foreach($listsub1 as $val):
    $listsub2  = $this->manage->get_all_main_category($val->catid); 
    ?>
    <tr class="row<?=$j?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$val->catid?>"></td>
        <td><?=$val->catid?></td>
        <td style="padding-left: 10px;">|____ <?=$val->catname?></td>

        <td align="center">
            <?=icon_add1('features/manage/add_features_cat/'.$val->catid.'/'.$cat_id)?>      
        </td>
    </tr>
    
    <?foreach($listsub2 as $val1):?> 
    <tr class="row<?=$j?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$val1->catid?>"></td>
        <td><?=$val1->catid?></td>
        <td style="padding-left: 10px;">|_______ <?=$val1->catname?></td>

        <td align="center">
            <?=icon_add1('features/manage/add_features_cat/'.$val1->catid.'/'.$cat_id)?>      
        </td>
    </tr>
    <?endforeach;?>
    <?endforeach;?>   
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