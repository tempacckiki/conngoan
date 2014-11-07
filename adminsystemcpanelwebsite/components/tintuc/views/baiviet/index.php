<?
$cat_url = ($cat_id != 0) ? '&cat_id='.$cat_id:'';
$key_url = ($key != '') ? '&key='.$key:'';
?>
<input type="hidden" name="page" value="<?=$this->uri->segment(3)?>">
<table class="tuychon" style="width: 100%;">
    <tr>
        <td colspan="">
            Lọc <input type="text" name="key" id="key" value="<?=$key?>" class="w200">
            <input type="button" onclick="go_search()" name="bt_loc" value="Tìm">
            <input type="button" onclick="go_search_reset()" name="bt_loc" value="Làm lại">
        </td>
        <td align="right" class="w200">
            <select class="w200" onchange="window.open(this.value,'_self');" name="cat_id" id="cat_id">
                <option value="<?=site_url('tintuc/baiviet/0/?option=true'.$key_url)?>">--Tất cả danh mục--</option>
                <?php foreach($listcat as $cat):?>
                <option value="<?=site_url('tintuc/baiviet/0/?option=true&cat_id='.$cat->catid.$key_url)?>" <?php echo ($cat_id == $cat->catid)?'selected="selected"':'';?>><?php echo $cat->catname?></option>
                <?php endforeach;?>
            </select>
        </td>
    </tr>
</table>
<?
    $url = 'tintuc/baiviet/0/?option=true'.$cat_url;
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
<?php echo form_open('tintuc/dels',  array('id' => 'admindata'));?> 
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?php echo $num?> Bài viết <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('tintuc/baiviet/0/newsid/asc','ID')?></th>
            <th><?php echo vnit_order('tintuc/baiviet/0/title/asc','Tiêu đề')?></th>
            <th style="width: 150px;"><?php echo vnit_order('tintuc/baiviet/0/catid/asc','Danh mục')?></th>
            <th style="width: 30px;">Link</th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?php echo $rs->newsid?>"></td>
        <td><?=$rs->newsid?></td>
        <td><?=$rs->title?></td>
        <td><?=$this->vdb->find_by_id('news_cat',array('catid'=>$rs->catid))->catname?></td>
        <td class="copy" id="<?=$rs->newsid?>" align="center">
            <img src="<?=base_url()?>templates/images/page_white_copy.png"  alt="copy to clipboard" title="Copy to Clipboard">
            <input class="w200" id="link_<?=$rs->newsid?>" type="hidden" 
              value="<?=$this->config->item('base_url_site') . ('tin-tuc/' . $rs->caturl . '/' . $rs->title_alias . '-' . $rs->newsid . '.html');?>"
            >
        </td>         
        <td align="center">
            <?php echo icon_edit('tintuc/edit/'.$rs->newsid)?>
            <span id="publish<?php echo $rs->newsid?>"><?php echo icon_active("'news_detail'","'newsid'",$rs->newsid,$rs->published,'tintuc/publishednew')?></span>
            <?php echo icon_del('tintuc/del/'.$rs->newsid.'/'.(int)$this->uri->segment(4))?>        
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
