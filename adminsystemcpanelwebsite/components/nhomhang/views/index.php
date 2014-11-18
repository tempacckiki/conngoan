<?
$catid = $this->uri->segment(3);
echo form_open('nhomhang/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>

        <tr>
            <th class="head" colspan="6">
                Hiện có <?=$num?> nhóm hàng <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('nhomhang/dsnhomhang/'.$catid.'/0/catid/asc','ID')?></th>
            <th><?=vnit_order('nhomhang/dsnhomhang/'.$catid.'/0/catname/asc','Nhóm hàng')?></th>
            <th style="width: 70px;"><?=vnit_order('nhomhang/dsnhomhang/'.$catid.'/0/ordering/asc','Hiển thị')?></th>
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
        <td><?=$rs->ordering?></td>
        <td align="center">
            <?=icon_edit('nhomhang/edit/'.$rs->catid.'/'.(int)$this->uri->segment(4))?>
<!--             <span id="publish<?=$rs->catid?>"><?=icon_active("'shop_cat'","'catid'",$rs->catid,$rs->published,'nhomhang/published')?></span>
 -->            <?=icon_del('nhomhang/del/'.$rs->catid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>      
    <?

    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="6">
            Hiện có <?=$num?> nhóm hàng <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
