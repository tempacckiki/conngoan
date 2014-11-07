<?php 
$imgPath  = base_url().'technogory/templates/default/images/';
?>
<div class="box-content-wapper">
<div class="box-dathang">
    <div class="c-dathang">
        <div class="element-dathang">
        	<?=form_open(uri_string(),array('id'=>'diachigiaonhan','onsubmit'=>'return validate_frmlienhe(this)','name'=>'frmCart'));?>
	        <div class="step-container">
	        	
	            <div class="box-register-checkout">
	            	<div class="note-register">
	            		Thông tin tài khoản tại alobuy.vn?            		
	            	</div>
	            	
	            	<div class="row-item">
	            		<div class="col">
	            			<label>Họ và tên (*):</label>
	            			<input type="text" name="fullname" id="fullname" value="<?=($rs)?$rs->fullname:$this->session->userdata('fullname')?>">
	            		</div>
	            		<div class="col">
	            			<label>Tỉnh/Thành (*):</label>
	            			<select name="city_id" id="city_id">
	                    	<!-- <option value="">Chọn Tỉnh, Thành phố</option> -->
	                                                <?foreach($listcity as $val):
	                                                if($rs){
	                                                   $select_city = ($rs->city_id == $val->city_id)?'selected="selected"':'';
	                                                }else{
	                                                    $select_city = ($this->session->userdata('city_id') == $val->city_id)?'selected="selected"':'';
	                                                }
	                                                ?>
	                                                <option value="<?=$val->city_id?>" <?=$select_city?>><?=$val->city_name?></option>
	                                                <?endforeach;?>
	                    	</select>
	            			
	            		</div>
	            	</div>
	            	
	            	<div class="row-item">
	            		<div class="col">
	            			<label>Điện thoại (*):</label>
	            			<input type="text" name="phone" id="phone" value="<?=($rs)?$rs->phone:$this->session->userdata('phone')?>">
	            		</div>
	                    <div class="col">
	                    	<label>Quận/Huyện (*)</label>
	            			<select name="districts_id" id="districts_id">
	                                                <option value="">Chọn Quận, Huyện</option>
	                                                <?if(!$this->session->userdata('city_id')){
	                                                    $list_district = $this->vdb->find_by_list('city',array('parentid'=>25));
	                                                }else{
	                                                    $list_district = $this->vdb->find_by_list('city',array('parentid'=>$this->session->userdata('city_id')));
	                                                }
	                                                foreach($list_district as $valDist):
	                                                if(!$this->session->userdata('city_id')){
	                                                   $select_district = ($rs->districts_id == $valDist->city_id)?'selected="selected"':'';
	                                                }else{
	                                                    $select_district = ($this->session->userdata('district_id') == $valDist->city_id)?'selected="selected"':'';
	                                                }
	                                                ?>
	                                                <option value="<?=$valDist->city_id?>" <?=$select_district?>><?=$valDist->city_name?></option>
	                                                <?
	                                                endforeach;
	                                                ?>
	                   		</select>
	                    </div>                   
	            	</div>
	            	<div class="row-item">
	            		<div class="col">
	            			<label>Email (*):</label>
	            			<input type="text" id="email" name="email" value="<?=($rs)?$rs->email:$this->session->userdata('email');?>">
	            		</div>
	            		<div class="col">
	            			<label>Địa chỉ (*):</label>
	            			<input type="text" name="address" id="address" value="<?=($rs)?$rs->address:$this->session->userdata('address')?>">
	            		</div>
	            	</div>
	            	
	            	
	            	
	            	<div class="row-item">
	            		<label class="label">Ghi chú :</label>
	            		<textarea style="width: 550px;" rows="4" name="notes"><?=($rs)?$rs->notes:''?></textarea>
	            	</div>
	            	
	            	
	            	<div class="row-item">
	            		
	                      <div class="register-member-alobuy">
		                      <input type="checkbox" name="active_reg" value="1" <?=($rs)?($rs->active_reg == 1)?'checked="checked"':'':''?>> Đăng ký làm thành viên Alobuy.vn<br />
		                      (Nhận mật khẩu tự động qua email hoặc <a href="javascript:;" id="create_ac"><b>bấm cài mật khẩu</b></a>)                                         
		                      <input type="hidden" name="pass_templ" id="pass_templ" value="<?=($rs)?$rs->pass_templ:''?>">
	                      </div>
	            	</div>
	            	
	                </div>
	                
	                <div class="step3-checkout-payment">
			            	<div class="title">
			            		Hình thức thanh toán
			            	</div>
			               
			               <div class="box-shipping">
			               	 <?foreach($listshiping as $key=>$val):			               	 
			               	 	//get vnitcart->get_list_payment
			               	 	//$listPaymentsToShip   = $this->vnitcart->get_list_payment($val->shipping_id);
			               	 	$listPaymentsToShip   =  $this->vnitcart->get_payment_shipping($val->shipping_id);
			               	 
			               	 ?>
			               	 	<div class="clear">
			               	 		<div class="item-row-ship">
					               	 	<div class="clear-row">
					                    	<div class="item">
					                      		<input  type="radio" <?=($key==0)?'checked="checked"':'';?> name="shipping_id" value="<?=$val->shipping_id?>" onclick="change_ship(<?=$val->shipping_id?>)">
					                      		<strong><?=$val->shipping_name?></strong>
					                      		<div class="title_ship" id="title_ship<?=$val->shipping_id?>"></div>
					                      	</div>
					                      	<div class="description-img" id="description-img_<?=$val->shipping_id?>">
					                      		<p class="img"><img src="<?=base_url();?>alobuy0862779988/payment/shipping/thumb/<?=$val->shipping_img;?>" width="80"></p>
					                      	
							                     <div class="description">  
							                        <?=$val->shipping_intro?>
							                     </div>
						                     </div>
						                    <div id="payment_list_<?=$val->shipping_id;?>" class="payment_list" <?=($key==0)?'style="display: block;"':'style="display: none;"';?> >
						                    <?foreach($listPaymentsToShip as $keyPay=>$valPayment):
						                    	$subpay = $this->checkout->get_payment_sub($valPayment->payment_id);
						                    ?>
						                    <div class="row-listPayment">
												<div class="left-payment-check">
													<p class="img"><img src="<?=base_url();?>alobuy0862779988/payment/bank/thumb/<?=$valPayment->payment_img;?>" width="80" height="70"></p>
																	                      
												</div>
												<div class="right-payment-check">
												    <div class="left-item">
												        <input type="radio" name="payment_id" id="<?=$valPayment->payment_id?>" class="payment" value="<?=$valPayment->payment_id?>" <?=($keyPay == 0)?'checked="checked"':'';?>>
												        <b style="color: #0182cb;"><?=$valPayment->payment_name?></b>
												         <div class="title_pay" id="title_pay<?=$valPayment->payment_id?>" align="center"></div>
												    </div>
												   
												    <div class="box-description-payment">
												        <div id="pay<?=$valPayment->payment_id?>" class="class_payment">
												            <div class="description"><?=($valPayment->payment_intro);?></div>
												        </div>
												        <div id="subpayment_<?=$valPayment->payment_id?>" style="<?=($rs->payment_id == $valPayment->payment_id)?'display: block;':'display: none;'?>" class="listsub_pay">
												            <input type="hidden" id="count_sub_<?=$val->payment_id?>" value="<?=count($subpay)?>">
												            <ul class="sub_bank">
												            <?foreach($subpay as $val1):?>
												                <li>
												                    <div class="radio">
												                        <input type="radio" name="sub_payment_id" class="choice_subbank" value="<?=$val1->payment_id?>" id="<?=$val1->payment_id?>" <?=($val1->payment_id == $rs->sub_payment_id)?'checked="checked"':''?>>
												                    </div>
												                    <div class="img">
												                        <img src="<?=base_url().'alobuy0862779988/payment/bank/thumb/'.$val1->payment_img?>" width="80"  alt="">
												                    </div>
												                </li>
												            <?endforeach;?>
												            </ul>
												            <div class="clear"></div>
												            <div id="sub_bank">
												            <?foreach($subpay as $val1):?> 
												                <div class="show_notice choice_sub_content" id="choice_sub_<?=$val1->payment_id?>" style="<?=($val1->payment_id == $rs->sub_payment_id)?'display: block;':'display: none;'?>">
												                    <div><b><?=$val1->payment_name?></b></div>
												                    <div><?=$val1->payment_intro?></div>
												                </div>
												            <?endforeach;?>    
												            </div>
												        </div>
												    </div>
												
												</div>
												</div>
			                   
			                    		<?endforeach;?>
			                    		</div>
					                   </div>
				                    	<span class="arr-up">&nbsp;</span>
				                    	
				                    	
				                   </div>
				                 
			                    
			                   </div>
			                   
			                    <?endforeach;?>
			               </div>
			               
			               
			
			              	     
			            </div>
			            
			            
			         
			        
	            	
	        </div>
        
        
	        <div class="box-cart-order-checkout">
	            	<div class="title">
	            	 Xác nhận đơn hàng
	            	</div>
	            	
	                <table class="dataship" border="1">
	                                <thead>
	                                    <tr>
	                                        <th colspan="2">Sản phẩm</th>
	                                      
	                                        <th style="width:100px;text-align: center;">Giá bán</th>
	                                        <th style="width: 70px;text-align: center;">SL</th>
	                                        <th style="width: 100px;text-align: center;">Th.Tiền</th>
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
	                                    	<a href="<?=site_url('san-pham/'.$val->producturl.'-'.$val->productid)?>"><img src="<?=base_url_img()?>alobuy0862779988/0862779988product/80/<?=$val->productimg?>" width="80" height="60" alt=""> <br>
	                                        <?=$val->productname?></a>
	                                       
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
	               
	                <div class="clear"></div>
	                
	                <div class="box-complets">                    	                     
	                     <input id="ship_payment" type="submit" class="submit_cart" value="Hoàn tất đặt hàng">    
	                  
	                </div>
	            </div>
            
        
        	<?=form_close()?>   
    </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){     
   // $("#email").Watermark("Email đăng nhập alobuy.vn");
    $.validator.addMethod("not_email", not_email, "Vui lòng nhập Email.");
});
// ham check validate
function validate_frmlienhe(frmCart){
	var  fullname 		= $("#fullname").val();
	var  phone 		= $("#phone").val();
	var  city_id 		= $("#city_id").val();
	var  districts_id 	= $("#districts_id").val();
	var  address 		= $("#address").val();
	if(fullname == ''){
		jAlert("Bạn phải nhập Họ tên của bạn.!",'Thông báo');
		$("#fullname").focus();
        return false;
	}

	if(phone == ''){
		jAlert("Bạn phải nhập địa chỉ của bạn.!",'Thông báo');
		$("#fullname").focus();
        return false;
	}
	
	if(address == ''){
		jAlert("Bạn phải nhập địa chỉ của bạn.!",'Thông báo');
		$("#fullname").focus();
        return false;
	}
	
	//shipping 
	
	  <?if($ship->shipping_id !=0){?>
      	change_ship(<?=$ship->shipping_id?>,<?=$ship->order_id?>);
	   <?}?>    
	  
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
	       
	       
	   
}

function not_email(value, element){
   // return value != 'Email đăng nhập alobuy.vn';
}


</script>



</div>