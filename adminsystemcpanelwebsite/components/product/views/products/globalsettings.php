

<form accept-charset="utf-8" method="post" action="<?php echo base_url()?>product/shop/globalsettings">
	<table class="form">
	    <tr>
	        <td class="label">Số lượng sản phẩm hiện thị mỗi category ở trang chủ </td>
	        <td>
	            <input type="text" class="w300" name="itemcategory" value="<?php 
	            		if(isset($aGlobalSetting->data['itemcategory'])){
	            			echo $aGlobalSetting->data['itemcategory'];
	            		}
	            	?>">
	        </td>
	    </tr>
	    <tr>
	        <td class="label">Liên kết Facebook</td>
	        <td>
	            <input type="text" class="w300" name="linkfacebook" value="<?php 
	            		if(isset($aGlobalSetting->data['linkfacebook'])){
	            			echo $aGlobalSetting->data['linkfacebook'];
	            		}
	            	?>">
	        </td>
	    </tr>
	    <tr>
	        <td class="label">Liên kết Google +</td>
	        <td>
	            <input type="text" class="w300" name="linkgoogleplus" value="<?php 
	            		if(isset($aGlobalSetting->data['linkgoogleplus'])){
	            			echo $aGlobalSetting->data['linkgoogleplus'];
	            		}
	            	?>">
	        </td>
	    </tr>
	    <tr>
	        <td class="label">Liên kết YouTube</td>
	        <td>
	            <input type="text" class="w300" name="linkyoutube" value="<?php 
	            		if(isset($aGlobalSetting->data['linkyoutube'])){
	            			echo $aGlobalSetting->data['linkyoutube'];
	            		}
	            	?>">
	        </td>
	    </tr>
	    <tr>
	        <td class="label">Tài khoản Skype</td>
	        <td>
	            <input type="text" class="w300" name="accountskype" value="<?php 
	            		if(isset($aGlobalSetting->data['accountskype'])){
	            			echo $aGlobalSetting->data['accountskype'];
	            		}
	            	?>">
	        </td>
	    </tr>
	    <tr>
	        <td class="label">Tài khoản Yahoo</td>
	        <td>
	            <input type="text" class="w300" name="accountyahoo" value="<?php 
	            		if(isset($aGlobalSetting->data['accountyahoo'])){
	            			echo $aGlobalSetting->data['accountyahoo'];
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

