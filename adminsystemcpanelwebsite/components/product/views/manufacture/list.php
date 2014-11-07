<?echo form_open('product/manufacture/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<input type="hidden" name="catid" value="<?=$this->uri->segment(3)?>">
<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                Hiện có <?=$num?> nhà sản xuất <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('product/manufacture/listmanufacture/0/manufactureid/asc','ID')?></th>
            <th><?=vnit_order('product/manufacture/listmanufacture/0/name/asc','Tên nhà sản xuất')?></th>
            <th style="width: 50px;">Hình ảnh</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->manufactureid?>"></td>
        <td><?=$rs->manufactureid?></td>
        <td><?=$rs->name?></td>
        <td>
            <img src="<?=base_url_img()?>data/img_manufacture/<?=$rs->images_small?>" width="50" alt="">
        </td>
        <td align="center">
            <?=icon_edit('product/manufacture/edit/'.$rs->manufactureid.'/'.$page_m)?>
            <span id="publish<?=$rs->manufactureid?>"><?=icon_active("'shop_manufacture'","'manufactureid'",$rs->manufactureid,$rs->published,'product/manufacture/published')?></span>
            <?=icon_del('product/manufacture/del/'.$rs->manufactureid.'/'.$page_m)?>        
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="5">
            Hiện có <?=$num?> nhà sản xuất <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
