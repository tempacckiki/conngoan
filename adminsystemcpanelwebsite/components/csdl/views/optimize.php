<?php
set_time_limit( 100 );

$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$start = $time;
$this->load->dbutil();
$list = $this->db->query("SHOW TABLE STATUS")->result();   
foreach($list as $rs):
;
if ($this->dbutil->optimize_table($rs->Name))
{
    echo '<div>'.$rs->Name.': Success!</div>';
}else{
    echo '<div>'.$rs->Name.': Error</div>';
} 
?>

<?php
endforeach;
$time = microtime();
$time = explode(' ', $time);
$time = $time[1] + $time[0];
$finish = $time;
$total_time = round(($finish - $start), 6);
echo 'Parsed in ' . $total_time . ' secs' . "\n\n";
?>
