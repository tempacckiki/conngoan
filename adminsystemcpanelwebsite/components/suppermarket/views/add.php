<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<table style="width: 100%;">
    <tr>
        <td style="width: 450px;padding-right: 5px;">
            <input type="hidden" name="id" value="0">
            <table class="form">   
                <tr>
                    <td class="label">Tên siêu thị</td>
                    <td><input type="text" class="w200" name="sup[name]" value="<?php echo set_value('sup[name]')?>"></td>
                </tr>
                 <tr>
                    <td class="label">Địa chỉ</td>
                    <td><input type="text" class="w200" name="sup[address]" value="<?php echo set_value('sup[address]')?>"></td>
                </tr>
                <tr>
                    <td class="label">Điện thoại</td>
                    <td><input type="text" class="w200" name="sup[phone]" value="<?php echo set_value('sup[phone]')?>"></td>
                </tr>
                <tr>
                    <td class="label">Fax</td>
                    <td><input type="text" class="w200" name="sup[fax]" value="<?php echo set_value('sup[fax]')?>"></td>
                </tr>        
                <tr>
                    <td class="label">Email</td>
                    <td><input type="text" class="w200" name="sup[email]" value="<?php echo set_value('sup[email]')?>"></td>
                </tr>  
                <tr>
                    <td class="label">Sắp xếp</td>
                    <td><input type="text" class="w200" name="sup[ordering]" value="<?php echo set_value('sup[ordering]')?>"></td>
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
