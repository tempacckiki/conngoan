<?
function cart_status($status){
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
            <li><a href="<?=site_url('giao-dich/don-hang')?>">Danh sách đơn hàng</a></li> 
            <li><a href="#" class="active">Chi tiết đơn hàng</a></li> 
        </ul>
    </div>
    <div class="box_cart">
        <div class="head_cart">
            <div class="col1">
                <h3 class="company">CÔNG TY FYI VIỆT NAM</h3>
                <div>Địa chỉ: SS1N Hồng Lĩnh - F15 -Q10 -TP HCM</div>
                <div>Điện thoại: 84-8-3977 8088 - Fax: 84-8-3977 8088</div>
            </div>
            <div class="col2"><img src="<?=base_url()?>site/templates/fyi/images/logo_.png" alt=""></div>
        </div>
        <div class="title_barcode">
            <p>ĐƠN HÀNG ONLINE - ECOM</p>
            <p><?=$rs->barcode?></p>
        </div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 42%;">
                    <table class="info">
                        <tr>
                            <td class="label">Họ tên</td>
                            <td><?=$rs->fullname?></td>
                        </tr>
                        <tr>
                            <td class="label">Điện thoại</td>
                            <td><?=$rs->phone?></td>
                        </tr>
                        <tr>
                            <td class="label">Email</td>
                            <td><?=$rs->email?></td>
                        </tr>
                        <tr>
                            <td class="label">Địa chỉ</td>
                            <td><?=$rs->address?></td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table class="info">
                        <tr>
                            <td class="label">Phương thức thanh toán</td>
                            <td><?
                            $thanhtoan = $this->vdb->find_by_id('shop_payment',array('payment_id'=>$rs->payment_id));
                            echo ($thanhtoan)?$thanhtoan->payment_name:'';
                            ?></td>
                        </tr>
                        <tr>
                            <td class="label">Phương thức nhận hàng</td>
                            <td><?
                            $vanchuyen = $this->vdb->find_by_id('shop_shipping',array('shipping_id'=>$rs->shipping_id));
                            echo ($vanchuyen)?$vanchuyen->shipping_name:'';
                            ?></td>
                        </tr>
                        <tr>
                            <td class="label">Thời gian đặt hàng</td>
                            <td><?=date('H:i d/m/Y',$rs->date_buy)?></td>
                        </tr>
                        <tr>
                            <td class="label">Tình trạng đơn hàng</td>
                            <td id="status_text"><?=cart_status($rs->status)?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="height: 10px;"></div>
        <table class="listcart">
            <thead>
                <th style="padding: 10px 5px;width: 105px;">Mã sản phẩm</th>
                <th style="padding: 10px 5px;">Tên sản phẩm</th>
                <th style="padding: 10px 5px;width: 30px;">SL</th>
                <th style="padding: 10px 5px;width: 80px;">Đơn giá</th>
                <th style="padding: 10px 5px;width: 80px;">Thành tiền</th>
            </thead>
            
            <?
            $k = 1;
            $subtotal = 0;
            foreach($list_product as $val):
            $tongtien = $val->s_qty * $val->s_price;
            $subtotal = $subtotal + $tongtien;
            ?>
            <tr class="row<?=$k?>">
                <td><?=$val->barcode?></td>
                <td><?=$val->productname?></td>
                <td align="center"><?=$val->s_qty?></td>
                <td align="right"><?=number_format($val->s_price,0,'.','.')?></td>
                <td align="right"><?=number_format($tongtien,0,'.','.')?></td>
            </tr>
            <?endforeach?>
          </table>
          <div style="padding: 10px 0px; overflow: hidden;clear: both; margin-bottom: 10px;">
            <?if(count($list_discount) > 0){?>
            <div class="box_giamgia">
                <p><b>Phiếu khuyến mãi</b></p>
            <table class="info" width="100%">
                <?
                $giamgia = 0;
                foreach($list_discount as $val):
                $giamgia = $giamgia + $val->price;
                ?>
                <tr>
                    <td><?=$val->discount_key?></td>
                    <td>Giá trị: <?=number_format($val->price,0,'.','.')?> vnđ</td>
                </tr>
                <?endforeach;?>
            </table>
            </div>
            <?}else{
                $giamgia = 0;
            }?>
            <div class="box_total">
                <?
                $total = $subtotal + $rs->price_shipping - $giamgia;
                ?>
                <table class="info" width="100%">
                    <tr>
                        <td class="label" style="text-align: right;">Tổng</td>
                        <td><?=number_format($subtotal,0,'.','.')?></td>
                    </tr>
                    <tr>
                        <td class="label" style="text-align: right;">Giảm giá</td>
                        <td><?=number_format($giamgia,0,'.','.')?></td>
                    </tr>
                    <tr>
                        <td class="label" style="text-align: right;">Phí giao hàng</td>
                        <td><?=number_format($rs->price_shipping,0,'.','.')?></td>
                    </tr>
                    <tr>
                        <td class="label" style="text-align: right;">Tổng giá trị đơn hàng</td>
                        <td><p><span class="total"><?=number_format($total,0,'.','.')?></span> VNĐ</p></td>
                    </tr>
                </table>
            </div>
          </div>
        <?if($rs->status == 1){?>
        <div class="show_notice" id="show_notice" style="clear: both;margin: 5px">
            <p>Đơn hàng của bạn chưa được xác nhận. Hãy xác nhận ngay để mua hàng được nhanh hơn</p>
            <input type="hidden" id="cart_id" value="<?=$rs->order_id?>">
            <p><a href="javascript:;" id="xacnhandonhang" class="xacnhandonhang">Xác nhận đơn hàng</a></p>
        </div>
        <?}?>
    </div>
    
</div>