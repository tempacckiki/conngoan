

<form accept-charset="utf-8" method="post" action="<?php echo base_url()?>product/shop/globalsettings">
	<table class="form">
	    <tr>
	        <td class="label">Số lượng sản phẩm hiện thị mỗi category ở trang chủ </td>
	        <td>
	            <input type="text" class="w300" name="itemcategory" value="<?php 
	            		if(isset($aGlobalSetting)){
	            			echo $aGlobalSetting->data['itemcategory'];
	            		}
	            	?>">
	        </td>
	    </tr>
	    <tr>
	    	<td></td>
	    	<td><input type="submit" value="Lưu" /></td>
	    </tr>
	</table>
</form>

