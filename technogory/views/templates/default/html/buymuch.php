<!-- 
<div class="box-prod-same">
<?if(count($spmuanhieu) > 0){?>
    <p class="title-de">có thể bạn quan tâm</p>
    
    <?foreach($spmuanhieu as $val):
    $tangpham = $this->product->gettangpham($val->productid);
    $giaban = $val->giaban; 
    ?>
        <div class="sp_lienquan vnit_tip" id="tip_<?=$val->productid?>">
            <div class="img">
                <a href="<?=site_url('product/'.$val->producturl.'/'.$val->productid)?>" title="<?=$val->productname?>">
                    <img src="<?=base_url_img()?>data/img_product/80/<?=$val->productimg?>" alt="<?=$val->productname?>">
                </a>
            </div>
            <p class="productname">
                <a href="<?=site_url('product/'.$val->producturl.'/'.$val->productid)?>" title="<?=$val->productname?>">
                    <?=$val->productname?>
                </a>
            </p>
            <p class="price"><?=number_format($giaban,0,'.','.')?> vnd</p>
            <div id="vtip">
                <div class="v-title">
                    <p><?=$rs->productname?></p>
                    <p class="giaban">Giá bán: <span><?=number_format($giaban,0,'.','.')?></span> VND</p>
                </div>
                <div class="vcontent">
               <?if($tangpham){?>
                    <div class="v-discount">
                        <div class="tangpham">Khuyến mãi</div>
                        <div class="tangpham_title"><?=$tangpham->name?></div>
                    </div>
                <?}?>
                <div class="tinhnang">Tính năng nổi bật</div>
                    <ul class="tinhnangnoibat">
                        <?=addli($rs->tinhnang)?>
                    </ul>
                </div>
            </div>
        </div>
    <?endforeach;?>
    
    <?}?>
</div>
 -->