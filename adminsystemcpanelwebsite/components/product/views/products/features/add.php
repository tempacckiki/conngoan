<table class="form">
<?foreach($list_attr as $val):
$list_fea  = $this->shop->get_item_features($val->feature_id);
?>
    <tr>
        <td class="label" colspan="2" style="text-align: left;"><?=$val->description?></td>
    </tr>
    <?foreach($list_fea as $val1):?>
    <tr>
        <td class="label" style="font-weight: 100;"><?=$val1->description?></td>
        <td>
            <?=build_fea($val1->feature_id,$val1->feature_type)?>
        </td>
    </tr>
    <?endforeach;?>
<?endforeach;?>
</table>