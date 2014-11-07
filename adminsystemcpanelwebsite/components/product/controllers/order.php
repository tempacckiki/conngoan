<?php
class order extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('order_model','order');
        $this->load->config('config_site');
        $this->load->helper('mail');
        $this->pre_message = "";
        $css_array = array(
            array(base_url().'components/product/views/esset/order.css')
        );
        $this->esset->css($css_array);
    }
    
    function listorder(){
        $data['title'] = 'Danh sách đơn hàng';
        write_log(72,232,'Xem danh sách đơn hàng');
        $data['delete'] = icon_dels('product/order/dels');
        $uri4 = $this->uri->segment(4);
        $data['offset'] = $this->uri->segment(5);
        $field = $this->uri->segment(6);
        $order = $this->uri->segment(7);          
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'product/order/listorder/'.$uri4;
        $config['total_rows']   =  $this->order->get_num_donhang($uri4);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 5; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->order->get_all_donhang($config['per_page'],$this->uri->segment(5),$uri4,$field,$order);
        $data['listcity'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message;  
        $this->_templates['page'] = 'order/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $tinhtrangs = $this->uri->segment(4);
        $data['title'] = 'Xem thông tin đơn đặt hàng';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'product/order/listorder/'.$tinhtrangs;         
        $order_id = $this->uri->segment(5);

        $this->db->query("UPDATE shop_cart SET order_news = 0 WHERE order_id =".$order_id);
        
        $data['info'] = $this->order->get_info_order($order_id);
        $data['list'] = $this->order->get_list_order($order_id);
        $data['list_discount'] = $this->order->get_list_discount($order_id);
        // From validation
        $this->form_validation->set_rules('order_id','','');
        if($this->form_validation->run()){
            
            $order_id = $this->input->post('order_id');
            $cart = $this->input->post('cart');
            if($data['info']->employee_id == 0){
               $cart['employee_id']  = $this->session->userdata('user_id');
            }
            if($this->vdb->update('shop_cart',$cart,array('order_id'=>$order_id))){
                write_log(72,233,'Cập nhật đơn hàng: '.$data['info']->barcode); 
                 $sendmail = $this->input->post('sendmail');
                 if($sendmail == 1){
                      
                      $cart =  $this->order->get_info_order($order_id);
                      $list = $this->order->get_list_order($order_id); 
                      
                      /***********Email don hang********/
                      $templates      = $this->vdb->find_by_id('email_templates',array('slug'=>'admin_donhang'));
                      // Subject
                      $madonhang      = $cart->barcode;
                      $subject_php    = addslashes($templates->subject);
                      eval("\$subject=\"$subject_php\";");
                        
                      // Khoi tao du lieu truoc khi gui mail don hang
                      $tenkhachhang = $cart->fullname;
                      $diachi = $cart->address;
                      $khuvuc = $this->vdb->find_by_id('city',array('city_id'=>$cart->city_id))->city_name;
                      $dienthoai = $cart->phone;
                      $email = $cart->email;
                      
                      $phivanchuyen = $cart->price_shipping;
                      
                      $phuongthucgiaohang = $this->vdb->find_by_id('shop_shipping',array('shipping_id'=>$cart->shipping_id))->shipping_name;
                      $phuongthucthanhtoan = $this->vdb->find_by_id('shop_payment',array('payment_id'=>$cart->payment_id))->payment_name;
                      $thoigian = date('H:i d/m/Y',$cart->date_buy);
                      $tinhtrang = get_status($cart->status);
                      
                      //Thong tin san pham mua hang
                        $thongtinsanpham = '<table border="1" width="800" cellpadding="2" bordercolor="#C0C0C0" style="border-collapse: collapse">';
                        $thongtinsanpham .='
                                        <tr>
                                            <td align="center" width="106" bgcolor="#0066FF" height="34"><b>
                                            <font face="Arial" size="2" color="#FFFFFF">Hình ảnh</font></b></td>
                                            <td align="center" width="406" bgcolor="#0066FF" height="34"><b>
                                            <font face="Arial" size="2" color="#FFFFFF">Tên sản phẩm</font></b></td>
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
                        $list_gifts = $this->order->get_gifts($val->id); 
                        $giaban = number_format($val->s_price,0,'.','.');
                        $thanhtien = number_format(($val->s_qty * $val->s_price),0,'.','.');
                        $subtotal = $subtotal + ($val->s_qty * $val->s_price);
                        if(count($list_gifts) > 0){
                            $tangpham = '<br />';
                            foreach($list_gifts as $val1):
                            $tangpham .='<p>-'.$val1->name.'</p>';
                            endforeach;
                        }else{
                            $tangpham = '';
                        }
                        
                        $thongtinsanpham .= '
                                    <tr>
                                        <td width="106"><img src="'.base_url_site().'data/img_product/80/'.$val->productimg.'" width="80"></td>
                                        <td width="406"><font face="Arial" size="2">'.$val->productname.'</font>'.$tangpham.'</td>
                                        <td>
                                        <p align="center"><font face="Arial" size="2">'.$val->s_qty.'</font></td>
                                        <td>
                                        <p align="right"><font face="Arial" size="2">'.$giaban.'</font></td>
                                        <td>
                                        <p align="right"><font face="Arial" size="2">'.$thanhtien.'</font></td>
                                    </tr>';
                        endforeach;
                        $subtotal = $subtotal + $phivanchuyen;
                        $thongtinsanpham .='
                                    <tr>
                                        <td colspan="4">
                                        <p align="right"><font face="Arial" size="2"><b>Giảm giá:</b></font></td>
                                        <td>
                                        <p align="right"><font face="Arial" size="2">0 VND</font></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                        <p align="right"><font face="Arial" size="2"><b>Phí vận chuyển:</b></font></td>
                                        <td>
                                        <p align="right"><font face="Arial" size="2">'.number_format($phivanchuyen,0,'.','.').' VND</font></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4">
                                        <p align="right"><font face="Arial" size="2"><b>Tổng thanh toán:</b></font></td>
                                        <td>
                                        <p align="right"><font face="Arial" size="2">'.number_format($subtotal,0,'.','.').' VND</font></td>
                                    </tr>
                        ';
                        $thongtinsanpham .= '</table>';
                        $ghichuquantri = $cart->admin_notes;
                        $to         = $cart->email;
                        $template_text=addslashes($templates->content);
                        eval("\$body=\"$template_text\";");
                        send_mail_templates($to,$subject,$body);  
                    }
                    
                    // End Send Mail Order
                    $this->session->set_flashdata('message','Lưu thành công');
                    $option =  $this->input->post('option');
                    if($option == 'save'){
                       $url = 'product/order/listorder/'.$tinhtrangs;
                    }else{
                        $url = uri_string();
                    }
                    redirect($url);
                
               
            }
        }
        $this->_templates['page'] = 'order/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function view_result(){
        $this->load->library('pagi');
        $barcode = $this->input->post('barcode');
        $fullname = $this->input->post('fullname');
        $date_begin = $this->input->post('date_begin');
        $data_end = $this->input->post('date_end');

        $city_id = $this->input->post('city_id');
        $status = $this->input->post('status');
        $limit = 10;
        $data['key'] = $this->input->post('key');
        $data['limit'] = $limit; 
        $offset = (int)$this->input->post('page_no'); 
        $data['offset'] = $offset;
        $num = $this->order->get_num_search($barcode, $fullname, $date_begin, $data_end, $city_id, $status);
        $data['num'] = $num;
        if($offset!=0) 
            $start = ($offset - 1) * $limit;
        else
            $start = 0;   
        $data['list'] =   $this->order->get_all_search($limit,$start,$barcode, $fullname, $date_begin, $data_end, $city_id, $status);
        $data['pagination']   = $this->pagi->page($num,$offset,$limit,'order');       

        $this->_templates['page'] = 'order/result';
        $this->load->view($this->_templates['page'],$data);  
    }
    
    
    
  // Xoa 1 ban ghi
  function del(){
      $id = $this->uri->segment(5);
      $page = $this->uri->segment(4);
      $barcode = $this->vdb->find_by_id('shop_cart',array('order_id'=>$id))->barcode;
        if($this->vdb->delete('shop_cart',array('order_id'=>$id))){
            
            write_log(72,235,'Xóa đơn hàng mã:'.$barcode); 
            $this->vdb->delete('shop_cart_detail',array('cartid'=>$id));
            $this->session->set_flashdata('message','Đã xóa thành công');
        }else{ 
            $this->session->set_flashdata('message','Xóa không thành công');
        }
      redirect('product/order/listorder/'.$page);
  }
  // Xoa nhieu ban ghi
  function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $tinhtrang = $this->input->post('tinhtrang');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $barcode = $this->vdb->find_by_id('shop_cart',array('order_id'=>$ar_id[$i]))->barcode; 
                    if($this->vdb->delete('shop_cart',array('order_id'=>$ar_id[$i]))){
                        write_log(72,234,'Xóa đơn hàng mã: '.$barcode); 
                        $this->vdb->delete('shop_cart_detail',array('cartid'=>$ar_id[$i]));
                    $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{ 
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('product/order/listorder/'.$tinhtrang.'/'.$page);
  }     
}
