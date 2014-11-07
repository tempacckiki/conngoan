<div>Link Photo <input type="text" class="w400" value="hinh-anh-hoat-dong"></div>
<?echo form_open('photo/delscat',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">

                Hiện có <?=$num?> chuyên mục <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('photo/listcat/0/catid/desc','ID')?></th>
            <th><?=vnit_order('photo/listcat/0/catname/desc','Tên chuyên mục')?></th>
            <th>Alias</th>
            <th><?=vnit_order('photo/listcat/0/ordering/desc','Sắp xếp')?></th>
            <th style="width: 30px;">Link</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->catid?>"></td>
        <td><?=$rs->catid?></td>
        <td><?=$rs->catname?></td>
        <td><?=$rs->caturl?></td>
        <td><?=$rs->ordering?></td>
        <td class="copy" id="<?=$rs->catid?>" align="center">
            <img src="<?=base_url()?>templates/images/page_white_copy.png"  alt="copy to clipboard" title="Copy to Clipboard">
            <input class="w200" id="link_<?=$rs->catid?>" type="hidden" value="hinh-anh-hoat-dong/<?php echo $rs->caturl?>-<?php echo $rs->catid?>">
        </td>
        <td align="center">
            <?=icon_edit('photo/editcat/'.$rs->catid)?>
            <span id="publish<?=$rs->catid?>"><?=icon_active("'album_cat'","'catid'",$rs->catid,$rs->IsActive)?></span>
            <?=icon_del('photo/delcat/'.$rs->catid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="7">
                    Hiện có <?=$num?> chuyên mục <span class="pages"><?=$pagination?></span>
                </td>
            </tfoot>    
</table>
<?=form_close()?>
