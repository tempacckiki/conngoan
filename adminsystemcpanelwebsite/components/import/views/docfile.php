<div id="xuly">
<div>Hệ thống đang thực hiện nạp dữ liệu</div>
<div class="process">
    <div class="percent" style="width: 0%;">
        <div class="dr">0%.</div>
    </div>
</div>
<div>Xử lý được <span id="offset"></span>/<span id="total"></span> bản ghi</div>
</div>
<div id="bx_import">
<?php
ini_set('memory_limit', '100M');
memory_get_peak_usage(true);
require_once APPEXCEL.'excel/PHPExcel.php';
$objPHPExcel = new PHPExcel();
$objReader = new PHPExcel_Reader_Excel5();
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load( ROOT.'alobuy0862779988/templ/'.$filename);
//$objPHPExcel = $objReader->load( ROOT.'data/demo.xls');
$rowIterator = $objPHPExcel->getActiveSheet()->getRowIterator();
?>
<?=form_open('import/save_import',array('id'=>'admin_import'))?>
<div style="margin: 10px 0px;"><input type="submit" name="bt_submit" value="Lưu dữ liệu"></div>
<table class="admindata">
    <thead>
        <tr>
            <th rowspan="2">STT</th>
            <th rowspan="2">ID SP</th>
            <th rowspan="2" style="width: 100px;">Mã sản phẩm</th>
            <th rowspan="2" style="width: 200px;">Tên sản phẩm</th>
            <th rowspan="2" style="width: 100px;">Nhãn hàng</th>
            <th rowspan="2" style="width: 50px;">Bảo hành/<br />Tháng</th>
            <th rowspan="2">Tặng phẩm</th>
            <th colspan="3">Giá sản phẩm</th>
            <th rowspan="2" style="width: 50px;">Mã tỉnh</th>

        </tr>
        <tr>
            <th style="width: 70px;">Giá thị trường</th>
            <th style="width: 70px;">Giảm giá</th>
            <th style="width: 70px;">Giá bán</th>
        </tr>
    </thead>

<? 

//var_dump($rowIterator);

      $sheet = $objPHPExcel->getActiveSheet();
      $array_data = array();
    foreach($rowIterator as $row){
    $rowIndex = $row->getRowIndex ();
    $array_data[$rowIndex] = array('A'=>'', 'B'=>'','C'=>'','D'=>'','E'=>'','F'=>'','G'=>'','H'=>'','I'=>'','J'=>'','K'=>'');

    $cell = $sheet->getCell('A' . $rowIndex);
    $array_data[$rowIndex]['A'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('B' . $rowIndex);
    $array_data[$rowIndex]['B'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('C' . $rowIndex);
    $array_data[$rowIndex]['C'] = PHPExcel_Style_NumberFormat::toFormattedString($cell->getCalculatedValue(), 'YYYY-MM-DD');
    $cell = $sheet->getCell('D' . $rowIndex);
    $array_data[$rowIndex]['D'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('E' . $rowIndex);
    $array_data[$rowIndex]['E'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('F' . $rowIndex);
    $array_data[$rowIndex]['F'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('G' . $rowIndex);
    $array_data[$rowIndex]['G'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('H' . $rowIndex);
    $array_data[$rowIndex]['H'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('I' . $rowIndex);
    $array_data[$rowIndex]['I'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('J' . $rowIndex);
    $array_data[$rowIndex]['J'] = $cell->getCalculatedValue();
    $cell = $sheet->getCell('K' . $rowIndex);
    $array_data[$rowIndex]['K'] = $cell->getCalculatedValue();
    
    
    }
$j = 1;
$k = 1;
for($r = 5; $r <= count($array_data); $r++){
     $row_product = $array_data[$r];
?>
<tr class="row<?=$k?>" id="row">

    <?foreach($row_product as $key=>$value):
    ?>
    <td>
    <?if($key == 'A'){?>
            <?=$j?>
            <input type="hidden" name="ar_id[]" value="<?=$j?>">
    <?}else if($key == 'B'){?>
    <input type="text" name="productid_<?=$j?>" value="<?=$value?>" style="width: 40px;">
    <?}else if($key == 'C'){?>
    <input type="text" name="barcode_<?=$j?>" value="<?=$value?>" style="width: 100px;">
    <?}else if($key == 'D'){?>
    <textarea style="width: 200px; height: 40px;" name="productname_<?=$j?>"><?=$value?></textarea>
    <?}else if($key == 'E'){?>
    <input type="text" name="manufactureid_<?=$j?>" value="<?=$value?>" style="width: 100px;">
    <?}else if($key == 'F'){?>
    <input type="text" name="baohanh_<?=$j?>" value="<?=$value?>" style="width: 50px;">
    <?}else if($key == 'G'){?>
    <input type="text" name="tangpham_<?=$j?>" value="<?=$value?>" style="width: 99%;">
    <?}else if($key == 'H'){?>
    <input type="text" name="giathitruong_<?=$j?>" value="<?=number_format($value,0,',',',')?>" style="width: 70px;">
    <?}else if($key == 'I'){?>
    <input type="text" name="giamgia_<?=$j?>" value="<?=number_format($value,0,',',',')?>" style="width: 70px;">
    <?}else if($key == 'J'){?>
    <input type="text" name="giaban_<?=$j?>" value="<?=number_format($value,0,',',',')?>" style="width: 70px;">
    <?}else if($key == 'K'){?>
    <input type="text" name="city_<?=$j?>" value="<?=$value?>" style="width: 50px;">
    <?}?>
    </td>
    
    <?endforeach;?>
</tr>
<?
$j++;
$k = 1 - $k;
}
?>
</table>
<input type="hidden" name="type_import" value="file">
<div style="margin: 10px 0px;"><input type="submit" name="bt_submit" value="Lưu dữ liệu"></div>
</div>
<?=form_close()?>
<script type="text/javascript">
$(document).ready(function() {
    $("#admin_import").validate({
        rules: {
            type_import: "required"
        },
        submitHandler: function(form) {
            //show_v();
            dataString = $("#admin_import").serialize();
            $.ajax({
                type: "POST",
                url: $("#admin_import").attr('action'),
                data: dataString,
                dataType: "json",
                success: function(data) {
                    //hide_v();
                    $("#bx_import").hide();
                    $("#xuly").show();
                    process();
                    
                }
            }); 
        }        
    });        
});

</script>
<script type="text/javascript">
function process()
{
    $.get(base_url+'import/process_import', function (msg) {
        if(!isNaN(msg.begin))
        {
            if(msg.begin!='' && msg.begin < 100)
            {
                $('.percent').css('width',msg.begin+'%');
                $("#offset").html(msg.offset);
                $("#total").html(msg.total);
                $('.dr').html((msg.begin)+'%.').show('fast', function(){
                    process();
                });
            }else{

                $('.percent').css({width:'100%',color:'red'});
                $('.dr').css({left:'40%',color:'red'}).html('Hoàn thành');
                $("#offset").html(msg.total);
                $("#total").html(msg.total); 
                hide_v();              
            }
        }
    },'json');
}
</script>