<?php if($city_id != 0){?>
<?=form_open(uri_string(),array('id'=>'producthot','onsubmit'=>'return checkform(this);'))?>
<input type="hidden" name="city_id" value="<?=$city_id?>">
<input type="hidden" name="cat_id" value="<?=$cat_id;?>">
<table class="admindata" align="left" style="width: 500px;">
    <thead>
        <th style="width: 20px;">STT</th>
        <th style="width: 70px;">ID</th>
        <th>Tên sản phẩm</th>
        <th style="width: 40px;">Hình ảnh</th>
    </thead>
    <?
    $k = 1;
    for($i = 1; $i <=20; $i++){
        $rs = $this->producthome->get_item_hotcat($i,$city_id,$cat_id);
      
    ?>
    <tr class="row0">
        <td align="center"><?=$i?></td>
        <td>
            <input type="hidden" name="ar_id[]" value="<?=$i?>">
            <input type="text" name="productid_<?=$i?>" style="width: 70px;" value="<?=($rs)?$rs->productid:0;?>">
        </td>
        <td><?=($rs)?$rs->productname:''?></td>
        <td>
            <?
            if($rs){?>
            <img src="<?=base_url_img()?>alobuy0862779988/0862779988product/40/<?=$rs->productimg?>" alt="">
            <?}
            ?>
        </td>
    </tr>
    <?
    $k = 1 - $k;
    }
    ?>
</table>
<div style="clear: both;overflow: hidden;"><br /><input type="submit" id="save_hot" value="Lưu dữ liệu"></div>
<?=form_close();?>

<?}else{?>
    <div class="show_notice_small">Vui lòng chọn một Tỉnh, Thành phố</div>
<?}?>
<script type="text/javascript"><!--
    function checkform(form){       
        dataString = $("#producthot").serialize(); 
        $.ajax({
            type: "POST",
            url: base_url+"product/producthome/save_cat",
            data: dataString,
            dataType: "json",
            success: function(data) { 
                get_hot(data.city_id);
                jAlert(data.msg);
            }
        }); 
        return false;
    }
</script>
