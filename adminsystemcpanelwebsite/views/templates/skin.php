<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html>
<head>
    <title>Quản trị hệ thống</title> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <?=$this->load->view('templates/html/meta')?>
</head>
<body>
<?if(($this->session->userdata('group_id') < 17) || ($this->session->userdata('admin') != 'fyi')){
    redirect(base_url());
}?>
    <div id="ajax-load">
        <div class="loading">Đang tải dữ liệu</div>
    </div>
    <div id="overlay-popup"></div>
    <div id="pop_bg"></div>
    <div id="pop"></div>
    <div id="wrapper">
        <div id="header">
            <ul id="topbar">
                <li><b style="font-size: 20px;color: #999999;">QUẢN TRỊ HỆ THỐNG WEBSITE</b></li>
                <li class="fr"><a href="<?=site_url('login/logout')?>" title="Thoát khỏi đăng nhập"><div class="logout"></div></a></li>
                <li class="fr">&nbsp;&nbsp;</li>
                <li class="fr"><a href="<?=base_url_site()?>" target="_blank" title="Trang chủ Site"><div class="homepage"></div></a></li>
                <li class="fr">&nbsp;&nbsp;</li>
                <li class="fr"><a href="<?=site_url('accountinfo')?>" title="Thông tin tài khoản"><div class="account"></div></a></li>  
                <!--
                <li class="s_1 fr"></li>
                <li class="fr">
       
                    <span>Xem dữ liệu theo ngôn ngữ</span>
                    <select name="namhoc" onchange="set_lang(this.value)">
                        
                        <option value="vietnamese" <?php echo ($this->session->userdata('lang_admin')=='vietnamese')?'selected="selected"':''?>>Vietnamese</option>
                        <option value="english" <?php echo ($this->session->userdata('lang_admin')=='english')?'selected="selected"':''?>>English</option>
                    </select>

                </li>
                -->
            </ul>
        </div>
        <div id="menutop"><?=$this->load->view('templates/html/mod_menu')?></div>
        <div class="space">&nbsp;</div> 
        <table class="table_full" style="width: 100%;">
            <tr>
                <!--
                <td valign="top" style="display: none;" class="colum_left_small">
                    <span class="lage" onclick="clickHide(2)">&nbsp;</span>
                </td>
                <td style="display: table-cell;" class="colum_left_lage" valign="top">
                    <?=$this->load->view('templates/html/mod_menuleft')?>
                </td>
                -->
                <td style="background: #F2F2F2;padding: 0px 5px 5px 0px;" valign="top">      
                    <div class="box-content" id="page">
                    <?php 
                    if($this->uri->segment('1') != 'admincp'){
                    ?>
                    <div class="gray">
                        <table style="width: 99%;">
                            <tr>
                                <td valign="middle"><?if(isset($title)){ echo '<div class="h-title">'.$title.'</div>';}?> </td>
                                <td align="right">
                                <?php echo $this->load->view('templates/html/toolbar')?>
                                    <!--
                                    <?if(isset($add)){
                                        $add = explode('|',$add);
                                        $add_link = $add[0];
                                        $add_text = (isset($add[1]))?$add[1]:'Thêm mới';
                                    ?>
                                        <div class="addlink"><a href="<?=site_url($add_link)?>" class="add"><span><?=$add_text?></span></a></div>
                                    <?
                                    }?> 
                                    -->                       
                                </td>
                            </tr>
                        </table> 
                        </div> 
                      <?php }?>
                       <?if(count($this->menu) > 0){?> 
                        <div id="menucontent">
                            <ul>
                            <?
                                for($i = 0; $i < count($this->menu); $i++){
                                    $uri2 = $this->uri->segment(2);
                                    if(isset($this->menu)){$select =  'class="select"';}else{$select = "";}
                                    $link = $this->menu[$i]['link'];
                                    $name = $this->menu[$i]['name'];
                                    $link_select = end(explode('/',$link));
                                    $select_submenu = ($uri2==$link_select)?'class="select"':'';
                                    echo '<li '.$select_submenu.'><a  href="'.base_url().$link.'" >'.$name.'</a></li>';    
                                }
                            ?>
                            </ul>
                        </div>
                        <?}?>                        
                        
                        <?if(isset($message) && $message !=''){ echo '<div class="show_notice" id="msg">'.$message.'</div>';}?>
                        <?if($this->session->flashdata('message')){
                            echo '<div class="show_success" id="msg">'.$this->session->flashdata('message').'</div>';
                        }if($this->session->flashdata('error')){
                            echo '<div class="show_error" id="msg">'.$this->session->flashdata('error').'</div>';
                        }if($this->session->flashdata('notes')){
                            echo '<div class="show_notice" id="msg">'.$this->session->flashdata('notes').'</div>';
                        }
                        ?>                        
                                          
                        <?=$this->load->view($page)?>
                    </div>
                </td>
            </tr>
        </table>
        <div id="footer">
            <div class="copyright">
                <div>Thời gian nạp trang {elapsed_time} giây</div>
                <div>Copyright © 2009 - <?=date('Y',time())?> Version 2.0 - <?=$this->config->item('site_name')?>. All right reserved</div>

            </div>        
        </div>
    </div>
  
</body>
</html>