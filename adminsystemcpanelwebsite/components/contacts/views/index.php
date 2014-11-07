<?php echo form_open('contacts/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="6">
                Hiện có <?php echo $num?> danh bạ <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('contacts/listcontacts/0/id/desc','ID')?></th>
            <th><?php echo vnit_order('contacts/listcontacts/0/hoten/desc','Họ tên ')?></th>
            <th><?php echo vnit_order('contacts/listcontacts/0/chucvu/desc','Chức vụ ')?></th>
            <th style="width: 30px;"><?php echo vnit_order('contacts/listcontacts/0/ordering/desc','Sắp xếp')?> <?php echo action_order()?></th>

            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><?=$rs->hoten?></td>
        <td><?=$rs->chucvu?></td>
        <td align="center">
            <input type="text"  class="order" name="order_<?=$rs->id?>" value="<?=$rs->ordering?>">
            <input type="hidden" name="id[]" value="<?=$rs->id?>">
        </td>
        <td align="center">
            <?php echo icon_edit('contacts/edit/'.$rs->id)?>
            <span id="publish<?php echo $rs->id?>"><?php echo icon_active("'contacts'","'id'",$rs->id,$rs->id)?></span>
            <?php echo icon_del('contacts/del/'.$rs->id.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="6">
                    Hiện có <?php echo $num?> danh bạ <span class="pages"><?php echo $pagination?></span>
                </td>
            </tfoot>    
</table>
<?php echo form_close()?>
<script type="text/javascript">
    function save_order(){
        load_show();
        var fields = $("#admindata :input").serializeArray();
        $.post(base_url+"contacts/save_order",fields, function(data) {
            load_hide();
            location.reload();
        });
    }

</script>