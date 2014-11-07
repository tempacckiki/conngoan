<?
if(!isset($catmenu)){
    $catmenu = 0;
} 
?>
<nav class="nav-top">
    <ul id="mainnavtop">
        <li class="home"><a href="<?=base_url()?>">Trang chủ</a></li>
        <?
        $i = 1;
        for($c1=1; $c1 <= $this->config->item('total_maincat'); $c1++){?>
        <li rel="main_<?=$this->config->item('m_id_'.$c1)?>">
            <a href="">
                <?=$this->config->item('m_name_'.$c1)?>
                <b class="arrow"></b>
            </a>
            <!--Begin Submenu-->
            <?

            $total_col = $this->config->item('m_totalcol_'.$c1);     
            
            ?> 
            <div class="submenu" id="menuitemchild_<?=$this->config->item('m_id_'.$c1)?>" style="width: <?=$total_col * 163?>px;">
                <?for($col = 1; $col <= $total_col; $col++){?>
                <div class="col<?=$col?>">
                    <?for($c2 = 1; $c2 <= $this->config->item('m_totalcol_'.$c1.'_'.$col); $c2++){?>
                    <div class="title">
                    <a href="<?=site_url('category/'.$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2).'-'.$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2))?>">
                        <?=$this->config->item('m_name_'.$c1.'_'.$col.'_'.$c2)?>
                    </a>
                    </div>
                        <?if($this->config->item('m_total_'.$c1.'_'.$col.'_'.$c2) > 0){?>
                        
                            <?for($c3 = 1; $c3 <=$this->config->item('m_total_'.$c1.'_'.$col.'_'.$c2) ; $c3++ ){?>
                            <div class="link">
                            <a href="<?=site_url('category/'.$this->config->item('m_slug_'.$c1.'_'.$col.'_'.$c2.'_'.$c3).'-'.$this->config->item('m_id_'.$c1.'_'.$col.'_'.$c2.'_'.$c3))?>">
                            <?=$this->config->item('m_name_'.$c1.'_'.$col.'_'.$c2.'_'.$c3)?>
                            </a>
                            </div>
                            <?}?>
                        <?}?>
                    <?}?>
                </div>
                <?}?>
            </div>

           <!--End Submenu--> 
        </li>
        <?
        $i++;
        }?>
    </ul>
</nav> <!-- End nav header -->


