<h3 style="font-size : 13px;"><?=lang('search.result_key')?>: <?=$key?></h3>
<div id="result">
<?if(count($list) > 0){?>
<div class="content">
    <ul>
        <?php foreach($list as $rs):?>
        <li>
            <?php if($rs->images_thumb != ''){?>
            <div class="img">
                <img src="<?php echo base_url().$rs->images_thumb?>" alt="">
            </div>
            <?php }?>
            <h3 class="title"><?php echo anchor('content/'.$rs->sections_alias.'/'.$rs->cat_alias.'/'.$rs->title_alias.'-'.$rs->id,str_replace($key,'<span style="color:#FF0000">'.$key.'</span>',$rs->title))?></h3>
            <div><?php echo str_replace($key,'<span style="color:#FF0000">'.$key.'</span>',$rs->introtext)?></div>
        </li>
        <?endforeach;?>
    </ul>
</div>
<?php if($pagination){?>
<div class="pages"><?php echo $pagination?></div>
<div class="current-page">Trang <?php echo $current?> trong tổng số <?php echo $total_page?> </div>
<?php }?>
<?}else{?>
<div class="show_notice" style="text-align: center;">Không tìm thấy kết quả. Vui lòng thử lại</div>
<?}?>
</div>
<script type="text/javascript">
function go(page_no){ 
    var key = '<?=$key?>';
    $.post(base_url+"search/ajax_result",{'page_no':page_no,'key':key},function(data){
        $("#result").html(data);                                            
    });
}
</script>