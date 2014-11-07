<?echo form_open('daugia/phienmuare/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">

<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<?$uri5 = (int)$this->uri->segment(5)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="9">
                Hiện có <?=$num?> Chiến thắng <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th style="width: 70px;">Hình ảnh</th>
            <th>Tên sản phẩm</th>
            <th class="w70">
                <div>Giá bán</div>
            </th>
            <th class="w70">
                <div>Giá khởi điểm</div>
            </th>
            <th class="w70">
                <div>Giá kết thúc</div>          
            </th>
            <th class="w100">
                <div>Tên thành viên</div>
            </th>
            <th style="width: 60px;">
                <div>Kết thúc</div>
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
            <img src="<?=base_url_img()?>daugia/200/<?=$pro->productimg?>" width="80" alt="">
        </td>
        <td><?=$this->vdb->find_by_id('product_bid',array('productid'=>$rs->productid))->productname?></td>
        <td align="right">
            <?=number_format($rs->price_old,0,'.',',')?>
        </td>
        <td align="right">
            <?=number_format($rs->price_bid,0,'.',',')?>
        </td>
        <td align="right">
            <?=number_format($rs->price_last,0,'.',',')?>
        </td>
        <td><?=$rs->buyer_name?></td>
        <td style="text-align: center;"><?=date('H:i:s',$rs->time_begin)?><br /><?=date('d/m/Y',$rs->time_begin)?></td>
        <td align="center">
            <a href="<?=site_url('daugia/phiendaugia/lichsubid/'.$rs->id.'/'.$uri4)?>" title="Lịch sử Bid">
                <img src="<?=base_url()?>templates/icon/wait.png">
            </a>
        </td>
    </tr>   
  
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="9">
            Hiện có <?=$num?> Chiến thắng <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
