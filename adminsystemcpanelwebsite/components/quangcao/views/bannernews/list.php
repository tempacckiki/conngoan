<?echo form_open('quangcao/banner_newspage/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">

                Hiện có <?=$num?> banner <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('quangcao/banner_newspage/listads/0/productid/desc','ID')?></th>
            <th width="150"><?=vnit_order('quangcao/banner_newspage/listads/0/productimg/desc','Hình ảnh')?></th>
            <th width="300"><?=vnit_order('quangcao/banner_newspage/listads/0/productname/desc','Tên banner')?></th>
            <th width="350"><?=vnit_order('quangcao/banner_newspage/listads/0/dicription/desc','Mô tả')?></th>
            <th><?=vnit_order('quangcao/banner_newspage/listads/0/giaban/desc','Giá bán')?></th>
            <th><?=vnit_order('quangcao/banner_newspage/listads/0/giathitruong/desc','Giá cũ')?></th>
           
           
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    	$id	 		= $rs->productid;
    	$name 	 	= $rs->productname;
    	$price	 	= $rs->giaban;
    	$priceOld	= $rs->giathitruong;
    	$decription	= $rs->decription; 
    	$img	 	= (!empty($rs->productimg))?base_url_site().'data/img_product/80/'.$rs->productimg:base_url_site().'site/templates/default/images/no_image.gif';
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$id;?>"></td>
        <td><?=$id;?></td>
        <td align="center"><img src="<?=$img;?>" width="90" alt=""></td>
        <td><?=$name;?></td>
        <td><?=$decription;?></td>
      	<td align="center"><?=$price;?></td>
      	<td align="center"><?=$priceOld;?></td>
        <td align="center">                
            <?=icon_del('quangcao/banner_newspage/del/'.$rs->productid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>        
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="8">

                    Hiện có <?=$num?> banner <span class="pages"><?=$pagination?></span>
                </td>
            </tfoot>    
</table>
<?=form_close()?>
