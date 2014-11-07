<?echo form_open('faq/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">

                Hiện có <?=$num?> hướng dẫn <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('faq/listfaq/0/id/desc','ID')?></th>
            <th><?=vnit_order('faq/listfaq/0/title/desc','Tiêu đề')?></th>
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
        <td><?=$rs->title?></td>
        <td align="center">
            <?php echo icon_edit('faq/edit/'.$rs->id)?>
            <?if($rs->readonly != 1){?> 
            <?=icon_del('faq/del/'.$rs->id.'/'.(int)$this->uri->segment(4))?>        
            <?}?>
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="7">

            Hiện có <?=$num?> hướng dẫn <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
