<div style="clear: both;" id="content">
	<div style="float: left;width: 300px;">
	   <strong>Chọn tỉnh thành phố:</strong> 
	    <select name="city_id" id="city_id">
	        <option value="0">Chọn Tỉnh, Thành phố</option>
	        <?foreach($listcity as $val):?>
	        <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
	        <?endforeach;?>
	    </select>
	</div>
	
	<div style="float: left;width: 300px;">
	    Chọn chuyên mục: 
	    <select name="cat_id" id="cat_id">
	        <option value="0">|- Chọn chuyên mục</option>
	        <?foreach($listcat as $valCat):?>
	        <option value="<?=$valCat->catid;?>"><?=$valCat->catname;?></option>
	        <?endforeach;?>
	    </select>
	</div>
	<div style="float: left;width: 120px;">
		<a href="javascript:;" onclick="get_hot(this.value);">Xem sản phẩm</a>
	</div>
</div>


<div id="show_hot" style="margin-top: 10px;"></div>
<script type="text/javascript">
   function get_hot(city_id){
	   var city_id 	=  $("#city_id").val();
	   var cat_id 	=  $("#cat_id").val();	  
        $.post(base_url+"product/producthome/load_hot",{'city_id':city_id,'cat_id':cat_id},function(data){
            $("#show_hot").html(data);
        });
   }
</script>