<?php echo form_open(uri_string(), array('id'=>'admindata'));?>
<input type="hidden" name="id" value="<?=$rs->id?>">

<table class="form">
    <tr>
        <td class="label">Sản phẩm</td>
        <td><a target="_blank" href="<?=base_url_site()?>product/<?=$rs->producturl?>-<?=$rs->productid?>"><?=$rs->productname?></a></td>
    </tr>
     <tr>
        <td class="label">Họ và tên</td>
        <td><?=$rs->fullname?></td>                    
    </tr>
     <tr>
        <td class="label">Điện thoại</td>
        <td><?=$rs->phone?></td>                    
    </tr>
    <tr>
        <td class="label">Thời gian gửi</td>
        <td><?=date('H:i d/m/Y',$rs->add_date)?></td>                    
    </tr> 
    <tr>
        <td class="label">Nội dung</td>
        <td><?=nl2br($rs->content)?></td>                    
    </tr>
    <tr>
        <td class="label">Ghi chú</td>
        <td>
            <textarea style="width: 500px; height: 100px;" name="notes"><?=$rs->notes?></textarea><br />
            <input type="checkbox" name="checked" value="1" <?=($rs->checked == 1)?'checked="checked"':'';?>> Đã liên hệ với khách hàng
        </td>                    
    </tr>
    
</table>

<?php echo form_close();?>

