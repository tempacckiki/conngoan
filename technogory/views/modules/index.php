<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$this->load->helper('params_helper');
$list = $this->modules->get_position($position);
if(count($list) > 0){
    foreach($list as $rs):
    $title = $rs->title;
    $params = $rs->params;
    //var_dump(get_params($rs->attr)); 
    $data['attr'] = $rs->attr;
?>
    <?if($params == ''){?>
    <div class="mod_tl">
        <div class="mod_tr">
            <div class="mod_tm">
            <?php if($rs->show_title == 1){?>
                <h3><?php echo $title?></h3>
            <?php  }?>            
            </div>
        </div>
    </div>
    <div class="mod_ml">
        <div class="mod_mr">
            <div class="mod_mc">    
            <?php if($rs->html == 0){?>
                <?php echo $this->load->view('modules/'.$rs->module.'/index',$data)?>
            <?php }?>
            <?php if($rs->html == 1){?>
                <?php echo $rs->content?>
            <?php }?>            
            </div>
        </div>
    </div>
    <div class="mod_bl"><div class="mod_br"><div class="mod_bm"></div></div></div>
    <?}else if($params != '_blank'){?>
    <div class="modules_<?php echo $params?>">
        <div class="mod_top">
        <?php if($rs->show_title == 1){?>
            <h3><?php echo $title?></h3>
        <?php  }?>
        </div>
        <div class="mod_mid">
        <?php if($rs->html == 0){?>
            <?php echo $this->load->view('modules/'.$rs->module.'/index',$data)?>
        <?php }?>
        <?php if($rs->html == 1){?>
            <?php echo $rs->content?>
        <?php }?>        
        </div>
        <div class="mod_bot"></div>
    </div>                
    <?php }else{?>
        <?php if($rs->html == 0){?>
            <?php if($rs->show_title == 1){?>
                <h3><?php echo $title?></h3>
            <?php  }?>        
            <?php echo $this->load->view('modules/'.$rs->module.'/index',$data)?>
        <?php }?>
        <?php if($rs->html == 1){?>
             <?php if($rs->show_title == 1){?>
                <h3><?php echo $title?></h3>
            <?php  }?>       
            <?php echo $rs->content?>
        <?php }?>
    <?php }?>
<?php 
    endforeach;
}
?>