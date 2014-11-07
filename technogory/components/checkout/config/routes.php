<?php
$route['thanh-toan/gio-hang'] 				= 'checkout/step_one';   
$route['thanh-toan/thong-tin-giao-nhan'] 	= 'checkout/step_two';   
$route['thanh-toan/giao-hang-thanh-toan'] 	= 'checkout/step_three';   
$route['thanh-toan/xac-nhan-don-hang'] 		= 'checkout/step_four';   
$route['thanh-toan/hoan-tat-don-hang'] 		= 'checkout/step_five';   
$route['thanh-toan/mua-hang-thanh-cong'] 	= 'checkout/step_six';   
$route['thanh-toan/xac-nhan-don-hang/(:any)'] = 'checkout/active_order/$1';   
?>
