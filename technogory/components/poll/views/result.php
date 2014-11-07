<div class="poll-title"><?=$poll->question?></div>
<?if(isset($msg)){?>
    <div class="show_notice" style="margin: 0 10px;text-align: center;"><?=$msg?></div>
<?}?>
<table class="poll">
    <?foreach($list as $rs):
    ?>
      <tr>
        <td class="label"><?=$rs->title?></td>
        <td style="width: 200px;" class="proce">
            <div class="process_bar">
                <div class="hits"><?=$rs->hitstotal?></div>
                <div class="bar" style="width: <?=round(($rs->hitstotal / $poll->total) * 100,1)?>%;"></div>
            </div>
        </td>
        <td class="percent"><?=round(($rs->hitstotal / $poll->total) * 100,1)?> %</td>
    </tr>
    
    <?endforeach;?>
</table>

<div class="poll_static">Có tổng <b><?=$poll->total?></b> lượt bình chọn. Lần cuối lúc: <?=($poll->hit_date!=0)?date('H:i:s d-m-Y',$poll->hit_date):'N/A'?></div>
<script type="text/javascript">
$(document).ready(function() {
    $(".poll").find('.bar').each(function(){
        var bar_width=$(this).css('width');
        $(this).css('width', '0').animate({ width: bar_width }, 1000);
    });
});
</script>