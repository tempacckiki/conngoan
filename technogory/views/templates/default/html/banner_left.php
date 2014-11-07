<?php
$city_id = $this->session->userdata('city_site'); 
//load config
$this->load->config('config_qcleft_'.$city_id);
?>
<div class="box-ads-main-left">
		<!-- Quang cao-->
		<?php 
		$cat_ID  		= end(explode('-', $this->uri->segment('2')));
		$cat_ID	= ($cat_ID >0)?$cat_ID:$cat_ID_de;
		$total_advLeft 		= $this->config->item('advleft_total_'.$cat_ID);
		if($total_advLeft > 0){ 
			$k = 0;
			for($i = 1; $i <= $total_advLeft; $i++){
				$name   		= $this->config->item('advleft_name_'.$cat_ID.'_'.$i);
				$discription   	= $this->config->item('advleft_summary_'.$cat_ID.'_'.$i);
				$price   		=  $this->config->item('advleft_price_'.$cat_ID.'_'.$i);
				 
				$link   		= $this->config->item('advleft_link_'.$cat_ID.'_'.$i);
				$img  			= base_url().'alobuy0862779988/adv/left/'.$this->config->item('advleft_img_'.$cat_ID.'_'.$i);

		?>
		
		<div class="item-ads-left<?php echo $k;?>">
			<p class="name"><a href="<?php echo $link;?>" target="_blank" title="<?php echo $name;?>"><?php echo $name;?></a></p>
		    	<p class="img">
				    <a href="<?php echo $link;?>" target="_blank" title="<?php echo $name;?>">
				        <img width="60" src="<?php echo $img;?>" alt="<?php echo $name;?>">
				    </a>
			    </p>
			    <div class="info">				
					<p class="summary"><?php echo $discription;?></p>
					<p class="price">Giá: <span><?php echo $price;?> đ</span></p>
				</div>
		 </div>
		
		<?php 
			$k= 1-$k;	
			}
		}
		?>
		
	<!-- End QUang cao-->
</div>