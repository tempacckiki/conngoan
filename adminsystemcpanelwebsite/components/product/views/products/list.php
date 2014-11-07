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
                    <option value="0">Tất cả</option>
                    <?foreach($listcat as $cat):
                    $dis1 = $this->shop->check_per_dm($cat->catid); 
                    if($dis1){
                    $listsub = $this->shop->get_sub_cat($cat->catid);
                    ?>
                        <option value="<?=$cat->catid?>" style="font-weight: bold;font-size: 16px;text-transform: uppercase;color: #FF0000" <?=($cat->catid == $uri4)?'selected="selected"':'';?>><?=$cat->catname?></option>
                        <?foreach($listsub as $sub):
                         
                        $dis2 = $this->shop->check_per_dm($sub->catid); 
                        $listsub1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$sub->catid));
                        if($dis2){
                        ?>
                        <option style="padding-left: 10px;font-weight: bold; font-size: 14px;color: #0082C9" value="<?=$sub->catid?>" <?=($sub->catid == $uri4)?'selected="selected"':'';?>>|__<?=$sub->catname?></option>
                            <?foreach($listsub1 as $sub1):
                            
                            $dis3 = $this->shop->check_per_dm($sub1->catid);
                            if($dis3){
                            $listsub2 = $this->shop->get_sub_cat($sub1->catid); 
                            ?>
                            <option style="padding-left: 10px;color: #fb7203;font-weight: bold" value="<?=$sub1->catid?>" <?=($sub1->catid == $uri4)?'selected="selected"':'';?>>|__|__<?=$sub1->catname?></option>
                                
                                <?foreach($listsub2 as $sub2):?>
                                <option style="padding-left: 10px;" value="<?=$sub2->catid?>" <?=($sub2->catid == $uri4)?'selected="selected"':'';?>>|__|__|__<?=$sub2->catname?></option>
                                <?endforeach;?>
                                
                            <?}?> 
                            <?endforeach;?>
                        <?}?>
                        <?endforeach;?>
                    <?}?>
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
    var catid = $("#catid").val();    
    var city_id = $("#city_ids").val();
    var barcode = $("#barcode").val();
    var productkey = $("#productkey").val();
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
    window.location.href = base_url + "product/shop/listproduct/"+catid+"/"+city_id+barcode_text;
}
</script>
<?
if($num > 0){
$page = (int)$this->uri->segment(6);
echo form_open('product/shop/delsproduct',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$page?>">
<input type="hidden" name="catid" value="<?=$catid?>">
<input type="hidden" name="city_id" value="<?=$uri5?>">
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
            <th style="width: 70px;"><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/shop_product.productid/asc','ID')?></th>
            <th style="width: 70px;"><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/barcode/asc','Mã hàng')?></th>
            <th style="width: 70px;">Hình ảnh</th>
            <th style="width: 85px;">Icon</th>
            <th><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/productname/asc','Tên sản phẩm')?></th>
             <?php    
			    if(($editPrice == 1 && $this->session->userdata('user_id') == $user_idPrice) || $this->session->userdata('group_id') >=17){
			 ?>
            <th style="width: 80px;">
                <div><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/giathitruong/asc','Giá thị trường')?></div>
            </th>
            <th style="width: 80px;">
                <div><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/giaban/asc','Giá bán')?></div>
            </th>
            <th style="width: 80px;">
                <div><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/giamgia/asc','Giảm giá')?></div>
            </th>
            <?php }?>
            <th style="width: 40px;">VAT</th>
            <th style="width: 40px;"><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/orderhome/asc','Trang chủ')?></th>
            <th style="width: 70px;"><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/tinhtrang/asc','Tình trạng')?></th>
            <th style="width: 40px;"><?=vnit_order('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page.'/thutu/asc','Thứ tự')?></th>
            <th style="width: 40px;">CN</th>
        </tr>        
    </thead>
    <?
    $k=1;
   
    foreach($list as $rs):
    	
    ?>
    <tr class="row<?=$k?>">
        <td><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->productid;?>"></td>
        <td><?=$rs->productid?></td>
        <td><?=$rs->barcode?></td>
        <td>
            <img src="<?=base_url_img()?>alobuy0862779988/0862779988product/80/<?=$rs->productimg?>" alt="">
        </td>
        <td>
            <div><input type="checkbox" id="sphot_<?=$rs->productid?>" value="1" <?=($rs->sphot == 1)?'checked="checked"':''?>>Hot</div>
            <div><input type="checkbox" id="spmoi_<?=$rs->productid?>" value="1" <?=($rs->spmoi == 1)?'checked="checked"':''?>>New</div>
            <div><input type="checkbox" id="spkhuyenmai_<?=$rs->productid?>" value="1" <?=($rs->spkhuyenmai == 1)?'checked="checked"':''?>>Khuyến mãi</div>
        </td>
        <td><?=$rs->productname?></td>
         <?php    
			    if(($editPrice == 1 && $this->session->userdata('user_id') == $user_idPrice) || $this->session->userdata('group_id') >=17){
		?>
        <td>
            <div><input type="text" class="giathitruong w100" id="giathitruong_<?=$rs->productid?>" value="<?=number_format($rs->giathitruong,0,'.','.')?>"></div>
        </td>
        <td>
            <div><input type="text" class="giaban w100" id="giaban_<?=$rs->productid?>" value="<?=number_format($rs->giaban,0,'.','.')?>"></div>
        </td>
        <td>
            <div><input type="text" class="giamgia w100" id="giamgia_<?=$rs->productid?>" value="<?=number_format($rs->giamgia,0,'.','.')?>" ></div>
        </td>
        <?php }?>
        <td><div class="fr"><input type="checkbox" value="1" class="w30" <?=($rs->vat == 1)?'checked="checked"':''?>></div></td>
        <td align="center"><input type="checkbox" id="home_<?=$rs->productid?>" value="1" <?=($rs->home == 1)?'checked="checked"':''?>></td>
        <td>
            <div>
                <select name="tinhtrang" id="tinhtrang_<?=$rs->productid?>">
                    <option value="1" <?=($rs->tinhtrang == 1)?'selected="selected"':''?>>Còn hàng</option>
                    <option value="2" <?=($rs->tinhtrang == 2)?'selected="selected"':''?>>Hết hàng</option>
                </select>
            </div>

        </td>
        <td align="center">
            <div><input style="text-align: center;" type="text" id="thutu_<?=$rs->productid?>" value="<?=$rs->thutu?>" class="w40"></div>
        </td>


        <td align="center">
            <?if($this->permit->get_permit_icon('product/shop/save_ajax')){?>
            <a href="javascript:;" onclick="save_edit(<?=$rs->productid?>)">
            <img src="<?=base_url()?>templates/icon/save.png" alt="">
            </a>
            <?}?>
            <?=icon_edit('product/shop/edit/'.$rs->productid.'/'.$catid.'/'.$city_id.'/'.$page)?><br />
            <span id="publish<?=$rs->productid?>"><?=icon_active("'shop_product'","'productid'",$rs->productid,$rs->published,'product/shop/published')?></span>
            <?=icon_del('product/shop/delproduct/'.$rs->productid.'/'.$catid.'/'.$city_id.'/'.$page)?>
            <script type="text/javascript">
            $(document).ready(function() {
                $('#giaban_<?=$rs->productid?>').priceFormat({});
                $('#giathitruong_<?=$rs->productid?>').priceFormat({});

            });
            </script>
        </td>
    </tr>   
  
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
    function save_edit(id){
        city_id = $("#city_id").val();
        giathitruong = $("#giathitruong_"+id).val();
        giaban = $("#giaban_"+id).val();
        giamgia = $("#giamgia_"+id).val();
        tinhtrang = $("#tinhtrang_"+id).val();
        thutu = $("#thutu_"+id).val();
        sphot = $("#sphot_"+id+":checked").val();
        spmoi = $("#spmoi_"+id+":checked").val();
        spkhuyenmai = $("#spkhuyenmai_"+id+":checked").val();
        home = $("#home_"+id+":checked").val();
        
        $.post(base_url+"product/producthome/save_ajax",
        {
            'city_id':city_id,
            'giathitruong':giathitruong,
            'giaban':giaban,
            'giamgia':giamgia,
            'tinhtrang':tinhtrang,
            'thutu':thutu,
            'sphot':sphot,
            'spmoi':spmoi,
            'spkhuyenmai':spkhuyenmai,
            'home':home,
            'productid':id
        },function(data){
            alert(data.msg);
        },'json');
    }
</script>
<?}?>