<div class="uleft">
    <?=$this->load->view('html/uleft')?>
</div>
<div class="ucontent">
    <div class="pathway" style="margin-bottom: 10px;">
        <ul>
            <li><a href="<?=base_url()?>" class="homepage">Trang chủ</a></li>
            <li><a href="<?=site_url('u/thong-tin-tai-khoan')?>">Tài khoản</li> 
            <li><a href="#" class="active">Đổi hình đại diện</a></li> 
        </ul>
    </div>
    <?=form_open_multipart(uri_string())?>
    <div class="ShowInfoUser">
        <div class="img" id="img_avatar">
        <?if($rs->url_avatar == ''){?>
            <img src="<?=base_url().'data/no_avatar.png'?>" alt="" width="110px">
        <?}else{?>
            <img src="<?=base_url_avatar().'avatar/'.$rs->url_avatar?>" alt="" width="110px">
        <?}?>
        </div>
        <p style="margin-top: 10px;"><input type="file" id="userfile" name="userfile"></p>
        <p><input type="submit" id="upload_button" class="submit" value="<?=lang('tailen')?>" style="padding: 2px 10px;margin-top: 5px;"></p>
        <p id="msg" class="show_notice_small"><?=lang('av.ghichu')?></p>
    </div>
    <div class="clear"></div>
    <?=form_close();?>
</div>
