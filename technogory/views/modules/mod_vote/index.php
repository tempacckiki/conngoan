<?
$this->db->where('published',1);
$poll = $this->db->get('poll')->row();
?>
<?if($poll){
    $this->db->where('pid',$poll->pid);
    $this->db->order_by('id','asc');
    $list = $this->db->get('poll_rows')->result();
    ?>

        <div class="poll-question"><?=$poll->question?></div>
        <?
        $i = 1;
        foreach($list as $rs):?>
        <div><input <?echo ($i == 1)?'checked="checked"':''?> type="radio" id="row_id" name="row_id" value="<?=$rs->id?>"><?=$rs->title?></div>
        <?
        $i ++;
        endforeach;?>
        <div align="center">
            <input type="hidden" class="button" name="pid" id="pid" value="<?=$poll->pid?>">
            <input type="button" class="button" name="binhchon" onclick="add_poll()" value="Bình chọn">
            <input type="button" class="button" name="binhchon" onclick="result()" value="Kết quả">

        </div>

<script type="text/javascript">
 function add_poll(){
    var row_id = $('input[name=row_id]:checked').val();
    var pid = $("#pid").val();
    var poll_url = base_url+'poll/show_poll/'+pid+'/'+row_id;
    $.colorbox({href:poll_url});
 }
 
 function result(){
    var pid = $("#pid").val();
    var poll_url = base_url+'poll/show_result/'+pid
    $.colorbox({href:poll_url});
 }
</script>
<?}?>
