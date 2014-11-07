<div class="box-content-wapper">
<div>
	<a href=""><img src="<?=base_url()?>/site/templates/fyi/images/top-banner.jpg" width="1000" alt=""></a>
</div>
<div class="pathway-news">
      <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=base_url()?>" itemprop="url" class="homepage"><span itemprop="title">Trang chủ</span></a></div>
      <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?=site_url('news')?>" itemprop="url" class="homepage"><span itemprop="title">Tin tức</span></a></div>
      <div itemscope itemtype="http://data-vocabulary.org/Breadcrumb" class="no-bg"><a href="<?=site_url('news/'.$catinfo->caturl.'-'.$catinfo->catid);?>" itemprop="url" class="homepage"><span itemprop="title"><?=$catinfo->catname?></span></a></div>
         
      
</div>
<div class="news-content">
    
    
   
     <h3 class="title-de"><?=$rs->title?></h3>
     <div class="plugin-date">
     	<p class="date">
     	Ngày đăng: <?=date('H:i d/m/Y',$rs->created)?> - Lượt xem: <?=$rs->hits?> (lần)
     	</p>
     	<ul class="share_buttons">
                        <li class="zingme">
                <a href="http://link.apps.zing.vn/share?u=http%3A%2F%2Fnews.zing.vn%2Fsao-viet%2Ftiet-lo-thoi-khac-ra-di-cua-le-cong-tuan-anh%2Fa278937.html%23share_button_top&amp;t=Ti%E1%BA%BFt+l%E1%BB%99+th%E1%BB%9Di+kh%E1%BA%AFc+ra+%C4%91i+c%E1%BB%A7a+L%C3%AA+C%C3%B4ng+Tu%E1%BA%A5n+Anh&amp;desc=L%C3%AA+C%C3%B4ng+%C4%91%C6%B0%E1%BB%A3c+%C4%91%C6%B0a+%C4%91i+c%E1%BA%A5p+c%E1%BB%A9u+b%E1%BA%B1ng+m%E1%BB%99t+chi%E1%BA%BFc+x%C3%ADch+l%C3%B4%2C+v%C3%AC+c%C3%B3+2+v%E1%BA%BFt+th%C6%B0%C6%A1ng+%E1%BB%9F+%C4%91%E1%BA%A7u+n%C3%AAn+b%C3%A1c+s%C4%A9+ch%E1%BA%A9n+%C4%91o%C3%A1n+anh+b%E1%BB%8B...+ch%E1%BA%A5n+th%C6%B0%C6%A1ng+s%E1%BB%8D+n%C3%A3o.&amp;images=http%3A%2F%2Fimg2.news.zing.vn%2F2012%2F10%2F14%2F6-1.jpg&amp;" target="_blank" title="Chia sẻ lên Zing Me"><img src="http://static2.news.zing.vn/v3/images/small_zing_icon.png"></a>
            </li>
            <li class="google">
                <a href="https://plus.google.com/share?url=http%3A%2F%2Fnews.zing.vn%2Fsao-viet%2Ftiet-lo-thoi-khac-ra-di-cua-le-cong-tuan-anh%2Fa278937.html%23share_button_top" target="_blank" title="Chia sẻ trên Google"><img src="http://static2.news.zing.vn/v3/images/icon_googleplus.jpg" alt="Google +1"></a>
            </li>
            <li class="google">
                <a href="http://api.go.vn/social-plugins/share/share.php?title=Ti%E1%BA%BFt+l%E1%BB%99+th%E1%BB%9Di+kh%E1%BA%AFc+ra+%C4%91i+c%E1%BB%A7a+L%C3%AA+C%C3%B4ng+Tu%E1%BA%A5n+Anh&amp;description=L%C3%AA+C%C3%B4ng+%C4%91%C6%B0%E1%BB%A3c+%C4%91%C6%B0a+%C4%91i+c%E1%BA%A5p+c%E1%BB%A9u+b%E1%BA%B1ng+m%E1%BB%99t+chi%E1%BA%BFc+x%C3%ADch+l%C3%B4%2C+v%C3%AC+c%C3%B3+2+v%E1%BA%BFt+th%C6%B0%C6%A1ng+%E1%BB%9F+%C4%91%E1%BA%A7u+n%C3%AAn+b%C3%A1c+s%C4%A9+ch%E1%BA%A9n+%C4%91o%C3%A1n+anh+b%E1%BB%8B...+ch%E1%BA%A5n+th%C6%B0%C6%A1ng+s%E1%BB%8D+n%C3%A3o.&amp;imgthumb=http%3A%2F%2Fimg2.news.zing.vn%2F2012%2F10%2F14%2F6-1.jpg&amp;link=http%3A%2F%2Fnews.zing.vn%2Fsao-viet%2Ftiet-lo-thoi-khac-ra-di-cua-le-cong-tuan-anh%2Fa278937.html%23share_button_top" target="_blank" title="Chia sẻ trên Go"><img src="http://static2.news.zing.vn/v3/images/icon_govn.png" alt="Google +1"></a>
            </li>
            <li class="facebook">
                <a href="https://www.facebook.com/sharer/sharer.php?s=100&amp;p[title]=Ti%E1%BA%BFt+l%E1%BB%99+th%E1%BB%9Di+kh%E1%BA%AFc+ra+%C4%91i+c%E1%BB%A7a+L%C3%AA+C%C3%B4ng+Tu%E1%BA%A5n+Anh&amp;p[url]=http%3A%2F%2Fnews.zing.vn%2Fsao-viet%2Ftiet-lo-thoi-khac-ra-di-cua-le-cong-tuan-anh%2Fa278937.html%23share_button_top&amp;p[images][0]=http%3A%2F%2Fimg2.news.zing.vn%2F2012%2F10%2F14%2F6-1.jpg&amp;p[summary]=L%C3%AA+C%C3%B4ng+%C4%91%C6%B0%E1%BB%A3c+%C4%91%C6%B0a+%C4%91i+c%E1%BA%A5p+c%E1%BB%A9u+b%E1%BA%B1ng+m%E1%BB%99t+chi%E1%BA%BFc+x%C3%ADch+l%C3%B4%2C+v%C3%AC+c%C3%B3+2+v%E1%BA%BFt+th%C6%B0%C6%A1ng+%E1%BB%9F+%C4%91%E1%BA%A7u+n%C3%AAn+b%C3%A1c+s%C4%A9+ch%E1%BA%A9n+%C4%91o%C3%A1n+anh+b%E1%BB%8B...+ch%E1%BA%A5n+th%C6%B0%C6%A1ng+s%E1%BB%8D+n%C3%A3o." target="_blank" title="Chia sẻ trên Facebook"><img src="http://static2.news.zing.vn/v3/images/icon_facebook.png" alt="Facebook"></a>
            </li>
        </ul>
     </div>
      <div class="introtext-de"><?=$rs->introtext?></div>
       
    <!--  box relative --> 
     
    <div class="box-relative">
    	<p class="title">liên quan</p>
    	<ul class="item-l">
    		 <?foreach($listorther as $val):?>
            <li><a href="<?=site_url('news/'.$val->caturl.'/'.$val->title_alias.'-'.$val->newsid)?>" title="<?=$val->title?>"><?=$val->title?></a></li>
            <?endforeach;?>
    	</ul>
    	
    	<?php 
    	if(count($listViewMax)>0){
    	?>
    	<div class="box-viewmax">
    		<p class="title">Đọc nhiều nhất</p>
    		<ul class="item-other">
    		<?
    			$stt = 1;
    			$str0  = '';
    			$strRelative  = '';
    			foreach($listViewMax as $valMax):
    			if($stt == 1){
    				$nameMax0 = $valMax->title;
    				$link0    = site_url('news/'.$valMax->caturl.'/'.$valMax->title_alias.'-'.$valMax->newsid);
    				$imgThumb0 = (!empty($valMax->images_thumb))? base_url().$valMax->images_thumb: base_url().'data/no_image.jpg';
    				$str0 .='<li>';
    				$str0 .='<div class="item0">';
    				$str0 .='<a href="'.$link0.'"><img src="'.$imgThumb0.'" width="150" alt="'.$nameMax0.'"></a>';
    				$str0 .='<p class="name"><a href="'.$link0.'">'.$nameMax0.'</a></p>';
    				$str0 .='</div>';
    				$str0 .='</li>';
    				echo $str0;
    			}else{
    				$nameMax = $valMax->title;
    				$link    = site_url('news/'.$valMax->caturl.'/'.$valMax->title_alias.'-'.$valMax->newsid);
    				$strRelative .='<li><a href="'.$link.'">'.$nameMax.'</a></li>';
    			}
    		?>
           
    			
    		<?
    			$stt++;
    		endforeach;?>
    		<?=$strRelative;?>
    		</ul>
    	</div>
    	<?php }?>
    </div>
    <div class="news_detail">
        
       
       
        <div class="fulltext"><?=$rs->fulltext?></div>
        
        <div class="orther_news"><span>Tin khác..</span></div>
        <ul class="list_orther">
            <?foreach($listorther as $val):?>
            <li><a href="<?=site_url('news/'.$val->caturl.'/'.$val->title_alias.'-'.$val->newsid)?>" title="<?=$val->title?>"><?=$val->title?></a></li>
            <?endforeach;?>
        </ul>
        
        <div class="form_comment">
            <div class="icon_ykienbandoc">
                <h3>Ý kiến bạn đọc</h3>
                <div class="thongke">có <b>51</b> phản hồi về <b>"<?=$rs->title?>"</b>. </div>
            </div>
            <div class="form_add_comment">
                <div class="comleft">
                    <p class="title">Chia sẻ ý kiến</p>
                </div>
                <div class="comright">
                <form id="send_comment" accept-charset="utf-8" method="post" action="<?=uri_string()?>"> 
                    <div class="p5">
                        <input type="text" id="c_hoten" style="width: 230px;" class="text" name="fullname">
                        <input type="text" id="c_email" style="width: 242px;" class="text" name="email">
                    </div>
                    <div class="p5">
                        <textarea id="c_content" name="content" class="text" style="width: 482px; height: 100px; "></textarea>
                    </div>
                    <div id="warning"></div>

                    <div class="p5"><input type="submit" class="submit" value="Gửi ý kiến" name="bt_sendcommnet"></div>
                    <input type="hidden" value="<?=$rs->newsid?>" id="newsid" name="newsid">
                </form>            
                </div>
            </div>
            <div class="listcomment">
                <ul id="lastPostsLoader">
                <?foreach($listcomment as $val):?>
                    <li class="commentlast" id="<?=$val->commentid?>">
                        <div class="commentuser">
                            <img src="<?=base_url()?>data/avatar/1.jpeg" alt="">
                        </div>
                        <div class="infocomment">
                            <div class="arrow"></div>
                            <div class="boxcomment">
                                <div class="info_user_comment">
                                    <b><?=$val->fullname?></b> <span>xuaxxx@yahoo.com.vn</span> - 
                                    <span><?=date('H:i - d/m/Y',$val->add_date)?></span>
                                </div>
                                <div>
                                    <?=$val->content?>    
                                </div>
                            </div>
                        </div>
                    </li>
                <?endforeach;?>
                </ul>
            </div>
            <!-- 
            <div class="comment-show-more" id="show_more"><a href="javascript:;" onclick="func_morecomment(1)">Xem thêm nhận xét</a></div>
             -->
            <div ids="proce_comment" align="center"></div>
            
        </div>
    </div>
</div>
<div class="news-right">
	<?php 
	$this->load->config("config_logo");
	$linkAdsTop    = $this->config->item("link-logo");
	$imgAdsTop    = base_url().'/data/ads/full_images/'.$this->config->item("view-logo");
	?>
	<p class="img-ads"><a href="<?=$linkAdsTop;?>" target="_blank"><img src="<?=$imgAdsTop;?>" width="300" alt="fyi"></a></p>
    <?php $this->load->view('tindocnhieu')?>
     <?php $this->load->view('videoclip');?>
    <?php $this->load->view('photo');?>
    <?php $this->load->view('advright');?>
    
      <?php $this->load->view('advright1');?>
</div>


<?php $this->load->view('advfooter');?>
</div>