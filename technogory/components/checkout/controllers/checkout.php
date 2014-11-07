<?php
class checkout extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        //load lai database
        $this->db = $this->load->database('default', TRUE);
        $this->pre_message = "";
        $this->load->model('checkout_model','checkout');
        $this->load->model('cart_model','vnitcart');
        $this->user_id = $this->session->userdata('user_id');
       
        $js_array = array(
        array(base_url().'technogory/templates/default/js/checkout.js')
        );
        $this->esset->js($js_array);
        
        $this->session_id = $this->session->userdata('session_id');
    }
    function thanhtoan(){
        redirect('checkout/step_one');
    }
  
    function view_cart(){
        $this->form_validation->set_rules('step','','');
        if($this->form_validation->run()){
          $ar_id = $this->input->post('ar_id');
          for($i = 0; $i < sizeof($ar_id) ; $i++){
              if($ar_id[$i]){
                  $vdata['s_qty'] = $this->input->post('qty_'.$ar_id[$i]);
                  $del_id = $this->input->post('del_id_'.$ar_id[$i]);
                  if($vdata['s_qty'] == 0 || $del_id){
                      $this->vdb->delete('shop_cart_detail',array('id'=>$ar_id[$i]));
                  }else{
                      $this->vdb->update('shop_cart_detail',$vdata,array('id'=>$ar_id[$i]));
                  }
              }
          }
          $this->session->set_flashdata('message','Cập nhật giỏ hàng thành công');
          redirect('checkout/view_cart');
        }else{
          $data['title'] = 'Giỏ hàng';
          $this->link[0] = 'Giở hàng';
          $data['list'] = $this->vnitcart->get_list_cart();
          $this->_templates['page'] = 'view_cart';
          $this->templates->load($this->_templates['page'],$data,'detail');
        }
    }
    
    /*-------------------------------+
     * step one
     +------------------------------*/
    function step_one(){
        $this->form_validation->set_rules('step','','');
        if($this->form_validation->run()){
          $ar_id = $this->input->post('ar_id');
          for($i = 0; $i < sizeof($ar_id) ; $i++){
              if($ar_id[$i]){
                  $vdata['s_qty'] = $this->input->post('qty_'.$ar_id[$i]);
                  $vdata['s_color'] = $this->input->post('icolor_'.$ar_id[$i]);
                  $del_id = $this->input->post('del_id_'.$ar_id[$i]);
                  if($vdata['s_qty'] == 0 || $del_id){
                      $this->vdb->delete('shop_cart_detail',array('id'=>$ar_id[$i]));
                  }else{
                      $this->vdb->update('shop_cart_detail',$vdata,array('id'=>$ar_id[$i]));
                  }
              }
          }
          $this->session->set_flashdata('message','Cập nhật giỏ hàng thành công');
          redirect('thanh-toan/gio-hang');
        }else{
          $data['title'] = 'Đơn hàng';
          $this->link['0'] = 'Thanh toán:checkout/step_one';
          $this->link['1'] = 'Thông tin đơn hàng';
          //set top link
          $data['top_link']	= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="javascript:;" itemprop="url"><span itemprop="title">Thông tin giỏ hàng</span></a></div>';
          
          $data['list'] = $this->vnitcart->get_list_cart();          
          $data['message'] = $this->pre_message;
          
          //***load templates ************************
          $this->_templates['page'] = 'step_one';
          $this->templates->load($this->_templates['page'],$data,'detail');
        }

    }
    
    function remove(){
        $id = $this->uri->segment(3);
        $this->db->where('session_id',$this->session_id);
        $this->db->where('id',$id);
        $row = $this->db->get('shop_cart_detail')->row();
        if($row){
            $this->db->where('id',$id);
            $this->db->delete('shop_cart_detail');
            $this->session->set_flashdata('message','Xóa sản phẩm khỏi giỏ hàng thành công');
        }else{
            $this->session->set_flashdata('message','Sản phẩm không tồn tại trong đơn hàng của bạn');
            
        }
        redirect('thanh-toan/gio-hang');
    }
  	/*
  	 * Method Login
  	 * 
  	 */
    function login(){
    	//set title
    	$data['title'] 		= 'Đơn hàng';
    	
    	
    	$data['message'] = $this->pre_message;
    	//** load templates ****************
    	$this->_templates['page'] = 'login';
    	$this->templates->load($this->_templates['page'],$data,'detail');
    }
    /**
     *@Method  step_two
     *
     */
    function step_two(){
        $data['title'] 		= 'Đơn hàng';
       
       
        $this->link['0'] 	= 'Thanh toán:checkout/step_one';
        $this->link['1'] 	= 'Địa chỉ giao nhận';      
        $data['ship'] 		= $this->vnitcart->check_cookie_cart();
        $data['list'] 		= $this->vnitcart->get_list_cart();
        $data['listcity'] 	= $this->vnitcart->get_list_city();
        
        //get list 
        $data['listshiping'] = $this->vnitcart->get_list_shipping();
        
		//get list payment 
        $data['listpayment'] = $this->vnitcart->get_list_payment($data['ship']->shipping_id);
        
        
        //get shopcart
        $data['rs'] = $this->vdb->find_by_id('shop_cart',array('session_id'=>cookie_mycart()));
        //set top link
        $data['top_link']	= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="javascript:;" itemprop="url"><span itemprop="title">Thanh toán</span></a></div>';
        
        
        /*if(!$data['rs']){
          redirect('thanh-toan/gio-hang');
        } */
        if($this->vcart->total_price() <= 0){
          redirect('checkout/step_one');
        }
        $this->form_validation->set_rules('fullname','Họ và tên','trim|required');
        /* $this->form_validation->set_rules('address','Địa chỉ','trim|required');
        $this->form_validation->set_rules('city_id','Tỉnh, Thành phố','trim|required');
        $this->form_validation->set_rules('districts_id','Quận, Huyện','trim|required');
        $this->form_validation->set_rules('phone','Điện thoại','trim|required');
        $this->form_validation->set_rules('email','Email','trim|required'); */

        if($this->form_validation->run() == false){
          //$this->pre_message = validation_errors();
        }else{
          if($this->vnitcart->save_cart()){
             // $this->session->set_flashdata('message','Cập nhật địa chỉ giao nhận thành công');
              redirect('thanh-toan/hoan-tat-don-hang');
          }
        }
        $data['message'] = $this->pre_message;
        //** load templates ****************
        $this->_templates['page'] = 'step_two';
        $this->templates->load($this->_templates['page'],$data,'detail');
    }
  
    function step_three(){
        $data['title'] = 'Đơn hàng';
        $this->link['0'] 		= 'Thanh toán:checkout/step_one';
        $this->link['1'] 		= 'Hình thức thanh toán';       
        $data['rs'] 			= $this->vnitcart->check_cookie_cart();
        $data['list_discount'] 	= $this->vnitcart->get_list_cart_discount();
        $data['list'] 			= $this->vnitcart->get_listproduct();
        
        if(!$data['rs']){
          redirect('thanh-toan/gio-hang');
        }
        if($this->vcart->total_price() <= 0){
          redirect('checkout/step_one');
        }
        
        //set top link
        $data['top_link']	= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="javascript:;" itemprop="url"><span itemprop="title">Thanh toán</span></a></div>';
        
        
        $data['list'] = $this->vnitcart->get_list_cart();
        $data['listpayment'] = $this->vnitcart->get_list_payment($data['rs']->shipping_id);
        $data['listshiping'] = $this->vnitcart->get_list_shipping();
        $this->form_validation->set_rules('payment_id','Hình thức thanh toán','trim|required');
        $this->form_validation->set_rules('shipping_id','Phương thức vận chuyển','trim|required');
        if($this->form_validation->run() == false){
          $this->pre_message = validation_errors();
        }else{                                                                                                                    
          if($this->vnitcart->save_buoc3()){
             // $this->session->set_flashdata('message','Cập nhật cách giao hàng và Thanh toán thành công');
              redirect('thanh-toan/hoan-tat-don-hang');
          }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'step_three';
        $this->templates->load($this->_templates['page'],$data,'detail');
    }
  
    
  
    function step_five(){
        $data['title'] = 'Hoàn tất thanh toán';
        $data['rs'] = $this->vnitcart->check_cookie_cart();
        if(!$data['rs']){
          //redirect('thanh-toan/gio-hang');
        }
        if($this->vcart->total_price() <= 0){
          //redirect('checkout/step_one');
        }
		
        //set top link
        $data['top_link']	= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="javascript:;" itemprop="url"><span itemprop="title">Thanh toán</span></a></div>';
        
        
        // Tao ma don hang
        $madonhang                    = $this->vnitcart->find_barcode();
        $barcode_old = ($madonhang)?$madonhang->barcode:'DH00000000';
        $barcode = vnit_barcode('DH',substr($barcode_old,2) + 1,8);

        $random                       = createRandomCode();
        $vupdate['barcode']           = $barcode;
        $vupdate['user_id']           = $this->session->userdata('user_id');
        $vupdate['active_code']       = $random;
        $vupdate['active_buy']        = 1;
        $vupdate['date_buy']          = time();
        $this->vdb->update('shop_cart',$vupdate,array('order_id'=>$data['rs']->order_id));

        // Cap nhat danh sach san pham mua
        $vshop['cartid']          = $data['rs']->order_id;
        $this->vdb->update('shop_cart_detail',$vshop,array('session_id'=>$data['rs']->session_id));

        // Cap nhat danh sach phieu giam gia
        $vdis['cartid']           = $data['rs']->order_id;
        $this->vdb->update('shop_cart_discount',$vshop,array('session_id'=>$data['rs']->session_id));

        $cart             = $this->vdb->find_by_id('shop_cart',array('order_id'=>$data['rs']->order_id));
        $list             = $this->vnitcart->get_listproduct_order($data['rs']->order_id);
        $total_discount   = $this->vnitcart->get_total_discount($data['rs']->order_id);
        $sub_total        = $this->vnitcart->get_subtotal($data['rs']->order_id);



        //Thưc hien gưi Email don hang cho khach hang
        $this->load->helper('mail_helper');
      
      
        /***********Email thong tin tai khoan********/
        if($cart->active_reg == 1){
          $reg              = $this->vdb->find_by_id('email_templates',array('slug'=>'fyi_dangkytaikhoan'));
          $email            = $cart->email;
          $matkhau          = ($cart->pass_templ != '')?$cart->pass_templ:createRandomPassword();
          $hovaten          = $cart->fullname;
          $diachi           = $cart->address;
          $quanhuyen        = $this->vdb->find_by_id('city',array('city_id'=>$cart->districts_id))->city_name;
          $thanhpho         = $this->vdb->find_by_id('city',array('city_id'=>$cart->city_id))->city_name;
          $dienthoai        = $cart->phone;
          $random_active    = createRandomCode();
          $vuser['group_id']    = 1;
          $vuser['fullname']    = $hovaten;
          $vuser['email']       = $email;
          $vuser['password']    = md5($matkhau);
          $vuser['phone']       = $dienthoai;
          $vuser['address']     = $diachi;
          $vuser['city_id']     = $cart->city_id;
          $vuser['district_id'] = $cart->districts_id;
          $vuser['active_code'] = $random_active;
          $vuser['published']   = 0;
          //load
               
          $this->load->database('member', TRUE);
          $user_id              = $this->vdb->update('user',$vuser);
         
          $vup['user_code']     = vnit_barcode('Alobuy_',$user_id,8);
          $this->vdb->update('user',$vup,array('user_id'=>$user_id));
          $this->db->close();
          //mo lai 
          //$this->load->database('data', TRUE);
          
          $url = anchor('kich-hoat-tai-khoan/'.$user_id.'/'.$random_active,'<b>Kích hoạt</b>');
          $to = $email;
          $subject = $reg->subject;
          $template_reg_text=addslashes($reg->content);
          eval("\$body=\"$template_reg_text\";");
          send_mail_templates($to,$subject,$body);
        } 

        /***********Email don hang********/
        $templates      = $this->vdb->find_by_id('email_templates',array('slug'=>'donhang'));
        // Subject
        $madonhang      = $barcode;
        $subject_php    = addslashes($templates->subject);
        eval("\$subject=\"$subject_php\";");

        // Khoi tao du lieu truoc khi gui mail don hang
        $tenkhachhang     = $cart->fullname;
        $diachi           = $cart->address;
        $khuvuc           = $this->vdb->find_by_id('city',array('city_id'=>$cart->city_id))->city_name;
        $dienthoai        = $cart->phone;
        $email            = $cart->email;

        $phivanchuyen     = $cart->price_shipping;

        $phuongthucgiaohang   = $this->vdb->find_by_id('shop_shipping',array('shipping_id'=>$cart->shipping_id))->shipping_name;
        $phuongthucthanhtoan  = $this->vdb->find_by_id('shop_payment',array('payment_id'=>$cart->payment_id))->payment_name;
        $thoigian             = date('H:i d/m/Y',time());
        $tinhtrang            = 'Chưa xác nhận';

        //Thong tin san pham mua hang
        $thongtinsanpham = '<table border="1" width="800" cellpadding="2" bordercolor="#C0C0C0" style="border-collapse: collapse">';
        $thongtinsanpham .='
                        <tr>
                            <td align="center" width="106" bgcolor="#0066FF" height="34"><b>
                            <font face="Arial" size="2" color="#FFFFFF">Hình ảnh</font></b></td>
                            <td align="center" width="406" bgcolor="#0066FF" height="34"><b>
                            <font face="Arial" size="2" color="#FFFFFF">Tên sản phẩm</font></b></td>
                            <td align="center" width="65" bgcolor="#0066FF" height="34"><b>
                            <font face="Arial" size="2" color="#FFFFFF">Mầu sắc</font></b></td>
                            <td align="center" width="65" bgcolor="#0066FF" height="34"><b>
                            <font face="Arial" size="2" color="#FFFFFF">Số lượng</font></b></td>
                            <td align="center" width="94" bgcolor="#0066FF" height="34"><b>
                            <font face="Arial" size="2" color="#FFFFFF">Đơn giá(vnd)</font></b></td>
                            <td align="center" width="104" bgcolor="#0066FF" height="34"><b>
                            <font face="Arial" size="2" color="#FFFFFF">Thành tiền(vnd)</font></b></td>
                        </tr>
        ';
        $subtotal = 0;
        foreach($list as $val):
        $color          = $this->vnitcart->get_color_by_id($val->s_color);
        $giaban         = number_format($val->s_price,0,'.','.');
        $thanhtien      = number_format(($val->s_qty * $val->s_price),0,'.','.');
        $subtotal       = $subtotal + ($val->s_qty * $val->s_price);
        $listgift       = $this->vnitcart->get_gifts($val->id);
        if($color){
            $str_color ='<img src="'.base_url_img().'alobuy0862779988/iconcolor/'.$color->images.'" alt="'.$color->color.'">'.$color->color;
        }else{
            $str_color = '';
        }
        if(count($listgift) > 0){
            $tangpham = '<br />';
            foreach($listgift as $val1):
                $tangpham .'<div>'.$val1->name.'</div>';
            endforeach;
        }else{
            $tangpham = '';
        }

        $thongtinsanpham .= '
                    <tr>
                        <td width="106"><img src="'.base_url().'alobuy0862779988/0862779988product/80/'.$val->productimg.'" width="80"></td>
                        <td width="406"><font face="Arial" size="2">'.$val->productname.'</font>'.$tangpham.'</td>
                        <td>
                            <font face="Arial" size="2">'.$val->s_qty.'</font>
                         </td>
                       
                        <td>'.$str_color.'</td>
                        <td align="right">
                            <font face="Arial" size="2">'.$giaban.'</font>
                        </td>
                        <td align="right">
                            <font face="Arial" size="2">'.$thanhtien.'</font>
                        </td>
                    </tr>';
        endforeach;
        $subtotal = $subtotal + $phivanchuyen;
        $payPhivanChuyen = (number_format($phivanchuyen,0,'.','.')>0)?number_format($phivanchuyen,0,'.','.'):'Liên hệ';
        $thongtinsanpham .='
                    <tr>
                        <td colspan="5">
                        <p align="right"><font face="Arial" size="2"><b>Giảm giá:</b></font></td>
                        <td>
                        <p align="right"><font face="Arial" size="2">0 VND</font></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                        <p align="right"><font face="Arial" size="2"><b>Phí vận chuyển:</b></font></td>
                        <td>
                        <p align="right"><font face="Arial" size="2">'.$payPhivanChuyen.'</font></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                        <p align="right"><font face="Arial" size="2"><b>Tổng thanh toán:</b></font></td>
                        <td>
                        <p align="right"><font face="Arial" size="2">'.number_format($subtotal,0,'.','.').' VND</font></td>
                    </tr>
        ';
        $thongtinsanpham .= '</table>';
        $url            = site_url('thanh-toan/xac-nhan-don-hang/'.$cart->order_id.'/'.$random);
        $link           = '<a href="'.$url.'">link</a>';
        $to             = $cart->email;
        $template_text  = addslashes($templates->content);
        eval("\$body=\"$template_text\";");
        send_mail_templates($to,$subject,$body);

        // Cap nhat lại thong tin don hang
        $vdonhang['subtotal']   = $subtotal;
        $vdonhang['discount']   = $total_discount;
        $vdonhang['total']      = ($phivanchuyen + $subtotal - $total_discount);
        $this->vdb->update('shop_cart',$vdonhang,array('order_id'=>$cart->order_id));

        // Remove session
        $s_cart['session_id'] = '';
        $this->vdb->update('shop_cart',$s_cart,array('order_id'=>$cart->order_id));

        $s_cart_detail['session_id'] = '';
        $this->vdb->update('shop_cart_detail',$s_cart_detail,array('cartid'=>$cart->order_id));

        $s_discount['session_id'] = '';
        $this->vdb->update('shop_cart_discount',$s_cart,array('cartid'=>$cart->order_id));
        
         
        $payment = $this->vdb->find_by_id('shop_payment',array('payment_id'=>$data['rs']->payment_id));
        if($payment->payment_code == 'onepay'){
            // OnePay Payemtn
            $SECURE_SECRET = $payment->secure_hash;//"A3EFDFABA8653DF2342E8DAC29B51AF0";
            $Onepay["virtualPaymentClientURL"]  = $payment->url_pay; //'http://mtf.onepay.vn/onecomm-pay/vpc.op';
            $Onepay["vpc_Merchant"]             = $payment->merchant_id;
            $Onepay["vpc_AccessCode"]           = $payment->access_code;
            $Onepay["vpc_MerchTxnRef"]          = date ( 'YmdHis' ) . rand ();
            $Onepay["vpc_TicketNo"]             = $_SERVER ['REMOTE_ADDR'];
            $Onepay["vpc_OrderInfo"]            = $barcode; 
            $Onepay["vpc_Amount"]               = $subtotal.'00'; 
            $Onepay["vpc_Version"]              = 1; 
            $Onepay["vpc_ReturnURL"]            = site_url('thanh-toan-thanh-cong/one-pay'); 
            $Onepay["vpc_Command"]              = 'pay'; 
            $Onepay["vpc_Locale"]               = 'vn'; 
            $Onepay["vpc_Currency"]             = 'VND'; 
            $Onepay["vpc_SHIP_Street01"]        = vnit_change_string($diachi); 
            $Onepay["vpc_Customer_Phone"]       = $dienthoai; 
            $Onepay["vpc_Customer_Email"]       = $email; 
            $Onepay["vpc_Customer_Id"] = 'thanhvt'; 
            
            // Lấy giá trị url cổng thanh toán
            $vpcURL = $Onepay["virtualPaymentClientURL"] . "?";
                        
            // bỏ giá trị url và nút submit ra khỏi mảng dữ liệu
            unset($Onepay["virtualPaymentClientURL"]); 
            unset($Onepay["SubButL"]);
            // tạo chuỗi dữ liệu được bắt đầu bằng khóa bí mật
            $md5HashData = $SECURE_SECRET;
            // sắp xếp dữ liệu theo thứ tự a-z trước khi nối lại
            ksort ($Onepay);

            // đặt tham số đếm = 0
            $appendAmp = 0;

            foreach($Onepay as $key => $value) {
                // tạo chuỗi đầu dữ liệu những tham số có dữ liệu
                if (strlen($value) > 0) {
                    // this ensures the first paramter of the URL is preceded by the '?' char
                    if ($appendAmp == 0) {
                        $vpcURL .= urlencode($key) . '=' . urlencode($value);
                        $appendAmp = 1;
                    } else {
                        $vpcURL .= '&' . urlencode($key) . "=" . urlencode($value);
                    }
                    $md5HashData .= $value;
                }
            }
            // thêm giá trị chuỗi mã hóa dữ liệu được tạo ra ở trên vào cuối url
            if (strlen($SECURE_SECRET) > 0) {
                $vpcURL .= "&vpc_SecureHash=" . strtoupper(md5($md5HashData));
            }
            // chuyển trình duyệt sang cổng thanh toán theo URL được tạo ra
            header("Location: ".$vpcURL);
        }else if($payment->payment_code == 'baokim'){
        // Bao kim Payment

        $nl = $this->vdb->find_by_id('shop_payment',array('payment_code'=>'baokim'));
        $config_bk = array(
            'baokim_url' => $nl->url_pay,
            'merchant_id' => $nl->merchant_id,
            'secure_pass' => $nl->access_code
        );
        $this->load->library('baokim',$config_bk);
        $order_id = $barcode;                      
        $business = 'alex@chonmua24h.com';
        $total_amount = $subtotal;
        $shipping_fee = 0;
        $tax_fee = 0;
        $order_description  ='Thanh toan don hang ID: '.$barcode;
        $url_success = site_url('checkout/redirectpayment');
        $url_cancel = site_url('checkout/redirectpayment');            //Url trả về khi hủy thanh toán
        $url_detail  = site_url('checkout/redirectpayment');           //Url chi tiết đơn hàng   
        redirect($this->baokim->createRequestUrl($order_id, $business, $total_amount, $shipping_fee, $tax_fee, $order_description, $url_success, $url_cancel, $url_detail));
        }else if($payment->payment_code == 'nganluong'){
            $nl = $this->vdb->find_by_id('shop_payment',array('payment_code'=>'nganluong')); 
            $config_nl = array(
                'nganluong_url' => $nl->url_pay,
                'merchant_site_code' => $nl->merchant_id,
                'secure_pass' => $nl->access_code
            );
            $this->load->library('nganluong',$config_nl);
          
            $order_code = $barcode;                      
            $receiver = 'alex@alobuy.vn';
            $price = $subtotal;
            $transaction_info  ='Thanh toan don hang ID: '.$barcode;
            $return_url = site_url('checkout/checkpayment/nganluong/');     
            redirect($this->nganluong->buildCheckoutUrl($return_url, $receiver, $transaction_info, $order_code, $price));
        }else if($payment->payment_code == ''){
          $data['title'] = 'Mua hàng thành công';
          $this->_templates['page'] = 'step_five';
          $this->templates->load($this->_templates['page'],$data,'detail');
        }
    }
  

    function districts(){
        $city_id = $this->input->post('city_id');
        $list = $this->vdb->find_by_list('city',array('parentid'=>$city_id,'parentid !='=>0));
        $html ='<option value="">Chọn Quận, Huyện</option>';
        foreach($list as $rs):
            $html .='<option value="'.$rs->city_id.'">'.$rs->city_name.'</option>';
        endforeach;
        $data['info'] = $html;
        echo json_encode($data);
    }
  
    // Lay danh sach phuong thuc thanh toan theo van chuyen
    function get_payment(){
        $shipping_id = $this->input->post('shipping_id');  
        $data['rs']  = $this->vnitcart->check_cookie_cart();
        $data['list'] = $this->vnitcart->get_payment_shipping($shipping_id);
        $this->load->view('listpayment',$data);
    }
  
  // Kiem tra ma khuyen mai
  
    function check_discount(){
        $discount_code = $this->input->post('discount_code');
        $check_cart_discount = $this->vnitcart->check_cart_discount($discount_code);
        $total = $this->vnitcart->check_total_discount_by_key($discount_code);
        if($check_cart_discount){
          $data['error'] = 1;
          $data['msg'] = 'Mã giảm giá: '.$discount_code.' đã được bạn sử dụng';
        }else{
          $check = $this->vnitcart->check_discount($discount_code);
          
          if($check){
              if($check->discount_total > $total){ 
                    if($check->discount_datebegin > time()){  
                       $data['error'] = 1;
                       $data['msg'] = 'Mã khuyến mãi: '.$discount_code.' chưa có hiệu lực';
                    }else if($check->discount_dateend < time()){
                       $data['error'] = 1;
                       $data['msg'] = 'Mã khuyến mãi: '.$discount_code.' đã hết hiệu lực';
                    }else{
                       $vdata['discount_key']  = $check->discount_key;
                       $vdata['discount_id'] = $check->discount_id;
                       $vdata['session_id'] = cookie_mycart();
                       $vdata['price'] = $check->discount_price;
                       $this->vdb->update('shop_cart_discount',$vdata);
                       $data['error'] = 0;
                    }
              }else{
                   $data['error'] = 1;
                   $data['msg'] = 'Mã giảm giá: '.$discount_code.' đã hết số lượng giảm giá';
              }
          }else{
              $data['error'] = 1;
              $data['msg'] = 'Mã khuyến mãi: '.$discount_code.' không tồn tại';
          }
        }

        echo json_encode($data);
    }
  
    function remove_discount(){
        $id = $this->input->post('id');
        if($this->vdb->delete('shop_cart_discount',array('id'=>$id))){
          $data['error'] = 0;
        }else{
          $data['error'] = 1;
        }
        echo json_encode($data);
    }
    // Cai dat mat khau khi mua hang
    function set_pass(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $html = '<div style="padding:5px">';
        $html .='<table>';
        $html .='<tr>';
            $html .='<td>Email đăng nhập</td>';
            $html .='<td><input type="text" id="email_c" value="'.$email.'" style="width: 200px;"></td>';
        $html .='</tr>';
        $html .='<tr>';
            $html .='<td>Mật khẩu</td>';
            $html .='<td><input type="password" id="pass_c" value="'.$password.'" style="width: 200px;"></td>';
        $html .='</tr>';
        $html .='<tr>';
            $html .='<td></td>';
            $html .='<td><input type="button" class="submit_cart" value="Cài mật khẩu" onclick="add_pass()"></td>';
        $html .='</tr>';
        $html .='</table>';
        $html .= '</div>';
        $data['html'] = $html;
        echo json_encode($data);
    }
  
    function checkmail(){
        $email = $this->input->post('email');
        $check = $this->vdb->find_by_id('user',array('email'=>$email));
        if($check){
          $data['error'] = 1;
        }else{
          $data['error'] = 0;
        }
        echo json_encode($data);
    }
  
  
  
    function active_order(){
        $order_id = $this->uri->segment(3);
        $active_code = $this->uri->segment(4);
        $data['title'] = 'Xác nhận đơn hàng';
        $check = $this->vnitcart->get_donhang($order_id, $active_code);
        if($check == 0){
          $data['msg'] = 'Đơn hàng không tồn tại';
        }else if($check == 2){
          $data['msg'] = 'Đơn hàng đã được xác nhận';
        }else{
          $data['msg'] = 'Xin cảm ơn! Đơn hàng của quý khách đã được xác nhận thành công';
        }
        $this->_templates['page'] = 'active';
        $this->templates->load($this->_templates['page'],$data,'detail');
    }

  
  
}
