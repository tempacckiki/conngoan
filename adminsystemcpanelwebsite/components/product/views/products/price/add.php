<script type="text/javascript" src="<?=base_url()?>components/product/views/esset/add_product.js" charset="UTF-8"></script>
<table class="form">
    <tr>
        <td class="label">Giá sản phẩm</td>
        <td>
            <table>
                <tr>
                    <td align="right">
                        Giá bán 
                        <input type="text" class="w100" name="giathitruong" id="giathitruong_miennam" value="0">
                        VAT <input type="checkbox" name="vat" value="1" checked="checked">
                    </td>

                    <td align="right">
                        Giá khuyến mãi 
                        <input type="text" class="w100" name="giaban" id="giaban_miennam" value="0">
                    </td>

                    <td>Giảm giá <input type="text" class="w100" name="giamgia" id="giamgia_miennam" value="0"> = <input type="text" id="per_miennam" name="per_miennam" style="width: 50px;" value="0">%</td>
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

            <div id="tangpham_miennam" style="padding: 5px;">
                <input type="text" class="w500" name="tangpham_miennam_name[]"> 
            </div>

            <div id="ds_tangpham_miennam"></div>
        </td>
    </tr>
    <tr>
        <td class="label">Tình trạng</td>
        <td>
            <select name="tinhtrang_miennam" onchange="change_tinhtrang_miennam(this.value)">
                <option value="1">Còn hàng</option>
                <option value="2">Hết hàng</option>
                <option value="3">Tùy chọn</option>
            </select>
            <div id="tinhtrang_miennam_text" style="display: none;padding: 5px 0px;">
            <input type="text" name="tinhtrang_miennam_text" value="" class="w300">
            </div>
        </td>
    </tr>
    <tr>
        <td class="label"></td>
        <td><input type="submit" value="Lưu giá sản phẩm"></td>
    </tr>
</table>
<script type="text/javascript">
/************
* Tang pham mien nam
*/
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