<?=form_open(uri_string(),array('id'=>'admindata'))?>
<table style="width: 100%;">
    <tr>
        <td style="width: 450px;padding-right: 5px;">
            <table class="form">
                <tr>
                    <td class="label">Tỉnh/ Thành phố</td>
                    <td>
                        <select name="city_id" onchange="change_city(this.value)">
                            <option value="">==Chọn Tỉnh, Thành phố==</option>
                            <?foreach($listcity as $val):?>
                            <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                            <?endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">Quận/ Huyện</td>
                    <td>
                        <select name="parent_id" id="city_parentid">
                            <option value="">==Chọn Quận, Huyện==</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">Địa chỉ</td>
                    <td><input type="text" class="w300" name="address"></td>
                </tr>
                <tr>
                    <td class="label">Điện thoại</td>
                    <td><input type="text" class="w300" name="phone"></td>
                </tr>
                <tr>
                    <td class="label">Website</td>
                    <td><input type="text" class="w300" name="website"></td>
                </tr>
                <tr>
                    <td class="label">Giờ làm việc</td>
                    <td><input type="text" class="w300" name="time_working"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <input type="submit" value="Lưu">
                        <input type="button" onclick="get_map()" value="Xem trước">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <div>
                Xem trước địa điểm 
            </div>
            
            <iframe id="show_map" src="" width="600" height="400"></iframe>               

        </td>
    </tr>
</table>
<?=form_close();?>