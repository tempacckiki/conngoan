 <?
 $uri2 = $this->uri->segment(2);
 ?>
 <h3 class="title">Thông tin tài khoản</h3>
 <div class="box_modules">
    <div class="full_name">Xin chào: <?=$this->session->userdata('fullname')?></div>
    <div align="center" class="avatar">
    <?
    $user = $this->openid->get_user_by_id();
    $this->db = $this->load->database('default', TRUE);
    ?>
    <?if($user->url_avatar != ''){?>
        <img src="<?=base_url_avatar()?>avatar/<?=$user->url_avatar?>" alt="">
    <?}else{?>
        <img src="<?=base_url()?>data/no_avatar.png" alt="">
    <?}?>
    </div>
    <ul class="cpanel">
        <li class="<?=($uri2 == 'thong-tin-tai-khoan')?'active':''?>"><a href="<?=site_url('u/thong-tin-tai-khoan')?>">Thông tin tài khoản</a></li>
        <li class="<?=($uri2 == 'doi-mat-khau')?'active':''?>"><a href="<?=site_url('u/doi-mat-khau')?>">Đổi mật khẩu</a></li>
        <!--
        <li class="<?=($uri2 == 'doi-hinh-dai-dien')?'active':''?>"><a href="<?=site_url('u/doi-hinh-dai-dien')?>">Đổi hình đại diện</a></li>-->
    </ul>
</div>

 <h3 class="title">Thông tin giao dịch</h3>
 <div class="box_modules">
    <ul class="cpanel">
        <li class="<?=($uri2 == 'don-hang')?'active':''?>"><a href="<?=site_url('giao-dich/don-hang')?>">Đơn hàng của bạn</a></li>
        <li class="<?=($uri2 == 'thong-bao-chuyen-khoan')?'active':''?>"><a href="<?=site_url('giao-dich/thong-bao-chuyen-khoan')?>">Thông báo chuyển khoản</a></li>
        <!--<li class="<?=($uri2 == 'doi-hinh-dai-dien')?'':''?>"><a href="<?=site_url('u/doi-hinh-dai-dien')?>">Điểm thưởng</a></li>-->
    </ul>
</div>
