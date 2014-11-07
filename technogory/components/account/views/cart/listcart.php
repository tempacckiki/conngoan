<?
function get_status($status){
  if($status == 1){
      return 'Chưa xác nhận';
  }else if($status == 2){
      return 'Đã xác nhận';
  }else if($status==3){
      return 'Đang xử lý';
  }else if($status == 4){
      return 'Hoàn thành';
  }else if($status == 5){
      return 'Đã Hủy';
  }
}
?>

<div class="uleft">
    <?=$this->load->view('html/uleft')?>
</div>
<div class="ucontent">
    <div class="pathway" style="margin-bottom: 10px;">
        <ul>
            <li><a href="<?=base_url()?>" class="homepage">Trang chủ</a></li>
            <li><a href="#" class="active">Danh sách đơn hàng</a></li> 
        </ul>
    </div>
    <table class="listcart">
        <thead>
            <th style="padding: 10px 5px;width: 75px;">Mã đơn hàng</th>
            <th style="padding: 10px 5px;">Ngày mua</th>
            <th style="padding: 10px 5px;width: 120px;">Tổng tiền (VND)</th>
            <th style="padding: 10px 5px;width: 100px;">Tình trạng</th>
            <th style="padding: 10px 5px;width: 80px;">Chức năng</th>
        </thead>
        <?if(count($list) > 0){?>
        <?
        $k = 1;
        foreach($list as $rs):?>
        <tr class="row<?=$k?>">
            <td><?=$rs->barcode?></td>
            <td>    
            <?=date('H:i d/m/Y',$rs->date_buy)?>
            </td>
            <td align="right"><?=number_format($rs->total,0,'.','.')?></td>
            <td align="center"><?=get_status($rs->status)?></td>
            <td align="center">
                <a href="<?=site_url('giao-dich/thong-tin-don-hang/'.$rs->order_id)?>" title="Xem đơn hàng">
                    <img src="<?=base_url()?>site/templates/fyi/icon/view.png" alt="">
                </a>
                <a href="<?=site_url('giao-dich/xoa-don-hang/'.$rs->order_id)?>" title="Xóa đơn hàng">
                    <img src="<?=base_url()?>site/templates/fyi/icon/dels_status.png" alt="">
                </a>
            </td>
        </tr>
        <?
        $k = 1 - $k;
        endforeach;?>
        <?}?>
    </table>
</div>