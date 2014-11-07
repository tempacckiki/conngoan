<script type="text/javascript" src="<?=base_url()?>templates/js/shop.js?v=2.0" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>templates/css/shop.css?v=2.0" media="screen" />
<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="productid" value="<?=$pro->productid?>">
<div class="gray">

    <table class="form">
        <tr>
            <td class="label">Sản phẩm</td>
            <td><input type="text" name="data[product_name]" readonly="readonly" value="<?=$pro->productname?>" class="w400"></td>
        </tr>
        <tr>
            <td class="label">Giá bán</td>
            <td><input type="text" name="data[price_old]" readonly="readonly" id="cheap_price_old" value="<?=number_format($pro->price,0,'.','.')?>"></td>
        </tr> 
        <tr>
            <td class="label">Giá khởi điểm</td>
            <td><input type="text" name="data[price_bid]" id="cheap_price" value="<?=set_value('data[price_bid]')?>"></td>
        </tr>
        <tr>
            <td class="label">Giá hiện tại đang đấu giá</td>
            <td><input type="text" name="data[price_last]" readonly="readonly" id="price_last" value=""></td>
        </tr>
        <tr>
            <td class="label">Tiết kiệm</td>
            <td><input type="text" name="data[price_saving]" id="cheap_saving" value="<?=set_value('data[price_saving]')?>"> = <input type="text" name="data[per_saving]" value="<?=set_value('data[cheap_per]')?>" class="w30" id="cheap_per">%</td>
        </tr>
        <tr>
            <td class="label">Giá tăng sau 1 lần Bid</td>
            <td><input type="text" name="data[price_inc]" id="price_inc" value="<?=set_value('data[price_inc]')?>"></td>
        </tr>
        <tr>
            <td class="label">Thời gian tăng sau 1 lần Bid</td>
            <td><input type="text" name="data[time_inc]" value="<?=set_value('data[time_inc]')?>"></td>
        </tr>
        <tr>
            <td class="label">Giờ hệ thống</td>
            <td valign="middle"><?=date('H:i:s d/m/Y',time())?></td>
        </tr>
        <tr>
            <td class="label">Bắt đầu</td>
            <td>
                Ngày: <input type="text" id="time_begin_date" name="time_begin_date" class="w100"> 
                Giờ: <select name="time_begin_h">
                        <?for($h=0; $h<=23; $h++){?>
                        <option value="<?=$h?>"><?=$h?></option>
                        <?}?>
                    </select>
                Phút: <select name="time_begin_i">
                        <?for($h=0; $h<=59; $h++){?>
                        <option value="<?=$h?>"><?=$h?></option>
                        <?}?>
                    </select>
                Giây: <select name="time_begin_s">
                        <?for($h=0; $h<=59; $h++){?>
                        <option value="<?=$h?>"><?=$h?></option>
                        <?}?>
                    </select>
            </td>
        </tr>
        <tr>
            <td class="label">Kết thúc</td>
            <td>
                Ngày: <input type="text" id="time_end_date" name="time_end_date" class="w100"> 
                Giờ: <select name="time_end_h">
                        <?for($h=0; $h<=23; $h++){?>
                        <option value="<?=$h?>"><?=$h?></option>
                        <?}?>
                    </select>
                Phút: <select name="time_end_i">
                        <?for($h=0; $h<=59; $h++){?>
                        <option value="<?=$h?>"><?=$h?></option>
                        <?}?>
                    </select>
                Giây: <select name="time_end_s">
                        <?for($h=0; $h<=59; $h++){?>
                        <option value="<?=$h?>"><?=$h?></option>
                        <?}?>
                    </select>
            </td>
        </tr>
        <tr>
            <td class="label">Địa điểm</td>
            <td>
                <select name="data[city_id]">
                    <option value="0">Toàn Quốc</option>
                    <?foreach($listcity as $val):?>
                    <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                    <?endforeach;?>
                </select>
            </td>
        </tr>
    </table>


</div>
<?=form_close()?>
<script type="text/javascript">
    $(function() {
        var dates = $( "#time_begin_date, #time_end_date" ).datepicker({
            changeMonth: true,
            dateFormat: 'dd-mm-yy', 
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {
                var option = this.id == "time_begin_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" );
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
$(document).ready(function() {
    $('#cheap_price').keyup(function() {
        giathitruong = ToNumber($("#cheap_price_old").val());
        giamuare = ToNumber($(this).val());
        //alert(giamuare);
        tietkiem_phantram = ((giathitruong - giamuare)*100)/giathitruong;
        $("#cheap_per").val(roundNumber(tietkiem_phantram,1));
        $("#cheap_saving").val(formatCurrency(giathitruong - giamuare));
        $("#price_last").val(formatCurrency(giamuare));
    });
    $('#cheap_price').priceFormat({});
    $('#price_inc').priceFormat({});
});
function roundNumber(number, decimals) { 
    var newnumber = new Number(number+'').toFixed(parseInt(decimals));
    return parseFloat(newnumber); 
}
</script>