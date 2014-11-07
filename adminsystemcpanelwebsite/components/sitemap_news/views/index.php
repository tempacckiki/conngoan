<?=form_open(uri_string(),array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Category ID: </td>
        <td><input type="text" class="w250" name="idCat" value=""></td>
    </tr>
    <tr>
        <td class="label">Priority:</td>
        <td><input type="text" class="w250" name="priority" value="0.80"></td>
    </tr>
    <tr>
        <td class="label">changefreq:</td>
        <td><input type="text" class="w250" name="changefreq" value="daily"></td>
    </tr>

</table>
<?=form_close();?>
