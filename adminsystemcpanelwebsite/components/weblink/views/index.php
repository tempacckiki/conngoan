<?php echo form_open('weblink/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">

                Hiện có <?php echo $num?> liên kết <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('weblink/listweblink/0/weblink_id/asc','ID')?></th>
            <th><?php echo vnit_order('weblink/listweblink/0/name/asc','Tên liên kết')?></th>
            <th><?php echo vnit_order('weblink/listweblink/0/link/asc','Links')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->weblink_id?>"></td>
        <td><?=$rs->weblink_id?></td>
        <td><?=$rs->name?></td>
        <td><?=$rs->link?></td>
        <td align="center">
            <?php 
                echo icon_edit('weblink/edit/'.$rs->weblink_id);  
                echo icon_del('weblink/del/'.$rs->weblink_id.'/'.(int)$this->uri->segment(4));
            ?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="7">

                    Hiện có <?php echo $num?> liên kết <span class="pages"><?php echo $pagination?></span>
                </td>
            </tfoot>    
</table>
<?php echo form_close()?>

