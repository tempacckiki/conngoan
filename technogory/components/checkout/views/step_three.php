<div class="box-dathang">
    <div class="c-dathang">
       
        <?=form_open(uri_string(),array('giaohang_thanhtoan'));?>
        <div class="step-container-active">
            <div class="step3-checkout-payment">
            	<div class="title">
            		1. Hình thức thanh toán
            	</div>
               
               <div class="box-shipping">
               	 <?foreach($listshiping as $key=>$val):?>
                    	<div class="item">
                      		<input <?=($key == 0)?'checked="checked"':''?> type="radio" name="shipping_id" value="<?=$val->shipping_id?>" onclick="change_ship(<?=$val->shipping_id?>)">
                      		<strong><?=$val->shipping_name?></strong>
                      		<div class="title_ship" id="title_ship<?=$val->shipping_id?>"></div>
                      	</div>
	                      <div class="description">  
	                        <?=$val->shipping_intro?>
	                      </div>
                   
                    <?endforeach;?>
               </div>
               
               

              	<div class="dataship">
              		<div id="payment_list">
                    <?foreach($listpayment as $val):
                    	$subpay = $this->checkout->get_payment_sub($val->payment_id);
                    ?>
                    <div>
                    	<div class="left-item">
	                    	<input type="radio" name="payment_id" value="<?=$val->payment_id?>" id="<?=$val->payment_id?>" class="payment" <?=($rs->payment_id == $val->payment_id)?'checked="checked"':'';?>>
	                    	<b style="color: #0182cb;"><?=$val->payment_name?></b>
	                    	<div class="title_pay" id="title_pay<?=$val->payment_id?>" align="center"></div>
                    	</div>
                    	
                    	<div class="box-description-payment">
                            <div id="pay<?=$val->payment_id?>" class="class_payment">
                                <div><?=($val->payment_des)?></div>
                            </div>
                            <div id="subpayment_<?=$val->payment_id?>" class="listsub_pay" style="display: none;">
                                <input type="hidden" id="count_sub_<?=$val->payment_id?>" value="<?=count($subpay)?>">
                                <ul class="sub_bank">
                                <?foreach($subpay as $val1):?>
                                    <li>
                                        <div class="radio">
                                            <input type="radio" name="sub_payment_id" class="choice_subbank" value="<?=$val1->payment_id?>" id="<?=$val1->payment_id?>">
                                        </div>
                                        <div class="img">
                                            <img src="<?=base_url().$val1->payment_img?>" width="35" alt="">
                                        </div>
                                    </li>
                                <?endforeach;?>
                                </ul>
                                <div class="clear"></div>
                                <div id="sub_bank">
                                <?foreach($subpay as $val1):?> 
                                    <div class="show_notice choice_sub_content" id="choice_sub_<?=$val1->payment_id?>" style="display: none;">
                                        <div><b><?=$val1->payment_name?></b></div>
                                        <div><?=$val1->payment_intro?></div>
                                    </div>
                                <?endforeach;?>    
                                </div>
                            </div>
                        </div>
                    	
                    </div>
                   
                    <?endforeach;?>
                    </div>
                    
                 
                          
               
                </div>        
            </div>
            
            
            <div class="box-cart-order-checkout">
            	<div class="title">
            		2. Xác nhận đơn hàng
            	</div>
            	<div class="infomation-member-checkout">
	            	<div class="title_order_online">ĐƠN HÀNG ONLINE</div>
	            	<div class="item">
	            		<strong>Tên Quý khách:</strong>
	            		<?=$rs->fullname?>
	            	</div>
	            	
	            	<div class="item">
	            		<strong>Địa chỉ giao hàng:</strong>
	            		<?=$rs->address?>
	            	</div>
	            	<div class="item">
	            		<strong>Điện thoại:</strong>
	            		<?=$rs->phone;?>
	            	</div>
	            	
	            	<div class="item">
	            		<strong>Email:</strong>
	            		<?=$rs->email?>
	            	</div>
	            	<div class="item">
	            		<strong>Ghi chú:</strong>
	            		<?=$rs->notes?>
	            	</div>
            	</div>
                <table class="dataship" border="1">
                                <thead>
                                    <tr>
                                        <th colspan="2">Sản phẩm</th>
                                      
                                        <th style="width:100px;text-align: center;">Giá bán</th>
                                        <th style="width: 70px;text-align: center;">Số lượng</th>
                                        <th style="width: 100px;text-align: center;">Thành tiền (VNĐ)</th>
                                    </tr>
                                </thead>
                                <?
                                $total = 0;
                                foreach($list as $val):
	                              
	                                $listgift = $this->vnitcart->get_gifts($val->id);
	                                $subtotal = $val->s_price * $val->s_qty;
	                                $total = $total + $subtotal;
                                ?>
                                <tr>                                   
                                    <td colspan="2" align="center">
                                    	<img src="<?=base_url_img()?>alobuy0862779988/0862779988product/80/<?=$val->productimg?>" width="80" height="60" alt=""> <br>
                                        <a href="<?=site_url('san-pham/'.$val->producturl.'-'.$val->productid)?>"><b class="title_product"><?=$val->productname?></b></a>
                                        <?if(count($listgift) > 0){?>
                                        <ul class="listgifts" style="margin-left: 0px;">
                                        <?foreach($listgift as $gift):?>
                                        <li><?=$gift->name?></li>
                                        <?endforeach;?>
                                        </ul>
                                        <?}?>
                                    </td>
                                    
                                    <td align="center"><?=number_format($val->s_price,0,'.','.')?></td>
                                    <td align="center"><?=number_format($val->s_qty,0,'.','.')?></td>
                                    <td align="right"><?=number_format($subtotal,0,'.','.')?></td>
                                </tr>
                                <?endforeach;
                                $total = $total + $rs->price_shipping;
                                $total_no_discount = $total + $rs->price_shipping;
                                ?>
                                <tr>
                                    <td colspan="4" align="right"><b>Giảm giá:</b></td>
                                    <td align="right">
                                    <?
                                    $total_giamgia = 0;
                                    foreach($list_discount as $val):
                                        $total_giamgia = $total_giamgia + $val->price;
                                    endforeach;
                                    $total = $total - $total_giamgia;
                                    ?>
                                    <?=number_format($total_giamgia,0,'.','.')?> VNĐ
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Phí giao hàng:</b></td>
                                    <?php 
                                   	$phiGiaohang  =  (number_format($rs->price_shipping,0,'.','.'))?number_format($rs->price_shipping,0,'.','.').'VNĐ':'Liên hệ';
                                    ?>
                                    <td align="right"><?=$phiGiaohang;?> </td>
                                </tr>
                                <tr>
                                    <td colspan="4" align="right"><b>Tổng tiền VND</b></td>
                                    <td align="right">
                                        <span id="total_order" style="font-size: 16px;color: #FF0000;font-weight: bold;"><?=number_format($total,0,'.','.')?></span> VNĐ
                                    </td>
                                </tr>
                            </table>
                            
                <input type="hidden" id="total_no_discount" value="<?=$total_no_discount?>">
                <div class="box_discount">
                    Mã khuyến mãi :
                    <input type="text" id="discount_code"> 
                    <input type="button" class="submit_cart" onclick="apply_discount();" value="Sử dụng mã giảm giá" style="padding: 1px 5px;">
                    <div class="listcode">
                        <?foreach($list_discount as $val):?>
                        <div id="discount_<?=$val->id?>">
                        <img src="<?=base_url()?>site/templates/fyi/icon/del.gif" alt="" onclick="remove_discount(<?=$val->id?>)" style="cursor: pointer;">
                        <?=$val->discount_key?> Giá trị: <?=number_format($val->price,0,'.','.')?> vnđ</div>    
                        <?endforeach;?>
                    </div>
                </div>
                <div class="clear"></div>
                
                <div class="box-complets">                    
                    <a href="<?=site_url('thanh-toan/giao-hang-thanh-toan')?>" class="submit_cart"><span>Quay lại</span></a>   
                     <input id="ship_payment" type="submit" class="submit_cart" value="Hoàn tất đặt hàng">    
                  
                </div>
            </div>
            
            
            
            
            
        </div>
         <?=form_close()?>
       
    </div>
</div>
<script type="text/javascript">
$(document).ready(function(){  

    <?if($rs->shipping_id !=0){?>
       change_ship(<?=$rs->shipping_id?>,<?=$rs->order_id?>);
    <?}?>    
    $("#ship_payment").click(function(){
        shipping_id = $("input[name='shipping_id']:checked").val();
        payment_id = $("input[name='payment_id']:checked").val();
        if(shipping_id && payment_id){
             count_subpay = $("#count_sub_"+payment_id).val();
             if(count_subpay > 0){
                 payment_sub_id = $("input[name='sub_payment_id']:checked").val();
                 if(payment_sub_id){
                     
                 }else{
                     jAlert("Vui lòng chọn một Ngân hàng để thanh toán",'Thông báo');
                     return false;
                 }
             }
        }else{
            jAlert("Vui lòng chọn phương thức thanh toán và vận chuyện",'Thông báo');
            return false;
        }
        
        
    });
          
});
</script>
