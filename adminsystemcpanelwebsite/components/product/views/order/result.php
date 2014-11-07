<?echo form_open('product/order/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$offset?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="9">
                Hiện có <?=$num?> đơn hàng <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">Mã đơn hàng</th>
            <th style="width: 150px;">Tên khách hàng</th>
            <th>Sản phẩm</th>
            <th>Địa chỉ</th>
            <th style="width: 120px;">Điện thoại</th>
            <th style="width: 100px;">Ngày đặt hàng</th>
            <th style="width: 100px;">Tình trạng</th>
            <th style="width: 100px;">NV</th>
            <th style="width: 80px;">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    //$user = $this->vdb->find_by_id('user',array('user_id'=>$rs->employee_id));
    $user = $this->order->find_user($rs->employee_id);
    $this->db = $this->load->database('default', TRUE); 
    $uri4 = $this->order->get_status_text($rs->status);
    $listsp = $this->order->get_list_order($rs->order_id); 
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->order_id?>"></td>
        <td><?=$rs->barcode?></td>
        <td><?=$rs->fullname?></td>
        <td>
            <ul style="margin-left: 18px;">
                <?foreach($listsp as $val):?>
                <li style="list-style: circle;"><?=$val->productname?></li>
                <?endforeach;?>
            </ul>
        </td>
        <td><?=$rs->address?>, <?=$this->vdb->find_by_id('city',array('city_id'=>$rs->districts_id))->city_name?>, <?=$this->vdb->find_by_id('city',array('city_id'=>$rs->city_id))->city_name?></td>
        <td><?=$rs->phone?></td>
        <td><?=date('H:i d/m/Y',$rs->date_buy)?></td>
        <td><?=get_status($rs->status)?></td>
        <td><?=($user)?$user->fullname:''?></td>
        <td align="center">
            <?=icon_edit('product/order/edit/'.$uri4.'/'.$rs->order_id.'/'.$offset)?>
            <?=icon_del('product/order/del/'.$uri4.'/'.$rs->order_id.'/'.$offset)?>        
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="9">
            Hiện có <?=$num?> đơn hàng <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?=form_close()?>