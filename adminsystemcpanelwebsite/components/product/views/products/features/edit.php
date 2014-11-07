<table class="form">
<?foreach($list_attr as $val):
$list_fea  = $this->shop->get_item_features($val->feature_id);
?>
    <tr>
        <td class="label" colspan="2" style="text-align: left;"><?=$val->description?></td>
    </tr>
    <?foreach($list_fea as $val1):
    $variant = $this->vdb->find_by_id('shop_features_values',array('product_id'=>$productid,'feature_id'=>$val1->feature_id));
    if($variant){
        $variant_id = $variant->variant_id;
        $variant_name = $variant->value;
    }else{
        $variant_id = 0;
        $variant_name = '';
    }
    ?>
    <tr>
        <td class="label" style="font-weight: 100;"><?=$val1->description?></td>
        <td>
            <?=build_fea($val1->feature_id,$val1->feature_type,$variant_id,$variant_name)?>
        </td>
    </tr>
    <?endforeach;?>
<?endforeach;?>
</table>