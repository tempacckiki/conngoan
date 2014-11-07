<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table class="form">
	<tr>
		<td class="label">Chọn thành phố:</td>
		<td>
		<select name="city_id" id="city_id" class="w300">
	        <option value="0">Chọn Tỉnh, Thành phố</option>
	        <?php foreach($listcity as $valCity):?>
	        <option value="<?php echo $valCity->city_id;?>"><?php echo $valCity->city_name;?></option>
	        <?php endforeach;?>
	    </select>
		</td>
	</tr>
    <tr>
        <td class="label">Danh mục sản phẩm</td>
        <td>
            <select name="cat_id">    
            <option value="0">|- Trang chủ</option>             
                 <?foreach($listcat as $cat):
                $listsub = $this->danhmuc->get_sub_cat($cat->catid); 
                ?>
                <option value="<?=$cat->catid?>" style="font-size: 16px;font-weight: bold;"><?=$cat->catname?></option>
                <?foreach($listsub as $val):
                $listsub1 = $this->danhmuc->get_sub_cat($val->catid);
                ?>
                <option value="<?=$val->catid?>" style="font-size: 14px;font-weight: bold;">|___<?=$val->catname?></option>
                <?foreach($listsub1 as $val1):
                ?>
                <option value="<?=$val1->catid?>" >|___|___<?=$val1->catname?></option>
                <?endforeach;?>
                <?endforeach;?>
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
        <td class="label">Giá:</td>
        <td>
            <input type="text" class="w300" name="price" id="price" value="">
        </td>
    </tr>
    <tr>
        <td class="label">Tóm tắt:</td>
        <td>
            <textarea rows="5" cols="60" name="summary"></textarea>
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
            <br>Kích thước: W: 90px; H:90px;
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
<script type="text/javascript">
 	$(document).ready(function() {
       $('#price').priceFormat({});
              
    });
 </script>
