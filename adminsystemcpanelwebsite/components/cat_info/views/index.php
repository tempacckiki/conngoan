<?php 
$catID   = $this->uri->segment('4');
?>
<?php echo form_open('cat_info/detailnews/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$catid?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?=count($list)?> thông tin
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th class="id">Cat ID</th>
          
            <th>Tên thông tin</th>
            <th style="width: 200px;">               
                <select name="cat_id" id="cat_id" onchange="window.open(this.value,'_self');" class="w250">
                        <?php foreach($listcat as $cat):
                        $listsub = $this->danhmuc->get_sub_cat($cat->catid);?>
                        <option value="<?=$cat->catid?>" <?=($cat->catid == $rs->cat_id)?'selected="selected"':'';?>><?=$cat->catname?></option>
                            <?php foreach($listsub as $sub):
                            $listsub1 = $this->danhmuc->get_sub_cat($sub->catid);
                            ?>
                            <option value="<?=$sub->catid?>" <?=($sub->catid == $rs->cat_id)?'selected="selected"':'';?>>|___<?=$sub->catname?></option>
                            
                                <?php foreach($listsub1 as $val):
                                $listsub2 = $this->danhmuc->get_sub_cat($val->catid);  
                                ?>
                                <option value="<?=$val->catid?>" <?=($val->catid == $rs->cat_id)?'selected="selected"':'';?>>|___|___<?=$val->catname?></option>
                                    <?foreach($listsub2 as $val1):?>
                                    <option value="<?=$val1->catid?>">|___|___|___<?=$val1->catname?></option>
                                    <?endforeach;?>
                                <?endforeach;?>
                            <?endforeach;?>
                        
                        <?endforeach;?>
                    </select>
            </th>
            <th style="width: 70px;">Sắp xếp</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><?php echo $rs->cat_id;?></td>       
        <td><?=$rs->name?></td>
        <td></td>
        <td align="center"><?=$rs->ordering?></td>
        <td align="center">
            <?=icon_edit('cat_info/detailnews/edit/'.$rs->id.'/'.$rs->cat_id)?>
            <span id="publish<?=$rs->id?>"><?=icon_active("'cat_info'","'id'",$rs->id,$rs->published,'cat_info/detailnews/published')?></span>    
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="8">
            Hiện có <?=count($list)?> thông tin
        </td>
    </tfoot>    
</table>
<?=form_close()?>