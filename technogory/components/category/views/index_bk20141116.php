<?php 
$imgPath   		= base_url().'technogory/templates/default/images/';
$uriCatID		= end(explode('-', $this->uri->segment('2')));
$uri3			= (int)$this->uri->segment('3');
?>
<?php if(file_exists(ROOT.'technogory/cache/cat/hot_'.$uriCatID.'city_'.$this->session->userdata('city_site').'.db')){ ?>
<div class="group-cat-project">
			<script type="text/javascript" src="<?=base_url_static()?>technogory/templates/default/js/jquery.easing.js?v=alobuy.vn" charset="UTF-8"></script>
			<script type="text/javascript" src="<?=base_url_static()?>technogory/templates/default/js/caroufredsel.js?v=alobuy.vn" charset="UTF-8"></script>
			<link type="text/css" rel="stylesheet" href="<?=base_url_static()?>technogory/templates/default/css/tabscroll_cat.css?v=alobuy.vn" media="screen" />
			<script type="text/javascript">				
				//****************************
				$(function() {
					$('ul#mod_hethong').carouFredSel({
						auto: true,
						prev: "#prev_ht",
						width : 790,
						visible : 10,
						items: 3,
						duration : 1000,
						start: 0,
						next: "#next_ht"
						});
					});
			</script>
			<div class="image_hethong">			
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
				<ul id="mod_hethong" style="width: 100%;">
				<?php if(file_exists(ROOT.'technogory/cache/cat/hot_'.$uriCatID.'city_'.$this->session->userdata('city_site').'.db')){
	           		require_once(ROOT.'technogory/cache/cat/hot_'.$uriCatID.'city_'.$this->session->userdata('city_site').'.db'); 
	            }?>
	            </ul>   
				
				<div class="clearfix"></div>
				<a id="prev_ht" class="prev" href="#"></a>
				<a id="next_ht" class="next" href="#"></a>
			</div>			
							
							
</div>	
<?php }?>	
<?php if(file_exists(ROOT.'technogory/cache/products/'.$uriCatID.'_product_'.$this->city_id.'.db')){?>
<div id="vnit_page_cat">
    <div class="head-order-cat">
    	<h2 class="cat-head">Tìm thấy <?=$num?> sản phẩm <?=$catinfo->catname;?></h2>
        <ul class="ordering">  
        	         
            <li class="fr">
            	Giá: 
                <select onchange="change_order(this.value)" id="vnit_order">
                    <option value="price_desc">Giá giảm dần</option>
                    <option value="price_asc" selected="selected">Giá tăng dần</option>
                    <option value="name_asc">Từ A-Z</option>
                    <option value="name_desc">Từ Z-A</option>
                </select>
            </li>            
            <li class="fr">
            	Sắp xếp:
                <select onchange="change_hot(this.value)" id="vnit_hot" style="width: 120px;">
                    <option value="all">Tất cả</option>
                    <option value="hot">Sản phẩm hot</option>
                    <option value="new">Sản phẩm mới</option>
                    <option value="promotion">Sản phẩm khuyến mãi</option>
                </select>
            </li>
        </ul>
    </div>
    
  
    
    <?php    	
	   if($uri3 != 0){
			echo $cacheFilePage;
		}else{
			echo $cacheFile;
		}
    ?>
  	
    
    <div class="clear"></div>
    <div class="div_page pages" style="padding: 0px;"><?=$pagination?></div>
    
</div>

<?}else{?>
<div class="infomation-show">
	<div class="photo-not-found">
		<img src="<?=$imgPath;?>not-found.jpg"  height="200" alt="">
	</div>
	
	<div class="text-infomation">
		<p class="title">Thông báo:</p>
		- Dữ liệu đang cập nhật. Xin vui lòng quay trở lại sau cảm ơn!......<br>
	 	- Sử dụng chức năng tìm kiếm để tìm thông tin bạn cần.<br>
		- Nếu bạn chắc chắn đây là lỗi, hãy liên hệ chúng tôi để hoàn thiện hơn.
	</div>
	
	
</div>
<?php }?>

<script type="text/javascript">
	$(document).ready(function(){
		$(".info-prod-cat").hover(function(){
			$(this).find(".buttom-buy-prod").css({
				'display':'block'
			});
		},function(){
			$(this).find(".buttom-buy-prod").css({
				'display':'none'
			});
		});
	});
</script>


