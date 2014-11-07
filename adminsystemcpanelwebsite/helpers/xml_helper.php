<?php
function getParams_select($xml,$name,$default){
    $data = '<select name="param['.$name.']">';
    $i = 1;
    foreach($xml as $option){
        $select = ($option['value'] == $default)?'selected="selected"':'';
        $data .='<option value="'.$option['value'].'" '.$select.'>'.$option[0].'</option>';
        $i ++;
    }
    $data .='</select>';
    return  $data;
}
function getParams_radio($xml,$name,$default){
    $data = '';
    $i = 1;
    foreach($xml as $option){
        $check = ($option['value'] == $default)?'checked="checked"':'';
        $data .='<input type="radio" name="param['.$name.']" value="'.$option['value'].'" '.$check.'>'.$option[0];
        $i ++;
    }
    $data .='';
    return  $data;
}
function getParams_text($name = 'params',$default){
    $data ='<input type="text" name="param['.$name.']" value="'.$default.'">';
    return  $data;
}