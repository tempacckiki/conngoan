	   <aside id="col-right-i">
	   		<?php
 				$aRandomNews = $this->helper->getLatestNews(5);
 				if(count($aRandomNews) > 0){
			        $imgPath   = base_url_static().'technogory/templates/default/images/';
			        $base_url_static = $this->config->item('base_url_static');
			        $base_url_site = $this->config->item('base_url_site');
	   		?>
	   			<div>
	   				<ul>
	   					<?php
	        				foreach ($aRandomNews as $key => $aNews) {
	        					if(empty($aNews->images_thumb) == false){
				                    $newsimg     = $base_url_static . $aNews->images_thumb;
	        					} else {
				                    $newsimg     = $imgPath . 'no_image.gif';
	        					}
	   					?>
	   						<li>
	   							<div>
	   								<div><a href="<?=$this->config->item('base_url_site') . ('tin-tuc/' . $aNews->caturl . '/' . $aNews->title_alias . '-' . $aNews->newsid . '.html');?>"><?=$aNews->title?></a></div>
	   								<div>
	   									<div><img src="<?=$newsimg?>" alt="<?=$aNews->title?>" title="<?=$aNews->title?>" /></div>
	   									<div>
	   										<div><?=$aNews->introtext?></div>
	   										<div><?=$this->helper->formatDatetime($aNews->created, 'd-m-Y, g:i a')?></div>
	   									</div>
	   								</div>
	   								<div><a href="<?=$this->config->item('base_url_site') . ('tin-tuc/' . $aNews->caturl . '/' . $aNews->title_alias . '-' . $aNews->newsid . '.html');?>">Xem tất cả</a></div>
	   							</div>
	   						</li>
	   					<?php
	   						}
	   					?>
	   				</ul>
	   			</div>
	   		<?php
	   			}
	   		?>
	   </aside>
