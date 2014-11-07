<?
$catid = (int)$this->uri->segment(4);
echo form_open('product/shop/delscat',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="6">
                Chọn chuyên mục chính 
                <select name="viewcat" onchange="window.open(this.value,'_self');">
                    <option value="<?=base_url()?>product/shop/listcat/0/0/">Xem chuyên mục chính</option>
                    <?foreach($listcat as $val):?>
                    <option value="<?=base_url()?>product/shop/listcat/<?=$val->catid?>/0/" <?=($catid == $val->catid)?'selected="selected"':''?>><?=$val->catname?></option>
                    <?endforeach;?>
                </select>
            </th>
        </tr>
    </thead>

    <thead>
        <tr>
            <th class="head" colspan="6">
                Hiện có <?=$num?> chuyên mục <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('product/shop/listcat/'.$catid.'/0/catid/asc','ID')?></th>
            <th><?=vnit_order('product/shop/listcat/'.$catid.'/0/catname/asc','Tên chuyên mục')?></th>
            <th>Alias</th>
            <th>Sắp xếp</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    $listsub  = $this->shop->get_sub_cat($rs->catid);
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->catid?>"></td>
        <td><?=$rs->catid?></td>
        <td><?=$rs->catname?></td>
        <td><?=$rs->caturl?></td>
        <td></td>
        <td align="center">
            <?=icon_edit('product/shop/editcat/'.$rs->catid.'/'.(int)$this->uri->segment(4))?>
            <span id="publish<?=$rs->catid?>"><?=icon_active("'shop_cat'","'catid'",$rs->catid,$rs->published)?></span>
            <?=icon_del('product/shop/delcat/'.$rs->catid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr> 

    <!--
    <?
    //$j=1;
    //foreach($listsub as $sub):?>
    <tr class="row<?=$j?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$sub->catid?>"></td>
        <td><?=$sub->catid?></td>
        <td style="padding-left: 10px;"> |__ <?=$sub->catname?></td>
        <td><?=$sub->caturl?></td>
        <td></td>
        <td align="center">
            <?=icon_edit('shop/editcat/'.$sub->catid)?>
            <span id="publish<?=$sub->catid?>"><?=icon_active("'news_cat'","'catid'",$sub->catid,$rs->IsActive)?></span>
            <?=icon_del('shop/delcat/'.$sub->catid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr> 
    -->       
    <?
    /*
    $j = 1-$j;
    endforeach;*/
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="6">
                    Hiện có <?=$num?> chuyên mục <span class="pages"><?=$pagination?></span>
                </td>
            </tfoot>    
</table>
<?=form_close()?>
