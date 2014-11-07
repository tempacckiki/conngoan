<?php echo form_open('menu/delsmenus',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="6">

                Hiện có <?php echo $num?> danh mục menu
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Danh mục menu</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->menutype_id?>"></td>
        <td><?=$rs->menutype_id?></td>
        <td><?=$rs->menutype_title?></td>
        <td align="center">
            <?php echo icon_edit('menu/editmenus/'.$rs->menutype_id)?>
            <?php // echo icon_del('menu/delmenus/'.$rs->menutype_id.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="6">

                    Hiện có <?php echo $num?> danh mục menu
                </td>
            </tfoot>    
</table>
<?php echo form_close()?>
