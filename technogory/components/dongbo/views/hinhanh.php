
<div class="process">
    <div class="percent">
        <div class="dr">0%</div>
    </div>
</div>
<div>Xử lý được <span id="offset"></span>/<span id="total"></span> bản ghi</div>
 
<div id="loading"></div>
<style>
.percent{
    background: #CCC;
}
.dr{
    background: #FF0000;
}
</style>
<?=$this->session->userdata('begin')?>
<script type="text/javascript">
$(function(){
    process(); 
});
function process()
{
    $.get(site_url+'dongbo/hinhanh/process', function (msg) {
        //if(!isNaN(msg.begin))
        //{
            //if(msg.begin !='' && msg.begin < 100)
            //{ 
            if(msg.total == 40){
                return false;
            }
                $('.percent').css('width',msg.begin+'%');
                $("#offset").html(msg.offset);
                $("#total").html(msg.total);
                $('.dr').html((msg.begin)+'%.').show('fast', function(){
                    process();
                });
            /*}else{

                $('.percent').css({width:'100%',color:'red'});
                $('.dr').css({left:'40%',color:'red'}).html('Hoàn thành');
                $("#offset").html(msg.total);
                $("#total").html(msg.total);               
            }*/
        //}
    },'json');
}
</script>
