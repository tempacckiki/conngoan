<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" id="cart_id" name="id" value="<?=$rs->cart_id?>">
<fieldset>
    <legend>Thông tin</legend>
    <table width="100%" class="info">
        <tr>
            <td width="49%">
                <div><b>Tên khách hàng</b>: <?=$rs->hovaten?></div>
                <div><b>Địa chỉ giao hàng</b>: <?=$rs->diachi?></div>
                <div><b>Khu vực</b>: <?//=$val->b_email?></div>
                <div><b>Điện thoại:</b>: <?=$rs->dienthoai?></div>
                <div><b>Email:</b>: <?=$rs->email?></div>
                <div><b>Thời gian nhận hóa đơn:</b>: <?=date('H:i d/m/Y',$rs->ngaymua)?></div>
            </td>
            <td >
                <div><b>Phương thức thanh toán</b>: <?=$this->vdb->find_by_id('shop_payment',array('payment_id'=>$rs->phuongthucthanhtoan_id))->payment_name?></div>
                <div><b>Phương thức giao hàng</b>: <?=$this->vdb->find_by_id('shop_shipping',array('shipping_id'=>$rs->phuongthucgiaohang_id))->shipping_name?></div>
            </td>
        </tr>
    </table>
</fieldset>

<fieldset>
    <legend>Thông tin sản phẩm</legend>
    <table class="admindata">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th style="width: 120px;">Số lượng</th>
                <th style="width: 120px;">Đơn giá</th>
                <th style="width: 120px;">Thành tiền</th>
            </tr>        
        </thead>
        <tr class="row1">
            <td>
                <b><?=$cheap->product_title?></b><br />
                <?=$cheap->cheap_title?>
            </td>
            <td><?=$rs->soluong?></td>
            <td align="right"><?=number_format($rs->giaban,0,'.','.')?></td>
            <td align="right"><?=number_format($rs->thanhtien,0,'.','.')?></td>
        </tr>
        <tr class="row0">
            <td rowspan="4" colspan="2" valign="top">
                <p>Mã khuyến mãi:</p>
                <?foreach($giamgia as $val):?>
                    <div style="padding-left: 50px;"><?=$val->key?></div>
                <?endforeach;?>
            </td>
            <td>Giảm giá</td>
            <td align="right"><?=number_format($tonggiamgia,0,'.','.')?></td>
        </tr> 
        <tr class="row0">

            <td>Phí giao hàng</td>
            <td align="right">0</td>
        </tr> 
        <tr class="row0">

            <td>Phí thanh toán</td>
            <td align="right">0</td>
        </tr>
        <tr class="row0">

            <td><b>Tổng thanh toán</b></td>
            <td align="right"><?=number_format($rs->tongtien,0,'.','.')?></td>
        </tr>
    </table>
</fieldset>

<fieldset>
    <legend>Thông tin ghi chú</legend>
    <table style="width: 100%;">
        <tr>
            <td style="width: 49%;padding-right: 10px;">
                <div>Ghi chú từ khách hàng</div>
                <div>
                    <textarea style="width: 99%; height: 100px;" id="ghichu" name="cart[ghichu]"><?=$rs->ghichu?></textarea>
                </div>
                
            </td>
            <td>
                <div>Ghi chú từ quản trị</div>
                <div><textarea style="width: 99%; height: 100px;" name="cart[ghichuquantri]"><?=$rs->ghichuquantri?></textarea></div>
                <div>Tình trạng đơn hàng
                    <select name="cart[tinhtrang]">
                        <option value="1" <?=($rs->tinhtrang==1)?'selected="selected"':''?>>Chưa xác nhận</option>
                        <option value="2" <?=($rs->tinhtrang==2)?'selected="selected"':''?>>Đã xác nhận</option>
                        <option value="3" <?=($rs->tinhtrang==3)?'selected="selected"':''?>>Hoàn thành</option>
                        <option value="4" <?=($rs->tinhtrang==4)?'selected="selected"':''?>>Đã hủy</option>
                    </select>
                </div>
                <div><input type="submit" value="Cập nhật"></div>
            </td>
        </tr>
    </table>
</fieldset>
<?=form_close()?>
<style>
table.info td{
    padding: 5px;
}
table.info td div{
    margin-bottom: 5px;
}
</style>