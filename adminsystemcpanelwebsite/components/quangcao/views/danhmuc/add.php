<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">Danh mục sản phẩm</td>
        <td>
            <select name="cat_id">
                <?foreach($listcat as $val):?>
                <option value="<?=$val->catid?>" <?=($catid == $val->catid)?'selected="selected"':''?>><?=$val->catname?></option>
                <?endforeach;?>
            </select>
        </td>
    </tr>
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
            <br>Kích thước: W: 200px; H:490px
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td>
            <input type="text" name="ordering" value="<?=$this->vdb->find_by_order('banner','ordering',array('position'=>2,'cat_id'=>$catid))?>">
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
