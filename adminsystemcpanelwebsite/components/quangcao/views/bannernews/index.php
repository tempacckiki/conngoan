<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table>
    <tr>        
        <td>
            <fieldset>
                <legend>Quảng cáo footer</legend>
                <table class="form">
                    <tr>
                        <td class="label"><strong style="text-transform: uppercase;color: #ff0000;">Danh sách ID:</strong></td>
                        <td>
                            <input type="text" name="arrIDFooter" value="<?=$arrIDFooter;?>" class="w400">
                             <p>(VD: 23,56,7896,2356)</p>
                              <p>Cách nhau dấu (,)</p>
                        </td>
                    </tr>
                   
                </table>
                
                
            </fieldset>
        </td>
    </tr>
    <tr>
        <td class="2">
            Kích hoạt: <input type="checkbox" name="active" value="1" checked="checked"> 
        </td>
    </tr>
</table>
<?=form_close();?>

