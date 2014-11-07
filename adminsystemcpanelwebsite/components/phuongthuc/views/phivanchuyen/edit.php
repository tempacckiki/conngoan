<?=form_open_multipart(uri_string(), array('id' => 'admindata'))?>
<input type="hidden" name="cityid" value="<?=$val->parentid?>">
<input type="hidden" name="city_id" value="<?=$val->city_id?>">
<table class="form">
    <tr>
        <td class="label">Thành phố</td>
        <td valign="middle" style="padding-top: 5px;"><?=$rs->city_name?> - <?=$val->city_name?></td>
    </tr>
    <tr>
        <td class="label">Phí vận chuyển</td>
        <td><input type="text" id="rate_price" value="<?=number_format($val->rate,0,'.','.')?>" name="rate"></td>
    </tr>
</table>
<?=form_close()?>
<script type="text/javascript">

$(function(){
   $("#rate_price").priceFormat();
});
</script>
