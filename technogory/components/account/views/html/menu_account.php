<?$uri2 = $this->uri->segment(2);?>
<div class="main-categ">
    <ul class="list-categ"> 
        <li class="main-title"><?=lang('giaodich')?></li>
        <li class="sub-title <?=($uri2 == 'don-hang')?'active':''?>"><a href="<?=site_url('giao-dich/don-hang')?>" class="sub"><span><?=lang('donhang')?></span></a></li>
    </ul>
</div>

<div class="main-categ">
    <ul class="list-categ"> 
        <li class="main-title"><?=lang('thongtintaikhoan')?></li>
        <li class="sub-title <?=($uri2 == 'thong-tin-tai-khoan')?'active':''?>"><a href="<?=site_url('u/thong-tin-tai-khoan')?>" class="sub"><span><?=lang('capnhatthongtin')?></span></a></li>
        <li class="sub-title <?=($uri2 == 'doi-mat-khau')?'active':''?>"><a href="<?=site_url('u/doi-mat-khau')?>" class="sub"><span><?=lang('doimatkhau')?></span></a></li>
        <li class="sub-title <?=($uri2 == 'doi-hinh-dai-dien')?'active':''?>"><a href="<?=site_url('u/doi-hinh-dai-dien')?>" class="sub"><span><?=lang('doiavatar')?></span></a></li>
    </ul>
</div>