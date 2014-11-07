
<?php
foreach($list as $val):  
$subpay = $this->checkout->get_payment_sub($val->payment_id);
?>
<div class="row-listPayment">
<div class="left-payment-check">
	<p class="img"><img src="<?=base_url();?>alobuy0862779988/payment/bank/thumb/<?=$val->payment_img;?>" width="80" height="70"></p>
					                      
</div>
<div class="right-payment-check">
    <div class="left-item">
        <input type="radio" name="payment_id" id="<?=$val->payment_id?>" class="payment" value="<?=$val->payment_id?>" <?=($rs->payment_id == $val->payment_id)?'checked="checked"':'';?>>
        <b style="color: #0182cb;"><?=$val->payment_name?></b>
         <div class="title_pay" id="title_pay<?=$val->payment_id?>" align="center"></div>
    </div>
   
    <div class="box-description-payment">
        <div id="pay<?=$val->payment_id?>" class="class_payment">
            <div class="description"><?=($val->payment_intro);?></div>
        </div>
        <div id="subpayment_<?=$val->payment_id?>" style="<?=($rs->payment_id == $val->payment_id)?'display: block;':'display: none;'?>" class="listsub_pay">
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

