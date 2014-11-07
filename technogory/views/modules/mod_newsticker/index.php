<script type="text/javascript" src="<?=base_url()?>site/views/modules/mod_newsticker/esset/jquery.ticker.js" charset="UTF-8"></script>
<script type="text/javascript">
$(document).ready(function() {
    var options = {
         newsList: "ul.news-ticker",
         startDelay: 20,
         tickerRate: 30,
         controls: false,
         ownControls: false,
         stopOnHover: false,
         resumeOffHover: true
    }
    $().newsTicker(options);
});
</script>
<?
$this->db->where('published',1);
$this->db->order_by('created','desc');
$this->db->limit(5);
$list = $this->db->get('content')->result();
?>
<ul class="news-ticker">
    <?php foreach($list as $rs):?>
    <li><a href="<?=site_url('content/article/'.$rs->title_alias.'-'.$rs->id)?>"><?=$rs->title?></a></li>
    <?php endforeach;?>
</ul>