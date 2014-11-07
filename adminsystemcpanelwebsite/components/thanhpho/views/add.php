<?php echo form_open(uri_string(), array('id'=>'admindata'));?>
<input type="hidden" name="id" value="0">
<table class="form">
     <tr>
        <td class="label">Tùy chọn</td>
        <td>
            <select name="tp[parentid]" style="width: 205px;">
                <option <?php echo (set_value('tp[parentid] == 0')?'checked="checked"':'')?>>Thành phố chính</option>
                <?foreach($list as $rs):?>
                <option value="<?php echo $rs->city_id?>"><?=$rs->city_name?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Tên thành phố/Quận huyện - vi</td>
        <td>
            <input type="text" name="tp[city_name]" value="" class="w200">
        </td>
    </tr>
    <tr>
        <td class="label">Tên thành phố/Quận huyện - en</td>
        <td>
            <input type="text" name="tp_en[city_name]" value="" class="w200">
        </td>
    </tr>
    <tr>
        <td class="label">Thành phố hệ thống</td>
        <td>
            <input type="checkbox" name="site" value="1">
        </td>
    </tr>
    <tr>
        <td class="label">Tỷ lệ phí vận chuyển</td>
        <td>
            <input type="text" name="tp[rate]" id="rate" value="0" class="w200">
            <p style="font-size: 11px; color: #FF0000;">(Phí đơn hàng * tỷ lệ theo thành phố)</p>
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="radio" name="tp[published]" value="0" <?php echo (set_value('tp[published]') == 0)?'checked="checked"':'';?>> Không 
            <input type="radio" name="tp[published]" value="1" <?php echo (set_value('tp[published]') == 1)?'checked="checked"':'checked="checked"';?>>Có                        
        </td>
    </tr>                    
</table>

<?=form_close()?>
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