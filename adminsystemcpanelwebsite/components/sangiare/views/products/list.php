<?echo form_open('sangiare/shop/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(5)?>">
<input type="hidden" name="catid" value="<?=$this->uri->segment(4)?>">
<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<?$uri5 = (int)$this->uri->segment(5)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="15">
                Hiện có <?=$num?> sản phẩm 
                 <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th style="width: 70px;"><?=vnit_order('sangiare/shop/listproduct/'.$uri4.'/0/barcode/asc','Mã hàng')?></th>
            <th style="width: 70px;">Hình ảnh</th>
            <th><?=vnit_order('sangiare/shop/listproduct/'.$uri4.'/0/productname/asc','Tên sản phẩm')?></th>
            <th class="w100">
                <div><?=vnit_order('sangiare/shop/listproduct/'.$uri4.'/0/giathitruong_miennam/asc','Giá thị trường')?></div>
            </th>
            <th style="width: 60px;">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=($rs->del == 1)?'3':$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->productid?>"></td> 
        <td><?=$rs->barcode?></td>
        <td>
            <img src="<?=base_url_site()?>data/sangiare/200/<?=$rs->productimg?>" alt="" width="80">
        </td>
        <td><?=$rs->productname?></td>
        <td>
            <div><input type="text" id="giathitruong_miennam_<?=$rs->productid?>" value="<?=number_format($rs->giathitruong_miennam,0,'.','.')?>" class="w100"></div>
        </td>
        <td align="center">
            <?if($rs->del==0){?>
            <?=icon_sangiare('sangiare/phienmuare/add/'.$rs->productid)?>
            <?}?>
            <?=icon_edit('sangiare/shop/edit/'.$rs->productid.'/'.$uri4.'/'.$uri5)?>
            <?=icon_del('sangiare/shop/del/'.$rs->productid.'/'.$uri4.'/'.$uri5)?>
            
            <script type="text/javascript">
            $(document).ready(function() {
                $('#giathitruong_miennam_<?=$rs->productid?>').priceFormat({
                    centsSeparator: '', 
                    thousandsSeparator: '.',
                    centsLimit: 0
                });
            });
            </script>
        </td>
    </tr>   
  
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="15">
            Hiện có <?=$num?> sản phẩm <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>
