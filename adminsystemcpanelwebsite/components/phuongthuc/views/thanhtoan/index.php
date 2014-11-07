<?echo form_open('phuongthuc/thanhtoan/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>

<ul class="tab">
    <?php 
    foreach ($listShipping as $valShipping){
		$shipping_id	 = $valShipping->shipping_id;
    ?>
    <li class="<?=($uri4 == $shipping_id)?'select':''?>"><a href="<?=site_url('phuongthuc/thanhtoan/ds/'.$valShipping->shipping_id)?>"><?=$valShipping->shipping_name;?></a></li>
    <?php 
    }
    ?>
</ul>

<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                Hiện có <?=$num;?> phương thức thanh toán
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th width="100">Hình</th>
            <th>Phương thức</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?php   
	    $k=1;
	    foreach($list as $rs):
    		$listsub = $this->vdb->find_by_list('shop_payment',array('parentid'=>$rs->payment_id,'shipping_id'=>$uri4));
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->payment_id?>"></td>
        <td><?=$rs->payment_id?></td>
        <td><img src="<?=base_url_site().'alobuy0862779988/payment/bank/thumb/'.$rs->payment_img;?>" width="80"></td>
        <td><?=$rs->payment_name?></td>
        <td align="center">
            <?=icon_edit('phuongthuc/thanhtoan/edit/'.$rs->payment_id)?>
            <span id="publish<?=$rs->payment_id?>"><?=icon_active("'shop_payment'","'payment_id'",$rs->payment_id,$rs->published,'phuongthuc/thanhtoan/published')?></span>    
        </td>
    </tr>
    <?foreach($listsub as $rs1):?>       
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs1->payment_id?>"></td>
        <td><?=$rs1->payment_id?></td>
        <td><img src="<?=base_url_site().'alobuy0862779988/payment/bank/thumb/'.$rs1->payment_img;?>" width="80"></td>
        <td>|__<?=$rs1->payment_name?></td>
        <td align="center">
            <?=icon_edit('phuongthuc/thanhtoan/edit/'.$rs1->payment_id)?>
            <span id="publish<?=$rs1->payment_id?>"><?=icon_active("'shop_payment'","'payment_id'",$rs1->payment_id,$rs1->published,'phuongthuc/thanhtoan/published')?></span>    
        </td>
    </tr>
    <?endforeach;?>
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