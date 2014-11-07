<?=form_open(uri_string(),  array('id' => 'admindata'))?>
<table class="form">
    <thead>
    <tr>
        <td class="label">Câu hỏi</td>
        <td><input type="text" class="w500" name="question" value="<?=$rs->question?>"></td>
    </tr>
    <tr>
        <td class="label">Tùy chọn</td>
        <td>
            <a href="javascript:;" id="add">Thêm trả lời</a> |
            <a href="javascript:;" id="remove">Xóa trả lời</a>
        </td>
    </tr>
    </thead>
    <tbody>
    <?
    $i=1;
    foreach($list_rows as $val):?>
    <tr>
        <td class="label">Trả lời số <?=$i?></td>
        <td><input type="text" name="ar_value[<?=$val->id?>]" value="<?=$val->title?>" class="w400"></td>
    </tr>
    <?
    $i++;
    endforeach;?>
    </tbody>

</table>
<?=form_close();?>
<script type="text/javascript">
$(function() {
    var i = $('form#admindata tbody tr').size() + 1;
    $('a#add').click(function() {
        $('<tr><td class="label">Trả lời số '+i+'</td><td><input type="text" value="" class="w400" name="ar_value[]" /></td></tr>').appendTo('form#admindata tbody');
        i++;
    });

    $('a#remove').click(function() {
    if(i > <?=count($list_rows)+1?>) {
        $('form#admindata tbody tr:last').remove();
        i--; 
    }
    });

    $('a.reset').click(function() {
    while(i > 2) {
        $('input:last').remove();
        i--;
    }
    });
});
</script>
