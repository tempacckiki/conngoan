
<?php echo form_open(uri_string(), array('id'=>'admindata'));
$module = $this->uri->segment(3);
?>
<div class="gray">
    <table class="table_">
    <tr>
        <td valign="top">
            <input type="hidden" name="id" value="0">
            <input type="hidden" name="mod[module]" value="<?php echo $module?>">
            <input type="hidden" name="mod[html]" value="<?php echo ($module =='mod_html' || $module == 'mod_custom')?1:0?>">
            <table class="form">
                <tr>
                    <td class="label">Module</td>
                    <td><?php echo $this->uri->segment(3)?></td>
                </tr>
                <tr>
                    <td class="label">Tên Modules</td>
                    <td><input type="text" name="mod[title]" value="<?php echo set_value('mod[title]')?>"></td>
                </tr>
                <tr>
                    <td class="label">Hiển thị tiêu đề</td>
                    <td><input type="radio" name="mod[show_title]" value="1" <?php echo (set_value('mod[show_title]') == 1)?'checked="checked"':'';?>> Có hiển thị <input type="radio" name="mod[show_title]" value="0" <?php echo (set_value('mod[show_title]') == 0)?'checked="checked"':'';?>>Không hiển thị</td>
                </tr>
                <tr>
                    <td class="label">Bật Module</td>
                    <td>
                    <input type="radio" name="mod[published]" value="1" <?php echo (set_value('mod[published]') == 1)?'checked="checked"':'';?>> Có bật
                    <input type="radio" name="mod[published]" value="0" <?php echo (set_value('mod[published]') == 0)?'checked="checked"':'';?>>Không bật</td>
                </tr>

                <tr>
                    <td class="label">CSS Class</td>
                    <td><input type="text" name="mod[params]" value="<?php echo set_value('mod[params]')?>"></td>
                </tr>
                <tr>
                    <td class="label">Nội dung</td>
                    <td><textarea name="mod[content]" id="full"><?php echo set_value('mod[content]')?></textarea></td>
                </tr>
                <tr>
                    <td></td>
                    <td><?php echo action_save('Lưu Module')?></td>
                </tr>
            </table>        
        </td>
        <td valign="top">
        <?
        $attr = explode(':',$rs->attr);
        ?>
             <table class="form"> 
                <?php
                $i = 0;                
                foreach($xml->params[0] as $param) {
                    $attr_ = explode('=',$attr[$i]);
                    $value =  ($attr_[1] != '')?$attr_[1]:$param['default'];
                    echo '<tr>';
                    echo '<td><b>'.$param['label'].'</b></td>';
                    echo '<td>';
                    if($param['type'] == 'list'){
                        echo getParams_select($param->option,$param['name'],$value);
                    }else if($param['type'] == 'radio'){
                        echo getParams_radio($param->option,$param['name'],$value);
                    }else if($param['type'] == 'text'){
                        echo getParams_text($param['name'],$value);
                    }
                    echo '</td>';
                    echo '</tr>';
                $i ++;
                } 
                ?>             
             </table>
        </td>
    </tr>
    </table>
</div>
<?php echo form_close();?>

