<?=form_open(uri_string(),array('id'=>'admindata'))?>
<input type="hidden" name="to" value="<?=$rs->email?>">
<table class="form">
    <tr>
        <td class="label">Họ tên</td>
        <td><?php echo $rs->fullname?></td>
    </tr>

    <tr>
        <td class="label">Điện thoại</td>
        <td><?php echo $rs->phone?></td>
    </tr>
   
</table>
<?=form_close();?>
