<?echo form_open('daugia/phienmuare/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">

<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<?$uri5 = (int)$this->uri->segment(5)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="15">
                Hiện có <?=$num?> phiên mua rẻ <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th style="width: 70px;">Hình ảnh</th>
            <th><?=vnit_order('daugia/phiendaugia/ds/'.$uri4.'/product_name/asc','Tên sản phẩm')?></th>

            <th class="w70">
                <div><?=vnit_order('daugia/phiendaugia/ds/'.$uri4.'/price_old/asc','Giá bán')?></div>
            </th>
            <th class="w70">
                <div><?=vnit_order('daugia/phiendaugia/ds/'.$uri4.'/price/asc','Giá khởi điểm')?></div>          
            </th>
            <th class="w100">
                <div><?=vnit_order('daugia/phiendaugia/ds/'.$uri4.'/price_saving/asc','Tiết kiệm')?></div>
            </th>
            <th style="width: 60px;">
                <div><?=vnit_order('daugia/phiendaugia/ds/'.$uri4.'/time_begin/asc','Bắt đầu')?></div>
            </th>
            <th style="width: 60px;">
                <div><?=vnit_order('daugia/phiendaugia/ds/'.$uri4.'/time_end/asc','Kết thúc')?></div>
            </th>
            <th style="width: 60px;">
                <div><?=vnit_order('daugia/phiendaugia/ds/'.$uri4.'/stop/asc','Tình trang')?></div>
            </th>
            <th style="width: 40px;">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    $pro = $this->vdb->find_by_id('product_bid',array('productid'=>$rs->productid));
    ?>
    <tr class="row<?=($rs->bid_del == 1)?'3':$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->id?>"></td>
        <td>
            <img src="<?=base_url_img()?>alobuy0862779988/daugia/200/<?=$pro->productimg?>" width="80" alt="">            
        </td>
        <td><?=$this->vdb->find_by_id('product_bid',array('productid'=>$rs->productid))->productname?></td>

        <td align="right">
            <?=number_format($rs->price_old,0,'.',',')?>
        </td>
        <td align="right">
            <?=number_format($rs->price_bid,0,'.',',')?>
        </td>
        <td><?=number_format($rs->price_saving)?> = <?=$rs->per_saving?>%</td>
        <td style="text-align: center;"><?=date('H:i:s',$rs->time_begin)?><br /><?=date('d/m/Y',$rs->time_begin)?></td>
        <td style="text-align: center;"><?=date('H:i:s',$rs->time_end)?><br /><?=date('d/m/Y',$rs->time_end)?></td>
        <td align="center">
            <?if($rs->stop == 1){?>
                <img src="<?=base_url()?>templates/icon/ketthuc.png" alt="Đã kết thúc" title="Đã kết thúc">

            <?}else{?>
                <img src="<?=base_url()?>templates/icon/dangdienra.png" alt="Đang diễn ra" title="Đang diễn ra">
            <?}?>
        </td>
        <td align="center">
            <a href="<?=site_url('daugia/phiendaugia/lichsubid/'.$rs->id.'/'.$uri4)?>" title="Lịch sử Bid">
                <img src="<?=base_url()?>templates/icon/wait.png">
            </a>
            <?=icon_edit('daugia/phiendaugia/edit/'.$rs->id.'/'.$uri4.'/'.$uri5)?>
            <?=icon_del('daugia/phiendaugia/del/'.$rs->id.'/'.$uri4.'/'.$uri5)?>
        </td>
    </tr>   
  
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="15">
            Hiện có <?=$num?> phiên mua rẻ <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
