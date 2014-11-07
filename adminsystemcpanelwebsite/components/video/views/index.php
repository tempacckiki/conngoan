<div>Link Video <input type="text" class="w400" value="video"></div>
<?php echo form_open('video/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">
                Hiện có <?php echo $num?> Chủ đề con <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('video/listvideo/0/video_id/desc','ID')?></th>
            <th><?php echo vnit_order('video/listvideo/0/video_title/desc','Tiêu đề')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->video_id?>"></td>
        <td><?=$rs->video_id?></td>
        <td><?=$rs->video_title?></td>     
        <td align="center">
            <?php echo icon_edit('video/edit/'.$rs->video_id)?>
            <span id="publish<?php echo $rs->video_id?>"><?php echo icon_active("'video'","'video_id'",$rs->video_id,$rs->published)?></span>
            <?php echo icon_del('video/del/'.$rs->video_id)?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
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
