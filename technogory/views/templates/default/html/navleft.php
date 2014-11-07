<div class="main_navleft">
    <ul class="navleft" id="navleft">
    	<li class="deal-hot"><a href="<?php echo site_url('gia-re-moi-ngay');?>" target="_blank">Danh mục</a></li>
    <?
    $i = 1;
    $total_maincat = $this->config->item('total_menu');
    require_once (ROOT . 'debug/debug.php');


    for($c1=1; $c1 <= $this->config->item('total_menu'); $c1++){
    	$total_col = $this->config->item('m_totalcol_'.$c1);
   		$display_none = ($c1 <= 500)?'style="display:block"':'style="display:none"';
    ?>
        <li class="root"  <?=$display_none?> rel="main_<?=$this->config->item('menu_id_leve_1_'.$c1);?>">
            <a onclick="_gaq.push(['_trackEvent', 'Menu', 'Click', 'main_<?=$this->config->item('menu_id_leve_1_'.$c1)?>']);" href="<?=site_url('chuyen-muc/'.$this->config->item('menu_alias_leve_1_'.$c1).'-'.$this->config->item('menu_id_leve_1_'.$c1))?>" class="ddcm_root" id="main_<?=$this->config->item('menu_id_leve_1_'.$c1)?>">
                <?=$this->config->item('menu_name_leve_1_'.$c1)?>
            </a>
            <?if($total_col > 0){            	
            ?>
           
           
            <div class="ddcm_ul_child" id="menuitemchild_<?=$this->config->item('menu_id_leve_1_'.$c1);?>" style="width: <?=$total_col * 184?>px;">
            	 <div class="bg-itemchild_<?=$this->config->item('menu_id_leve_1_'.$c1);?>">
                <?for($col = 1; $col <= $total_col; $col++){?>
                <div class="col<?=$col?>">
                    <?for($c2 = 1; $c2 <= $this->config->item('m_totalcol_'.$c1.'_'.$col); $c2++){?>
                    <div class="title">
                    <a onclick="_gaq.push(['_trackEvent', 'menuitemchild', 'Click', 'menuitemchild_<?=$this->config->item('m_id_'.$c1)?>']);" href="<?=site_url('chuyen-muc/'.$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2).'-'.$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2))?>"><?=$this->config->item('m_name_'.$c1.'_'.$col.'_'.$c2)?></a>
                    </div>
                    <div class="minimenu">
                        <?
                        $total3 = $this->config->item('m_total_'.$c1.'_'.$col.'_'.$c2);
                        //if($total3 > 0){
                            //$total_tem = ($total3 > 4)?4:$total3;
                            $total_tem = $total3;
                        ?>
                            
                            <?for($c3 = 1; $c3 <= $total_tem ; $c3++ ){?>
                            <div class="link">
                                <a onclick="_gaq.push(['_trackEvent', 'minimenu', 'Click', 'menuitemchild_<?=$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2.'_'.$c3)?>']);" href="<?=site_url('chuyen-muc/'.$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2.'_'.$c3).'-'.$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2.'_'.$c3))?>"><?=$this->config->item('m_name_'.$c1.'_'.$col.'_'.$c2.'_'.$c3)?></a>
                            </div>
                            <?}?>
                            
                          
                        <?//}?>
                        </div>
                    <?}?>
                </div>
                <?}?>
            	</div>
            </div>
            
            
            
            <?}?>
        </li>

    <?
    $i++;
    }
    ?>
    </ul>
    
    
</div>
