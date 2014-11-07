<?echo form_open('sangiare/denghi/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">

<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">
                Hiện có <?=$num?> đề nghị mua nhóm <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('sangiare/denghi/ds/0/id/asc','ID')?></th>
            <th><?=vnit_order('sangiare/denghi/ds/0/email/asc','Email')?></th>
            <th><?=vnit_order('sangiare/denghi/ds/0/productname/asc','Sản phẩm')?></th>
            <th><?=vnit_order('sangiare/denghi/ds/0/time/asc','Ngày')?></th>
            <th><?=vnit_order('sangiare/denghi/ds/0/check/asc','Tình trạng')?></th>
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
        <td><?=$rs->email?></td>
        <td><?=$rs->productname?></td>
        <td><?=date('d/m/Y',$rs->time)?></td>
        <td>
            <?=($rs->check==1)?'Đã xem':'Mới nhận'?>
        </td>
        <td align="center">
            <?=icon_edit('sangiare/denghi/edit/'.$rs->id.'/'.$this->uri->segment(4))?>
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="7">
            Hiện có <?=$num?> đề nghị mua nhóm <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
