<?echo form_open('giamgia/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="9">

                Hiện có <?=$num?> Mã giảm giá <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('giamgia/ds/0/discount_id/desc','ID')?></th>
            <th><?=vnit_order('giamgia/ds/0/discount_key/desc','Mã giảm giá')?></th>
            <th><?=vnit_order('giamgia/ds/0/discount_price/desc','Giá trị')?></th>
            <th><?=vnit_order('giamgia/ds/0/discount_total/desc','Tổng')?></th>
            <th><?=vnit_order('giamgia/ds/0/discount_sum/desc','Đã sử dụng')?></th>
            <th><?=vnit_order('giamgia/ds/0/discount_datebegin/desc','Bắt đầu')?></th>
            <th><?=vnit_order('giamgia/ds/0/discount_dateend/desc','Kết thúc')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->discount_id?>"></td>
        <td><?=$rs->discount_id?></td>
        <td><?=$rs->discount_key?></td>
        <td><?=number_format($rs->discount_price,0,'.','.')?></td>
        <td><?=$rs->discount_total?></td>
        <td><?=$rs->discount_sum?></td>
        <td><?=date('d/m/Y',$rs->discount_datebegin)?></td>
        <td><?=date('d/m/Y',$rs->discount_dateend)?></td>
        <td align="center">
            <?=icon_edit('giamgia/edit/'.$rs->discount_id)?>
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="9">
            Hiện có <?=$num?> Mã giảm giá <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
