<?echo form_open('tintuc/delscat',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                Hiện có <?=$num?> danh mục
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Danh mục</th>
            <th style="width: 40px;">Sắp xếp</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    $subcat = $this->vdb->find_by_list('news_cat',array('parentid'=>$rs->catid));
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->catid?>"></td>
        <td><?=$rs->catid?></td>
        <td><?=$rs->catname?></td>
        <td><input type="text" style="width: 40px; text-align: center;" value="<?=$rs->ordering?>"></td>
        <td align="center">
            <?=icon_edit('tintuc/editcat/'.$rs->catid)?>
            <span id="publish<?=$rs->catid?>"><?=icon_active("'news_cat'","'catid'",$rs->catid,$rs->published,'tintuc/publishedcat')?></span>    
        </td>
    </tr>
    <?foreach($subcat as $rs1):?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs1->catid?>"></td>
        <td><?=$rs1->catid?></td>
        <td>|__<?=$rs1->catname?></td>
        <td><input type="text" style="width: 40px; text-align: center;" value="<?=$rs1->ordering?>"></td>
        <td align="center">
            <?=icon_edit('tintuc/editcat/'.$rs1->catid)?>
            <span id="publish<?=$rs->catid?>"><?=icon_active("'news_cat'","'catid'",$rs1->catid,$rs1->published,'tintuc/publishedcat')?></span>    
        </td>
    </tr>
    <?endforeach;?>
          
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="5">
            Hiện có <?=$num?> danh mục
        </td>
    </tfoot>    
</table>
<?=form_close()?>