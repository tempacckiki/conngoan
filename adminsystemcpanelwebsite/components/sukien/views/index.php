<?
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
    </tr>
</table>
<?
    $url = 'sukien/ds/0/?option=true';
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
<?php echo form_open('sukien/dels',  array('id' => 'admindata'));?> 
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?php echo $num?> Sự kiện <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?php echo vnit_order('sukien/ds/0/newsid/asc','ID')?></th>
            <th><?php echo vnit_order('sukien/ds/0/title/asc','Tiêu đề')?></th>
            <th style="width: 100px;"><?php echo vnit_order('sukien/ds/0/created/asc','Ngày đăng')?></th>
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
        <td><?=date('H:i d/m/Y',$rs->created)?></td>
        <td align="center">
            <?php echo icon_edit('sukien/edit/'.$rs->newsid)?>
            <span id="publish<?php echo $rs->newsid?>"><?php echo icon_active("'events'","'newsid'",$rs->newsid,$rs->published,'sukien/published')?></span>
            <?php echo icon_del('sukien/del/'.$rs->newsid.'/'.(int)$this->uri->segment(4))?>        
        </td>
    </tr>       
    <?php
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="8">
            Hiện có <?php echo $num?> Sự kiện <span class="pages"><?php echo $pagination?></span>
        </td>
    </tfoot>    
</table>
<?php echo form_close()?>
