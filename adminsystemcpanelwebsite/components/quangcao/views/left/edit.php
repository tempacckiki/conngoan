<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<input type="hidden" name="id" value="<?=$rs->id?>">
<table class="form">
	<tr>
		<td class="label">Chọn thành phố:</td>
		<td>
		<select name="city_id" id="city_id" class="w300">
	        <option value="0">Chọn Tỉnh, Thành phố</option>
	        <?php foreach($listcity as $valCity):?>
	        <option value="<?php echo $valCity->city_id;?>" <?php echo ($valCity->city_id == $rs->city_id)?'selected="selected"':'';?>><?php echo $valCity->city_name;?></option>
	        <?php endforeach;?>
	    </select>
		</td>
	</tr>
    <tr>
        <td class="label">Danh mục sản phẩm</td>
        <td>
            <select name="cat_id">
                <option value="0" <?=($catid == 0 )?'selected="selected"':'';?>>|- Trang chủ</option> 
                <?foreach($listcat as $cat):
                $listsub = $this->danhmuc->get_sub_cat($cat->catid); 
                ?>
                <option value="<?=$cat->catid?>" <?=($cat->catid == $rs->cat_id)?'selected="selected"':''?> style="font-size: 16px;font-weight: bold;"><?=$cat->catname?></option>
                <?foreach($listsub as $val):
                $listsub1 = $this->danhmuc->get_sub_cat($val->catid);?>
                <option value="<?=$val->catid?>" <?=($val->catid == $rs->cat_id)?'selected="selected"':''?> style="font-size: 14px;font-weight: bold;">|__<?=$val->catname?></option>
                <?foreach($listsub1 as $val1):
                ?>
                <option value="<?=$val1->catid?>" <?=($val1->catid == $rs->cat_id)?'selected="selected"':''?>>|___|___<?=$val1->catname?></option>
                <?endforeach;?>
                <?endforeach;?>
                <?endforeach;?>
                
            </select>
        </td>
    </tr>
    <tr>
        <td class="label">Tên quảng cáo</td>
        <td>
            <input type="text" class="w300" name="name" value="<?=$rs->name?>">
        </td>
        <td rowspan="5">
            <div class="img_news" id="image">
                <?=read_img($rs->images,'left')?>
            </div>
        </td>
    </tr>
    <tr>
        <td class="label">Giá:</td>
        <td>
            <input type="text" class="w300" name="price" id="price" value="<?=number_format( $rs->price,0,'.','.');?>">
        </td>
    </tr>
    <tr>
        <td class="label">Tóm tắt:</td>
        <td>
            <textarea rows="5" cols="60" name="summary"><?php echo $rs->summary;?></textarea>
        </td>
    </tr>
    <tr>
        <td class="label">Link</td>
        <td>
            <input type="text" class="w300" name="link" value="<?=$rs->link?>">
        </td>
    </tr>
    <tr>
        <td class="label">Hình ảnh</td>
        <td>
            <input type="file" name="userleft">
             <br>Kích thước: W: 90px; H: 90px;
            <input type="hidden" name="img_old" value="<?=$rs->images?>">
        </td>
    </tr>
    <tr>
        <td class="label">Sắp xếp</td>
        <td>
            <input type="text" name="ordering" value="<?=$rs->ordering?>">
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="checkbox" name="published" value="1" <?=($rs->published == 1)?'checked="checked"':''?>>
        </td>
    </tr>
</table>
<?=form_close();?>
<script type="text/javascript">
 	$(document).ready(function() {
       $('#price').priceFormat({});
              
    });
 </script>
