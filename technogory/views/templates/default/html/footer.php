<?php 
$imgPath   = base_url_static().'technogory/templates/default/images/';

?>
<footer> <!-- BEGIN footer-->
    <section class="group-support-f">
        <div class="sub-group-suport">
			<aside class="col-items">  <!-- info company -->
                <p class="title">Về Con Ngoan</p>
                <ul class="sub-f-items">
                    <li><a href="<?=site_url('huong-dan/gioi-thieu-37')?>">Giới thiệu</a></li>
                    <li><a href="<?=site_url('huong-dan/dieu-khoan-su-dung-33')?>">Điều khoản sử dụng</a></li>
                    <li><a href="<?=site_url('huong-dan/chinh-sach-bao-mat-31')?>">Chính sách bảo mật</a></li>
                    <li><a href="<?=site_url('lien-he');?>">Liên Hệ</a></li>
                </ul>
            </aside>
            
            <aside class="col-items">  <!-- info company -->
                <p class="title">Hỗ trợ khách hàng</p>
                <ul class="sub-f-items">
               		<li><a href="<?=site_url('huong-dan/huong-dan-mua-hang-38');?>">Hướng dẫn mua hàng</a></li>
					<li><a href="<?=site_url('huong-dan/chinh-sach-bao-mat-31');?>">Giao hàng</a></li> 					
					<li><a href="<?=site_url('huong-dan/thanh-toan-39');?>">Thanh toán</a></li> 					
					<li><a href="<?=site_url('huong-dan/bao-hanh-40');?>">Bảo hành</a></li> 					
          <li><a href="<?=site_url('huong-dan/doi-tra-41');?>">Đổi trả</a></li>           
					<li><a href="<?=site_url('huong-dan/kiem-tra-don-hang-42');?>">Kiểm tra đơn hàng</a></li> 					
                </ul>
            </aside>
            
            <aside class="item-next-f">
                <p class="title">Kết nối với Con Ngoan</p>
				<ul class="sub-f-items">
                	<li class="no-bg"><a href="http://www.facebook.com/www.alobuy.vn?ref=hl" target="_blank"><img src="<?=$imgPath;?>footer-social-fb.png" align="middle"> Facebook</a></li>
                	              	
<!--                 	<li class="no-bg"><a href=""><img src="<?=$imgPath;?>footer-social-zingme.png" align="middle"> ZingMe</a></li>
                	<li class="no-bg"><a href=""><img src="<?=$imgPath;?>footer-social-twitter.png" align="middle"> Twitter</a></li>
                	<li class="no-bg"><a href=""><img src="<?=$imgPath;?>footer-social-youtube.png" align="middle"> Youtube</a></li>
 -->                </ul>
            </aside>
            
<!--              <aside class="item-next-f">
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
				
            </aside> -->
            
<!--             <aside class="item-next-float-right">
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
					<?php echo date('d/m/Y:h:i:s', time());?>
               </div>
            </aside>
 -->            
        </div>
    </section>
    
   <div class="copyright">
   	Copyright © 2014 congnoan.com. Bản quyền của Con Ngoan.
   </div> 
</footer><!-- End footer-->

 <?php echo $this->load->view("templates/default/html/box-support");?>

<!-- 
<?php//$this->load->view('modules/mod_popf/index')?> 
<?php //$this->load->view('modules/mod_pop_content/index')?>
-->

<?php 
 $city_id = $this->session->userdata('city_site');
if(file_exists(ROOT.'technogory/config/home/bannertruot'.$city_id.'.db')){
   // include_once (ROOT.'technogory/config/home/bannertruot'.$city_id.'.db'); 
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
		//set cookie
		province_c_cookie = $.cookie('province_city');
		if(province_c_cookie == null || province_c_cookie == 1){
			$('.city_toolTip').show();
		}else{
			$('.city_toolTip').hide();
		}
		$("#closeChoosenCity").click(function(data){
			$('.city_toolTip').hide();
			//set cooki
			$.cookie('province_city', 2);
		});
		//set timeout 3s
		setTimeout(function(){setCookiesTimeout()},5000);
	
		//scroll
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

	 //
	 function setCookiesTimeout(){
		 $.cookie('province_city', 2);
		 $('.city_toolTip').hide();
	 }
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
  