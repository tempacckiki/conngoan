<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<script type="text/javascript">
$(document).ready(function() {
    var la = <?=($rs->lat)?$rs->lat:'10.7796653'?>;
    var lo = <?=($rs->lng)?$rs->lng:'106.66273950000004'?>;
    var title = 'Công ty THNHH FYI Việt Nam';
    var content = 'SS1N Hồng Lĩnh, Phường 15, Quận 10, Tp.Hồ Chí Minh';
    addlocal(la,lo,title,content,'show_map');
});
</script>
<input type="hidden" name="id" value="<?=$rs->id?>">
 <table style="width: 100%;">
    <tr>
        <td style="width: 450px;padding-right: 5px;">
            <table class="form">
                <tr>
                    <td class="label">Tên</td>
                    <td><input type="text" name="sup[name]" value="<?php echo $rs->name?>" class="w200"></td>
                </tr>
                <tr>
                    <td class="label">Địa chỉ</td>
                    <td><input type="text" id="address" name="sup[address]" value="<?php echo $rs->address?>" class="w200"></td>
                </tr>
                 <tr>
                    <td class="label">Điện thoại</td>
                    <td><input type="text" name="sup[phone]" value="<?php echo $rs->phone?>" class="w200"></td>
                </tr>
                  <tr>
                    <td class="label">Fax</td>
                    <td><input type="text" name="sup[fax]" value="<?php echo $rs->fax?>" class="w200"></td>
                </tr> 
                  <tr>
                    <td class="label">Email</td>
                    <td><input type="text" name="sup[email]" value="<?php echo $rs->email?>" class="w200"></td>
                </tr>    
                <tr>
                    <td class="label">Sắp xếp</td>
                    <td><input type="text" name="sup[ordering]" value="<?php echo $rs->ordering?>" class="w200"></td>
                </tr> 
                <tr>
                    <td class="label">Vị trí</td>
                    <td>
                        Lat:<input type="text" name="sup[lat]" class="w250" id="lat" value="<?=$rs->lat?>"><br>
                        lng:<input type="text" name="sup[lng]" class="w250" id="lng" value="<?=$rs->lng?>">
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

<?php echo form_close();?>

