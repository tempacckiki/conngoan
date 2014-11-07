<?php
function get_params($name,$params){
 parse_str($params, $output);
 return $output[$name];
}


