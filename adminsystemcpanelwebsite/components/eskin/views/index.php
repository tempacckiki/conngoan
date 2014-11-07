<?echo form_open('poll/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                Hiện có <?=count($list)?> email templates
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Code</th>
            <th>Tiêu đề</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><?=$rs->slug?></td>
        <td><?=$rs->subject?></td>

        <td align="center">
            <?=icon_edit('eskin/edit/'.$rs->id)?>
            
            <?=icon_del('eskin/del/'.$rs->id)?>        
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="5">
            Hiện có <?=count($list)?> email templates
        </td>
    </tfoot>    
</table>
<?=form_close()?>
