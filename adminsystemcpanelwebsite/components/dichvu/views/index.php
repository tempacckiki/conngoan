<?php echo form_open('dichvu/dels',  array('id' => 'admindata'));?> 
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?php echo count($list)?> dịch vụ
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Dịch vụ</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><?=$rs->name?></td>
        <td align="center">
            <?php echo icon_edit('dichvu/edit/'.$rs->id)?>
            <span id="publish<?php echo $rs->id?>"><?php echo icon_active("'service'","'id'",$rs->id,$rs->published,'tintuc/published')?></span>
            <?php echo icon_del('dichvu/del/'.$rs->id)?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="8">
            Hiện có <?php echo count($list)?> Dịch vụ
        </td>
    </tfoot>    
</table>
<?php echo form_close()?>
