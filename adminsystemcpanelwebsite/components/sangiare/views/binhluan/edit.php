<?=form_open(uri_string(), array('id' => 'admindata'))?>
<input type="hidden" name="id" value="<?=$rs->commentid?>">
<input type="hidden" name="page" value="<?=$this->uri->segment(5)?>">
<table class="form">
    <tr>
        <td class="label">Sản phẩm khuyến mãi</td>
        <td><?=$rs->cheap_title?></td>       
    </tr>
    <tr>
        <td class="label">Ngày gửi</td>
        <td><?=date('d/m/Y',$rs->add_date)?></td>
    </tr>    
    <tr>
        <td class="label">Họ tên</td>
        <td>
             <input type="text" name="comment[fullname]" value="<?=$rs->fullname?>" class="w350">
        </td>
    </tr>

    <tr>
        <td class="label">Nội dung</td>
        <td>
            <textarea style="width: 500px; height: 150px;" name="comment[content]"><?=$rs->content?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="comment[published]" value="1" <?=($rs->published==1)?'checked="checked"':'';?>></td>
    </tr>
</table>
<?=form_close();?>
