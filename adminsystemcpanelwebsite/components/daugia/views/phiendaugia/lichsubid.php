
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="3">
                Hiện có <?=$num?> lượt bid <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th>Người Bid</th>
            <th style="width: 120px;">Giá Bid</th>
            <th style="width: 120px;">Thời gian Bid</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td><?=$rs->fullname?></td>
        <td style="text-align: right;"><?=number_format($rs->bid_price,0,'.',',')?></td>
        <td><?=date('H:i:s d/m/Y',$rs->bid_time)?></td>
    </tr>   
  
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="3">
            Hiện có <?=$num?> lượt Bid <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
