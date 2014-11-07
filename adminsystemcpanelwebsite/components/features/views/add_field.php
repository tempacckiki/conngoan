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
                        <td><input type="text" class="w200" name="fea[description]" value=""></td>
                    </tr>
                    <tr>
                        <td class="label">Kiểu</td>
                        <td>
                            <select name="fea[feature_type]" class="w200">
                                <!--<option value="C">CheckBox</option>-->
                                <option value="S">SelectBox</option>
                                <option value="T">Text</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Nhóm thuộc tính</td>
                        <td>
                            <select name="fea[parent_id]" class="w200">
                                <?foreach($listfeatures as $val):?>
                                <option value="<?=$val->feature_id?>"><?=$val->description?></option>
                                <?endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Miêu tả</td>
                        <td><textarea style="width: 350px; height: 200px;" name="fea[full_description]"></textarea></td>
                    </tr>

                    <tr>
                        <td class="label">Lọc ở nhóm sản phẩm</td>
                        <td><input type="checkbox" name="fea[display_on_catalog]" value="1" ></td>
                    </tr>
                    <tr>
                        <td class="label">Sắp xếp</td>
                        <td><input type="text" name="fea[ordering]" value=""></td>
                    </tr>
                </table>

            </fieldset>
        </td>
        <td>
            <fieldset>
                <legend>Giá trị của thuộc tính:</legend>
                <div style="max-height: 400px; overflow: auto;">
                    
                </div>
            </fieldset>
        </td>
    </tr>
</table>

<?php echo form_close();?>