<?
$uri = uri_string();
?>
<script>
    $(function() {
        var dates = $( "#ngay" ).datepicker({
            changeMonth: true,
            dateFormat: 'dd-mm-yy', 
            numberOfMonths: 1
        });
    });
    function go_search(){ 
        var key = $("#ngay").val();
        window.location.href = base_url + "account/view_history/<?php echo $user_id?>?date=" + key;
    }
</script>
<div style="margin-bottom: 10px;">Xem theo ngày <input type="text" id="ngay" value="<?=$key?>" > <input type="button" value="Xem" onclick="go_search();"></div>
<table class="admindata">
    <thead>
        <tr>
            <th class="head" colspan="8">
                Hiện có <?php echo $num?> lịch sử <span class="pages"><?php echo $pagination?></span>
            </th>
        </tr>
        <tr>
            <th style="width: 140px;">Modules</th>
            <th style="width: 70px;">Chức năng</th>
            <th>Thao tác</th>
            <th>ULR</th>
            <th style="width: 100px;">Thời gian</th>
            <th style="width: 70px;">IP</th>
        </tr>
    </thead>
    <?
    $k = 1;
    foreach($list as $rs):
    ?>
    <tr class="row<?=$k?>">
        <td style="color: #fd3e03;"><?=$this->account->get_phanquyen($rs->phanquyen_id)?></td>
        <td style="color: #0588c3;"><?=$this->account->get_chucnang($rs->function_id)?></td>
        <td><?=$rs->message?></td>
        <td><a href="<?=site_url($rs->url)?>" target="_blank"><?=$rs->url?></a></td>
        <td><?=date("H:i d/m/Y",$rs->date)?></td>
        <td><?=$rs->ip_address?></td>
    </tr>
    <?
    $k = 1 - $k;
    endforeach;
    ?>
    <tfoot>
        <td colspan="8">
            Hiện có <?php echo $num?> lịch sử <span class="pages"><?php echo $pagination?></span>
        </td>
    </tfoot>
</table>