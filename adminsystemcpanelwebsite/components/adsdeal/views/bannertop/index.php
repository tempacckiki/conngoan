<?echo form_open('adsdeal/bannertop/dels',  array('id' => 'admindata'));?> 
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                Hiện có <?=count($list)?> quảng cáo top
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Tên quảng cáo</th>
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
        <td align="center"><?=$rs->ordering?></td>
        <td align="center">
            <?=icon_edit('adsdeal/bannertop/edit/'.$rs->id)?>
            <span id="publish<?=$rs->id?>"><?=icon_active("'banner_deal'","'id'",$rs->id,$rs->published,'adsdeal/bannertop/published')?></span>    
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="5">
            Hiện có <?=count($list)?> quảng cáo top
        </td>
    </tfoot>    
</table>
<?=form_close()?>