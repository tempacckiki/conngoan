<script type="text/javascript">
document.write('<link type="text/css" rel="stylesheet" href="<?php echo base_url()?>site/views/modules/mod_topnews/topnews.css" media="screen" />');
</script>
<?php
//$val = $this->vdb->find_by_list('')
$this->db->where('images !=','');
$this->db->order_by('created','desc');
$this->db->limit(10);
$list = $this->db->get('content')->result();
?>

<div class="topnews">
<?php if(count($list)> 0){?>
    <div class="topleft">
        <div><h3 class="title"><?php echo anchor('content/article/'.$list[0]->title_alias.'-'.$list[0]->id,$list[0]->title)?></h3></div>
        <?php if($list[0]->images !=''){?>
        <div class="img"><img src="<?php echo base_url().$list[0]->images?>" alt=""></div>
        <?php }?>
        <div style="text-align: justify;"><?php echo $list[0]->introtext?></div>
    </div>
    <div class="topright">
        <h3 class="title">Tin mới</h3>
        <div class="listnews">
            <ul>
            <?for($i=1; $i < count($list); $i++){
                $rs = $list[$i];
            ?>
                <li><?php echo anchor('content/article/'.$rs->title_alias.'-'.$rs->id,$rs->title)?></li>
            <?php }?>
            </ul>
        </div>
    </div>
<?}else{ echo 'Không tìm thấy tin';}?>
</div>
