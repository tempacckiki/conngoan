<div class="box-head">
	<?php 
	$url  =  $this->uri->segment('1');
	?>
	<div class="sub-box">
		<ul class="menu-head">
			<li  <?php echo ($url != 'huong-dan' && $url != 'lien-he')?'class="active"':'';?> ><a href="<?php echo base_url();?>">Home</a></li>
			<li  <?php echo ($url == 'huong-dan')?'class="active"':'';?> ><a href="<?=site_url('huong-dan/gioi-thieu-alobuy-viet-nam-30');?>">Giới thiệu</a></li>
			<li <?php echo ($url == 'lien-he')?'class="active"':'';?> ><a href="<?=site_url('lien-he');?>">Liên hệ</a></li>
		</ul>
<!-- 		<ul class="menu-head">
			<li  <?php echo ($url != 'tin-tuc')?'class="active"':'';?>><a href="<?php echo base_url();?>">Alobuy Việt Nam</a></li>
			<li  <?php echo ($url == 'tin-tuc')?'class="active"':'';?>><a href="<?php echo site_url('tin-tuc');?>">Alo News!</a></li>
			<li ><a href="<?php echo site_url('gia-re-moi-ngay');?>" target="_blank">Alo Deal!</a></li>
			<li ><a href="">Alo bid!</a></li>
			<li ><a href="#">Alo truyện!</a></li>
		</ul>
 -->		
<!-- 		 <?php 
		   if($this->session->userdata('city_site') == 26){
		   ?>
		   <div class="hotline-top">Hotline: <strong>(04) 6670 0379</strong></div>
		   <?php }elseif($this->session->userdata('city_site') == 197){?>
		   <div class="hotline-top">Hotline: <strong>(059) 35 00 600</strong></div>
		   <?php }else{?>
		    <div class="hotline-top">Hotline: <strong>(08) 6277 9988</strong></div>
		   <?php }?>
 -->   
		
<!-- 		<div class="register-login-main">
			<?php if(!$this->session->userdata('user_id')){?>
			<div  class="login-main login-popup-show"><a href="javascript:;">Đăng nhập</a></div>
			<?php }else{?>
			<div  class="login-success"><a href="javascript:;"></a></div>
			<?php }?>
			<div class="register-main"><a href="<?php echo site_url('dang-ky');?>">Đăng ký</a></div>
			
		</div>
		
		<div class="box-login-success" style="display: none;">
			<ul class="content-login-success">
				<li class="user-login">Xin chào: <?php echo $this->session->userdata('fullname');?></li>
				<li class="logout"><a href="<?php echo site_url('thoat');?>">Đăng xuất</a></li>
			</ul>
		</div>
 -->	
 	</div>
	
</div>
