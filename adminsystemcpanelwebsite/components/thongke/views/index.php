<fieldset>
    <legend>Tiêu chí thống kê</legend>
    <?=form_open(uri_string(),array('id'=>'adminform'))?>
    <table class="form">
        <tr>
            <td class="label">Từ ngày</td>
            <td><input type="text" id="tungay" name="tungay" style="width: 200px;"></td>
        </tr>
        <tr>
            <td class="label">Đến ngày</td>
            <td><input type="text" id="denngay" name="denngay" style="width: 200px;"></td>
        </tr>
        <tr>
            <td class="label">Danh mục sản phẩm</td>
            <td>
                <select name="catid" style="width: 205px;">
                    <option value="0">Tất cả</option>
                    <?foreach($list as $cat):
                    $listsub = $this->thongke->get_sub_cat($cat->catid);
                    ?>
                        <option value="<?=$cat->catid?>" style="font-weight: bold;"><?=$cat->catname?></option>
                        <?foreach($listsub as $sub):
                        $listsub1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$sub->catid)); 
                        ?>
                        <option style="padding-left: 10px;" value="<?=$sub->catid?>">|__<?=$sub->catname?></option>
                            <?foreach($listsub1 as $sub1):?>
                            <option style="padding-left: 10px;" value="<?=$sub1->catid?>">|_____<?=$sub1->catname?></option>
                            <?endforeach;?> 
                        <?endforeach;?>
                    <?endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Tỉnh, Thành phố</td>
            <td>
                <select name="city_id" style="width: 205px;">
                    <option value="0">Tất cả</option>
                    <?foreach($listcity as $val):?>
                    <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
                    <?endforeach;?>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Tình trạng đơn hàng</td>
            <td>
                <select name="status" style="width: 205px;">
                    <option value="0">Tất cả</option>
                    <option value="1">Chưa xác nhận</option>
                    <option value="2">Đã xác nhận</option>
                    <option value="3">Đang xử lý</option>
                    <option value="4">Hoàn thành</option>
                    <option value="5">Đã hủy</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label">Sắp xếp</td>
            <td>
                <select name="order" style="width: 205px;">
                    <option value="status|asc">Tình trạng A-Z</option>
                    <option value="status|desc">Tình trạng Z-A</option>
                    <option value="date_buy|asc">Ngày mua A-Z</option>
                    <option value="date_buy|desc">Ngày mua Z-A</option>
                </select>
            </td>
        </tr>
        <tr>
            <td class="label"></td>
            <td><input type="submit" value="Thống kê"></td>
        </tr>
    </table>
    
    <?=form_close();?>
</fieldset>
<script>
    $(function() {
        var dates = $( "#tungay, #denngay" ).datepicker({

            changeMonth: true,
            dateFormat: 'yy-mm-dd', 
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