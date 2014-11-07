<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<table style="width: 99%;">
    <tr>
        <td style="width: 500px; padding-right : 10px;">
            <fieldset>
                <legend>Thuộc tính</legend>
                <input type="hidden" name="id" value="0">
                <table class="form">
                    <tr>
                        <td class="label">Tiêu đề</td>
                        <td><input type="text" name="fea[description]" value=""></td>
                    </tr>
                    <tr>
                        <td class="label">Miêu tả</td>
                        <td><textarea style="width: 400px; height: 100px;" name="fea[full_description]"></textarea></td>
                    </tr>
                    <tr>
                        <td class="label">Sắp xếp</td>
                        <td><input type="text" name="fea[ordering]" value=""></td>
                    </tr>
                </table>

            </fieldset>
        </td>

    </tr>
</table>

<?php echo form_close();?>