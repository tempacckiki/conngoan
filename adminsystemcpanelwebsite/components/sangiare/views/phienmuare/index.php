<?echo form_open('sangiare/phienmuare/dels',  array('id' => 'admindata'));?> 
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
            <th><?=vnit_order('sangiare/phienmuare/ds/'.$uri4.'/0/product_title/asc','Tên sản phẩm')?></th>
            <th><?=vnit_order('sangiare/phienmuare/ds/'.$uri4.'/0/cheap_title/asc','Tiêu đề')?></th>
            <th class="w70">
                <div><?=vnit_order('sangiare/phienmuare/ds/'.$uri4.'/0/cheap_price_old/asc','Giá thị trường')?></div>
            </th>
            <th class="w70">
                <div><?=vnit_order('sangiare/phienmuare/ds/'.$uri4.'/0/cheap_price/asc','Giá mua rẻ')?></div>          
            </th>
            <th class="w100">
                <div><?=vnit_order('sangiare/phienmuare/ds/'.$uri4.'/0/cheap_saving/asc','Tiết kiệm')?></div>
            </th>
            <th style="width: 60px;">
                <div><?=vnit_order('sangiare/phienmuare/ds/'.$uri4.'/0/cheap_timebegin/asc','Bắt đầu')?></div>
            </th>
            <th style="width: 60px;">
                <div><?=vnit_order('sangiare/phienmuare/ds/'.$uri4.'/0/cheap_timeend/asc','Kết thúc')?></div>
            </th>
            <th style="width: 60px;">
                <div><?=vnit_order('sangiare/phienmuare/ds/'.$uri4.'/0/cheap_timeend/asc','Tình trang')?></div>
            </th>
            <th style="width: 40px;">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    $pro = $this->vdb->find_by_id('shop_product',array('productid'=>$rs->productid));
    ?>
    <tr class="row<?=($rs->cheap_del == 1)?'3':$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->id?>"></td>
        <td>
            <img src="<?=base_url_site()?>data/sangiare/200/<?=$pro->productimg?>" width="80" alt="">
        </td>
        <td><?=$this->vdb->find_by_id('shop_product',array('productid'=>$rs->productid))->productname?></td>
        <td><?=$rs->cheap_title?></td>
        <td align="right">
            <?=number_format($rs->cheap_price_old,0,'.',',')?>
        </td>
        <td align="right">
            <?=number_format($rs->cheap_price,0,'.',',')?>
        </td>
        <td><?=number_format($rs->cheap_saving)?> = <?=$rs->cheap_per?>%</td>
        <td style="text-align: center;"><?=date('H:i:s',$rs->cheap_timebegin)?><br /><?=date('d/m/Y',$rs->cheap_timebegin)?></td>
        <td style="text-align: center;"><?=date('H:i:s',$rs->cheap_timeend)?><br /><?=date('d/m/Y',$rs->cheap_timeend)?></td>
        <td align="center">
            <?if($rs->cheap_timeend < time()){?>
                <img src="<?=base_url()?>templates/icon/ketthuc.png" alt="Đã kết thúc" title="Đã kết thúc">

            <?}else{?>
                <img src="<?=base_url()?>templates/icon/dangdienra.png" alt="Đang diễn ra" title="Đang diễn ra">
            <?}?>
        </td>
        <td align="center">
            <?=icon_edit('sangiare/phienmuare/edit/'.$rs->id.'/'.$uri4.'/'.$uri5)?>
            <?=icon_del('sangiare/phienmuare/del/'.$rs->id.'/'.$uri4.'/'.$uri5)?>
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
