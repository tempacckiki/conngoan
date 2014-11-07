<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<?$uri5 = (int)$this->uri->segment(5)?>

<fieldset>
    <legend>Tùy chọn xem</legend>
    <table>
        <tr>
            <td style="vertical-align: middle;padding-right: 10px;">ID/ Mã SP</td>
            <td style="vertical-align: middle;padding-right: 20px;">
                <input type="text" name="barcode" id="barcode" value="<?=$barcode?>">
            </td>
            <td style="vertical-align: middle;padding-right: 10px;">
            Tên SP <input type="text" id="productkey" value="<?=$productkey?>">
            </td>
            <td style="vertical-align: middle;padding-right: 10px;">Danh mục</td>
            <td style="vertical-align: middle;padding-right: 20px;">
                <select name="view" id="catid" style="width: 200px;">
                    <?foreach($listcat as $cat):
                    $listsub = $this->productdeal->get_sub_cat($cat->catid);
                    ?>
                        <option value="<?=$cat->catid?>" style="font-weight: bold;" <?=($cat->catid == $uri4)?'selected="selected"':'';?>><?=$cat->catname?></option>
                        <?foreach($listsub as $sub):
                        $listsub1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$sub->catid)); 
                        ?>
                        <option style="padding-left: 10px;" value="<?=$sub->catid?>" <?=($sub->catid == $uri4)?'selected="selected"':'';?>>|__<?=$sub->catname?></option>
                            <?foreach($listsub1 as $sub1):?>
                            <option style="padding-left: 10px;" value="<?=$sub1->catid?>" <?=($sub1->catid == $uri4)?'selected="selected"':'';?>>|_____<?=$sub1->catname?></option>
                            <?endforeach;?> 
                        <?endforeach;?>
                    <?endforeach;?>
                </select>
            </td>
            
            <td style="vertical-align: middle;padding-right: 20px;">
                <select name="city_id" id="city_ids">
                    <?foreach($list_city as $val):?>
                    <option value="<?=$val->city_id?>" <?=($city_id == $val->city_id)?'selected="selected"':'';?>><?=$val->city_name?></option>
                    <?endforeach;?>
                </select>
            </td>
            <td>
                <input type="button" name="bt_click" onclick="xemsp()" value="Xem sản phẩm">
                <input type="hidden" id="city_id" value="<?=$city_id?>">
            </td>
        </tr>
    </table>
</fieldset>
<script type="text/javascript">
function xemsp(){
    var catid 		= $("#catid").val();    
    var city_id 	= $("#city_ids").val();
    var barcode 	= $("#barcode").val();
    var productkey 	= $("#productkey").val();
    if(barcode !='' && productkey != ''){
        barcode_text = "/?barcode="+barcode+"&productkey="+productkey;
    }else{
        if(barcode != ''){
            barcode_text = "/?barcode="+barcode;
        }else if(productkey != ''){
            barcode_text = "/?productkey="+productkey;
        }else{
            barcode_text = "";
        }
    }
    window.location.href = base_url + "deal/productdeal/ds/"+catid+"/"+city_id+barcode_text;
}
</script>
<?
if($num > 0){
$page = (int)$this->uri->segment(6);
echo form_open('deal/productdeal/delsproduct',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="catid" value="<?=$catid?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="15">
                 Hiện có <?=$num?> sản phẩm
                 <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>                
        	<th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th style="width: 70px;"><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/productid/asc','ID')?></th>
            <th style="width: 70px;"><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/barcode/asc','Mã hàng')?></th>
            <th style="width: 70px;">Hình ảnh</th>
            
            <th><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/productname/asc','Tên sản phẩm')?></th>
            <th><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/decription/asc','Mô tả')?></th>
            <th class="w100">
                <div><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/giathitruong/asc','Giá thị trường')?></div>
            </th>
            <th class="w100">
                <div><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/giaban/asc','Giá bán')?></div>
            </th>
            <th class="w100">
                <div><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/giamgia/asc','Giảm giá')?></div>
            </th>
           <th class="w100">
                <div><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/percent_price/asc','Phần trăm')?></div>
            </th>
            <th  style="width: 40px;">
                <div><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/is_home/asc','Top home')?></div>
            </th>
            <th style="width: 40px;"><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/views/asc','Views')?></th>
            <th style="width: 40px;"><?=vnit_order('deal/productdeal/ds/'.$catid.'/'.$city_id.'/'.$page.'/orderhome/asc','Thứ tự')?></th>
            <th style="width: 85px;">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
    	<td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->productid;?>"></td>
        <td align="center"><?=$rs->productid?></td>
        <td><?=$rs->barcode?></td>
        <td>
            <img src="<?=base_url_img()?>alobuy0862779988/0862779988product/80/<?=$rs->productimg?>" alt="">
        </td>
      
        <td><?=$rs->productname?></td>
        <td>
        	<textarea rows="5" cols="40" id="decription_<?=$rs->productid?>"><?=$rs->decription;?></textarea>
        	
        </td>
        <td>
            <div><input type="text" class="giathitruong w100" id="giathitruong_<?=$rs->productid?>" value="<?=number_format($rs->giathitruong,0,'.','.')?>"></div>
        </td>
        <td>
            <div><input type="text" class="giaban w100" id="giaban_<?=$rs->productid?>" value="<?=number_format($rs->giaban,0,'.','.')?>"></div>
        </td>
        <td>
            <div><input type="text" class="giamgia w100" id="giamgia_<?=$rs->productid?>" value="<?=number_format($rs->giamgia,0,'.','.')?>" ></div>
        </td>
       <td>
            <div><input type="text" class="giamgia w100" id="percent_price_<?=$rs->productid?>" value="<?=number_format($rs->percent_price,0,'.','.')?>" ></div>
        </td>
         <td align="center">
            <div><input type="checkbox" class="giamgia " id="is_home_<?=$rs->productid?>" value="1" <?php echo ($rs->is_home == 1)?'checked="checked"':'';?>></div>
        </td>
        
        <td>
            <div><input style="text-align: center;" type="text" id="views_<?=$rs->productid?>" value="<?=$rs->views;?>" class="w40"></div>
        </td>
        <td>
            <div><input style="text-align: center;" type="text" id="thutu_<?=$rs->productid?>" value="<?=$rs->ordering;?>" class="w40"></div>
        </td>


        <td align="center">
            <?if($this->permit->get_permit_icon('deal/productdeal/save_ajax')){?>
            <a href="javascript:;" onclick="save_edit(<?=$rs->productid?>)">
            <img src="<?=base_url()?>templates/icon/save.png" alt="">
            </a>
            <?}?>
            
            <span id="publish<?=$rs->productid?>"><?=icon_active("'sangiare'","'productid'",$rs->productid,$rs->published,'deal/productdeal/published')?></span>
            <?=icon_del('deal/productdeal/delproduct/'.$rs->productid.'/'.$catid.'/'.$city_id.'/'.$page)?>
            <script type="text/javascript">
            $(document).ready(function() {
                $('#giaban_<?=$rs->productid?>').priceFormat({});
                $('#giathitruong_<?=$rs->productid?>').priceFormat({});

            });
            </script>
        </td>
    </tr>   
  	<script type="text/javascript">
	  	$(document).ready(function() {
		    $('#giaban_<?=$rs->productid?>').keyup(function() {		 
		        var giathitruong = ToNumber($("#giathitruong_<?=$rs->productid?>").val());
				//price sales		      
		        var giaban = ToNumber($(this).val());
		       //*** price percent
		        var tietkiem_phantram = ((giathitruong - giaban)*100)/giathitruong;
		        $("#percent_price_<?=$rs->productid?>").val(parseInt(tietkiem_phantram));
		        $("#giamgia_<?=$rs->productid?>").val(formatCurrency(giathitruong - giaban));
		    });
		    //$('.giaban').priceFormat({});
		});
  	</script>
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="15">
            Hiện có <?=$num?> sản phẩm <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
<script type="text/javascript">
	

	//***************************
    function save_edit(id){
        //city_id 		= $("#city_id").val();
        giathitruong 	= $("#giathitruong_"+id).val();
        giaban 			= $("#giaban_"+id).val();
        giamgia 		= $("#giamgia_"+id).val();
        phantram 		= $("#percent_price_"+id).val();
        thutu 			= $("#thutu_"+id).val();
        is_home			= $("#is_home_"+id).val();
        views			= $("#views_"+id).val();
      
        decription   	= $("#decription_"+id).val();
        city_id 		= $("#city_id").val();
        
        $.post(base_url+"deal/productdeal/save_ajax",
        {            
            'giathitruong':giathitruong,
            'giaban':giaban,
            'giamgia':giamgia,         
            'phantram':phantram,         
            'thutu':thutu, 
            'decription':decription,          
            'is_home':is_home,
            'views':views,          
            'city_id':city_id,          
            'productid':id
        },function(data){
            alert(data.msg);
            window.location.reload();
        },'json');
    }
</script>
<?}?>