<?echo form_open('thanhpho/dels',  array('id' => 'admindata'));?> 
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
            <th class="id"><?=vnit_order('support/ds/0/city_id/desc','Mã tỉnh')?></th>
            <th><?=vnit_order('support/ds/0/city_name/desc','Tỉnh, Thành phố')?></th>
             <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    $listparent = $this->vdb->find_by_list('city', array('parentid' => $rs->city_id));    
    ?>
    <tr class="row<?=$k?>">
        <td align="center">
        <?if($rs->city_id != 25){?>
        <input  type="checkbox" name="ar_id[]" value="<?=$rs->city_id?>">
        <?}?>
        </td>
        <td><?=$rs->city_id?></td>
        <td><?=$rs->city_name?></td>
        <td align="center">
            <?if($this->permit->get_permit_icon('support/yahoo')){?> 
            <a href="<?=site_url('support/yahoo/'.$rs->city_id)?>"><img src="<?=base_url()?>templates/icon/yahoo.png" alt=""></a>
            <?}?>
            <?if($this->permit->get_permit_icon('support/skype')){?> 
            <a href="<?=site_url('support/skype/'.$rs->city_id)?>"><img src="<?=base_url()?>templates/icon/skype.png" alt=""></a>
            <?}?>
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
