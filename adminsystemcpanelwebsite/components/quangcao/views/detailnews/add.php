<?=form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table class="form">
    <tr>
        <td class="label">ID Tin tức:</td>
        <td>
           <input type="text" name="id_news" class="w300" value="">
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
            <input type="text" name="ordering" value="1">
        </td>
    </tr>
    <tr>
        <td class="label">Hiển thị</td>
        <td>
            <input type="checkbox" name="published" value="1" checked="checked">
        </td>
    </tr>
</table>
<?=form_close();?>
<script type="text/javascript">
 	$(document).ready(function() {
       $('#price').priceFormat({});
              
    });
 </script>
