<?echo form_open('product/shop/attrdels',  array('id' => 'admindata'));
$id = $this->uri->segment(4);
?> 
<table class="form">
    <tr>
        <td class="label">
            Xem tin theo thuộc tính
        </td>
        <td>
            <?$listview = $this->shop->get_all_attr()?>
            <select name="view" onchange="window.open(this.value,'_self');">
                <option value="<?=base_url()?>product/shop/listattr/0">Thuộc tính chính</option>
                <?foreach($listview as $val):?>
                <option value="<?=base_url()?>product/shop/listattr/<?=$val->type_id?>" <?if($val->type_id==$this->uri->segment(4)){echo 'selected="selected"';}?>><?=$val->type_name?></option> 
                <?endforeach;?>
            </select>
        </td>
    </tr>
</table>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                <?=action_del()?>
                Hiện có <?=$num?> thuộc tính chính
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Tên thuộc tính</th>
            <th>Số thuộc tính con</th>
            <th style="width: 80px;">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->type_id?>"></td>
        <td><?=$rs->type_id?></td>
        <td><?=$rs->type_name?></td>
        <td><?//=$rs->titleurl?></td>
        <td align="center">
            <?=icon_view('product/shop/listattr/'.$rs->type_id)?>
            <?=icon_edit('product/shop/editattr/'.$rs->type_id.'/'.$id)?>
            <span id="publish<?=$rs->type_id?>"><?=icon_active("'shop_type'","'type_id'",$rs->type_id,$rs->published)?></span>
            <?=icon_del('product/shop/delattr/'.$rs->type_id.'/'.(int)$id)?>        
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="5">
                    <?=action_del()?>
                    Hiện có <?=$num?> thuộc tính chính
                </td>
            </tfoot>    
</table>
<?=form_close()?>
