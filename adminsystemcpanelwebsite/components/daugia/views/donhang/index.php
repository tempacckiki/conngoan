<fieldset>
    <legend>Thống kê</legend>
    <table class="form">
        <tr>
            <td style="width: 150px;">Tổng số đơn hàng:</td>
            <td style="width: 24%;"><b> <?=$this->donhang->get_total_donhang()?></b></td>
            <td style="width: 150px;">Đơn hàng Mới nhất:</td>
            <td><b> <?=$this->donhang->get_num_donhang('moinhat')?></b></td>
        </tr>
        <tr>
            <td>Đơn hàng Chưa xác nhận:</td>
            <td><b> <?=$this->donhang->get_num_donhang('chuaxacnhan')?></b></td>
            <td>Đơn hàng Đã xác nhận:</td>
            <td><b> <?=$this->donhang->get_num_donhang('daxacnhan')?></b></td>
        </tr>
        <tr>
            <td>Đơn hàng Đã hoàn thành:</td>
            <td><b> <?=$this->donhang->get_num_donhang('hoanthanh')?></b></td>
            <td>Đơn đơn Đang xử lý:</td>
            <td><b> <?=$this->donhang->get_num_donhang('dangxuly')?></b></td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>Đơn đơn Đã hủy:</td>
            <td><b> <?=$this->donhang->get_num_donhang('dahuy')?></b></td>
        </tr>
    </table>
</fieldset>
<?
$uri4 = $this->uri->segment(4);
?>
<ul class="tab">
    <li class="<?=($uri4 == 'moinhat')?'select':''?>"><a href="<?=site_url('daugia/donhang/ds/moinhat')?>">Mới nhất</a></li>
    <li class="<?=($uri4 == 'chuaxacnhan')?'select':''?>"><a href="<?=site_url('daugia/donhang/ds/chuaxacnhan')?>">Chưa xác nhận</a></li>
    <li class="<?=($uri4 == 'daxacnhan')?'select':''?>"><a href="<?=site_url('daugia/donhang/ds/daxacnhan')?>">Đã xác nhận</a></li>
    <li class="<?=($uri4 == 'dangxuly')?'select':''?>"><a href="<?=site_url('daugia/donhang/ds/dangxuly')?>">Đang xử lý</a></li>
    <li class="<?=($uri4 == 'hoanthanh')?'select':''?>"><a href="<?=site_url('daugia/donhang/ds/hoanthanh')?>">Hoàn thành</a></li>
    <li class="<?=($uri4 == 'dahuy')?'select':''?>"><a href="<?=site_url('daugia/donhang/ds/dahuy')?>">Đã hủy</a></li>
</ul>
<?echo form_open('daugia/donhang/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$offset?>">
<input type="hidden" name="tinhtrang" value="<?=$uri4?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="10">
                Hiện có <?=$num?> đơn hàng <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('daugia/donhang/ds/'.$uri4.'/0/barcode/asc','Mã đơn hàng')?></th>
            <th><?=vnit_order('daugia/donhang/ds/'.$uri4.'/0/hovaten/asc','Tên khách hàng')?></th>
            <th style="width: 80px;"><?=vnit_order('daugia/donhang/ds/'.$uri4.'/0/ngaymua/asc','Ngày đặt hàng')?></th>
            <th style="width: 100px;"><?=vnit_order('daugia/donhang/ds/'.$uri4.'/0/thanhpho_id/asc','Khu vực')?></th>
            <th style="width: 80px;"><?=vnit_order('daugia/donhang/ds/'.$uri4.'/0/soluong/asc','Số lượng')?></th>
            <th style="width: 80px;"><?=vnit_order('daugia/donhang/ds/'.$uri4.'/0/tongtien/asc','Tổng tiền')?></th>
            
            <th style="width: 100px;"><?=vnit_order('daugia/donhang/ds/'.$uri4.'/0/tinhtrang/asc','Tình trạng')?></th>
            <th style="width: 100px;"><?=vnit_order('daugia/donhang/ds/'.$uri4.'/0/admin_user_id/asc','NVKD')?></th>
            <th style="width: 80px;">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->cart_id?>"></td>
        <td><?=$rs->barcode?></td>
        <td><?=$rs->hovaten?></td>
        <td><?=date('d/m/Y',$rs->ngaymua)?></td>
        
        <td><?=$this->vdb->find_by_id('city',array('city_id'=>$rs->thanhpho_id))->city_name?></td>
        <td><?=$rs->soluong?></td>
        <td><?=number_format($rs->tongtien,0,'.','.')?></td>
        
        <td><?=get_status($rs->tinhtrang)?></td>
        <td><?=($rs->admin_user_id != 0)?$this->vdb->find_by_id('user',array('user_id'=>$rs->admin_user_id))->fullname:''?></td>
        <td align="center">
            <?=icon_edit('daugia/donhang/chitiet/'.$rs->cart_id.'/'.$uri4.'/'.$offset)?>       
            <?=icon_del('daugia/donhang/del/'.$rs->cart_id.'/'.$uri4.'/'.$offset)?>       
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="10">
            Hiện có <?=$num?> đơn hàng <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
