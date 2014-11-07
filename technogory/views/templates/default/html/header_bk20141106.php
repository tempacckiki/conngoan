<?php
$city_id = $this->session->userdata('city_site'); 
?>
<div id="bg_load"></div>
<div id="ajax_load"><div class="loading">Đang tải dữ liệu ...</div></div>
<?php include_once(ROOT.'technogory/config/home/popcity.db');?>

<div class="logo">
    <a href="<?php echo base_url()?>"><img src="<?=base_url()?>technogory/templates/default/images/alobuylogo.png?version=alobuy.vn"  width="162" alt="ALOBUY Việt Nam - Mua hàng trực tuyến, Giao hàng tận nhà"/></a>
    <div class="box-province">
    	<div class="active-location">
    		<a href="javascript:;">
    			<span class="text">
                  <?php 
                          
                            for($i=1; $i <= $this->config->item('total_city'); $i++){
                                
                                $city_id1 = $this->config->item('city_id_'.$i);
                                if($city_id == $city_id1){
                                    echo $this->config->item('city_name_'.$city_id.'_'.$i);
                                }
                            }?>
                            
                </span>
               <span class="icon">&nbsp;</span>
            </a>
          	
          	<ul class="SubLocation"> 
        	<?php for($i=1; $i <= $this->config->item('total_city'); $i++){
                            $city_s = $this->config->item('city_id_'.$i);
                            if($city_id != $city_s){
                            ?>
                        <li>
                            <a title="<?=$this->config->item('city_name_'.$city_s.'_'.$i)?>" id="choice_city" city_id="<?=$this->config->item('city_id_'.$i)?>" href="javascript:;">
                                <?=$this->config->item('city_name_'.$city_s.'_'.$i)?>
                            </a>
                        </li>
            <?}}?>
                        
        </ul>
        
    	</div>
    	
    	
    </div>
	
	<div class="city_toolTip">
		<div class="toolTip_in">
			<div class="arrow_upB"></div>
            <div class="arrow_upF"></div>
             <b>Vui lòng chọn thành phố
                                    <br>
                                    bạn đang cư trú
                                </b>
            <span class="close" id="closeChoosenCity"></span>
		</div>
	</div>
</div> <!--end logo -->

<div class="right-top-head">
	<div class="box-cam-ket-head">
		<div class="box-ads-main-top">
		<!-- Quang cao-->
		<?php 
		//check city_id		
		$this->load->config("config_qcchitiet_".$city_id);
		$this->load->config("config_index_".$city_id);
		
		
		//$config['config_index'] = ROOT.ADMIN_NAME."/config/config_index.php";
		//require_once($config['config_index']);
		//get catID
		$cat_ID  = end(explode('-', $this->uri->segment('2')));
		$cat_ID	 = ($cat_ID >0)?$cat_ID:$cat_ID_de;
		echo $total_adv = $this->config->item('advdetail_total_'.$cat_ID);
		if($total_adv > 0){
		?>
		<div class="box-quangcao">
		    <?php if($total_adv >= 1){?>
		    <div class="item-ads-top">
		    	<p class="img">
				    <a href="<?=$this->config->item('advdetail_link_'.$cat_ID.'_1')?>" target="_blank" title="<?=$this->config->item('advdetail_name_'.$cat_ID.'_1')?>">
				        <img width="75" src="<?=base_url()?>alobuy0862779988/adv/chitiet/<?=$this->config->item('advdetail_img_'.$cat_ID.'_1')?>" alt="<?=$this->config->item('advdetail_name_'.$cat_ID.'_1')?>">
				    </a>
			    </p>
			    <div class="info">
					<p class="name"><a href="<?=$this->config->item('advdetail_link_'.$cat_ID.'_1')?>" target="_blank" title="<?=$this->config->item('advdetail_name_'.$cat_ID.'_1')?>"><?php echo $this->config->item('advdetail_name_'.$cat_ID.'_1')?></a></p>
					<p class="summary"><?php echo $this->config->item('advdetail_summary_'.$cat_ID.'_1');?></p>
					<p class="price">Giá: <span><?php echo $this->config->item('advdetail_price_'.$cat_ID.'_1');?> đ</span></p>
				</div>
		    </div>
		    <?}?>
		    <?if($total_adv == 2){?>
		    <div class="item-ads-top">
		    	<p class="img">
				    <a href="<?=$this->config->item('advdetail_link_'.$cat_ID.'_2')?>" target="_blank" title="<?=$this->config->item('advdetail_name_'.$cat_ID.'_2')?>">
				        <img width="75" src="<?=base_url()?>alobuy0862779988/adv/chitiet/<?=$this->config->item('advdetail_img_'.$cat_ID.'_2')?>" alt="<?=$this->config->item('advdetail_name_'.$cat_ID.'_2')?>">
				    </a>
			    </p>
			    
			    <div class="info">
					<p class="name"><a href="<?=$this->config->item('advdetail_link_'.$cat_ID.'_2')?>" target="_blank" title="<?=$this->config->item('advdetail_name_'.$cat_ID.'_2')?>"><?php echo $this->config->item('advdetail_name_'.$cat_ID.'_2')?></a></p>
					<p class="summary"><?php echo $this->config->item('advdetail_summary_'.$cat_ID.'_2');?></p>
					<p class="price">Giá: <span><?php echo $this->config->item('advdetail_price_'.$cat_ID.'_2');?> đ</span></p>
				</div>
		    </div>
		    <?}?>
		</div>
		<?php }else{
			$total_adv_Index = $this->config->item('advdetail_total_index');
			
		?>
		 <?php if($total_adv_Index >= 1){?>
		    <div class="item-ads-top">
		    	<p class="img">
				    <a href="<?=$this->config->item('advdetail_link_index'.'_1')?>" target="_blank" title="<?=$this->config->item('advdetail_name_index'.'_1')?>">
				        <img width="75" src="<?=base_url()?>alobuy0862779988/adv/chitiet/<?=$this->config->item('advdetail_img_index'.'_1')?>" alt="<?=$this->config->item('advdetail_name_index'.'_1')?>">
				    </a>
			    </p>
			    <div class="info">
					<p class="name"><a href="<?=$this->config->item('advdetail_link_index'.'_1')?>" target="_blank" title="<?=$this->config->item('advdetail_name_index'.'_1')?>"><?php echo $this->config->item('advdetail_name_index'.'_1')?></a></p>
					<p class="summary"><?php echo $this->config->item('advdetail_summary_index'.'_1');?></p>
					<p class="price">Giá: <span><?php echo $this->config->item('advdetail_price_index'.'_1');?> đ</span></p>
				</div>
		    </div>
		    <?php }?>
		    
		 <?php if($total_adv_Index == 2){?>
		<div class="item-ads-top">
		    	<p class="img">
				    <a href="<?=$this->config->item('advdetail_link_index'.'_2')?>" target="_blank" title="<?=$this->config->item('advdetail_name_index'.'_2')?>">
				        <img width="75" src="<?=base_url()?>alobuy0862779988/adv/chitiet/<?=$this->config->item('advdetail_img_index'.'_2')?>" alt="<?=$this->config->item('advdetail_name_index'.'_2')?>">
				    </a>
			    </p>
			    
			    <div class="info">
					<p class="name"><a href="<?=$this->config->item('advdetail_link_index'.'_2')?>" target="_blank" title="<?=$this->config->item('advdetail_name_index'.'_2')?>"><?php echo $this->config->item('advdetail_name_index'.'_2')?></a></p>
					<p class="summary"><?php echo $this->config->item('advdetail_summary_index'.'_2');?></p>
					<p class="price">Giá: <span><?php echo $this->config->item('advdetail_price_index'.'_2');?> đ</span></p>
				</div>
		    </div>
		 <?php }?>
		<?php }?>
		
		
		
		
	<!-- End QUang cao-->
	</div>
	
	</div>
    
    <div class="box-infomation-buy">
    	<?php 
    		//load db
    		$this->db = $this->load->database('default', TRUE);
        	$listCart    = $this->vdb->find_by_listNew("shop_cart", 'order_id,barcode,user_id,fullname,city_id', array('city_id'=>(int)$this->session->userdata('city_site'),'barcode !='=>''), array('order_id'=>'DESC'), 5);
        	   	
       	?>
        <div id="news-container">
        	<ul class="info-deal">		
    			<?php 
    			foreach ($listCart as $valCart){
					$fullName    		= $valCart->fullname;
					$productCart 		= $this->vdb->find_by_id("shop_cart_detail",array('cartid'=>$valCart->order_id),"cartid,productid,productname");
					$linkProductCart  	= site_url('san-pham/'.vnit_change_title($productCart->productname).'-'.$productCart->productid); 
    			?>
    			<li>
    				<div class="deal">
    					<strong><?=$fullName;?> </strong> vừa mua thành công <span><a href="<?=$linkProductCart;?>"><?=$productCart->productname;?></a></span>
    				</div>	
    			</li>
    			
    			<?php }?>
    			
    			
    		</ul>
    	</div>
    </div>
</div>

<div class="box-counter-products">
	<div class="total-product">
		<?php 
		 $listProduct = $this->vdb->find_by_list("shop_product", array('published'=>1), '', 'productid');
		?>
   		<p class="number-product"><?=count($listProduct);?></p>
        <p class="label">Sản phẩm đang bán</p>
   </div>
   <?php 
   if($this->session->userdata('city_site') == 26){
   ?>
   <p class="number-person">Hotline: <strong>(04) 66 70 03 79</strong> để được giúp đỡ!</p>
   <?php }elseif($this->session->userdata('city_site') == 197){?>
    <p class="number-person">Hotline: <strong>(059) 35 00 600</strong> để được giúp đỡ!</p>
   <?php }else{?>
    <p class="number-person">Hotline: <strong>(08) 62 77 99 88</strong> để được giúp đỡ!</p>
   <?php }?>
</div>

<!-- box-search -login -->
<div class="login-search">
	
	<div class="category-home">
		&nbsp;
	</div>
		
    <!-- BEGIN SEARCH -->
    <div class="search-box"> 
    	<div class="box-search-result" id="search_result"></div>  
        <form action="<?=base_url();?>search/result" method="get">                        
            <input type="text" id="productkey"  name="p" value=""/>                        
            <input type="button" id="action_search" onclick="search_product()"  name="" value=""/>
        </form>
        
    </div>
     <!-- BEGIN SEARCH -->
     <!-- 
    <div class="box-login-register">
    	
    	<div class="login">
    		<span>Xin chào</span>
    		<p><a href="javascript:;" class="login-popup-show">Đăng nhập</a></p>
    	</div>
    	
    	<div class="register">
    		<span>Bạn chưa có tài khoản?</span>
    		<p><a href="<?=site_url('dang-ky');?>">Đăng ký</a></p>
    	</div>
    	
    </div>
     -->
    
	<div class="box-login-cart">
	   	<div class="cart-items-box">   		 
	   		 <p class="quality-cart" id="showminicart">
	   		 <strong id="total_product"><?=(int)$this->vcart->total_product()?></strong>
	          <a href="<?=site_url('thanh-toan/gio-hang');?>">Giỏ hàng của bạn!</a> 
	        </p>
	   	</div>       
	</div>
	<?php 
	if($this->uri->segment(1) != ''){
	?>
	
	
	<?=$this->load->view('templates/default/html/mainmenu_mini');?>
	
	<?php }?>
	

</div>

<!-- Box login -->
<div class="login-mask"></div>
	

<div class="popup-login">
		<div class="content-pop"> 
			<a href="javascript:();" class="closepop close-popup-login"></a>
			<p class="title-popup">ĐĂNG NHẬP HỆ THỐNG</p>
			<div class="mid-cont">
				
				<?php echo form_open(uri_string());?>
					<div class="row-frmLogin">
						<label>Email đăng nhập:</label>
						<input type="text" value="" name="email" id="email">
					</div>
					<div class="row-frmLogin">
						<label>Mật khẩu:</label>
						<input type="password" value="" name="password" id="password">
					</div>
					<div class="row-frmLogin">
						<label>&nbsp;</label>
						<input type="checkbox" value="" name=""> Lưu lại mật khẩu
					</div>
					
					<div class="row-frmLogin">
						<label>&nbsp;</label>
						<input type="button" value="Đăng nhập" name="submit" id="login-ajax"> 
						Hoặc <a href="<?php echo site_url('dang-ky');?>">đăng ký</a> tài khoản mới!
					</div>
					
				<?php echo form_close();?>
			</div>
			<div class="bottom-cont">
				Bạn có thể đăng nhập với tài khoản:
			</div>
		</div>
</div>