<?php 
$catID   = $this->uri->segment('4');
?>
<?php echo form_open('quangcao/chitiet/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$catid?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="6">
                Hiện có <?=count($list)?> quảng cáo danh mục
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Tên quảng cáo</th>
            <th style="width: 200px;">
                <select  onchange="window.open(this.value,'_self');" style="width: 200px;">
                    <option value="<?=site_url('quangcao/chitiet/ds/0');?>">|- Chọn chuyên mục</option>                    
                    <option value="<?=site_url('quangcao/chitiet/ds/0');?>" <?=($catID == 0 )?'selected="selected"':'';?>>|- Trang chủ</option>                    
                     <?foreach($listcat as $cat):
	                $listsub = $this->danhmuc->get_sub_cat($cat->catid); 
	                ?>
	                <option value="<?=site_url('quangcao/chitiet/ds/'.$cat->catid);?>" style="font-size: 16px;font-weight: bold;" <?=($catID == $cat->catid )?'selected="selected"':'';?>><?=$cat->catname?></option>
	                <?foreach($listsub as $val):
	                $listsub1 = $this->danhmuc->get_sub_cat($val->catid);
	                ?>
	                <option value="<?=site_url('quangcao/chitiet/ds/'.$val->catid);?>" style="font-size: 14px;font-weight: bold;" <?=($catID == $val->catid)?'selected="selected"':'';?>>|___<?=$val->catname?></option>
	                <?foreach($listsub1 as $val1):
	                ?>
	                <option value="<?=site_url('quangcao/chitiet/ds/'.$val1->catid);?>" <?=($catID == $val1->catid)?'selected="selected"':'';?>>|___|___<?=$val1->catname?></option>
	                <?endforeach;?>
	                <?endforeach;?>
	                <?endforeach;?>
                
                </select>
            </th>
            <th style="width: 70px;">Sắp xếp</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><?=$rs->name?></td>
        <td><?=$this->vdb->find_by_id('shop_cat',array('catid'=>$rs->cat_id))->catname?></td>
        <td align="center"><?=$rs->ordering?></td>
        <td align="center">
            <?=icon_edit('quangcao/chitiet/edit/'.$rs->id.'/'.$catid)?>
            <span id="publish<?=$rs->id?>"><?=icon_active("'banner_detail'","'id'",$rs->id,$rs->published,'quangcao/chitiet/published')?></span>    
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="6">
            Hiện có <?=count($list)?> quảng cáo danh mục
        </td>
    </tfoot>    
</table>
<?=form_close()?>