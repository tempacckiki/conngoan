<?php echo form_open(uri_string(), array('id'=>'admindata'));
?>
<input type="hidden" name="id" value="0">
<div class="gray">
    <table class="table_">
        <tr>
            <td valign="top">
                <table class="form">
                    <tr>
                        <td class="label">ID products:</td>
                        <td><input type="text" name="productid" value="" class="w200"></td>
                        
                    </tr>
                    
                    <tr>
                        <td class="label">Mô tả:</td>
                        <td>
                        <textarea rows="5" cols="70" name="decription"></textarea>
                        </td>
                        
                    </tr>
                    <tr>
                        <td class="label">Lượt xem:</td>
                        <td>
                      <input type="text" name="views" value="" class="w200">
                        </td>
                        
                    </tr>
                    <tr>
                        <td class="label">Deal top home:</td>
                        <td>
                        	<input type="checkbox" name="is_home"> (Tất cả deal  chỉ chọn 1 deal lên trên cùng)                       
                        </td>
                        
                    </tr>            
                
                </table>
            </td>
            
        </tr>
    </table>
</div>
