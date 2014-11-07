<?=form_open(uri_string(),array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Mã giảm giá</td>
        <td><input type="text" class="w300" name="dis[discount_key]" value="<?=get_discount('SGR')?>"></td>
    </tr> 
    <tr>
        <td class="label">Giá trị</td>
        <td><input type="text" class="w300" name="dis[discount_price]" id="discount_price" value="<?=set_value('dis[discount_price]')?>"></td>
    </tr> 
    <tr>
        <td class="label">Tổng phiếu</td>
        <td><input type="text" name="dis[discount_total]" class="w300" value="<?=set_value('dis[discount_total]')?>"></td>
    </tr>
    <tr>
        <td class="label">Ngày bắt đầu</td>
        <td><input type="text" name="dis[discount_datebegin]" id="DiscountBegin" class="w300" value="<?=set_value('dis[discount_datebegin]')?>"></td>
    </tr>
    <tr>
        <td class="label">Ngày kết thúc</td>
        <td><input type="text" name="dis[discount_dateend]" id="DiscountEnd" class="w300" value="<?=set_value('dis[discount_dateend]')?>"></td>
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