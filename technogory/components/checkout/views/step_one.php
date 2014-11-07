<div class="box-content-wapper">
<?if(count($list) > 0){?>
<div class="box-cart-group">
	<div class="cart-buyer-info">
                <?=form_open(uri_string())?>

                <table class="cart">
					<thead>
						<tr>

							<th align="left">Sản phẩm</th>
							<th width="200" align="left">Dự kiến giao hàng</th>
							<th style="width: 80px;">Đơn giá</th>
							<th style="width: 60px;">Số lượng</th>
							<th style="width: 20px;">Xóa</th>
							<th style="width: 100px;">Thành tiền</th>

						</tr>
					</thead>
                    <?
                    $k=1;
                    $discount_price = 0;
                    $total_price = 0;
                    foreach($list as $rs):
                    $total_price = $total_price + ($rs->s_qty * $rs->s_price);
                    $listgift = $this->vnitcart->get_gifts($rs->id);
                    $listcolor = $this->vnitcart->get_icolor($rs->productid); 
                    ?>
                    <tr>

						<td><a
							href="<?=site_url('product/'.$rs->producturl.'-'.$rs->productid)?>">
								<img
								src="<?=base_url_img()?>alobuy0862779988/0862779988product/80/<?=$rs->productimg?>"
								alt="" align="left" style="padding-right: 10px;">
						</a> <b><?=anchor('san-pham/'.$rs->producturl.'-'.$rs->productid,$rs->productname,array('class'=>'title_product'))?></b>
                            <?if(count($listgift) > 0){?>
                            <ul class="listgifts">
                            <?foreach($listgift as $val):?>
                            <li><?=$val->name?></li>
                            <?endforeach;?>
                            </ul>
                            <?}?>
                        </td>
						<td valign="middle" class="du-kien">
                            Hàng sẽ được giao trong vòng 1-3 ngày làm việc 
                            <a href="<?=site_url('huong-dan/giao-hang-25');?>">Xem chi tiết</a>
                        </td>
						<td style="text-align: right;"><?=number_format($rs->s_price,0,'.','.')?></td>
						<td><input type="text" name="qty_<?=$rs->id?>"
							value="<?=$rs->s_qty?>"
							style="width: 30px; text-align: right; margin-right: 5px;"><input
							type="submit" class="save" value=""></td>
						<td align="center"><input type="hidden" value="<?=$rs->id?>"
							name="ar_id[]"> <a
							href="<?=site_url('checkout/remove/'.$rs->id)?>"><img
								src="<?=base_url()?>technogory/templates/default/icon/dels_status.png"
								alt=""></a> <!--<input type="checkbox" value="<?=$rs->productid?>" name="del_id_<?=$rs->id?>">-->
						</td>
						<td style="text-align: right;margin-right: 3px;border-right:solid 2px #ccc; "><?=number_format($rs->s_price * $rs->s_qty,0,'.','.').' VND';?></td>

					</tr>
					
					
                    <?
                    $k++;
                    endforeach;?>
                    
				</table>
				
				<div class="box-payment-security-cart">
					<div class="sub-vote-payment">
						<div class="payment">
							<p class="title">Cách thức thanh toán</p>
							<div class="photo-payment">
								<img src="<?=base_url();?>technogory/templates/default/images/payment.png">
							</div>
						</div>
						
						<div class="distcount-vote">
							<p class="title">Phiếu giảm giá</p>
							<p class="text">Sử dụng mã giảm giá ở đây:</p>
							<form action="">
								<input type="text" value="">
								<input type="submit" value="Sử dụng">
							</form>
							<p class="note">
								Ghi chú: Mã giảm giá có thể không sử dụng cho sản phẩm khuyến mãi.
							</p>
						</div>
					</div>
				</div>
				
				<div class="box-cart-total">
					<div class="total-line"><strong>Tổng cộng: </strong> <span><?=number_format($total_price,0,'.','.').' VND';?></span></div>
					<div class="total-money">
						<strong>Thành tiền:</strong> 
						<p class="money">
							<?=number_format($total_price - $discount_price,0,'.','.'). ' VND';?>
							<br>
							<span>Bao gồm VAT</span>
						</p>
					</div>
					
					<div class="rounded shopping-continue">
						<a class="ui-button" href="<?=base_url();?>"><span>Tiếp tục mua sắm</span></a>
                     	<a class="ui-button sel-cart-add-button-new" href="<?=site_url('dang-nhap');?>">
                     		<span>Tiến hành thanh toán</span>
                     	</a>
                        
                     </div>
                        
				</div>
				
				<input type="hidden" name="step" value="1">
                <?=form_close()?>
            </div>		
</div>
<?}else{?>
    <div class="show_notice" style="margin: 10px; text-align: center;">
		Không có sản phẩm nào trong giỏ hàng <a href="<?=base_url()?>"><b>Tiếp
				tục mua hàng</b></a>
	</div>
<?}?>
</div>