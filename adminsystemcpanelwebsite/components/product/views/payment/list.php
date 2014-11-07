<?echo form_open('product/shop/delscomment',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">

<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="4">
                Hiện có <?=$num?> phương thức thanh toán
                 
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Phương thức</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->payment_id?>"></td>
        <td><?=$rs->payment_id?></td>
        <td><?=$rs->payment_name?></td>
        <td align="center">
            <?=icon_edit('product/payment/edit/'.$rs->payment_id)?>
            <span id="publish<?=$rs->payment_id?>"><?=icon_active("'shop_payment'","'payment_id'",$rs->payment_id,$rs->published)?></span>
            <?//=icon_del('shop/delcomment/'.$rs->commentid.'/'.$this->uri->segment(3))?>        
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="5">
                    Hiện có <?=$num?> phương thức thanh toán
                </td>
            </tfoot>    
</table>
<?=form_close()?>
