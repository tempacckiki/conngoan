<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="id" value="<?=$rs->discount_id?>">
<table class="form">
    <tr>
        <td class="label">Mã giảm giá</td>
        <td><input type="text" class="w300" name="dis[discount_key]" value="<?=$rs->discount_key?>"></td>
    </tr> 
    <tr>
        <td class="label">Giá trị</td>
        <td><input type="text" class="w300" name="dis[discount_price]" id="discount_price" value="<?=number_format($rs->discount_price,0,'.','.')?>"></td>
    </tr> 
    <tr>
        <td class="label">Tổng phiếu</td>
        <td><input type="text" name="dis[discount_total]" class="w300" value="<?=$rs->discount_total?>"></td>
    </tr>
    <tr>
        <td class="label">Ngày bắt đầu</td>
        <td><input type="text" name="dis[discount_datebegin]" id="DiscountBegin" class="w300" value="<?=date('Y-m-d',$rs->discount_datebegin)?>"></td>
    </tr>
    <tr>
        <td class="label">Ngày kết thúc</td>
        <td><input type="text" name="dis[discount_dateend]" id="DiscountEnd" class="w300" value="<?=date('Y-m-d',$rs->discount_dateend)?>"></td>
    </tr>
</table>
<?=form_close();?>
<script type="text/javascript">
    $(function() {
        $("#discount_price").priceFormat();
        var dates = $( "#DiscountBegin, #DiscountEnd" ).datepicker({

            changeMonth: true,
            dateFormat: 'yy-mm-dd', 
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {
                var option = this.id == "DiscountBegin" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" );
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
</script>