<?=form_open(uri_string(),array('id'=>'admindata'))?>
<script type="text/javascript">
$(document).ready(function() {
    var la = <?=$rs->lat?>;
    var lo = <?=$rs->lng?>;
    var title = 'Công ty THNHH FYI Việt Nam';
    var content = 'SS1N Hồng Lĩnh, Phường 15, Quận 10, Tp.Hồ Chí Minh';
    addlocal(la,lo,title,content,'show_map');
});
</script>
<input type="hidden" name="manufactureid" value="<?=$manufactureid?>">
<input type="hidden" name="id" value="<?=$rs->id?>">
<table style="width: 100%;">
    <tr>
        <td style="width: 450px;padding-right: 5px;">
            <table class="form">
                <tr>
                    <td class="label">Tỉnh/ Thành phố</td>
                    <td>
                        <select name="city_id" id="city_id" onchange="change_city(this.value)" style="width: 306px;">
                            <option value="">==Chọn Tỉnh, Thành phố==</option>
                            <?foreach($listcity as $val):?>
                            <option value="<?=$val->city_id?>" <?=($rs->city_id == $val->city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
                            <?endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">Quận/ Huyện</td>
                    <td>
                        <select name="parent_id" id="city_parentid" style="width: 306px;">
                            <option value="">==Chọn Quận, Huyện==</option>
                            <?foreach($listdistrict as $val):?>
                            <option value="<?=$val->city_id?>" <?=($rs->parent_id == $val->city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
                            <?endforeach;?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">Địa chỉ</td>
                    <td><input type="text" class="w300" id="address" name="address" value="<?=$rs->address?>"></td>
                </tr>
                <tr>
                    <td class="label">Điện thoại</td>
                    <td><input type="text" class="w300" id="phone" name="phone" value="<?=$rs->phone?>"></td>
                </tr>
                <tr>
                    <td class="label">Website</td>
                    <td><input type="text" class="w300" id="website" name="website" value="<?=$rs->website?>"></td>
                </tr>
                <tr>
                    <td class="label">Giờ làm việc</td>
                    <td><input type="text" class="w300" name="time_working" value="<?=$rs->time_working?>"></td>
                </tr>
                <tr>
                    <td class="label">Vị trí</td>
                    <td>
                        Lat:<input type="text" name="lat" class="w250" id="lat" value="<?=$rs->lat?>"><br>
                        lng:<input type="text" name="lng" class="w250" id="lng" value="<?=$rs->lng?>">
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        
                        <input type="button" onclick="get_map()" value="Xem trước">
                    </td>
                </tr>
            </table>
        </td>
        <td>
            <div id="show_map" style="width: 500px; height: 300px; border: 5px solid #CCC;">
                 
            </div>
        </td>
    </tr>
</table>
<?=form_close();?>