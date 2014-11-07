<div class="content">
    <ul>
        <?php foreach($list as $rs):?>
        <li>
            <?php if($rs->images_thumb != ''){?>
            <div class="img">
                <img src="<?php echo base_url().$rs->images_thumb?>" alt="">
            </div>
            <?php }?>
            <h3 class="title"><?php echo anchor('content/'.$rs->sections_alias.'/'.$rs->cat_alias.'/'.$rs->title_alias.'-'.$rs->id,$rs->title)?></h3>
            <div><?php echo $rs->introtext?></div>
        </li>
        <?endforeach;?>
    </ul>
</div>
<?php if($pagination){?>
<div class="pages"><?php echo $pagination?></div>
<div class="current-page">Trang <?php echo $current?> trong tổng số <?php echo $total_page?> </div>
<?php }?>

