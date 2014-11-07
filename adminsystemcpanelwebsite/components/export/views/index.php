<?=form_open(uri_string(),array('id'=>'admindata'));?>
<div class="show_notice_small">
Ghi chú: Mục Lọc theo ngày chính là ngày sản phẩm, giá được cập nhật
</div>
<table class="form">
    <tr>
        <td class="label">Nhóm hàng</td>
        <td>
            <select name="nhomhang" style="width: 300px;">
                <?foreach($listcat as $cat):
                $listsub = $this->export->get_sub_cat($cat->catid);
                ?>
                <option value="<?=$cat->catid?>" <?=($cat->catid == set_value('catid'))?'selected="selected"':'';?>><?=$cat->catname?></option>
                
                    <?foreach($listsub as $sub):
                    $listsub1 = $this->export->get_sub_cat($sub->catid);
                    ?>
                    <option value="<?=$sub->catid?>" <?=($sub->catid == set_value('catid'))?'selected="selected"':'';?>>|__<?=$sub->catname?></option>
                        <?foreach($listsub1 as $val):
                        $listsub2 = $this->export->get_sub_cat($val->catid);?>
                        <option value="<?=$val->catid?>">|____<?=$val->catname?></option>
                            <?foreach($listsub2 as $val2):?>
                            <option value="<?=$val2->catid?>">|________<?=$val2->catname?></option>
                            <?endforeach;?>
                        <?endforeach;?>
                    
                    <?endforeach;?>
                
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Tỉnh, Thành phố</td>
        <td>
            <select name="city_id" style="width: 300px;">
                <?foreach($listcity as $val):?>
                <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td>
            <select name="sapxep" style="width: 300px;">
                <option value="price|asc">Giá giảm dần</option>
                <option value="price|desc">Giá tăng dần</option>
                <option value="productname|asc">Tên sản phẩm A-Z</option>
                <option value="productname|desc">Tên sản phẩm Z-A</option>
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Lọc theo ngày</td>
        <td>
            Từ ngày <input type="text" id="tungay" name="tungay">
            Đến ngày <input type="text" id="denngay" name="denngay">
        </td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="Xuất dữ liệu"></td>
    </tr>
</table>
<?=form_close();?>
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