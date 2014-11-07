<?=form_open(uri_string(), array('id' => 'admindata'))?>
<input type="hidden" name="id" value="<?=$rs->id?>">
<input type="hidden" name="page" value="<?=$this->uri->segment(5)?>">
<table class="form">
    <tr>
        <td class="label">Email</td>
        <td><?=$rs->email?></td>       
    </tr>
    <tr>
        <td class="label">Ngày nhận</td>
        <td><?=date('d/m/Y',$rs->time)?></td>
    </tr>    
    <tr>
        <td class="label">Sản phẩm đề nghị</td>
        <td>
             <?=$rs->productname?>
        </td>
    </tr>
    <tr>
        <td class="label">Link sản phẩm</td>
        <td>
             <?=$rs->linkproduct?>
        </td>
    </tr>
    <tr>
        <td class="label">Nội dung</td>
        <td>
            <?=$rs->content?>
        </td>
    </tr>
    <tr>
        <td class="label">Đã xem</td>
        <td><input type="checkbox" name="denghi[check]" value="1" <?=($rs->check==1)?'checked="checked"':'';?>></td>
    </tr>
</table>
<?=form_close();?>
