<?php
$city_id = $this->session->userdata('city_site'); 
?>
<div id="bg_load"></div>
<div id="ajax_load"><div class="loading">Đang tải dữ liệu ...</div></div>
<?php include_once(ROOT.'technogory/config/home/popcity.db');?>

<div class="logo">
    <a href="<?php echo base_url()?>"><img src="<?=base_url()?>technogory/templates/default/images/alobuylogo.png?version=alobuy.vn"  width="162" alt="ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nhà"/></a>
</div> <!--end logo -->

<div class="right-top-head">
    <!-- BEGIN SEARCH -->
    <div class="search-box"> 
    	<div class="box-search-result" id="search_result"></div>  
        <form action="<?=base_url();?>search/result" method="get">                        
            <input type="text" id="productkey"  name="p" value=""/>                        
            <input type="button" id="action_search" onclick="search_product()"  name="" value=""/>
        </form>
        
    </div>
     <!-- BEGIN SEARCH -->
</div>

<div class="box-counter-products">
	<div>
		<div>Tư vấn / Bán hàng:</div>
		<div>0909 112233</div>
	</div>
	<div>
		<div>Khiếu nại:</div>
		<div>0909 112233</div>
	</div>
</div>

<!-- Box login -->
<div class="login-mask"></div>
	