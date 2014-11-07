<?echo form_open('quangcao/danhmuc/dels',  array('id' => 'admindata'));?> 
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
                    <?foreach($listcat as $val):?>
                    <option value="<?=site_url('quangcao/danhmuc/ds/'.$val->catid)?>" <?=($catid == $val->catid)?'selected="selected"':''?>><?=$val->catname?></option>
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
            <?=icon_edit('quangcao/danhmuc/edit/'.$rs->id.'/'.$catid)?>
            <span id="publish<?=$rs->id?>"><?=icon_active("'banner'","'id'",$rs->id,$rs->published,'quangcao/danhmuc/published')?></span>    
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