<div class="order_box">
    <div class="order-head">
        <div class="colleft">
            <p class="company"><?=$this->config->item('contact_name')?></p>
            <p>Địa chỉ: <?=$this->config->item('contact_address')?></p>
            <p>Điện thoại: <?=$this->config->item('contact_phone')?> - Fax: <?=$this->config->item('contact_fax')?></p>
        </div>
        <div class="colright">
            <img src="<?=base_url()?>templates/images/logo.png" align="right" height="70">
        </div>
    </div>
    <div class="title_order">
        <h3>ĐƠN HÀNG ONLINE - ECOM</h3>
        <h3><?=$info->barcode?></h3>
    </div>
    <table width="100%" class="info">
        <tr>
            <td width="49%">
                <table width="100%" class="info">
                    <tr>
                        <td class="label" style="width: 80px;">Họ tên</td>
                        <td><?=$info->fullname?></td>
                    </tr>
                    <tr>
                        <td class="label">Điện thoại</td>
                        <td><?=$info->phone?></td>
                    </tr>
                    <tr>
                        <td class="label">Email</td>
                        <td><?=$info->email?></td>
                    </tr>
                    <tr>
                        <td class="label">Địa chỉ</td>
                        <td><?=$info->address?>, <?=$this->vdb->find_by_id('city',array('city_id'=>$info->districts_id))->city_name?>, <?=$this->vdb->find_by_id('city',array('city_id'=>$info->city_id))->city_name?></td>
                    </tr>
                </table>
            </td>
            <td width="49%">
                <table width="100%" class="info">
                    <tr>
                        <td class="label" style="width: 150px;">Phương thức thanh toán</td>
                        <td><?=$this->vdb->find_by_id('shop_payment',array('payment_id'=>$info->payment_id))->payment_name?></td>
                    </tr>
                    <tr>
                        <td class="label">Phương thức nhận hàng</td>
                        <td><?=$this->vdb->find_by_id('shop_shipping',array('shipping_id'=>$info->shipping_id))->shipping_name?></td>
                    </tr>
                    <tr>
                        <td class="label">Thời gian đặt hàng</td>
                        <td><?=date('H:i d/m/Y',$info->date_buy)?></td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

    <table class="admindata">
        <thead>
            <tr>
                <th class="id">ID</th>
                <th>Tên sản phẩm</th>
                <th style="width: 120px;">Số lượng</th>
                <th style="width: 120px;">Đơn giá</th>
                <th style="width: 120px;">Thành tiền</th>
            </tr>        
        </thead>
        <?
        $k=1;
        $qty = 0;
        $total = 0;
        foreach($list as $rs):
        $list_gifts = $this->order->get_gifts($rs->id);
        $qty = $qty + $rs->s_qty;
        $total = $total + ($rs->s_price * $rs->s_qty);
        ?>
        <tr class="row<?=$k?>">
            <td><?=$rs->productid?></td>
            <td>
            <b><?=$rs->productname?></b>
                <ul>
                    <?foreach($list_gifts as $val):?>
                    <li>- <?=$val->name?> _Áp dụng đến <?=format_date($val->dateend,'d/m/Y')?></li>
                    <?endforeach;?>
                </ul>
            </td>
            <td align="center"><?=$rs->s_qty?></td>
            <td align="right"><b><?=number_format($rs->s_price,0,'.','.')?></b></td>
            <td align="right"><b><?=number_format($rs->s_price * $rs->s_qty,0,'.','.')?></b> VND</td>
        </tr>       
        <?
        $k=1-$k;
        endforeach;
        ?>    
    </table>
    <div style="clear: both; overflow: hidden; margin-bottom: 10px;">
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
        <div class="box_total">
            <table class="info" width="100%">
                <tr>
                    <td class="label" style="width: 140px; text-align: right;">Tổng</td>
                    <td><b><?=number_format($total,0,'.','.')?></b> VND</td>
                </tr>
                <tr>
                    <td class="label" style="text-align: right;">Giảm giá</td>
                    <td><b><?=number_format($giamgia,0,'.','.')?></b> VND</td>
                </tr>
                <tr>
                	<?php 
                	 $phiVanChuyen = (number_format($info->price_shipping,0,'.','.') == 0)?'Liên hệ': number_format($info->price_shipping,0,'.','.').'VND';
                	?>
                    <td class="label" style="text-align: right;">Phí giao hàng</td>
                    <td><b><?=$phiVanChuyen?></b></td>
                </tr>
            </table>
        </div>
    </div>
    <div class="total_order">
        <?
        $tongdonhang = $total - $giamgia + ($info->price_shipping);
        ?>
        Tổng giá trị đơn hàng: <span class="price"><?=number_format($tongdonhang,0,'.','.')?></span> vnđ
        
    </div>
    <div class="cp_info">
    <?=form_open(uri_string(),array('id'=>'admindata'))?>
    <input type="hidden" name="order_id" value="<?=$info->order_id?>">
    <table class="form">
        <tr>
            <td>
                Ghi chú khách hàng<br />
                <textarea style="width: 500px; height: 100px;" name="cart[notes]"><?=$info->notes?></textarea><br />
                <input type="checkbox" name="sendmail" value="1"> Gửi email cho khách hàng
                <?
                $transfer = $this->vdb->find_by_id('shop_message_transfer',array('order_id'=>$info->order_id));
                if($transfer){
                ?>
                <div style="font-weight: 100;">
                    <b>Thông báo chuyển khoản:</b><br />
                    <?echo date('H:i d/m/Y',$transfer->date)?><br /><?=nl2br($transfer->message)?>
                </div>
                <?}?>
            </td>
            <td>
                Ghi chú Quản trị<br />
                <textarea style="width: 500px; height: 100px;" name="cart[admin_notes]"><?=$info->admin_notes?></textarea><br />
                <select name="cart[status]">
                    <option value="1" <?=($info->status==1)?'selected="selected"':''?>>Chưa xác nhận</option>
                    <option value="2" <?=($info->status==2)?'selected="selected"':''?>>Đã xác nhận</option>
                    <option value="3" <?=($info->status==3)?'selected="selected"':''?>>Đang xử lý</option>
                    <option value="4" <?=($info->status==4)?'selected="selected"':''?>>Hoàn thành</option>
                    <option value="5" <?=($info->status==5)?'selected="selected"':''?>>Đã hủy</option>
                </select>
            </td>
        </tr>

    </table>
    <?=form_close()?>
    </div>
</div>
