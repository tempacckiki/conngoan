<?php echo form_open('account/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="10">

                Hiện có <?php echo count($list)?> quản trị
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('account/listaccount/0/user_code/asc','ID')?></th>
            <th><?php echo vnit_order('account/listaccount/0/fullname/asc','Tên thành viên')?></th>
            <th><?php echo vnit_order('account/listaccount/0/email/asc','Email đăng nhập')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->user_id?>"></td>
        <td><?=$rs->user_code?></td>
        <td><?=$rs->fullname?></td>
        <td><?=$rs->email?></td>
        <td align="center">
        <?if($this->permit->get_permit_icon('account/view_history')){?> 
            <a href="<?=site_url('account/view_history/'.$rs->user_id)?>" title="Lịch sử truy cập">
                <img src="<?=base_url()?>templates/icon/log.png" alt="">
            </a>
        <?}?>
        </td>                                                          
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="10">
            Hiện có <?php echo count($list)?> quản trị
        </td>
    </tfoot>    
</table>
<?php echo form_close()?>

