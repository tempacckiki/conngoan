<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Tên quảng cáo</td>
        <td>
            <input type="text" class="w300" name="name" value="">
        </td>
    </tr>
    <tr>
        <td class="label">Link</td>
        <td>
            <input type="text" class="w300" name="link" value="">
        </td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <input type="file" name="userleft">
              <br>Kích thước: W: 562px; H: 328px;
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td>
            <input type="text" name="ordering" value="<?=$this->vdb->find_by_order('banner','ordering',array('position'=>1))?>">
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="checkbox" name="published" value="1">
        </td>
    </tr>
</table>
<?=form_close();?>
