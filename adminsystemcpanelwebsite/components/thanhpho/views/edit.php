<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="city_id" value="<?=$rs->city_id?>">

<table class="form">
    <tr>
        <td class="label">Tùy chọn</td>
        <td>
             <select name="tp[parentid]" style="width: 205px;">
             <option value="0">Là thành phố</option>
             <?foreach($list as $val):?>
             <option value="<?php echo $val->city_id?>" <?=($rs->parentid == $val->city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
             <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Tên thành phố/Quận huyện - vi</td>
        <td>
            <input type="text" name="tp[city_name]" value="<?=$rs->city_name?>" class="w200">
        </td>
    </tr>
    <tr>
        <td class="label">Tên thành phố/Quận huyện - en</td>
        <td>
            <input type="text" name="tp_en[city_name]" value="<?=$rs_en->city_name?>" class="w200">
        </td>
    </tr>
    <tr>
        <td class="label">Thành phố hệ thống</td>
        <td>
            <input type="checkbox" name="site" value="1" <?=($rs->site == 1)?'checked="checked"':''?>>
        </td>
    </tr>
    <tr>
        <td class="label">Tỷ lệ phí vận chuyển</td>
        <td>
            <input type="text" name="tp[rate]" id="rate" value="<?=$rs->rate?>" class="w200">
            <p style="font-size: 11px; color: #FF0000;">(Phí đơn hàng * tỷ lệ theo thành phố)</p>
        </td>
    </tr>
     <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="radio" name="tp[published]" value="0" <?php echo ($rs->published == 0)?'checked="checked"':'';?>> Không 
            <input type="radio" name="tp[published]" value="1" <?php echo ($rs->published == 1)?'checked="checked"':'';?>>Có                        
        </td>
    </tr>                    
    <tr>
   
</table>

</div>
<?php echo form_close();?>
<script type="text/javascript">
$(function(){  
    $("#rate").priceFormat({
            prefix: '',
            centsSeparator: '.', 
            thousandsSeparator: ',',
            limit: 2,
            centsLimit: 1,
    });
});
</script>

