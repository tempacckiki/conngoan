<?php
function get_list_news_headline($catid,$limit){
    $CI =& get_instance();
    $CI->db->select('id,title, title_alias, catid, cat_alias, sections_id, sections_alias, introtext, images_thumb');
    $CI->db->where('sections_id',$catid);
    $CI->db->order_by('created','desc');
    $CI->db->limit($limit);
    return $CI->db->get('content')->result();
}

$this->db->where_in('sections_id',$catid);
$this->db->order_by('ordering','asc');
$listcat = $this->db->get('sections')->result();

?>
<?php foreach($listcat as $cat):
      $list = get_list_news_headline($cat->sections_id,$max);
?>
<?php if(count($list) > 0){?>
<div class="headline">
    <h3 class="title-head"><?php echo anchor('content/sections/'.$list[0]->sections_alias.'-'.$list[0]->sections_id,$cat->sections_title)?></h3>
    <div class="box-headline">
        <div class="box-top">
            <?php if($list[0]->images_thumb != ''){?>
            <div class="img">
                <img src="<?php echo base_url().$list[0]->images_thumb?>" alt="">
            </div>
            <?php }?>
            <h3><?php echo anchor('content/article/'.$list[0]->title_alias.'-'.$list[0]->id,$list[0]->title)?></h3>
            <div><?php echo $list[0]->introtext?></div>
        </div>
        <ul>
            <?php for($i=1 ; $i < count($list); $i++){
            $rs = $list[$i];
            ?>
            <li><?php echo anchor('content/article/'.$rs->title_alias.'-'.$rs->id,$rs->title)?></li>
            <?php }?>
        </ul>
    </div>
</div>
<?php }?>
<?php endforeach;?>
