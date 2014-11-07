<?echo form_open('callme/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">

                Hiện có <?=$num?> Liên hệ tư vấn <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('callme/ds/0/id/desc','ID')?></th>
            <th><?=vnit_order('callme/ds/0/productid/desc','Sản phẩm')?></th>
            <th style="width: 150px;"><?=vnit_order('callme/ds/0/fullname/desc','Họ và tên')?></th>
            <th style="width: 100px;"><?=vnit_order('callme/ds/0/phone/desc','Điện thoại')?></th>
            <th style="width: 40px;"><?=vnit_order('callme/ds/0/checked/desc','Trạng thái')?></th>
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
        <td><?=$this->vdb->find_by_id('shop_product',array('productid'=>$rs->productid))->productname?></td>
        <td><?=$rs->fullname?></td>
        <td><?=$rs->phone?></td>
        <td align="center">
            <?if($rs->checked == 1){?>
            <img src="<?=base_url()?>templates/icon/bulb.png" alt="Đã liên hệ">
            <?}else{?>
            <img src="<?=base_url()?>templates/icon/bulb-red.png" alt="Chưa liên hệ">
            <?}?>
        </td>
        <td align="center">
            <?php echo icon_edit('callme/edit/'.$rs->id.'/'.(int)$this->uri->segment(3))?>
            <?=icon_del('callme/del/'.$rs->id.'/'.(int)$this->uri->segment(3))?>
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="7">

            Hiện có <?=$num?> Liên hệ tư vấn <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
