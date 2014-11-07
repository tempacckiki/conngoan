<?php
  class cart_model extends CI_Model{
      function __construct(){
          parent::__construct();
          $this->load->helper('cookiecart');
      }
      function get_product_by_id($productid){
          $this->db->where('productid',$productid);
          return $this->db->get('shop_product')->row();
      }
      // Them moi san pham vao don hang
      function _insert_cart_detail($data){
          if($this->db->insert('shop_cart_detail',$data)){
              $this->_total_product();
              $this->_total_price();
              return true;
          }else{
              return false;
          }                
      }
      // Cap nhat san pham trong don hang
      function _update_cart_detail($data,$productid){
          $this->db->where('session_id',cookie_mycart());
          $this->db->where('productid',$productid);
          if($this->db->update('shop_cart_detail',$data)){
              $this->_total_product();
              $this->_total_price();              
              return true;
          }else{
              return false;
          }
      }
      // Xao san pham trong don hang
      function _delete_cart_detail($productid){
          $this->db->where('session_id',cookie_mycart());
          $this->db->where('productid',$productid);
          if($this->db->delete('shop_cart_detail')){
              return true;
          }else{
              return false;
          }          
      }
      // Kiem tra san pham trong don hang
      function _check_cart_detail($productid){
          $this->db->where('session_id',cookie_mycart());
          $this->db->where('productid',$productid);
          return $this->db->get('shop_cart_detail')->row();
      }
      
      function _total_product(){
          $this->db->select_sum('s_qty');
          $this->db->where('session_id',cookie_mycart());
          $total = $this->db->get('shop_cart_detail')->row()->s_qty;
          set_cookie('my_total', (int)$total, $this->config->item('exp_time_cart'));
      }
      function _total_price(){
          $this->db->select('s_price,s_qty');
          $this->db->where('session_id',cookie_mycart());
          $list = $this->db->get('shop_cart_detail')->result();
          $total = 0;
          foreach($list as $rs):
            $total = $total + ($rs->s_qty * $rs->s_price);
          endforeach;
          set_cookie('my_price', $total, $this->config->item('exp_time_cart'));
      }
      
      /******************
      * Danh sach san pham trong gio hang      
      */
      function get_list_cart(){
          $this->db->select('shop_product.*, shop_cart_detail.*');
          $this->db->join('shop_product','shop_product.productid = shop_cart_detail.productid');
          $this->db->where('shop_cart_detail.session_id',cookie_mycart());
          return $this->db->get('shop_cart_detail')->result();
      }
      // Thông tin thành phố, quận huyện
      function get_list_city($parentid = 0){
          $this->db->where('parentid',$parentid);
          $this->db->order_by('ordering','asc');
          return $this->db->get('city')->result();
      }
      
      //Danh sach cac phuong thuc thanh toan
      function get_list_payment($shipping_id){
          if($shipping_id == 0){
              $this->db->where('published',1);
              $this->db->where('parentid',0);
              $this->db->order_by('ordering','asc');
              return $this->db->get('shop_payment')->result();
          }else{
              $this->db->select('shop_payment.*, shop_payment_shipping.*');
              $this->db->join('shop_payment','shop_payment.payment_id = shop_payment_shipping.payment_id');
              $this->db->where('shop_payment_shipping.shipping_id',$shipping_id);
              $this->db->where('shop_payment.parentid',0);
              $this->db->order_by('shop_payment.ordering','asc');
              return $this->db->get('shop_payment_shipping')->result();
          }
      }
      
      // Danh sach phuong thuc van chuyen
      
      function get_list_shipping(){
          $this->db->where('published',1);
          $this->db->order_by('ordering','asc');
          return $this->db->get('shop_shipping')->result();
      }
      
      // Tinh toan phi van chuyen
      
      function get_shipping_rate($shipping_id){
          $check = $this->vdb->find_by_id('shop_shipping',array('shipping_id'=>$shipping_id));
          if($check->shipping_free == 1){
              return 0;
          }else{
              $mycart = $this->vdb->find_by_id('shop_cart',array('session_id'=>cookie_mycart()));
              $rate = $this->vdb->find_by_id('city',array('city_id'=>$mycart->districts_id));
              return $rate->rate;
          }
      }
      
      
      /******************
      * Thanh toan don hang      
      */
      // Cap nhat danh sach san pham trong don hang
      function _update_list_cart(){
          $product_data = $this->input->post('cart_products');
          foreach ($product_data as $key => $data) {
             if($key == $data['product_id']){
                 if($data['qty'] == 0){
                     $this->db->where('productid',$data['product_id']);
                     $this->db->where('session_id',cookie_mycart());
                     $this->db->delete('shop_cart_detail');
                 }
                 $cart['s_qty'] = $data['qty'];
                 $this->db->where('productid',$data['product_id']);
                 $this->db->where('session_id',cookie_mycart());
                 $this->db->update('shop_cart_detail',$cart);
             }

          }
              $this->_total_product();
              $this->_total_price();            
          return true;         
      }
      
      function save_cart(){
          $data['fullname'] = addslashes($this->input->post('fullname'));
          $data['address'] = addslashes($this->input->post('address'));
          $data['city_id'] = $this->input->post('city_id');
          $data['districts_id'] = $this->input->post('districts_id');
          $data['phone'] = addslashes($this->input->post('phone'));
          $data['email'] = addslashes($this->input->post('email'));
          $data['notes'] = addslashes($this->input->post('notes'));
          $data['active_reg'] = $this->input->post('active_reg');
          $data['pass_templ'] = $this->input->post('pass_templ');
          $data['timestamp'] = time();
          $data['session_id'] = cookie_mycart();
          if($this->check_cookie_cart()){
              $this->db->where('session_id',cookie_mycart()); 
              if($this->db->update('shop_cart',$data)){
                  return true;
              }else{
                  return false;
              }
          }else{
              if($this->db->insert('shop_cart',$data)){
                  return true;
              }else{
                  return false;
              }  
          }
          
          
      }
      
      function save_buoc3(){
          $data['payment_id'] = (int)$this->input->post('payment_id');
          $data['sub_payment_id'] = (int)$this->input->post('sub_payment_id');
          $data['shipping_id'] = (int)$this->input->post('shipping_id');
          $data['price_shipping'] = $this->get_shipping_rate($this->input->post('shipping_id'));
          $this->db->where('session_id',cookie_mycart());
          if($this->db->update('shop_cart',$data)){
              /*$rs = $this->vdb->find_by_id('shop_cart',array('session_id'=>cookie_mycart()));
              $order_id = $rs->order_id;
              $vdata['cartid'] = $order_id;
              $this->vdb->update('shop_cart_detail',$vdata,array('session_id'=>cookie_mycart()));*/
              return true;
          }else{
              return false;
          }
      }
      
      function delete_cookie_cart(){
          $val = $this->check_cookie_cart();  
          $list = $this->get_list_cart();
          $to = $val->b_email;
          $madonhang = $val->order_id;
          $ngaymua = date('d/m/Y',$val->timestamp);
          $b_hoten = $val->b_fullname;
          $b_email = $val->b_email;
          $b_dienthoai = $val->b_phone;
          $b_diachi = $val->b_address.','.$val->b_city.','.$val->b_country;
          $s_hoten = $val->s_fullname;
          $s_email = $val->s_email;
          $s_dienthoai = $val->s_phone;
          $s_diachi = $val->s_address.','.$val->s_city.','.$val->s_country; 
          
          // Gui Email don hang toi khach hang
          $thongtindonhang = '
            <table border="1" width="100%" cellpadding="2" style="border-collapse: collapse;border: 1px solid #e5e5e5;" id="table1">
                <tr>
                    <td align="center" bgcolor="#999999" style="border: 1px solid #e5e5e5;"><b><font color="#FFFFFF">Sản phẩm</font></b></td>
                    <td align="center" bgcolor="#999999" style="border: 1px solid #e5e5e5;"><b><font color="#FFFFFF">Đơn giá</font></b></td>
                    <td align="center" bgcolor="#999999" style="border: 1px solid #e5e5e5;"><b><font color="#FFFFFF">Số lượng</font></b></td>
                    <td align="center" bgcolor="#999999" style="border: 1px solid #e5e5e5;"><b><font color="#FFFFFF">Thành tiền</font></b></td>
                    <td align="center" bgcolor="#999999" style="border: 1px solid #e5e5e5;"><b><font color="#FFFFFF">Giảm giá</font></b></td>
                </tr>          
          ';
          $k=1;
          $discount_price = 0;
          $total_price = 0;
          foreach($list as $rs):
          $total_price = $total_price + ($rs->s_qty * $rs->s_price);
          $price = number_format($rs->s_price,0,'.','.');
          $thanhtien = number_format($rs->s_price * $rs->s_qty,0,'.','.');
          if($rs->discount_date_end > time()){
            $discount_price = $discount_price + ($rs->s_qty * $rs->discount_price);
            $giamgia = number_format($rs->discount_price,0,'.','.');
          }else{
              $giamgia = 0;
          }         
          $thongtindonhang .='
                <tr>
                     <td style="border: 1px solid #e5e5e5;">'.$rs->productname.'</td>
                     <td style="border: 1px solid #e5e5e5;">'.$price.'</td>
                     <td style="border: 1px solid #e5e5e5;">'.$rs->s_qty.'</td>
                     <td style="border: 1px solid #e5e5e5;">'.$thanhtien.'</td>
                     <td style="border: 1px solid #e5e5e5;">'.$giamgia.'</td>
                </tr>
          ';
          $k++;
          endforeach;  
          $tong_giam_gia = number_format($discount_price,0,'.','.');
          $tong_don_hang = number_format($total_price,0,'.','.');
          $tong_gia_tri_don_hang = number_format($total_price - $discount_price,0,'.','.');
          $thongtindonhang .='
                <tr>
                    <td colspan="3" style="border: 1px solid #e5e5e5;">
                    <p align="right">Tổng</td>
                    <td style="border: 1px solid #e5e5e5;">'.$tong_don_hang.'</td>
                    <td style="border: 1px solid #e5e5e5;">'.$tong_giam_gia.'</td>
                </tr>
                <tr>
                    <td colspan="4" style="border: 1px solid #e5e5e5;">
                    <p align="right">Tổng giá trị đơn hàng</td>
                    <td style="border: 1px solid #e5e5e5;">'.$tong_gia_tri_don_hang.'</td>
                </tr>
            </table>          
          ';
          $this->load->helper('mail_helper');
          // Send mail
          $templates = $this->get_email_templates('order_site');
          $subject = $templates->templates_name;
          $template_text=addslashes($templates->templates_content);
          eval("\$body=\"$template_text\";");        
          send_cart($to,$subject,$body);
          
          $rs = $this->vdb->find_by_id('shop_cart',array('session_id'=>cookie_mycart()));
          $order_id = $rs->order_id;
          $vdata['session_id'] = '';
          $this->vdb->update('shop_cart_detail',$vdata,array('cartid'=>$order_id));   
          $this->vdb->update('shop_cart',$vdata,array('order_id'=>$order_id));   
                           
          delete_cookie('my_cart');
          delete_cookie('my_price');
          delete_cookie('my_total');
      }
      
      function get_email_templates($code){
          $this->db->where('templates_code',$code);
          return $this->db->get('email_templates')->row();
      }
      
      function check_cookie_cart(){
          $this->db->where('session_id',cookie_mycart());
          return $this->db->get('shop_cart')->row();
      }
      
      function get_city_by_id($cityid){
          $this->db->where('cityid',$cityid);
          return $this->db->get('city')->row()->cityname;          
      }
      
      function get_listproduct(){
          $this->db->select('shop_product.*, shop_cart_detail.*');
          $this->db->join('shop_product','shop_product.productid = shop_cart_detail.productid');
          $this->db->where('shop_cart_detail.session_id',cookie_mycart());
          return $this->db->get('shop_cart_detail')->result();
      }
      
      function get_listproduct_order($cartid){
          $this->db->select('shop_product.*, shop_cart_detail.*');
          $this->db->join('shop_product','shop_product.productid = shop_cart_detail.productid');
          $this->db->where('shop_cart_detail.cartid',$cartid);
          return $this->db->get('shop_cart_detail')->result();
      } 
      
      function get_payment_shipping($shipping_id){
         // $this->db->select('shop_payment.*, shop_payment_shipping.*');
        //  $this->db->join('shop_payment','shop_payment.payment_id = shop_payment_shipping.payment_id');
          $this->db->where('shipping_id',$shipping_id);
          $this->db->where('parentid',0);
          $this->db->where('published',1);
          $this->db->order_by('ordering','asc');          
          return $this->db->get('shop_payment')->result();
      }
      
      // Danh sach qua tang
      function get_gifts($cart_detail_id){
          $this->db->where('cart_detail_id',$cart_detail_id);
          return $this->db->get('shop_cart_gifts')->result();
      }
      
      // Màu sac theo san pham
      function get_icolor($productid){
          $this->db->select('shop_color.*, shop_color_product.*');
          $this->db->join('shop_color','shop_color.icolor = shop_color_product.icolor');
          $this->db->where('shop_color_product.productid',$productid);
          return $this->db->get('shop_color_product')->result();
      }
      
      function get_color_by_id($icolor){
          $this->db->where('icolor',$icolor);
          return $this->db->get('shop_color')->row();
      }
      
      // Tim ma don hang
      function find_barcode(){
        $this->db->where('session_id','');
        $this->db->order_by('barcode','desc');
        return $this->db->get('shop_cart')->row();
      } 
      
      // Check discount
      function check_discount($discount_code){
          $this->db->where('discount_key',$discount_code);
          return $this->db->get('shop_discount')->row();
      }
      
      function check_cart_discount($discount_code){
          $this->db->where('session_id',cookie_mycart());
          $this->db->where('discount_key',$discount_code);
          $check = $this->db->get('shop_cart_discount')->row();
          if($check){
              return true;
          }else{
              return false;
          }
      }
      
      function get_list_cart_discount(){
          $this->db->where('session_id',cookie_mycart()); 
          return $this->db->get('shop_cart_discount')->result();
      }
      
      // Kiem tra so luong ma khuyen mai
      function check_total_discount_by_key($discount_code){
          $this->db->where('discount_key',$discount_code);
          $this->db->where('cartid !=',0);
          return $this->db->get('shop_cart_discount')->num_rows();
      }
      
      // Tong tien cua ma phieu giam gia
      function get_total_discount($cartid){
          $this->db->select_sum('price');
          $this->db->where('cartid',$cartid);
          $row = $this->db->get('shop_cart_discount')->row();
          if($row){
              return $row->price;
          }else{
              return 0;
          }
      }
      
      // Tinh tong tien cua tat ca san pham
      function  get_subtotal($cartid){
          $this->db->where('cartid',$cartid);
          $list = $this->db->get('shop_cart_detail')->result();
          $total = 0;
          foreach($list as $rs):
            $total = $total + ($rs->s_qty * $rs->s_price);
          endforeach;
          return $total;
      }
      
      /*************
      * Xac nhan don hang
      */
      function get_donhang($order_id, $active_code){
          $this->db->where('order_id',$order_id);
          $check =  $this->db->get('shop_cart')->row();
          if($check){
              if($check->active_code =='' && $check->status > 1){
                  return 2;// Don hang da duoc xac nhan;
              }else{
                  $vdata['active_code']  = '';
                  $vdata['status']  = 2;
                  $this->vdb->update('shop_cart',$vdata,array('order_id'=>$order_id));
                  return 1;
              }
          }else{
              return 0;// Don hang khong ton tai
          }
      }

  }