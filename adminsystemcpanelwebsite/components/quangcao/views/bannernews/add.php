<?=form_open_multipart ( uri_string (), array ('id' => 'admindata' ) )?>
<table class="form">
	<tr>
		<td class="label"><strong>Danh sách ID:</strong></td>
		<td><input type="text" name="productid" value=""></td>
		
		
	</tr>
	
	<tr>
		<td class="label"><strong>Mô tả sản phẩm:</strong></td>
		<td>
			<textarea rows="10" cols="80" name="decription"></textarea>
		</td>
		
		
	</tr>

</table>
<?=form_close ();?>

