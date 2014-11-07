<?php 
$route['tao-tai-khoan'] = 'account/openid/create_account_order';  
$route['dang-ky'] 		= 'account/openid/connectRegister'; 
$route['kich-hoat-tai-khoan/(:any)'] = 'account/openid/active/$1';
//$route['login'] = 'account/openid/login_fyi'; 
$route['dang-nhap'] 			= 'account/openid/login_fyi'; 
$route['thoat'] 				= 'account/openid/sign_out'; 
$route['u/thong-tin-tai-khoan'] = 'account/openid/change_info'; 
$route['u/doi-mat-khau'] 		= 'account/openid/change_pass'; 
$route['u/doi-hinh-dai-dien'] 	= 'account/openid/change_avatar'; 
$route['u/quen-mat-khau'] 		= 'account/openid/find_pass';

$route['giao-dich/don-hang'] = 'account/cart/listcart';
$route['giao-dich/don-hang/(:any)'] = 'account/cart/listcart/$1';
$route['giao-dich/thong-tin-don-hang/(:any)'] = 'account/cart/cartdetail/$1';
$route['giao-dich/xoa-don-hang/(:any)'] = 'account/cart/del/$1';  
$route['giao-dich/thong-bao-chuyen-khoan'] = 'account/cart/message_tranfer';  
?>
