<?echo form_open('phuongthuc/vanchuyen/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                Hiện có <?=$num?> phương thức vận chuyển
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th width="90">Hình ảnh</th>
            <th>Phương thức</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->shipping_id?>"></td>
        <td><?=$rs->shipping_id?></td>
		<td><img src="<?=base_url_site().'alobuy0862779988/payment/shipping/thumb/'.$rs->shipping_img;?>" width="80"></td>
        <td><?=$rs->shipping_name?></td>
        <td align="center">
            <?=icon_edit('phuongthuc/vanchuyen/edit/'.$rs->shipping_id)?>
            <span id="publish<?=$rs->shipping_id?>"><?=icon_active("'shop_shipping'","'shipping_id'",$rs->shipping_id,$rs->published,'phuongthuc/vanchuyen/published')?></span>
                    
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="5">
            Hiện có <?=$num?> phương thức vận chuyển
        </td>
    </tfoot>    
</table>
<?=form_close()?>
