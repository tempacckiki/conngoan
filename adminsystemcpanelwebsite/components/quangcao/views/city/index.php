<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<input name="cachecity" type="hidden" value="1">
<table class="form">
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="checkbox" name="published" value="1" <?=($published == 1)?'checked="checked"':''?>>
        </td>
    </tr>
</table>
<?=form_close();?>
