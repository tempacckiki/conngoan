<?php 
$imgPath   = base_url_static().'technogory/templates/default/images/';

?>
<footer> <!-- BEGIN footer-->
    <section class="group-support-f">
        <div class="sub-group-suport">
			<aside class="col-items">  <!-- info company -->
                <p class="title">HỖ TRỢ KHÁCH HÀNG</p>
                <ul class="sub-f-items">
                    <li><a href="<?=site_url('huong-dan/loi-ich-mua-hang-online-23')?>">Lợi ích mua hàng online</a></li>
                    <li><a href="<?=site_url('huong-dan/huong-dan-thanh-toan-24')?>">Hướng dẫn thanh toán</a></li>
                    <li><a href="<?=site_url('huong-dan/giao-hang-25')?>">Giao hàng</a></li>
                    <li><a href="<?=site_url('huong-dan/tuyen-dung-26')?>">Tuyển dụng</a></li>
                    <li><a href="<?=site_url('huong-dan/chinh-sach-tra-hang-27')?>">Chính sách đổi trả hàng</a></li>
                    <li><a href="<?=site_url('huong-dan/trung-tam-bao-hanh-28')?>">Trung tâm bảo hành</a></li>
                    <li><a href="<?=site_url('lien-he');?>">Liên Hệ</a></li>
                </ul>
            </aside>
            
            <aside class="col-items">  <!-- info company -->
                <p class="title">Thông tin công ty </p>
                <ul class="sub-f-items">
               		<li><a href="<?=site_url('huong-dan/gioi-thieu-alobuy-viet-nam-30');?>">Giới thiệu Alobuy Việt Nam</a></li>
					<li><a href="<?=site_url('huong-dan/chinh-sach-bao-mat-31');?>">Chính sách bảo mật</a></li> 					
					<li><a href="<?=site_url('huong-dan/camket-chat-luong-32');?>">Cam kết chất lượng</a></li> 					
					<li><a href="<?=site_url('huong-dan/dieu-khoan-su-dung-33');?>">Điều khoản sử dụng</a></li> 					
					<li><a href="<?=site_url('huong-dan/danh-cho-doanh-nghiep-34');?>">Dành cho doanh nghiệp</a></li> 					
                </ul>
            </aside>
            
            <aside class="item-next-f">
                <p class="title">KẾT NỐI VỚI CHÚNG TÔI</p>
				<ul class="sub-f-items">
                	<li class="no-bg"><a href="http://www.facebook.com/www.alobuy.vn?ref=hl" target="_blank"><img src="<?=$imgPath;?>footer-social-fb.png" align="middle"> Facebook</a></li>
                	              	
                	<li class="no-bg"><a href=""><img src="<?=$imgPath;?>footer-social-zingme.png" align="middle"> ZingMe</a></li>
                	<li class="no-bg"><a href=""><img src="<?=$imgPath;?>footer-social-twitter.png" align="middle"> Twitter</a></li>
                	<li class="no-bg"><a href=""><img src="<?=$imgPath;?>footer-social-youtube.png" align="middle"> Youtube</a></li>
                </ul>
            </aside>
            
             <aside class="item-next-f">
                <p class="title">HÌNH THỨC THANH TOÁN</p>
				<div class="bank">
					 <ul class="sub-f-items">
	                	<li class="no-bg"><strong>Ngân hàng Á Châu (ACB) - CN Lý Thường Kiệt- TP.HCM</strong></li>
	                	<li class="no-bg">Chủ TK: Nguyễn Thanh Tuấn</li>
	                	<li class="no-bg" style="font-size: 12px;font-weight: bold;color: #ff0000;">Số TK: 87 82 93 99</li>
	                	
	                	<li class="no-bg"><strong>Ngân hàng Vietcombank - CN Tân Bình - TP.HCM</strong></li>
	                	<li class="no-bg">Chủ TK: Nguyễn Thị Hồng Trâm</li>
	                	<li class="no-bg" style="font-size: 12px;font-weight: bold;color: #ff0000;">Số TK: 044 1000 648 525</li>
	                </ul>
								
				</div>
				
            </aside>
            
            <aside class="item-next-float-right">
                <p class="title"><?=$this->config->item('contact_name');?></p>
              
                <ul>
							 
					<li><strong>Địa chỉ:</strong><?=$this->config->item('contact_address');?> </li>
	                <li><strong>Điện thoại:</strong> <?=$this->config->item('contact_phone');?></li>
	                <li><strong>Fax:</strong> <?=$this->config->item('contact_fax');?></li>
					<li><strong>Email:</strong> <?=$this->config->item('contact_email');?> </li>
					
					<li><strong>Website:</strong> <a href="http://alobuy.vn">www.alobuy.vn</a></li>
					
				</ul>
               <div class="logo-f">
               		<a href="<?=base_url();?>" target="_blank"><img src="<?=base_url_static();?>technogory/templates/default/images/alobuy-f.png?version=alobuy.vn"></a>               		
               		<a href="<?=site_url('tin-tuc');?>" target="_blank"><img src="<?=base_url_static();?>technogory/templates/default/images/alo-news.png?version=alobuy.vn"></a>
					<?php 
					date_default_timezone_set("Asia/Bangkok");
					echo date("Y-m-d H:i:s");
					?>
               </div>
            </aside>
            
        </div>
    </section>
    
   <div class="copyright">
   	Copyright © 2009-2012 <strong>ALOBUY VIETNAM TRADING SERVICE AND PRODUCTION COMPANY LIMITED</strong>. All rights reserved.
   </div> 
</footer><!-- End footer-->

 <?php echo $this->load->view("templates/default/html/box-support");?>

<!-- 
<?php//$this->load->view('modules/mod_popf/index')?>
<?php//$this->load->view('modules/mod_pop_content/index')?>

 -->
<?if(file_exists(ROOT.'technogory/config/home/bannertruot.db')){
   require_once(ROOT.'technogory/config/home/bannertruot.db');
?>
<script type="text/javascript">
    $(document).ready(function(){
        var window_width = $(window).width();
        //alert(window_width); 
        if(window_width < 1024){
            $("#vt_l,#vt_r,#vt_tr,#vt_tl").css({
                'display':'none'
            });
        }else{
            var window_w = $(window).width();
                min_top = ((window_w - 1000)/2) - 115;
                min_bot = ((window_w - 1000)/2) - 115;
                $("#vt_l").css({
                    'left':min_bot
                });
                $("#vt_r").css({
                    'right':min_bot
                });
                
                $("#vt_tr").css({
                    'left':min_top
                });
                $("#vt_tl").css({
                    'right':min_top
                });
        }
        

    });
</script>
<?php }?>
  <!-- phan croll top -->
 <script type="text/javascript">
	 $(document).ready(function(){
		 $(window).scroll(function() {
				if($(this).scrollTop() != 0) {
					$('#toTop').fadeIn();	
				} else {
					$('#toTop').fadeOut();
				}
			});
		 
			$('#toTop').click(function() {
				$('body,html').animate({scrollTop:0},800);
			});	
	
	 });
</script>
  <div id="toTop">&nbsp;</div>
  
  <script type="text/javascript" src="<?=base_url_static();?>technogory/templates/default/js/jquery.lazyload.js?version=alobuy.vn"></script>

<script type="text/javascript" charset="utf-8">
      $(function() {
          $("img").lazyload({        	 
              effect : "fadeIn",
             
          });
      });
</script>

<script type="text/javascript" src="<?=base_url()?>technogory/templates/default/js/jquery.vticker-min.js?version=alobuy.vn"></script>
	<script type="text/javascript">
	$(function(){
		$('#news-container').vTicker({ 
			speed: 700,
			pause: 4000,
			animation: 'fade',
			mousePause: false,
			showItems: 1
		});
	   
	});
	</script>
  