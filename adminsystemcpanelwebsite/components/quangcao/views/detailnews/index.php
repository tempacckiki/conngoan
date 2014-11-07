<?php 
$catID   = $this->uri->segment('4');
?>
<?php echo form_open('quangcao/detailnews/dels',  array('id' => 'admindata'));?> 
<input type="hidden" name="page" value="<?=$catid?>">
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?=count($list)?> quảng cáo tin tức
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id">ID</th>
            <th class="id">ID News</th>
            <th>Hình ảnh</th>
            <th>Tên quảng cáo</th>
            <th style="width: 200px;">
                <select  onchange="window.open(this.value,'_self');" style="width: 200px;">
                    
                </select>
            </th>
            <th style="width: 70px;">Sắp xếp</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><?php echo $rs->id_news;?></td>
        <td><img src="<?php echo base_url_site();?>alobuy0862779988/adv/detailnews/<?php echo $rs->images;?>" width="90"></td>
        <td><?=$rs->name?></td>
        <td><?=$this->vdb->find_by_id('news_detail',array('newsid'=>$rs->id_news))->title?></td>
        <td align="center"><?=$rs->ordering?></td>
        <td align="center">
            <?=icon_edit('quangcao/detailnews/edit/'.$rs->id.'/'.$rs->id_news)?>
            <span id="publish<?=$rs->id?>"><?=icon_active("'detailnews'","'id'",$rs->id,$rs->published,'quangcao/detailnews/published')?></span>    
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="8">
            Hiện có <?=count($list)?> quảng cáo tin tức
        </td>
    </tfoot>    
</table>
<?=form_close()?>