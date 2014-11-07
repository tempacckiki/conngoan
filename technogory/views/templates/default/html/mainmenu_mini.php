<?
$uri1  = $this->uri->segment('1');
?>
<div class="mlist-cat">
    <ul class="navleft" id="navleft">
    <?
    $i = 1;
    for($c1=1; $c1 <= $this->config->item('total_maincat'); $c1++){
    $total_col = $this->config->item('m_totalcol_'.$c1);
    ?>
        <li class="root" rel="main_<?=$this->config->item('menu_id_leve_1_'.$c1)?>">
            <a onclick="_gaq.push(['_trackEvent', 'Menu', 'Click', 'main_<?=$this->config->item('menu_id_leve_1_'.$c1)?>']);" href="<?=site_url('chuyen-muc/'.$this->config->item('menu_alias_leve_1_'.$c1).'-'.$this->config->item('menu_id_leve_1_'.$c1))?>" class="ddcm_root" id="main_<?=$this->config->item('menu_id_leve_1_'.$c1)?>">
                <img class="icon" src="<?=base_url()?>alobuy0862779988/0862779988cat/<?=$this->config->item('menu_img_leve_1_'.$c1)?>" alt="<?=$this->config->item('menu_name_leve_1_'.$c1)?>">
                <?=$this->config->item('menu_name_leve_1_'.$c1)?>
                <?if($total_col > 0){?>
                <span></span>
                <?}?>
            </a>
            <?if($total_col > 0){?>
            <div class="ddcm_ul_child" id="menuitemchild_<?=$this->config->item('menu_id_leve_1_'.$c1)?>" style="width: <?=$total_col * 184?>px;">
            
            	<div class="bg-itemchild_<?=$this->config->item('menu_id_leve_1_'.$c1)?>">
                <?for($col = 1; $col <= $total_col; $col++){?>
                <div class="col<?=$col?>">
                    <?for($c2 = 1; $c2 <= $this->config->item('m_totalcol_'.$c1.'_'.$col); $c2++){?>
                    <div class="title">
                    <a onclick="_gaq.push(['_trackEvent', 'menuitemchild', 'Click', 'menuitemchild_<?=$this->config->item('m_id_'.$c1)?>']);" href="<?=site_url('chuyen-muc/'.$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2).'-'.$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2))?>">
                        <?=$this->config->item('m_name_'.$c1.'_'.$col.'_'.$c2)?>
                    </a>
                    </div>
                    <div class="minimenu">
                        <?
                        $total3 = $this->config->item('m_total_'.$c1.'_'.$col.'_'.$c2);
                        if($total3 > 0){
                            $total_tem = ($total3 > 4)?4:$total3;
                        ?>
                            
                            <?for($c3 = 1; $c3 <= $total_tem ; $c3++ ){?>
                            <div class="link">
                                <a onclick="_gaq.push(['_trackEvent', 'minimenu', 'Click', 'menuitemchild_<?=$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2.'_'.$c3)?>']);" href="<?=site_url('chuyen-muc/'.$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2.'_'.$c3).'-'.$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2.'_'.$c3))?>">
                                <?=$this->config->item('m_name_'.$c1.'_'.$col.'_'.$c2.'_'.$c3)?>
                                </a>
                            </div>
                            <?}?>
                            
                            <?if($total3 > 4){?>
                            <div id="mini_<?=$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2)?>" class="readmore">
                                <a class="removelink" href="javascript:;">Xem thêm</a>
                                <div class="contentmini" id="larger_<?=$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2)?>">
                                    <?for($c3 = 5; $c3 <= $total3 ; $c3++){?> 
                                     <div class="link">
                                        <a onclick="_gaq.push(['_trackEvent', 'minimenu', 'Click', 'menuitemchild_<?=$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2.'_'.$c3)?>']);" href="<?=site_url('chuyen-muc/'.$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2.'_'.$c3).'-'.$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2.'_'.$c3))?>">
                                        <?=$this->config->item('m_name_'.$c1.'_'.$col.'_'.$c2.'_'.$c3)?>
                                        </a>
                                    </div>
                                    <?}?>    
                                </div>
                            </div> 
                            <?}?>
                        <?}?>
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



