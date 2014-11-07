<?php echo form_open('category/dels',  array('id' => 'admindata'));?> 
<?$page = $this->uri->segment(4)?>
<fieldset>
    <legend>Tùy chọn</legend>
    <div style="font-weight: bold;">
        <?if($this->permit->get_permit_icon('features/manage/add_field')){?>
        <a href="<?=site_url('features/manage/add_field')?>" style="padding-right: 20px;">Thêm thuộc tính</a>
        <?}?>
        <?if($this->permit->get_permit_icon('features/manage/add_group')){?>
        <a href="<?=site_url('features/manage/add_group')?>">Thêm nhóm thuộc tính</a>
        <?}?>
    </div>
</fieldset>
<input type="hidden" name="page" value="<?=$page?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                Hiện có <?php echo $num?> nhóm thuộc tính sản phẩm <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>

            <th style="width: 50px;">ID</th>
            <th>Thuộc tính</th>
            <th style="width: 150px;">Lọc ở nhóm sản phẩm</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?

    foreach($list as $rs):
    if($rs->parent_id == 0){
        $listsub = $this->manage->get_subcat($rs->feature_id);
    ?>
    <tr class="row2">


        <td colspan="2"><?=$rs->description?></td>
        <td align="center"></td>
        <td align="center">
            <?php echo icon_edit('features/manage/edit_group/'.$rs->feature_id.'/'.$page)?>
            <?php echo icon_del('features/manage/del_group/'.$rs->feature_id.'/'.$page)?>        
        </td>
    </tr>   
    <?
    $k=1;
    foreach($listsub as $val):?>
    <tr class="row<?=$k?>">

        <td><?=$val->feature_id?></td>
        <td>|---- <?=$val->description?></td>
        <td align="center"><input type="checkbox" name="display_on_catalog_<?=$val->feature_id?>" onchange="change_status('display_on_catalog',<?=$val->feature_id?>)" value="1" <?=($val->display_on_catalog == 1)?'checked="checked"':''?>></td>
        <td align="center">
            <?php echo icon_edit('features/manage/edit_field/'.$val->feature_id.'/'.$page)?>
            <?php echo icon_del('features/manage/del_field/'.$val->feature_id.'/'.$page)?>        
        </td>
    </tr>  
    <?
    $k=1-$k;
    endforeach;?>
    <?php
    }
    endforeach;
    ?>
    <tfoot>
        <td colspan="7">
            Hiện có <?php echo $num?> nhóm thuộc tính sản phẩm <span class="pages"><?php echo $pagination?></span>
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
    function change_status(thuoctinh,feature_id){
        if($('input[name='+thuoctinh+'_'+feature_id+']').is(':checked')){
            giatri = 1;
        }else{
            giatri = 0;
        }
        $.post(base_url+"features/manage/save_display_on_catalog",{'thuoctinh':thuoctinh,'giatri':giatri,'feature_id':feature_id},function(data){ 
            
        },'json');
        return false;
    }

</script>
