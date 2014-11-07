<?echo form_open('contact/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="7">

                Hiện có <?=$num?> banner <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('ads/listcat/0/id/desc','ID')?></th>
            <th width="150"><?=vnit_order('ads/listcat/0/fullname/desc','Hình ảnh')?></th>
            <th><?=vnit_order('ads/listcat/0/phone/desc','Tên banner')?></th>
            <th><?=vnit_order('ads/listcat/0/price/desc','Giá bán')?></th>
            <th><?=vnit_order('ads/listcat/0/price_old/desc','Giá cũ')?></th>
           
           
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    	$id	 		= $rs->id;
    	$name 	 	= $rs->name;
    	$price	 	= $rs->price;
    	$priceOld	= $rs->price_old;
    	$img	 	= (!empty($rs->image))?base_url_site().'data/ads/thumb/'.$rs->image:base_url_site().'site/templates/default/images/no_image.gif';
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$id;?>"></td>
        <td><?=$id;?></td>
        <td align="center"><img src="<?=$img;?>" width="90" alt=""></td>
        <td><?=$name;?></td>
      	<td><?=$price;?></td>
      	<td><?=$priceOld;?></td>
        <td align="center">
            <?=icon_edit('ads/edit/'.$rs->id.'/'.(int)$this->uri->segment(4))?>        
            <?=icon_del('ads/del/'.$rs->id.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="7">

                    Hiện có <?=$num?> banner <span class="pages"><?=$pagination?></span>
                </td>
            </tfoot>    
</table>
<?=form_close()?>
