<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?=count($list)?> điểm bảo hành
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Địa chỉ</th>
            <th>Điện thoại</th>
            <th>Thành phố</th>
            <th>Thời gian làm việc</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->manufactureid?>"></td>
        <td><?=$rs->id?></td>
        <td><?=$rs->address?></td>
        <td><?=$rs->phone?></td>
        <td><?=$this->vdb->find_by_id('city',array('city_id'=>$rs->city_id))->city_name?></td>
        <td><?=$rs->time_working?></td>

        <td align="center">
            <?=icon_edit('baohanh/edit/'.$rs->manufactureid.'/'.$rs->id)?>
            <?=icon_del('baohanh/del/'.$rs->manufactureid.'/'.$rs->id)?>
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="8">
            Hiện có <?=count($list)?> điểm bảo hành
        </td>
    </tfoot>    
</table>

