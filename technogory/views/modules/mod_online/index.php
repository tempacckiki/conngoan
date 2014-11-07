<?php

    function getDigits( $number, $length=0 )
    {
        $strlen = strlen($number);
        
        $arr    =    array();
        $diff    =    $length -  $strlen;
        
        // Push Leading Zeros
        while ( $diff>0 ){
            array_push( $arr,0 );
            $diff--;
        }
        
        // For PHP 4.x
        $arrNumber    =    array();
        for ($i = 0; $i < $strlen; $i++) {
            $arrNumber[] = substr($number,$i,1);
        }
        
        // For PHP 5.x: $arrNumber    =    str_split( $number );
        
        $arr        =    array_merge( $arr,$arrNumber );
        
        return $arr;
    }
    /* ------------------------------------------------------------------------------------------------ */
    

    
    /*
    ** Show Digit Counter Image
    */
    /* ------------------------------------------------------------------------------------------------ */
    function showDigitImage( $digit_type="default", $digit )
    {    
        $path = base_url().'site/views/modules/mod_online/number'; 
        $ret    =    '<img src="'.$path.'/'.$digit_type.'/'.$digit.'.png"';
        $ret    .=    ' />';
        
        return $ret;
    }
    /* ------------------------------------------------------------------------------------------------ */    


  
  $this->db->where('c_type','total');
  $total = $this->db->get('counter_history')->row();
  
  $this->db->where('c_type','month');
  $month = $this->db->get('counter_history')->row();  
  
  $this->db->where('c_type','today');
  $today = $this->db->get('counter_history')->row(); 
  
  $this->db->where('c_type','isonline');
  $isonline = $this->db->get('counter_history')->row();     
?>
<div align="center">
<?php
    
    $path = base_url().'site/views/modules/mod_online/icon/';
    $digit_type  = get_params('number',$attr);
    $number_digits  = get_params('total_number',$attr);
    $arr = getDigits( $total->c_count,$number_digits );
    
    foreach ($arr as $digit){
        echo  showDigitImage( $digit_type, $digit );
    };
?>
</div> 
<table style="width: 100%;">
    <tr>
        <td style="width: 20px;"><img src="<?php echo $path.'vall.png'?>" alt=""></td>
        <td><?=lang('counter.online')?></td>
        <td class="cufon" align="right"><?php echo $isonline->c_count?></td>
    </tr>
    <tr>
        <td><img src="<?php echo $path.'vtoday.png'?>" alt=""></td> 
        <td><?=lang('counter.today')?></td>
        <td align="right" class="cufon"><?php echo $today->c_count?></td>
    </tr>
    <tr>
        <td><img src="<?php echo $path.'vmonth.png'?>" alt=""></td>
        <td><?=lang('counter.month')?></td>
        <td align="right" class="cufon"><?php echo $month->c_count?></td>
    </tr>
    <tr>
        <td><img src="<?php echo $path.'vweek.png'?>" alt=""></td>
        <td><?=lang('counter.total')?></td>
        <td align="right" class="cufon"><?php echo $total->c_count?></td>
    </tr>    
</table>
