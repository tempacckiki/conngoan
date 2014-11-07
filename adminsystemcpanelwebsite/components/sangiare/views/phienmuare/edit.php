<script type="text/javascript" src="<?=base_url()?>templates/js/shop.js?v=2.0" charset="UTF-8"></script>
<script type="text/javascript" src="<?=base_url()?>templates/js/core/datetimepicker_css.js"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>templates/css/shop.css?v=2.0" media="screen" />

<script type="text/javascript">
$(document).ready(function(){
    $("ul.tab li").click(function () {
        $("ul.tab li.select").removeClass("select");
        $(this).addClass("select");
        $(".content").css('display','none');
        var content_show = $(this).attr("title");
        $("#"+content_show).css('display','block');
    }); 
    
    CKEDITOR.replace('full',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('en_full',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('editor_chucnang',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('en_editor_chucnang',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('editor_dieukien',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('en_editor_dieukien',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('editor_noibat',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
    CKEDITOR.replace('en_editor_noibat',{
        toolbar : 'full',
        extraPlugins:'jwplayer'
    });
});
</script>
<ul class="tab">
    <li class="select" title="thongtin"><a href="javascript:void(0)">Thông tin</a></li>
    <li title="noibat"><a href="javascript:void(0)">Điểm nổi bật</a></li>
    <li title="dieukien"><a href="javascript:void(0)">Điều kiện mua rẻ</a></li>
</ul>
<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="productid" value="<?=$pro->productid?>">
<div class="gray">
        <div id="thongtin" class="content" style="display: block;">
            <table class="form">
                <tr>
                    <td class="label">Sản phẩm</td>
                    <td><input type="text" name="product_name" value="<?=$pro->productname?>" class="w400"></td>
                </tr>
                <tr>
                    <td class="label">Tiêu đề - vi</td>
                    <td>
                        <textarea style="width: 600px;height: 50px;" name="data[cheap_title]"><?=$rs->cheap_title?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="label">Tiêu đề - en</td>
                    <td>
                        <textarea style="width: 600px;height: 50px;" name="data_en[cheap_title]"><?=$rs_en->cheap_title?></textarea>
                    </td>
                </tr>

                <tr>
                    <td class="label">Giá thị trường</td>
                    <td><input type="text" name="data[cheap_price_old]" id="cheap_price_old" value="<?=number_format($rs->cheap_price_old,0,'.','.')?>"></td>
                </tr> 
                <tr>
                    <td class="label">Giá mua rẻ</td>
                    <td><input type="text" name="data[cheap_price]" id="cheap_price" value="<?=number_format($rs->cheap_price,0,'.','.')?>"></td>
                </tr>
                <tr>
                    <td class="label">Tiết kiệm</td>
                    <td><input type="text" name="data[cheap_saving]" id="cheap_saving" value="<?=number_format($rs->cheap_saving,0,'.','.')?>"> = <input type="text" name="data[cheap_per]" value="<?=$rs->cheap_per?>" class="w30" id="cheap_per">%</td>
                </tr>
                <tr>
                    <td class="label">Số lượng cơ hội mua rẻ</td>
                    <td><input type="text" name="data[cheap_qty]" value="<?=$rs->cheap_qty?>"></td>
                </tr>
                <tr>
                    <td class="label">Số lương/ Lần mua</td>
                    <td><input type="text" name="data[cheap_buy_limit]" value="<?=$rs->cheap_buy_limit?>"></td>
                </tr>
                <tr>
                    <td class="label">Khu vực</td>
                    <td>
                        <select name="city_id">
                            <option value="0">Toàn Quốc</option>
                            <?foreach($listcity as $val):?>
                            <option value="<?=$val->city_id?>" <?=($val->city_id == $rs->city_id)?'selected="selected"':''?>><?=$val->city_name?></option>
                            <?endforeach;?>
                        </select>
                    </td>
                </tr>
            </table>
            <fieldset id="miennam">
                <legend>Thời gian</legend>
                    <table class="form">
                            <tr>
                                <td class="label">Bắt đầu</td>
                                <td>
                                    Ngày: <input type="text" id="time_begin_date" name="time_begin_date" value="<?=date('d-m-Y',$rs->cheap_timebegin)?>" class="w100"> 
                                    Giờ: <select name="time_begin_h">
                                            <?for($h=0; $h<=23; $h++){?>
                                            <option value="<?=$h?>" <?=($h == date('H',$rs->cheap_timebegin))?'selected="selected"':'';?>><?=$h?></option>
                                            <?}?>
                                        </select>
                                    Phút: <select name="time_begin_i">
                                            <?for($h=0; $h<=59; $h++){?>
                                            <option value="<?=$h?>" <?=($h == date('i',$rs->cheap_timebegin))?'selected="selected"':'';?>><?=$h?></option>
                                            <?}?>
                                        </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="label">Kết thúc</td>
                                <td>
                                    Ngày: <input type="text" id="time_end_date" name="time_end_date" value="<?=date('d-m-Y',$rs->cheap_timeend)?>" class="w100"> 
                                    Giờ: <select name="time_end_h">
                                            <?for($h=0; $h<=23; $h++){?>
                                            <option value="<?=$h?>" <?=($h == date('H',$rs->cheap_timeend))?'selected="selected"':'';?>><?=$h?></option>
                                            <?}?>
                                        </select>
                                    Phút: <select name="time_end_i">
                                            <?for($h=0; $h<=59; $h++){?>
                                            <option value="<?=$h?>" <?=($h == date('i',$rs->cheap_timeend))?'selected="selected"':'';?>><?=$h?></option>
                                            <?}?>
                                        </select>
                                </td>
                            </tr>

                    </table>
            </fieldset>

        </div>
        <!-- Mo ta-->
        <div id="mieuta" class="content">
            <p>Tiếng Việt</p>
            <textarea id="full" name="data[cheap_des]"><?=$rs->cheap_des?></textarea>
            <p>Tiếng Anh</p>
            <textarea id="en_full" name="data_en[cheap_des]"><?=$rs_en->cheap_des?></textarea>
        </div>  
        <div id="chucnang" class="content">
            <p>Tiếng Việt</p>
            <textarea id="editor_chucnang" name="data[cheap_properties]"><?=$rs->cheap_properties?></textarea>
            <p>Tiếng Anh</p>
            <textarea id="en_editor_chucnang" name="data_en[cheap_properties]"><?=$rs_en->cheap_properties?></textarea>
        </div> 
        <div id="noibat" class="content">
            <p>Tiếng Việt</p>
            <textarea id="editor_noibat" name="data[cheap_highlights]"><?=$rs->cheap_highlights?></textarea>
            <p>Tiếng Anh</p>
            <textarea id="en_editor_noibat" name="data_en[cheap_highlights]"><?=$rs_en->cheap_highlights?></textarea>
        </div> 
        <!-- Thuoc tinh-->
        <div id="dieukien" class="content">
            <p>Tiếng Việt</p>
            <textarea id="editor_dieukien" name="data[cheap_condi]"><?=$rs->cheap_condi?></textarea>
            <p>Tiếng Anh</p>
            <textarea id="en_editor_dieukien" name="data_en[cheap_condi]"><?=$rs_en->cheap_condi?></textarea>
        </div>

          
</div>
<?=form_close()?>
<script type="text/javascript">
    $(function() {
        var dates = $( "#time_begin_date, #time_end_date" ).datepicker({
            changeMonth: true,
            dateFormat: 'dd-mm-yy', 
            numberOfMonths: 1,
            onSelect: function( selectedDate ) {
                var option = this.id == "time_begin_date" ? "minDate" : "maxDate",
                    instance = $( this ).data( "datepicker" );
                    date = $.datepicker.parseDate(
                        instance.settings.dateFormat ||
                        $.datepicker._defaults.dateFormat,
                        selectedDate, instance.settings );
                dates.not( this ).datepicker( "option", option, date );
            }
        });
    });
$(document).ready(function() {
    $('#cheap_price').keyup(function() {
        giathitruong = ToNumber($("#cheap_price_old").val());
        giamuare = ToNumber($(this).val());
        //alert(giamuare);
        tietkiem_phantram = ((giathitruong - giamuare)*100)/giathitruong;
        $("#cheap_per").val(parseInt(tietkiem_phantram));
        $("#cheap_saving").val(formatCurrency(giathitruong - giamuare));
    });
    $('#cheap_price').priceFormat({});


});
</script>