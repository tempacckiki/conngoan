<?php echo form_open('sections/dels',  array('id' => 'admindata'));
?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">
                Hiện có <?php echo $num?> chủ đề <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('sections/listsections/0/sections_id/asc','ID')?></th>
            <th><?php echo vnit_order('sections/listsections/0/sections_title/asc','Nhóm tin')?></th>
            <th style="width: 30px;"><?php echo vnit_order('sections/listsections/0/ordering/asc','Sắp xếp')?> <?php echo action_order()?></th>
            <th style="width: 30px;">Link</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->sections_id?>"></td>
        <td><?=$rs->sections_id?></td>
        <td><?=$rs->sections_title?></td>
        <td align="center">
            <input type="text"  class="order" name="order_<?=$rs->sections_id?>" value="<?=$rs->ordering?>">
            <input type="hidden" name="id[]" value="<?=$rs->sections_id?>">
        </td>
        <td class="copy" id="<?=$rs->sections_id?>" align="center">
            <img src="<?=base_url()?>templates/images/page_white_copy.png"  alt="copy to clipboard" title="Copy to Clipboard">
            <input class="w200" id="link_<?=$rs->sections_id?>" type="hidden" value="content/<?php echo $rs->sections_alias?>-<?php echo $rs->sections_id?>">
        </td>        
        <td align="center">
            <?php echo icon_edit('sections/edit/'.$rs->sections_id)?>
            <span id="publish<?php echo $rs->sections_id?>"><?php echo icon_active("'sections'","'sections_id'",$rs->sections_id,$rs->published)?></span>
            <?php echo icon_del('sections/del/'.$rs->sections_id.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="7">
                    Hiện có <?php echo $num?> chủ đề <span class="pages"><?php echo $pagination?></span>
                </td>
            </tfoot>    
</table>
<?php echo form_close()?>
<script type="text/javascript">
    function save_order(){
        load_show();
        var fields = $("#admindata :input").serializeArray();
        $.post(base_url+"sections/save_order",fields, function(data) {
            load_hide();
            location.reload();
        });
    }

</script>