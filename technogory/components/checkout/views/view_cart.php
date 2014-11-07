<div class="box-content-wapper">
<div class="box-dathang">
    <div class="c-dathang">
        <div class="element-dathang">
            <h2 class="step-title-active">Giỏ hàng</h2>
            <div class="step-body-active" style="padding: 7px 10px 17px;">
            <?if(count($list) > 0){?>
                <?=form_open(uri_string())?>
                <table class="donhang">
                    <thead>
                    <tr>
                        <th style="width: 20px;">Xóa</th>

                        <th>Sản phẩm</th>
                        <th style="width: 80px;">Đơn giá</th>
                        <th style="width: 60px;">Số lượng</th>
                        <th style="width: 80px;">Thành tiền</th>

                    </tr>
                    </thead>
                    <?
                    $k=1;
                    $discount_price = 0;
                    $total_price = 0;
                    foreach($list as $rs):
                    $total_price = $total_price + ($rs->s_qty * $rs->s_price);
                    ?>
                    <tr>
                        <td>
                            <input type="hidden" value="<?=$rs->id?>" name="ar_id[]">
                            <input type="checkbox" value="<?=$rs->productid?>" name="del_id_<?=$rs->id?>">
                        </td>

                        <td>
                            <a href="<?=site_url('product/view_product/'.$rs->producturl.'-'.$rs->productid)?>">
                            <img src="<?=base_url()?>data/img_product/80/<?=$rs->productimg?>" alt="" align="left" style="padding-right: 10px;"></a>
                            <b><?=anchor('product/view_product/'.$rs->producturl.'-'.$rs->productid,$rs->productname)?></b>


                        </td>
                        <td style="text-align: right;"><?=number_format($rs->s_price,0,'.','.')?></td>
                        <td><input type="text" name="qty_<?=$rs->id?>" value="<?=$rs->s_qty?>" style="width: 50px; text-align: right;"></td>
                        <td style="text-align: right;"><?=number_format($rs->s_price * $rs->s_qty,0,'.','.')?></td>

                    </tr>
                    <?
                    $k++;
                    endforeach;?>
                    <tr>
                        <td colspan="4" style="text-align: right;">Tổng</td>
                        <td style="text-align: right;"><?=number_format($total_price,0,'.','.')?></td>
                    </tr>
                    <tr>
                        <td colspan="4" style="text-align: right;">Tổng giá trị đơn hàng</td>
                        <td style="text-align: right;" colspan="2"><?=number_format($total_price - $discount_price,0,'.','.')?></td>
                    </tr>                
                </table>
                <div style="text-align: right;overflow: hidden;padding-top: 10px;height: 30px;">
                    <input type="submit" class="submit_cart" value="Cập nhật">
                    <a href="<?=base_url()?>" class="bt_ok"><span>Tiếp tục mua hàng</span></a>   
                    <a href="<?=site_url('checkout/step_two')?>" class="bt_ok"><span>Thanh toán</span></a>   
                </div>
                <input type="hidden" name="step" value="1">
                <?=form_close()?>
                <?}else{?>
                    <div class="show_notice">Không có sản phẩm nào trong giỏ hàng <a href="<?=base_url()?>"><b>Tiếp tục mua hàng</b></a></div>
                <?}?>
            </div>


        </div>
    </div>
</div>
</div>
