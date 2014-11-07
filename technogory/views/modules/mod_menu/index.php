<?
function remove_numbers($string) {
    $vowels = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", " ");
    $string = str_replace($vowels, '', $string);
    return $string;
}
$url3 =  trim(remove_numbers($this->uri->segment(4)),'-');

    

$this->db->where('menutype','Mainmenu');
$this->db->where('published',1);
$this->db->where('lang',vnit_lang());
$this->db->where('parent_id',0);
$this->db->order_by('ordering','asc');
$list = $this->db->get('menu')->result();
?>
<div id="menu">
<ul class="menu">
    <li><a href="<?=base_url()?>" <?=($this->uri->segment(1)=='')?'class="current"':'';?>><?=($this->session->userdata('lang')=='vi')?'Trang chủ':'Home'?></a></li>
    <?php foreach($list as $rs):
    $link_full = explode('/',$rs->link);
    if(isset($link_full[1])){
        $menu = trim(remove_numbers($link_full[1]),'-');    
        if($menu == $url3){
            if($rs->target == 1){
                $current = '';    
            }else{
                $current = 'current';
            }
        }else{
            $current = '';
        }
    }else{
        if($this->uri->segment(2)== trim(remove_numbers($link_full[0]),'-')){
            if($rs->target == 1){
                $current = '';    
            }else{
                $current = 'current';
            }
        }else{
            $current = '';
        }
    }
    
    
    $this->db->where('parent_id',$rs->id);
    $this->db->order_by('ordering','asc');
    $listsub = $this->db->get('menu')->result();
    ?>
    <li>
        <a class="<?=$current?>" href="<?php echo ($rs->target ==0)?site_url($rs->link):$rs->link?>" <?=($rs->target==1)?'target="_blank"':''?>><?=$rs->name?></a>
        
        <?php if(count($listsub) > 0){?>
        <ul>
            <?php foreach($listsub as $sub):?>
            <li><a  href="<?php echo ($sub->target ==0)?site_url($sub->link):$sub->link?>" <?=($sub->target==1)?'target="_blank"':''?>><?=$sub->name?></a></li>
            <?php endforeach;?>
        </ul>
        <?php }?>
       
    </li>
    <?php endforeach;?>
</ul>
</div>

