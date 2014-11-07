<a href="javascript:;" onclick="addnick();"><b>Thêm mới</b></a>
<div class="show_notice_small">
Để xóa 01 nick hỗ trợ. Vui lòng xóa trắng nick và tên sau đó bấm Lưu
</div>
<?php echo form_open(uri_string(), array('id'=>'admindata')); ?>
<input type="hidden" name="type" value="1">
<input type="hidden" name="city_id" value="<?=$city_id?>">
<table class="form" id="support">
<?foreach($list as $rs):?>
    <tr>
        <td class="label" style="width: 100px;">Nick</td>
        <td style="width: 200px;"><input type="text" name="ar_nick[]" value="<?=$rs->nick?>" style="width:200px"></td>
        <td class="label" style="width: 100px;">Tên</td>
        <td><input type="text" name="ar_name[]" value="<?=$rs->name?>" style="width:200px"></td>
    </tr>
<?endforeach;?>
</table>
<?=form_close();?>
<script type="text/javascript">
function addnick(){

    var sp='<tr>'+
             '<td class="label" style="width: 100px;">Nick</td>'+
             '<td style="width: 200px;"><input name="ar_nick[]" type="text" value="" style="width:200px"></td>'+
             '<td class="label" style="width: 100px;">Tên</td>'+
             '<td><input name="ar_name[]" type="text" value="" style="width:200px"></td>'+
             '</tr>';
    $("#support").append(sp);
}
</script>