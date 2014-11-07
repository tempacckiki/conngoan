<div style="clear: both;" id="content">
	<div style="float: left;width: 300px;">
	   <strong>Chọn tỉnh thành phố:</strong> 
	    <select name="city_id" id="city_id">
	        <option value="0">Chọn Tỉnh, Thành phố</option>
	        <?php foreach($listcity as $val):?>
	        <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
	        <?endforeach;?>
	    </select>
	</div>
	
	<div style="float: left;width: 400px;">
	   <strong> Chọn chuyên mục:</strong> 	   
	    
	      <select name="cat_id" id="cat_id" class="w250">
                        <?php foreach($listcat as $cat):
                        $listsub = $this->producthome->get_sub_cat($cat->catid);?>
                        <option value="<?=$cat->catid?>" <?=($cat->catid == set_value('catid'))?'selected="selected"':'';?>><?=$cat->catname?></option>
                            <?php foreach($listsub as $sub):
                            $listsub1 = $this->producthome->get_sub_cat($sub->catid);
                            ?>
                            <option value="<?=$sub->catid?>" <?=($sub->catid == set_value('catid'))?'selected="selected"':'';?>>|___<?=$sub->catname?></option>
                            
                                <?php foreach($listsub1 as $val):
                                $listsub2 = $this->producthome->get_sub_cat($val->catid);  
                                ?>
                                <option value="<?=$val->catid?>">|___|___<?=$val->catname?></option>
                                    <?foreach($listsub2 as $val1):?>
                                    <option value="<?=$val1->catid?>">|___|___|___<?=$val1->catname?></option>
                                    <?endforeach;?>
                                <?endforeach;?>
                            <?endforeach;?>
                        
                        <?endforeach;?>
                    </select>
	</div>
	<div style="float: left;width: 120px;padding:10px;text-align:center;font-weight: bold;border: solid 1px #ccc;">
		<a href="javascript:;" onclick="get_hot(this.value);">Xem sản phẩm</a>
	</div>
</div>


<div id="show_hot" style="margin-top: 10px;"></div>
<script type="text/javascript">
   function get_hot(city_id){
	   var city_id 	=  $("#city_id").val();
	   var cat_id 	=  $("#cat_id").val();	  
        $.post(base_url+"product/producthome/load_cat",{'city_id':city_id,'cat_id':cat_id},function(data){
            $("#show_hot").html(data);
        });
   }
</script>