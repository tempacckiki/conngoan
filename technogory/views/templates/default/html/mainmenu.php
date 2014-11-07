<?
 $uri1  =$this->uri->segment('1');
if(!isset($catmenu)){
    $catmenu = 0;
} 
?>
<nav class="nav-top">
    <ul id="mainnavtop">
        <li <?=($uri1 =='' || $uri1 =='contact')?'class="home"':'';?>><a href="<?=base_url()?>">&nbsp;</a></li>
       
        <li class="deal"><a onclick="_gaq.push(['_link', 'http://fyi.vn/sangiare']);" href="http://fyi.vn/sangiare">Sàn giá rẻ</a></li>
        <!--<li><a href="http://fyi.vn/sandaugia">Sàn đấu giá</a></li> -->
        
        <li><a href="<?=site_url('news')?>">Tin tức - Sự kiện</a></li>
       <!-- <li><a href="javascript:;">Sự kiện</a></li> -->
        <li id="dichvu">
            <a href="javascript:;">Dịch vụ</a>
            <ul id="dichvu_show">
                <?for($i = 1; $i <= $this->config->item('total_service'); $i++){?>
                <li class="clear">
                    <a href="<?=site_url('dich-vu/'.$this->config->item('service_slug_'.$i).'-'.$this->config->item('service_id_'.$i))?>">
                        <?=$this->config->item('service_name_'.$i)?>
                    </a>
                </li>
                <?}?>
            </ul>
        </li>
        <li <?=($uri1 =='contact')?'class="select"':'';?>><a href="<?=site_url('contact')?>">Liên hệ</a></li>
        <!--<li><a href="http://fyi.vn/diendan">Diễn đàn</a></li>-->
         <p class="date-time-head">Hôm nay: <?=date('H:i - d/m/Y',time());?></p>
    </ul>
    
   
</nav> <!-- End nav header -->


