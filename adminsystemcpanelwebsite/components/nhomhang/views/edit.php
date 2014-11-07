<?=form_open_multipart(uri_string(),  array('id' => 'admindata'))?>
<input type="hidden" name="id" value="<?=$rs_vi->catid?>">
<table class="form">
    <tr>
        <td class="label">Tên nhóm hàng</td>
        <td>
            <input type="text" class="w500" name="catname" value="<?=$rs_vi->catname?>">
        </td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>                                    
        <td>
            <img src="<?=base_url_site()?>data/img_cat/<?=$rs_vi->img_main?>" alt="" style="max-width: 100px;">
            <input type="file" name="userfile">
            <input type="hidden" name="img_main" value="<?=$rs_vi->img_main?>">
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td><input type="text" name="cat[ordering]" value="<?=$rs_vi->ordering?>" class="w200"></td>
    </tr>
    <tr>
        <td class="label">Hiển thị trang chủ</td>
        <td><input type="checkbox" name="ishome" value="1" <?=($rs_vi->ishome == 1)?'checked="checked"':''?>></td>
    </tr>
    <tr>
        <td class="label">Hiển thị Tab ngang con</td>
        <td><input type="checkbox" name="istab" value="1" <?=($rs_vi->istab == 1)?'checked="checked"':''?>></td>
    </tr>
    <!--
    <tr>
        <td class="label">Hiển thị menu trái</td>
        <td><input type="checkbox" name="ismenuleft" value="1" <?=($rs_vi->ismenuleft == 1)?'checked="checked"':''?>></td>
    </tr>
    <tr>
        <td class="label">Không link</td>
        <td><input type="checkbox" name="nolink" value="1" <?=($rs_vi->nolink == 1)?'checked="checked"':''?>></td>
    </tr>
    -->
    <tr>
        <td class="label">Từ khóa</td>
        <td><input type="text" name="cat[catkeyword]" class="w500" value="<?=$rs_vi->catkeyword?>"></td>
    </tr>
    <tr>
        <td class="label">Miêu tả</td>
        <td>
            <textarea style="width: 500px;height: 100px;" name="cat[catdes]"><?=$rs_vi->catdes?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td><input type="checkbox" name="published" value="1" <?=($rs_vi->published == 1)?'checked="checked"':'';?>></td>
    </tr>
</table>
<?=form_close();?>
