<?echo form_open('contact/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">

                Hiện có <?=$num?> liên hệ <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('photo/listcat/0/id/desc','ID')?></th>
            <th><?=vnit_order('photo/listcat/0/fullname/desc','Họ tên')?></th>
            <th><?=vnit_order('photo/listcat/0/phone/desc','Điện thoại')?></th>
            <th><?=vnit_order('photo/listcat/0/email/desc','Email')?></th>
            <th><?=vnit_order('photo/listcat/0/datesend/desc','Ngày gửi')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->contactid?>"></td>
        <td><?=$rs->contactid?></td>
        <td><?=anchor('contact/edit/'.$rs->contactid.'/'.$this->uri->segment(3),$rs->fullname)?></td>
        <td><?=$rs->phone?></td>
        <td><?=$rs->email?></td>
        <td><?=date('H:i:s d/m/Y',$rs->datesend)?></td>

        <td align="center">
            <?=icon_del('contact/del/'.$rs->contactid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="7">

                    Hiện có <?=$num?> liên hệ <span class="pages"><?=$pagination?></span>
                </td>
            </tfoot>    
</table>
<?=form_close()?>
