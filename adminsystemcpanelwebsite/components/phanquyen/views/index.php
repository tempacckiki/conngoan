<?php echo form_open('phanquyen/dels',  array('id' => 'admindata'));?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="6">
                Hiện có <?=count($list)?> quản lý
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Quản lý</th>
            <th>Email đăng nhập</th>
            <th>Nhóm</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->user_id?>"></td>
        <td><?=$rs->user_id?></td>
        <td><?=$rs->fullname?></td>
        <td><?=$rs->email?></td>
        <td><?=$this->vdb->find_by_id('user_group',array('group_id'=>$rs->group_id))->group_name?></td>
        <td align="center">
        
            <a href="<?=site_url('phanquyen/edit/'.$rs->user_id)?>">
                <img src="<?=base_url()?>templates/icon/application_key.png" alt="">
            </a>
             <?=icon_del('phanquyen/del/'.$rs->user_id.'/'.(int)$this->uri->segment(4))?> 
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="6">
            Hiện có <?=count($list)?> quản lý
        </td>
    </tfoot>    
</table>

<?php echo form_close();?>
