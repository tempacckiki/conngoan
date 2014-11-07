<?php 
$imgPath   = base_url().'technogory/templates/default/images/';
?>


	<div class="rss-content">
		<div class="box-left-rss">
			<div class="box-intro">
				<strong>RSS của ALOBUY Việt Nam</strong> <br>
				
				RSS viết tắt từ Really Simple Syndication là một tiêu chuẩn định dạng tài liệu dựa trên XML nhằm giúp người sử dụng dễ dàng cập nhật và tra cứu thông tin một cách nhanh chóng và thuận tiện nhất bằng cách tóm lược thông tin vào trong một đoạn dữ liệu ngắn gọn, hợp chuẩn. Dữ liệu này được các chương trình đọc tin chuyên biệt gọi là News reader phân tích và hiển thị trên máy tính của người sử dụng. Trên trình đọc tin này, người sử dụng có thể thấy những tin chính mới nhất, tiêu đề, tóm tắt và cả đường link để xem tòan bộ tin.
			</div>
			<p class="title-sub">Các kênh RSS do ALOBUY Việt Nam cung cấp</p>
			<div class="list-rss">
				<ul class="items">
					 <?
				    $i = 1;
				    for($c1=1; $c1 <= $this->config->item('total_maincat'); $c1++){
				    	$listSub1  = $this->rss->getAllCat($this->config->item('menu_id_leve_1_'.$c1));
				    				    
				    ?>
				    
					<li>
						<p class="icon"><a href="<?=base_url().'technogory/rss/'.$this->config->item('menu_alias_leve_1_'.$c1).'.rss';?>"><img src="<?=$imgPath;?>RSS2.gif" alt=""></a></p>
						<p class="menu"><a href="<?=base_url().'technogory/rss/'.$this->config->item('menu_alias_leve_1_'.$c1).'.rss';?>"><?=$this->config->item('menu_name_leve_1_'.$c1)?></a></p>
						<p class="link"><a href="<?=base_url().'technogory/rss/'.$this->config->item('menu_alias_leve_1_'.$c1).'.rss';?>"><?=base_url().'site/rss/'.$this->config->item('menu_alias_leve_1_'.$c1).'.rss';?></a></p>
					</li>
						<?php
						if(count($listSub1) > 0){
							foreach ($listSub1 as $valSub1):
								$nameCat1		= $valSub1->catname;
								$linkCat1 		= base_url().'site/rss/'.$valSub1->caturl.'.rss';
								
								//list cap 3
								$listSub2 		= $this->rss->getAllCat($valSub1->catid);
								
						?>
						<div class="sub-item-rss">
							<p class="icon"><a href="<?=$linkCat1;?>"><img src="<?=$imgPath;?>RSS2.gif" alt=""></a></p>
							<p class="menu"><a href="<?=$linkCat1;?>"><?=$nameCat1;?></a></p>
							<p class="link"><a href="<?=$linkCat1;?>"><?=$linkCat1;?></a></p>
						</div>
								<?php 
								if(count($listSub2)>0){
									foreach ($listSub2 as $valSub2):
									$nameCat2		= $valSub2->catname;
									$linkCat2 		= base_url().'technogory/rss/'.$valSub2->caturl.'.rss';
								?>
									<div class="sub-item-rss2">
										<p class="icon"><a href="<?=$linkCat2;?>"><img src="<?=$imgPath;?>RSS2.gif" alt=""></a></p>
										<p class="menu"><a href="<?=$linkCat2;?>"><?=$nameCat2;?></a></p>
										<p class="link"><a href="<?=$linkCat2;?>"><?=$linkCat2;?></a></p>
									</div>
							
						
								<?php 
									endforeach;
									} 
								?>
						
						
						<?php
							
						endforeach;
						}
						?>
					
					<?php 
					}
					?>
				</ul>
			</div>
			
			<div class="intro-footer">
				<p class="title-footer">Các giới hạn sử dụng </p>
		
				Các nguồn kênh tin được cung cấp miễn phí cho các cá nhân và các tổ chức phi lợi nhuận. Chúng tôi yêu cầu bạn cung cấp rõ các thông tin cần thiết khi bạn sử dụng các nguồn kênh tin này từ Alobuy Việt Nam.<br>
		
				Alobuy Việt Nam có quyền yêu cầu bạn ngừng cung cấp và phân tán thông tin dưới dạng này ở bất kỳ thời điểm nào và với bất kỳ lý do nào.
			</div>
		
		</div>
		
		<div class="right-rss">
			<p>
				<a href=""><img src="<?=base_url();?>alobuy0907125078/hotline/full_images/1358402904.png" width="200"></a>
			</p>
		</div>
	</div>
