<?echo form_open('poll/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                Hiện có <?=$num?> thăm dò <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('poll/listpoll/0/pid/asc','ID')?></th>
            <th><?=vnit_order('poll/listpoll/0/question/asc','Câu hỏi')?></th>
            <th><?=vnit_order('poll/listpoll/0/add_date/asc','Ngày tạo')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->pid?>"></td>
        <td><?=$rs->pid?></td>
        <td><?=$rs->question?></td>
        <td><?=date('d/m/Y',$rs->add_date)?></td>
        <td align="center">
            <?=icon_edit('poll/edit/'.$rs->pid)?>
            <span id="publish<?=$rs->pid?>"><?=icon_active("'poll'","'pid'",$rs->pid,$rs->published)?></span>
            <?=icon_del('poll/del/'.$rs->pid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="5">
                    Hiện có <?=$num?> thăm dò <span class="pages"><?=$pagination?></span>
                </td>
            </tfoot>    
</table>
<?=form_close()?>
