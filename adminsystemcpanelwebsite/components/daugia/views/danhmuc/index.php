<?php echo form_open('daugia/danhmuc/dels',  array('id' => 'admindata'));
$sections_url = ($sections_id != 0) ? '/?option=true&sections_id='.$sections_id : '';
?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">
                Hiện có <?php echo $num?> Chủ đề <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('daugia/danhmuc/listcategory/0/cat_id/desc'.$sections_url,'ID')?></th>
            <th><?php echo vnit_order('daugia/danhmuc/listcategory/0/cat_title/desc'.$sections_url,'Tiêu đề')?></th>
            <th style="width: 30px;"><?php echo vnit_order('daugia/danhmuc/listcategory/0/ordering/desc'.$sections_url,'Sắp xếp')?> <?php echo action_order()?></th>
            <th style="width: 30px;">Link</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k = 1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->cat_id?>"></td>
        <td><?=$rs->cat_id?></td>
        <td><?=$rs->cat_title?></td>
        <td>
            <input type="text"  class="order" name="order_<?=$rs->cat_id?>" value="<?=$rs->ordering?>">
            <input type="hidden" name="id[]" value="<?=$rs->cat_id?>">
        </td>
        <td class="copy" id="<?=$rs->cat_id?>" align="center">
            <img src="<?=base_url()?>templates/images/page_white_copy.png"  alt="copy to clipboard" title="Copy to Clipboard">
            <input class="w200" id="link_<?=$rs->cat_id?>" type="hidden" value="tin-tuc/danh-muc/<?=$rs->cat_alias.'-'.$rs->cat_id?>">
        </td>
        <td align="center">
            <?=icon_edit('daugia/danhmuc/edit/'.$rs->cat_id)?>
            <span id="publish<?=$rs->cat_id?>"><?=icon_active("'category'","'cat_id'",$rs->cat_id,$rs->published)?></span>
        </td>
    </tr>
    <?
    $k = 1 - $k;
    endforeach;?>
    <tfoot>
        <td colspan="7">
            Hiện có <?php echo $num?> Chủ đề con <span class="pages"><?php echo $pagination?></span>
        </td>
    </tfoot>    
</table>
<?php echo form_close()?>
<script type="text/javascript">
    function save_order(){
        load_show();
        var fields = $("#admindata :input").serializeArray();
        $.post(base_url+"category/save_order",fields, function(data) {
            load_hide();
            location.reload();
        });
    }

</script>
