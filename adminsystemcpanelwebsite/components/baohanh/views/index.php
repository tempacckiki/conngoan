
<input type="hidden" name="page" value="<?=$this->uri->segment(4)?>">
<input type="hidden" name="catid" value="<?=$this->uri->segment(3)?>">
<?$uri3 = (int)$this->uri->segment(3)?>
<?$uri4 = (int)$this->uri->segment(4)?>
<table class="tuychon" style="width: 100%;">
    <tr>
        <td>
            Lọc <input type="text" name="key" id="key" value="<?=$key?>" class="w200">
            <input type="button" onclick="go_search()" name="bt_loc" value="Tìm">
            <input type="button" onclick="go_search_reset()" name="bt_loc" value="Làm lại">
        </td>

    </tr>
</table>
<?
    $url = 'baohanh/ds/0/?option=true';
    $url_reset = $_SERVER['REQUEST_URI'];
    $url_reset = str_replace(end(explode('&',$_SERVER['REQUEST_URI'])),'',$_SERVER['REQUEST_URI']);
    
?>
<script type="text/javascript">
    function go_search(){ 
        var key = $("#key").val();
        window.location.href = base_url + "<?php echo $url?>&key=" + key;
    }
    function go_search_reset(){ 
        window.location.href = "<?php echo site_url('baohanh/ds/0/?option=true');?>";
    }    
</script>
<?php echo form_open('baohanh/dels',  array('id' => 'admindata'));?> 
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="4">
                Hiện có <?=$num?> nhà sản xuất <span class="pages"><?=$pagination?></span>
            </th>
        </tr>
        <tr>
            <th class="checkbox"><input type="checkbox" name="sa" id="sa" onclick="check_chose('sa', 'ar_id[]', 'admindata')"></th>
            <th class="id"><?=vnit_order('baohanh/ds/0/manufactureid/asc','ID')?></th>
            <th><?=vnit_order('baohanh/ds/0/name/asc','Tên nhà sản xuất')?></th>
            <th class="publish">Chức năng</th>
        </tr>        
    </thead>
    <?
    $k=1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td align="center"><input  type="checkbox" name="ar_id[]" value="<?=$rs->manufactureid?>"></td>
        <td><?=$rs->manufactureid?></td>
        <td><?=$rs->name?></td>

        <td align="center">
            <?=icon_add1('baohanh/dsdiembaohang/'.$rs->manufactureid)?>
     
        </td>
    </tr>       
    <?
    $k=1-$k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="4">
            Hiện có <?=$num?> nhà sản xuất <span class="pages"><?=$pagination?></span>
        </td>
    </tfoot>    
</table>
<?php echo form_close()?>
