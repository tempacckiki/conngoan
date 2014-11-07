<div class="pathway">
    <ul>
        <li><a href="<?=base_url()?>" class="homepage">Trang chủ</a></li>
        
        <li><a href="#">So sánh sản phẩm</a></li> 
    </ul>
</div>
<?
$w = number_format(90/ count($list),0,'.','.');
?>
<table class="thuoctinh" style="width: 100%; margin-top: 10px;">
    <tr>
        <td>Thông tin</td>
        <?foreach($list as $rs):
            $giathitruong = $rs->giathitruong;
            $giaban = $rs->giaban;
            $giamgiam = $rs->giamgia;
            $phantram = $rs->phantram;
            $tinhtrang = $rs->tinhtrang;
            $tinhtrang_text = $rs->tinhtrang_text;

        ?>
        <td width="<?=$w?>%" valign="top">
            <div align="right">
            <?
            $uri = str_replace(';'.$rs->productid,'',$_SERVER["REQUEST_URI"]);
            ?>
            <a href="<?echo 'http://'.$_SERVER['HTTP_HOST'].$uri;?>">
                <img src="<?=base_url()?>site/templates/fyi/images/xoasanpham.png" alt="">
            </a>
            </div>
            <div align="center"><img src="<?=base_url_img()?>data/img_product/200/<?=$rs->productimg?>" width="140"></div>
            <div align="center" class="compare_name"><a href="<?=site_url('product/'.$rs->producturl.'-'.$rs->productid)?>"><?=$rs->productname?></a></div>
            <div class="compare_price"><b>Giá bán: <?=number_format($giaban,0,'.','.')?> VND</b></div>
            <div class="compare_baohanh">Bảo hành: <?=$rs->baohanh?> tháng</div>
            <div class="compare_baohanh" align="center"><a style="margin-left: 35%" class="addtocart buynow" id="product_<?=$rs->productid?>" href="javascript:;"></a></div>
        </td>
        <?endforeach;?>

    </tr>
    <tr>
        <td>Thông số kỹ thuật:</td>
        <?
        foreach($list as $rs):?> 
        <td id="thongsokythuat"><?=$rs->thongsokythuat?></td>

        <?endforeach;?>
    </tr>
    <!--
    <?foreach($list_type as $val):
    $list_fea  = $this->compare->get_item_features($val->feature_id);
    $total = count($list_fea);

    ?>
    <tr>
        <td rowspan="<?=$total + 1?>" class="label" style="width: 10%;"><?=$val->description?></td>
    </tr>
    <?foreach($list_fea as $val1):?> 
    <tr>
        
        <td class="label_tip"><?=$val1->description?></td>
        <?foreach($list as $rs):
        $variant = $this->vdb->find_by_id('shop_features_values',array('product_id'=>$rs->productid,'feature_id'=>$val1->feature_id));
        if($variant){
            $variant_id = $variant->variant_id;
            $variant_name = $variant->value;
        }else{
            $variant_id = 0;
            $variant_name = '';
        }
        if($variant_id != 0){
            $variant_name = $this->vdb->find_by_id('shop_feature_variant_descriptions',array('variant_id'=>$variant_id))->variant;
        }
        ?>
        <td><?=$variant_name?></td>
        <?endforeach;?> 

    </tr>
    <?endforeach;?>  
    <?endforeach;?>
    -->
</table>

<script>
$(document).ready(function(){ 
   $("td#thongsokythuat td").each(function(){
        $(this).removeAttr('width'); 
        $(this).removeAttr('style');
        $(this).css({
           'text-align':'left',
           'border':'1px solid #C2C4C4',
           'color':'#333'
        });
   });
   $("td#thongsokythuat table").each(function(){
        $(this).removeAttr('width'); 
         
        $(this).removeAttr('style');
        $(this).css({
           'border-collapse':'collapse',
           'border-spacing':'0'
        }); 
   });
});
</script>

