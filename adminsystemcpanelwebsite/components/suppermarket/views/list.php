<?echo form_open('suppermarket/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">

                Hiện có <?=$num?> liên hệ <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('suppermarket/listsupper/0/id/desc','ID')?></th>
            <th><?=vnit_order('suppermarket/listsupper/0/name/desc','Tên')?></th>
            <th><?=vnit_order('suppermarket/listsupper/0/address/desc','Địa chỉ')?></th>
            <th><?=vnit_order('suppermarket/listsupper/0/phone/desc','Điện thoại')?></th>
            <th><?=vnit_order('suppermarket/listsupper/0/email/desc','Email')?></th>
            <th>Sắp xếp</th>
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
        <td><?=$rs->name?></td>
        <td><?=$rs->address?></td>
        <td><?=$rs->phone?></td>
        <td><?=$rs->email?></td>
        <td><?=$rs->ordering?></td>
        <td align="center">
            <?php echo icon_edit('suppermarket/edit/'.$rs->id)?> 
            <?=icon_del('suppermarket/del/'.$rs->id.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="8">

                    Hiện có <?=$num?> liên hệ <span class="pages"><?=$pagination?></span>
                </td>
            </tfoot>    
</table>
<?=form_close()?>
