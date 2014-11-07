<input type="hidden" name="shipping_id" id="shipping_id" value="<?=$shipping_id?>">
<table class="form">
    <tr>
        <td class="label">Giá đơn hàng lớn hơn</td>
        <td><input type="text" id="rate_cost" name="rate_cost"></td>
    </tr>
    <tr>
        <td class="label">Phí vận chuyển</td>
        <td><input type="text" id="rate_price" name="rate_price"></td>
    </tr>
    <tr>
        <td class="label">Kiểu tính</td>
        <td>
            <select name="rate_price_type" id="rate_price_type">
                <option value="1"> VNĐ</option>
                <option value="2"> %</option>
            </select>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><input type="button" onclick="save_add_rate()" value="Thêm mới"></td>
    </tr>
</table>
