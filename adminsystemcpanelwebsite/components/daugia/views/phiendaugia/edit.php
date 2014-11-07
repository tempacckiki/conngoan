<script type="text/javascript" src="<?=base_url()?>templates/js/shop.js?v=2.0" charset="UTF-8"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>templates/css/shop.css?v=2.0" media="screen" />
<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="productid" value="<?=$pro->productid?>">
<input type="hidden" name="id" value="<?=$rs->id?>">
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
            <td><input type="text" name="data[price_bid]" id="cheap_price" value="<?=number_format($rs->price_bid,0,'.','.')?>"></td>
        </tr>

        <tr>
            <td class="label">Giá hiện tại đang đấu giá</td>
            <td><input type="text" name="data[price_last]" readonly="readonly" id="price_last" value="<?=number_format($rs->price_last,0,'.','.')?>"></td>
        </tr>

        <tr>
            <td class="label">Tiết kiệm</td>
            <td><input type="text" name="data[price_saving]" id="cheap_saving" value="<?=number_format($rs->price_saving,0,'.','.')?>"> = <input type="text" name="data[per_saving]" value="<?=$rs->per_saving?>" class="w30" id="cheap_per">%</td>
        </tr>
        <tr>
            <td class="label">Giá tăng sau 1 lần Bid</td>
            <td><input type="text" name="data[price_inc]" id="price_inc" value="<?=number_format($rs->price_inc,0,'.','.')?>"></td>
        </tr>
        <tr>
            <td class="label">Thời gian tăng sau 1 lần Bid</td>
            <td><input type="text" name="data[time_inc]" value="<?=$rs->time_inc?>"></td>
        </tr>
        <tr>
            <td class="label">Giờ hệ thống</td>
            <td valign="middle"><?=date('H:i:s d/m/Y',time())?></td>
        </tr>
        <tr>
            <td class="label">Đã kết thúc</td>
            <td><input type="checkbox" name="stop" value="1" <?=($rs->stop == 1)?'checked="checked"':''?>></td>
        </tr>
         <tr>
            <td class="label">Bắt đầu</td>
            <td>
                Ngày: <input type="text" id="time_begin_date" name="time_begin_date" value="<?=date('d-m-Y',$rs->time_begin)?>" class="w100"> 
                Giờ: <select name="time_begin_h">
                        <?for($hb=0; $hb<=23; $hb++){?>
                        <option value="<?=$hb?>" <?=($hb == date('H',$rs->time_begin))?'selected="selected"':'';?>><?=$hb?></option>
                        <?}?>
                    </select>
                Phút: <select name="time_begin_i">
                        <?for($ib=0; $ib<=59; $ib++){?>
                        <option value="<?=$ib?>" <?=($ib == date('i',$rs->time_begin))?'selected="selected"':'';?>><?=$ib?></option>
                        <?}?>
                    </select>
                Giây: <select name="time_begin_s">
                        <?for($sb=0; $sb<=59; $sb++){?>
                        <option value="<?=$sb?>" <?=($sb == date('s',$rs->time_begin))?'selected="selected"':'';?>><?=$sb?></option>
                        <?}?>
                    </select>
            </td>
        </tr>
        <tr>
            <td class="label">Kết thúc</td>
            <td>
                Ngày: <input type="text" id="time_end_date" name="time_end_date" value="<?=date('d-m-Y',$rs->time_end)?>" class="w100"> 
                Giờ: <select name="time_end_h">
                        <?for($he=0; $he<=23; $he++){?>
                        <option value="<?=$he?>" <?=($he == date('H',$rs->time_end))?'selected="selected"':'';?>><?=$he?></option>
                        <?}?>
                    </select>
                Phút: <select name="time_end_i">
                        <?for($ie=0; $ie<=59; $ie++){?>
                        <option value="<?=$ie?>" <?=($ie == date('i',$rs->time_end))?'selected="selected"':'';?>><?=$ie?></option>
                        <?}?>
                    </select>
                Giây: <select name="time_end_s">
                        <?for($se=0; $se<=59; $se++){?>
                        <option value="<?=$se?>" <?=($se == date('s',$rs->time_end))?'selected="selected"':'';?>><?=$se?></option>
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
                    <option value="<?=$val->city_id?>" <?=($rs->city_id == $val->city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
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
    $('#cheap_price').priceFormat({});
    $('#price_inc').priceFormat({});

});
function roundNumber(number, decimals) { 
    var newnumber = new Number(number+'').toFixed(parseInt(decimals));
    return parseFloat(newnumber); 
}
</script>