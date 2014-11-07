<?echo form_open('thanhpho/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">

                Hiện có <?=$num?> liên hệ <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('thanhpho/listthanhpho/0/city_id/desc','Mã tỉnh')?></th>
            <th><?=vnit_order('thanhpho/listthanhpho/0/city_name/desc','Tỉnh, Thành phố')?></th>
             <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    $listparent = $this->vdb->find_by_list('city', array('parentid' => $rs->city_id));    
    ?>
    <tr class="row0">
        <td align="center">
        <?if($rs->city_id != 25){?>
        <input  type="checkbox" name="ar_id[]" value="<?=$rs->city_id?>">
        <?}?>
        </td>
        <td><?=$rs->city_id?></td>
        <td><?=$rs->city_name?></td>
        <td align="center">
            <?=icon_edit('thanhpho/edit/'.$rs->city_id.'/'.(int)$this->uri->segment(4))?>
            <span id="publish<?php echo $rs->city_id?>"><?php echo icon_active("'city'","'city_id'",$rs->city_id,$rs->published,'thanhpho/published')?></span>        
            <?if($rs->city_id != 25){?>
            <?=icon_del('thanhpho/del/'.$rs->city_id.'/'.(int)$this->uri->segment(4))?>        
            <?}?>
        </td>
    
    </tr>
    <?$i=1;
    foreach($listparent as $pr):?>   
    <tr class="row1">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$pr->city_id?>"></td>
        <td><?=$pr->city_id?></td>
        <td>
                |__<?=$pr->city_name?>
        </td>
        <td align="center">
            <?=icon_edit('thanhpho/edit/'.$pr->city_id.'/'.(int)$this->uri->segment(4))?>
            <span id="publish<?php echo $pr->city_id?>"><?php echo icon_active("'thanhpho'","'city_id'",$pr->city_id,$pr->published,'thanhpho/published')?></span>        
            <?=icon_del('thanhpho/del/'.$pr->city_id.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>
    <?endforeach;?> 
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="7">

            Hiện có <?=$num?> liên hệ <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
