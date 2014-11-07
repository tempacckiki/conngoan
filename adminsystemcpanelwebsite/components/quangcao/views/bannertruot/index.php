<?php echo form_open_multipart(uri_string(), array('id'=>'admindata'))?>
<table>
	<tr>
		<td class="label">Chọn thành phố:</td>
		<td align="left">
		<select name="city_id" id="city_id" class="w300" onchange="get_change(this.value)">
	        <option value="0">Chọn Tỉnh, Thành phố</option>
	        <?php foreach($listcity as $valCity):?>
	        <option value="<?php echo $valCity->city_id;?>"><?php echo $valCity->city_name;?></option>
	        <?php endforeach;?>
	    </select>
		</td>
	</tr>
    <tr>
        <td>
            <fieldset style="margin-right: 5px;">
                <legend>Quảng cáo trái</legend>
                <table class="form">
                    <tr>
                        <td class="label"><strong style="text-transform: uppercase;color: #ff0000;">Danh sách ID:</strong></td>
                        <td>
                        	<p id="ads_left">
                            <input type="text" name="arrID_Left" value="<?=$arrID_Left;?>" class="w250"> 
                            </p>
                            <p>(VD: 23,56,7896)</p>
                             <p>Cách nhau dấu (,)</p>
                        </td>
                    </tr>
                    
                   
                </table>
                

            </fieldset>
        </td>
        <td>
            <fieldset>
                <legend>Quảng cáo phải</legend>
                <table class="form">
                    <tr>
                        <td class="label"><strong style="text-transform: uppercase;color: #ff0000;">Danh sách ID:</strong></td>
                        <td>
                        	<p id="ads_right">
                            	<input type="text" name="arrID_Right" value="<?=$arrID_Right;?>" class="w250">
                            </p>
                             <p>(VD: 23,56,7896)</p>
                              <p>Cách nhau dấu (,)</p>
                        </td>
                    </tr>
                   
                </table>
                
                
            </fieldset>
        </td>
    </tr>
    <tr>
        <td class="2">
            Kích hoạt: <input type="checkbox" name="active" value="1" checked="checked"> 
        </td>
    </tr>
</table>
<?php echo form_close();?>
<script type="text/javascript">
   function get_change(city_id){
        $.post(base_url+"quangcao/bannertruot/load_bannerID",{'city_id':city_id},function(data){ 
            $("#ads_left").html(data.strLeft);
            $("#ads_right").html(data.strRight);
        },'json');
   }
</script>
