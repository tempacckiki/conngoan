<div style="padding-right:20px; padding-left:4px; width:200px">
    <div class="divclose">
        <div onclick="clickHide(1);" class="small">&nbsp;</div>
    </div>
    <div id="menu-left">
        <ul>
            <?
             if(isset($this->menu)) {
                for($i = 0; $i < count($this->menu); $i++){
                    $uri2 = $this->uri->segment(2);
                    if(isset($this->menu)){$select =  'class="select"';}else{$select = "";}
                    $link = $this->menu[$i]['link'];
                    $name = $this->menu[$i]['name'];
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';
                    if($i==0){
                        echo '<li><a  href="'.base_url().$link.'" '.$select.'>'.$name.'</a></li>';    
                    }else{
                        echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.' >'.$name.'</a></li>';
                    }
                }
             }
            ?>   
            <li><a href="<?=site_url('thongtin')?>" <?if(isset($this->mthongtin)){echo 'class="select"';}?>>Thông tin trường</a></li>
            <li><a href="<?=site_url('lop/dslop')?>" <?if(isset($this->mdaunam)){echo 'class="select"';}?>>Các công việc đầu năm</a></li>
            <?
             if(isset($this->mdaunam)) {
                for($i = 0; $i < count($this->mdaunam); $i++){                   
                    $link = $this->mdaunam[$i]['link'];
                    $name = $this->mdaunam[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?> 
            <li><a href="<?=site_url('diem/nhapdiem')?>" <?if(isset($this->mdiem)){echo 'class="select"';}?>>Quản lý điểm</a></li>
            <?
             if(isset($this->mdiem)) {
                for($i = 0; $i < count($this->mdiem); $i++){                   
                    $link = $this->mdiem[$i]['link'];
                    $name = $this->mdiem[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?>                                                                         
            <li><a href="<?=site_url('khenthuong')?>"  <?if(isset($this->mkhenthuong)){echo 'class="select"';}?>>Khen thưởng & Kỷ luật</a></li>
            <li><a href="<?=site_url('chuyencan')?>"  <?if(isset($this->mchuyencan)){echo 'class="select"';}?>>Chuyên cần</a></li>
            <?
             if(isset($this->mchuyencan)) {
                for($i = 0; $i < count($this->mchuyencan); $i++){                   
                    $link = $this->mchuyencan[$i]['link'];
                    $name = $this->mchuyencan[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?> 
            <li><a href="<?=site_url('hanhkiem')?>"  <?if(isset($this->mhanhkiem)){echo 'class="select"';}?>>Hạnh kiểm</a></li>
            <?
             if(isset($this->mhanhkiem)) {
                for($i = 0; $i < count($this->mhanhkiem); $i++){                   
                    $link = $this->mhanhkiem[$i]['link'];
                    $name = $this->mhanhkiem[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?>  
            <li><a href="<?=site_url('tongket')?>"  <?if(isset($this->mcuoinam)){echo 'class="select"';}?>>Cuối năm</a></li>
            <?
             if(isset($this->mcuoinam)) {
                for($i = 0; $i < count($this->mcuoinam); $i++){                   
                    $link = $this->mcuoinam[$i]['link'];
                    $name = $this->mcuoinam[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?>                        
            <li><a href="<?=site_url('giaovien/dsgiaovien')?>"  <?if(isset($this->mgiaovien)){echo 'class="select"';}?>>Quản lý giáo viên</a></li>
            <?
             if(isset($this->mgiaovien)) {
                for($i = 0; $i < count($this->mgiaovien); $i++){                   
                    $link = $this->mgiaovien[$i]['link'];
                    $name = $this->mgiaovien[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?> 
            <li><a href="<?=site_url('quanlyhocsinh/dslop')?>"  <?if(isset($this->mhocsinh)){echo 'class="select"';}?>>Quản lý học sinh</a></li>
            <?
             if(isset($this->mhocsinh)) {
                for($i = 0; $i < count($this->mhocsinh); $i++){                   
                    $link = $this->mhocsinh[$i]['link'];
                    $name = $this->mhocsinh[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?>                              
            <li><a href="<?=site_url('lichtuan')?>"  <?if(isset($this->mlichtuan)){echo 'class="select"';}?>>Lịch công tác tuần</a></li>
            <li><a href="<?=site_url('thoikhoabieu/capnhat')?>"  <?if(isset($this->mtkb)){echo 'class="select"';}?>>Thời khóa biểu</a></li>
            <li><a href="<?=site_url('intro')?>" <?if(isset($this->mintro)){echo 'class="select"';}?>>Giới thiệu</a></li>
            <?
             if(isset($this->mintro)) {
                for($i = 0; $i < count($this->mintro); $i++){                   
                    $link = $this->mintro[$i]['link'];
                    $name = $this->mintro[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?>              
            <li><a href="<?=site_url('news')?>" <?if(isset($this->mnews)){echo 'class="select"';}?>>Tin tức</a></li>
            <?
             if(isset($this->mnews)) {
                for($i = 0; $i < count($this->mnews); $i++){                   
                    $link = $this->mnews[$i]['link'];
                    $name = $this->mnews[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?>            
            <li><a href="<?=site_url('thongbaochung/dsthongbao')?>" <?if(isset($this->mthongbaochung)){echo 'class="select"';}?>>Thông báo chung</a></li>
            <li><a href="<?=site_url('photo/listalbum')?>"  <?if(isset($this->mphoto)){echo 'class="select"';}?>>Photo</a></li>
            <?
             if(isset($this->mphoto)) {
                for($i = 0; $i < count($this->mphoto); $i++){                   
                    $link = $this->mphoto[$i]['link'];
                    $name = $this->mphoto[$i]['name'];
                    $uri2 = $this->uri->segment(2);
                    $link_select = end(explode('/',$link));
                    $select_submenu = ($uri2==$link_select)?'class="selected"':'';                      
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'" '.$select_submenu.'>'.$name.'</a></li>';
                }
             }
            ?>   
                       
            <li><a href="<?=site_url('weblink/listlink')?>" <?if(isset($this->mweblink)){echo 'class="select"';}?>>Liên kế website</a></li>           
            <li><a href="<?=site_url('quangcao/listquangcao')?>" <?if(isset($this->mquangcao)){echo 'class="select"';}?>>Quảng cáo</a></li>
            <li><a href="<?=site_url('contact')?>" <?if(isset($this->mcontact)){echo 'class="select"';}?>>Liên hệ</a></li>
            <?
             if(isset($this->mcontact)) {
                for($i = 0; $i < count($this->mcontact); $i++){
                    $link = $this->mcontact[$i]['link'];
                    $name = $this->mcontact[$i]['name'];
                    echo '<li class="sub-menu"><a href="'.base_url().$link.'">'.$name.'</a></li>';
                }
             }
            ?>
             
        </ul>                    
    </div>
</div>