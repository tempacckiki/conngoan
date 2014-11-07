<?php echo form_open('menu/dels',  array('id' => 'admindata'));?> 
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
            <th style="width: 20px;">Sắp xếp <?php echo action_order()?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    $listsub = $this->vdb->find_by_list('menu',array('parent_id'=>$rs->id));
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><b><?=$rs->name?></b></td>
        <td align="center">
            <input type="text"  class="order" name="order_<?=$rs->id?>" value="<?=$rs->ordering?>">
            <input type="hidden" name="id[]" value="<?=$rs->id?>">
        </td>
        <td align="center">
            <?php echo icon_edit('menu/edit/'.$rs->id.'/?menutype='.$rs->menutype)?>
            <span id="publish<?=$rs->id?>"><?=icon_active("'menu'","'id'",$rs->id,$rs->published)?></span>
            <?php echo icon_del('menu/del/'.$rs->id.'/'.$this->uri->segment(3))?>        
        </td>
    </tr>       
    <?
    $j = 1;
    foreach($listsub as $sub):?>
    <tr class="row<?=$j?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $sub->id?>"></td>
        <td><?=$sub->id?></td>
        <td>|___<?=$sub->name?></td>
        <td align="center">
            <input type="text" class="order" name="order_<?=$sub->id?>" value="<?=$sub->ordering?>">
            <input type="hidden" name="id[]" value="<?=$sub->id?>">
        </td>
        <td align="center">
            <?php echo icon_edit('menu/edit/'.$sub->id.'/?menutype='.$sub->menutype)?>
            <span id="publish<?=$sub->id?>"><?=icon_active("'menu'","'id'",$sub->id,$sub->published)?></span>
            <?php echo icon_del('menu/del/'.$sub->id.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>     
    <?php 
    $j = 1 - $j;
    endforeach;?>
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

<script type="text/javascript">
    function save_order(){
        load_show();
        var fields = $("#admindata :input").serializeArray();
        $.post(base_url+"menu/save_order",fields, function(data) {
            load_hide();
            location.reload();
        });
    }

</script>
