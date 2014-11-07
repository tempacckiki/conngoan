<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<input type="hidden" name="id" value="<?=$rs->id?>">
<table class="form">
    <tr>
        <td class="label">ID tin tức:</td>
        <td>
            <input type="text" name="id_news" class="w300" value="<?php echo $rs->id_news;?>">
        </td>
    </tr>
    <tr>
        <td class="label">Tên quảng cáo</td>
        <td>
            <input type="text" class="w300" name="name" value="<?=$rs->name?>">
        </td>
        <td rowspan="5">
            <div class="img_news" id="image">
                <?php echo read_img($rs->images,'detailnews');?>
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
