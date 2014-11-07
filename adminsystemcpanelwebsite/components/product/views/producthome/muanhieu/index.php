<div>
    Chọn tỉnh thành phố: 
    <select name="city_id" id="city_id" onchange="get_hot(this.value)">
        <option value="0">Chọn Tỉnh, Thành phố</option>
        <?foreach($listcity as $val):?>
        <option value="<?=$val->city_id?>"><?=$val->city_name?></option>
        <?endforeach;?>
    </select>
</div>
<div id="show_hot" style="margin-top: 10px;"></div>
<script type="text/javascript">
   function get_hot(city_id){
        $.post(base_url+"product/producthome/load_muanhieu",{'city_id':city_id},function(data){
            $("#show_hot").html(data);
        });
   }
</script>