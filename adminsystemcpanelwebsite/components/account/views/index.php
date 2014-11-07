<script>
    $(function() {
        var dates = $( "#tungay, #denngay" ).datepicker({
            changeMonth: true,
            dateFormat: 'dd-mm-yy', 
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {
                var option = this.id == "tungay" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" );
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
</script>
<fieldset>
    <legend>Xuất dữ liệu</legend>
    <?=form_open('account/export')?>
    <table class="tuychon">
        <tr>
            <td>Từ ngày <input type="text" id="tungay" name="tungay" class="w100"></td>
            <td>Đến ngày <input type="text" id="denngay" name="denngay" class="w100"></td>
            <td>
                <select name="city_id">
                    <option value="0">--Tất cả khu vực--</option>
                <?foreach($listcity as $val){?>
                    <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                <?}?>
                </select>
            </td>
            <td>
                <input type="submit" value="Xuất dữ liệu">
            </td>
        </tr>
    </table>
    <?=form_close()?>
</fieldset>
<!--
<fieldset>
    <legend>Tìm kiếm</legend>
    <table class="tuychon">
        <tr>
            <td>Từ khóa <input type="text" class="w100"></td>
            <td>
                <select name="group_id">
                    <option value="0">--Nhóm thành viên--</option>
                <?foreach($this->group as $val){?>
                    <option value="<?=$val->group_id?>"><?=$val->group_name?></option>
                <?}?>
                </select>
            </td>
            <td>
                <input type="submit" value="Tìm kiếm">
            </td>
        </tr>
    </table>
</fieldset>
-->
<?
$get = "?option=true";
if($city_id != 0){
    $get .="&city_id=".$city_id;
}
$page = $this->uri->segment(3)
?>
<?php echo form_open('account/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="10">

                Hiện có <?php echo $num?> thành viên <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('account/listaccount/0/user_code/asc','ID')?></th>
            <th><?php echo vnit_order('account/listaccount/0/fullname/asc','Tên thành viên')?></th>
            <th><?php echo vnit_order('account/listaccount/0/email/asc','Email đăng nhập')?></th>
            <th><?php echo vnit_order('account/listaccount/0/phone/asc','Điện thoại')?></th>
            <th><?php echo vnit_order('account/listaccount/0/address/asc','Địa chỉ')?></th>
            <th style="width: 100px;">
                <select onchange="window.open(this.value,'_self');">
                    <option value="<?=site_url('account/listaccount/0/?option=true')?>">--Tất cả khu vực--</option>
                    <?foreach($listcity as $val){?>
                    <option <?=($val->city_id == $city_id)?'selected="selected"':''?> value="<?=site_url('account/listaccount/0/?option=true&city_id='.$val->city_id)?>"><?=$val->city_name?></option>
                    <?}?>
                </select>
            </th>
            <th><?php echo vnit_order('account/listaccount/0/username/asc','Điểm thưởng')?></th>

            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->user_id?>"></td>
        <td><?=$rs->user_code?></td>
        <td><?=$rs->fullname?></td>
        <td><?=$rs->email?></td>
        <td><?=$rs->phone?></td>
        <td><?=$rs->address?></td>
        <td><?=$this->account->find_city_by_id($rs->city_id)?></td>
        <td></td>
        <td align="center">
            <?php echo icon_edit('account/edit/'.$rs->user_id.'/'.$page)?>
            <span id="publish<?php echo $rs->user_id?>"><?php echo icon_active("'user'","'user_id'",$rs->user_id,$rs->published,'account/published')?></span>      
            <?php echo icon_del('account/del/'.$rs->user_id.'/'.$page)?>
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="10">

            Hiện có <?php echo $num?> thành viên <span class="pages"><?php echo $pagination?></span>
        </td>
    </tfoot>    
</table>
<?php echo form_close()?>

