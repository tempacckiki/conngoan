<?php
 if($this->session->userdata('lang') == 'vi'){
     $langdb = "";
 }else{
     $langdb = "_en";
 }
$max = get_params('max',$attr);
$catid =split(',',get_params('catid',$attr));
if(count($catid) > 0){
$this->db->where_in('catid',$catid);
$this->db->order_by('ordering','asc');
$list = $this->db->get('content'.$langdb)->result();
?>
<ul>
    <?foreach($list as $rs):?>
    <li><a href="<?=site_url('tin-tuc/bai-viet/'.$rs->title_alias.'-'.$rs->id)?>"><?=$rs->title?></a></li>
    <?endforeach;?>
</ul>
<?}
?>
