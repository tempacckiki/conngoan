<?

$sections_url = ($sections_id != 0) ? '&sections_id='.$sections_id : '';
$cat_url = ($cat_id != 0) ? '&cat_id='.$cat_id:'';
$key_url = ($key != '') ? '&key='.$key:'';

?>
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="tuychon" style="width: 100%;">
    <tr>
        <td>
            Lọc <input type="text" name="key" id="key" value="<?=$key?>" class="w200">
            <input type="button" onclick="go_search()" name="bt_loc" value="Tìm">
            <input type="button" onclick="go_search_reset()" name="bt_loc" value="Làm lại">
        </td>
        <td align="right" class="w200">
            <select class="w200" onchange="window.open(this.value,'_self');" id="sections_id" id="sections_id">
                <option value="<?=site_url('content/listcontent/0/?option=true'.$key_url)?>">--Chọn chủ đề--</option>
                <?php foreach($listsections as $sec):?>
                <option value="<?=site_url('content/listcontent/0/?option=true&sections_id='.$sec->sections_id.$cat_url.$key_url)?>" <?php echo ($sections_id == $sec->sections_id)?'selected="selected"':'';?>><?php echo $sec->sections_title?></option>
                <?php endforeach;?>
            </select>
        </td>
        <td align="right" class="w200">
            <select class="w200" onchange="window.open(this.value,'_self');" name="cat_id" id="cat_id">
                <option value="<?=site_url('content/listcontent/0/?option=true'.$sections_url.$key_url)?>">--Chọn chủ đề con--</option>
                <?php foreach($listcategory as $cat):?>
                <option value="<?=site_url('content/listcontent/0/?option=true'.$sections_url.'&cat_id='.$cat->cat_id.$key_url)?>" <?php echo ($cat_id == $cat->cat_id)?'selected="selected"':'';?>><?php echo $cat->cat_title?></option>
                <?php endforeach;?>
            </select>
        </td>
    </tr>
</table>
<?
    $url = 'content/listcontent/0/?option=true'.$sections_url.$cat_url;
    $url_reset = $_SERVER['REQUEST_URI'];
    $url_reset = str_replace(end(explode('&',$_SERVER['REQUEST_URI'])),'',$_SERVER['REQUEST_URI']);
    
?>
<script type="text/javascript">
    function go_search(){ 
        var key = $("#key").val();
        window.location.href = base_url + "<?php echo $url?>&key=" + key;
    }
    function go_search_reset(){ 
        window.location.href = 'http://'+document.domain + "<?php echo $url_reset?>";
    }    
</script>
<?php echo form_open('content/dels',  array('id' => 'admindata'));?> 
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?php echo $num?> Bài viết <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('content/listcontent/0/id/asc','ID')?></th>
            <th><?php echo vnit_order('content/listcontent/0/title/asc','Tiêu đề')?></th>
            <th><?php echo vnit_order('content/listcontent/0/sections_id/asc','Chủ đề')?></th>
            <th><?php echo vnit_order('content/listcontent/0/catid/asc','Chủ đề con')?></th>
            <th style="width: 30px;">Link</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->id?>"></td>
        <td><?=$rs->id?></td>
        <td><?=$rs->title?></td>
        <td><?=$this->vdb->find_by_id('sections',array('sections_id'=>$rs->sections_id))->sections_title?></td>
        <td><?
        $catname =$this->vdb->find_by_id('category',array('cat_id'=>$rs->catid));
        echo ($catname)?$catname->cat_title:''?></td>
        <td class="copy" id="<?=$rs->id?>" align="center">
            <img src="<?=base_url()?>templates/images/page_white_copy.png"  alt="copy to clipboard" title="Copy to Clipboard">
            <input class="w200" id="link_<?=$rs->id?>" type="hidden" value="content/<?=$rs->sections_alias?>/<?php echo $rs->cat_alias?>/<?php echo $rs->title_alias?>-<?php echo $rs->id?>">
        </td>         
        <td align="center">
            <?php echo icon_edit('content/edit/'.$rs->id)?>
            <span id="publish<?php echo $rs->id?>"><?php echo icon_active("'content'","'id'",$rs->id,$rs->published)?></span>
            <?php echo icon_del('content/del/'.$rs->id.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
            <tfoot>
                <td colspan="8">
                    Hiện có <?php echo $num?> Bài viết <span class="pages"><?php echo $pagination?></span>
                </td>
            </tfoot>    
</table>
<?php echo form_close()?>
