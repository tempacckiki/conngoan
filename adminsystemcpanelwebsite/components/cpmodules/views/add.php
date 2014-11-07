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
                    <td class="label">Tên Modules - vi</td>
                    <td><input type="text" class="w250" name="mod[title]" value="<?php echo set_value('mod[title]')?>"></td>
                </tr>
                <tr>
                    <td class="label">Tên Modules - en</td>
                    <td><input type="text" class="w250" name="mod_en[title]" value="<?php echo set_value('mod_en[title]')?>"></td>
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
                    <td class="label">Vị trí hiển thị</td>
                    <td>
                        <select name="mod[position]">
                        <?for($i=0;$i<count($position->position);$i++){
                            $val = $position->position[$i];
                            ?>
                           <option value="<?php echo $val?>"><?php echo $val?></option> 
                        <?}?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="label">CSS Class</td>
                    <td><input type="text" name="mod[params]" value="<?php echo set_value('mod[params]')?>"></td>
                </tr>
                <tr>
                    <td colspan="2">Nội dung - vi<br />
                    <textarea name="mod[content]" id="full"><?php echo set_value('mod[content]')?></textarea></td>
                </tr>
                <tr>
                    <td colspan="2">Nội dung - en<br />
                    <textarea name="mod_en[content]" id="en_full"><?php echo set_value('mod_en[content]')?></textarea></td>
                </tr>

            </table>
        <td valign="top" style="width: 400px;">

             <table class="form"> 
                <?php
                $i = 0;                
                foreach($xml->params[0] as $param) {
                $value = $param['default'];
                    echo '<tr>';
                    echo '<td class="label" style="width:200px">'.$param['label'].'<br /><label class="desc">'.$param['description'].'</label></td>';
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
<script type="text/javascript">
    CKEDITOR.replace('full',{
        toolbar : 'full'
    });
    CKEDITOR.replace('en_full',{
        toolbar : 'full'
    });
</script>