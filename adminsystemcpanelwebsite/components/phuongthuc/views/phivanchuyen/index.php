
<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="5">
                <select name="" onchange="window.open(this.options[this.selectedIndex].value,'_self');">
                    <?foreach($listcity as $val):?>
                    <option value="<?=site_url('phuongthuc/phivanchuyen/index/'.$val->city_id)?>" <?=($val->city_id == $city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
                    <?endforeach;?>
                </select>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th>Quận, Huyện</th>
            <th style="width: 100px;">Phi vận chuyển</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;

    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->city_id?>"></td>
        <td><?=$rs->city_id?></td>
        <td><?=$rs->city_name?></td>
        <td><?=number_format($rs->rate,0,'.','.')?></td>
        <td align="center">
            <?=icon_edit('phuongthuc/phivanchuyen/edit/'.$city_id.'/'.$rs->city_id)?>
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    
</table>
