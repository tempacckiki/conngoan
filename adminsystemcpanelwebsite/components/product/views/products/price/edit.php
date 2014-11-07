<script type="text/javascript" src="<?=base_url()?>components/product/views/esset/add_product.js" charset="UTF-8"></script>
<table class="form">
    <tr>
        <td class="label">Giá sản phẩm</td>
        <td>
            <table>
                <tr>
                    <td align="right">
                        Giá bán 
                        <input type="text" class="w100" name="giathitruong" id="giathitruong_miennam" value="<?=number_format($rs->giathitruong,0,'.','.')?>">
                        VAT <input type="checkbox" name="vat" value="1" <?=($rs->vat == 1)?'checked="checked"':''?>>
                    </td>

                    <td align="right">
                        Giá khuyến mãi 
                        <input type="text" class="w100" name="giaban" id="giaban_miennam" value="<?=number_format($rs->giaban,0,'.','.')?>">
                    </td>

                    <td>Giảm giá <input type="text" class="w100" name="giamgia" id="giamgia_miennam" value="<?=number_format($rs->giamgia,0,'.','.')?>"> = <input type="text" id="per_miennam" name="per_miennam" style="width: 50px;" value="<?=$rs->phantram?>">%</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="label">Tặng phẩm miền nam</td>
        <td>
            <div>
                <a href="javascript:;" id="add_miennam"><img height="16" width="16" src="<?=base_url()?>templates/icon/them.png"></a>
                <a href="javascript:;" id="remove_miennam"><img height="16" width="16" src="<?=base_url()?>templates/icon/xoa.png"></a>
            </div>
            <?if(count($tangpham) > 0){?>
            <?
            $i = 1;
            foreach($tangpham as $mn){?>
            <div id="tangpham_miennam" style="padding: 5px;">
                <input type="text" class="w500" name="tangpham_miennam_name[]" value="<?=$mn->name?>"> 

            </div>
            <?
            $i++;
            }?>
            <?}else{?>
            <div id="tangpham_miennam" style="padding: 5px;">
                <input type="text" class="w500" name="tangpham_miennam_name[]"> 
                
            </div>
            <?}?>
            <div id="ds_tangpham_miennam"></div>
        </td>
    </tr>
    <tr>
        <td class="label">Tình trạng</td>
        <td>
            <select name="tinhtrang_miennam" onchange="change_tinhtrang_miennam(this.value)">
                <option value="1" <?=($rs->tinhtrang == 1)?'selected="selected"':''?>>Còn hàng</option>
                <option value="2" <?=($rs->tinhtrang == 2)?'selected="selected"':''?>>Hết hàng</option>
                <option value="3" <?=($rs->tinhtrang == 3)?'selected="selected"':''?>>Tùy chọn</option>
            </select>
            <div id="tinhtrang_miennam_text" style="display: <?=($rs->tinhtrang == 3)?'block':'none'?>;padding: 5px 0px;">
            <input type="text" name="tinhtrang_miennam_text" value="<?=$rs->tinhtrang_text?>" class="w300">
            </div>
        </td>
    </tr>
    <tr>
        <td class="label"></td>
        <td><input type="submit" value="Lưu giá sản phẩm"></td>
    </tr>
</table>
<script type="text/javascript">
$(function() {
    var i = $('div#tangpham_miennam').size()+ 1;
    $('a#add_miennam').click(function() {
        $('<div id="tangpham_miennam" style="padding:5px">'+

        '<input type="text" class="w500" name="tangpham_miennam_name[]">'+

        '</div>').appendTo('#ds_tangpham_miennam');
        i++;
    });
    $('a#remove_miennam').click(function() {
        if(i > 2) {
            $('div#ds_tangpham_miennam #tangpham_miennam:last').remove();
            i--;
        }
    });
});
</script>