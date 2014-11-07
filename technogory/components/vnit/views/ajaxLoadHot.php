<script type="text/javascript">
		$(document).ready(function(){
					//** hover
					$("#mod_hethong li div.box-info-index").hover(function(){
						$(this).find('.buttom-buy').css({
							 'display': 'block'
						});
					},function(){
						$(this).find('.buttom-buy').css({
							'display': 'none'
						});
					});

					
				});
	
</script>
				
<?if(file_exists(ROOT.'technogory/config/home/hot/hot_'.$catId.'city_'.$this->city_id.'.db')){
	require_once(ROOT.'technogory/config/home/hot/hot_'.$catId.'city_'.$this->city_id.'.db');
}?> 