<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<table style="width: 99%;">
    <tr>
        <td style="width: 500px; padding-right : 10px;">
            <fieldset>
                <legend>Thuộc tính</legend>
                <input type="hidden" name="id" value="<?php echo $rs->feature_id?>">
                <table class="form">
                    <tr>
                        <td class="label">Tiêu đề</td>
                        <td><input type="text" class="w200" name="fea[description]" value="<?php echo $rs->description?>"></td>
                    </tr>
                    <tr>
                        <td class="label">Kiểu</td>
                        <td>
                            <select name="fea[feature_type]" class="w200">
                                <!--<option value="C" <?=($rs->feature_type == 'C')?'selected="selected"':''?>>CheckBox</option>-->
                                <option value="S" <?=($rs->feature_type == 'S')?'selected="selected"':''?>>SelectBox</option>
                                <option value="T" <?=($rs->feature_type == 'T')?'selected="selected"':''?>>Text</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Nhóm thuộc tính</td>
                        <td>
                            <select name="fea[parent_id]" class="w200">
                                <?foreach($listfeatures as $val):?>
                                <option value="<?=$val->feature_id?>" <?=($rs->parent_id == $val->feature_id)?'selected="selected"':''?>><?=$val->description?></option>
                                <?endforeach;?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Miêu tả</td>
                        <td><textarea style="width: 350px; height: 200px;" name="fea[full_description]"><?=$rs->full_description?></textarea></td>
                    </tr>

                    <tr>
                        <td class="label">Lọc ở nhóm sản phẩm</td>
                        <td><input type="checkbox" name="display_on_catalog" value="1"  <?=($rs->display_on_catalog== 1)?'checked="checled"':''?>></td>
                    </tr>
                    <tr>
                        <td class="label">Sắp xếp</td>
                        <td><input type="text" name="fea[ordering]" value="<?=$rs->ordering?>"></td>
                    </tr>
                </table>

            </fieldset>
        </td>
        <td>
            <fieldset>
                <legend>Giá trị của thuộc tính: <?=$rs->description?></legend>
                <div style="max-height: 400px; overflow: auto;">
                    
                </div>
            </fieldset>
        </td>
    </tr>
</table>

<?php echo form_close();?>