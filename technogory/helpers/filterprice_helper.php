<?php
function filter_price($catid){
    $CI = get_instance();
    $regions = $CI->session->userdata('fyi_regions');
    
    
    if($regions == 'miennam'){
        $CI->db->select_min('giaban_miennam');    
        $CI->db->where('catid',$catid);
        $price_min = $CI->db->get('shop_product')->row()->giaban_miennam;
        
        $CI->db->select_max('giaban_miennam');    
        $CI->db->where('catid',$catid);
        $price_max = $CI->db->get('shop_product')->row()->giaban_miennam;
    }else{
        $CI->db->select_min('giaban_mienbac');    
        $CI->db->where('catid',$catid);
        $price_min = $CI->db->get('shop_product')->row()->giaban_mienbac;
        
        $CI->db->select_max('giaban_mienbac');    
        $CI->db->where('catid',$catid);
        $price_max = $CI->db->get('shop_product')->row()->giaban_mienbac; 
    }
    //echo  $price_min.'<br />';
    //return  round($price_max / $price_min); 
    
  //Find Minimum and Maximum Values
$min    =    500000;//Minimum Price
$max    =    40000000;//Maximum Price
$numofRanges    =    5;
//Split the numbers  in to 5 price ranges
/*For eg
Price 20$ -----------200$
    200$-----------400$
    400$-----------600$
*/
$value    =    (float)($max/$numofRanges);
//Find the value to increment
$range    =    array();
$min_temp    =    $min;
for($i=1;$i<=$numofRanges;$i++)
{
    $temp    =    $min + $value;   
    if($temp > $max)
    {
        $temp    =    $max;
    }
    if($min_temp != $min)
    {
        $min_temp    =    round($min_temp);
    }
    if($temp != $max)
    {
        $temp     =    round($temp);
    }
    $range["$min_temp"]    =    $temp;
    $min_temp    =    $temp;
    $min_temp    += 500000;
    $min    =    $temp;
}
$str    =    '';
foreach($range as $min=>$max)
{
    $str    .=    $min."\$--------------".$max."\$";
    $str    .=    "<br/>";
}
echo "<h3>Price Ranges</h3>";
echo $str; 
    /*
    $split = 5;
    $minprice =$price_min;
    $maxprice =$price_max;

    $price_split = (ceil($maxprice / $split));

    $c=0;
    while ($c != $split+1) {
    if ($c == 0) {
    $minprice = $minprice;
    } else {
    $minprice = ($minprice + $price_split);
    }
    if ($minprice > $maxprice) {
    $minprice = ($maxprice);
    }
    print "$minprice<br />";
    ++$c;
    }
    */
    
array(0, 10, 20, 30, 40, 50, 60, 70, 80, 90, 100);
foreach (range(0, 100, 10) as $number) {
    echo $number;
}
}  

?>
