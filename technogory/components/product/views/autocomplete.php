<?if(count($list) > 0){?>
<ul class="search_list">
<li class="key"><a href="<?=site_url('search/result')?>?p=<?=$productkey?>">Tìm kiếm với <?=$productkey?></a></li>
<?php 

foreach($list as $rs):
$productname = str_replace($productkey, '<b>'.$productkey.'</b>',$rs->productname)  ;
?>
<li>
    <a href="<?=site_url('san-pham/'.$rs->producturl.'-'.$rs->productid)?>" title="<?=$rs->productname?>">
        <img src="<?=base_url_static()?>alobuy0862779988/0862779988product/40/<?=$rs->productimg?>" alt="<?=$rs->productname?>">
        <?=$productname?>
    </a>
</li>
<?endforeach;?>
</ul>
<div class="pages"><?=$pagination?></div>
<?}else{?>
    <div align="center">Không tìm thấy sản phẩm</div>
<?}?>
<script type="text/javascript">
function autosearch_page(page_no){ 
    productkey = $("#productkey").val();
    $.post(site_url+"product/autosearch",{'page_no':page_no,'productkey':productkey},function(data){
        $("#search_result").html(data);                                      
    });
}
</script>
