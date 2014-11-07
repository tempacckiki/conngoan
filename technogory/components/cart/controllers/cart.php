<?php
class cart extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->city_id = $this->session->userdata('city_site');
        $this->load->model('cart_model','vnitcart');
    }
  
    function add(){
        $productid = $this->input->post('productid');
        $qty = $this->input->post('qty');
        $productids = $this->vcart->addcart($productid,$qty);  
        if($productids > 0 ){
            $rs  = $this->vcart->get_product($productid);
            $list_gifts = $this->vcart->get_gifts($productid);
            $productname = $rs->productname;
            $productinfo =  $qty.' x '.number_format($rs->giaban,0,'.','.').' = '.number_format($qty * $rs->giaban);
            $html  ='<div class="title">Sản phẩm đã được thêm vào giỏ hàng</div>';
            $html .='<div class="box_info">
            <div class="product_title"><a href="">'.$productname.'</a></div>
            <div> '.$productinfo.'</div>';
            if(count($list_gifts) > 0){
            $html .='<div class="quatang">
                <div class="label">Quà tặng:</div><br />';
                foreach($list_gifts as $val):
                $html .='<div class="label_info">'.$val->name.'</div>';
                endforeach;
            $html .='</div>';
            }
            $html .='</div>
            <div class="bot">
            <a href="javascript:;" onclick="close_pop();" class="submit  conti">Tiếp tục mua</a>
            <a href="'.site_url('thanh-toan/gio-hang').'" class="submit  pay">Thanh toán</a>
            </div>
            ';
            $data['html'] = $html;
            $data['total_product'] = $this->vcart->total_product();
            $data['total_price'] = $this->vcart->total_price();
        }else if($productids == '-1'){
            $data['html'] = 'Xin lỗi. Sản phẩm chưa có giá. Bạn không thể mua sản phẩm này';
        }else{
            $data['html'] = 'Xin lỗi. Sản phẩm không tồn tại';
        }
        echo json_encode($data);

    }
  
    function addcart(){
        $productid = (int)$this->input->post('productid');
        $qty = (int)$this->input->post('qty');
        $rs = $this->vnitcart->get_product_by_id($productid);
        if($rs->product_option == 5){
          $info['list'] = '<div>Xin lỗi sản phẩm tạm thời hết hang</div>';
        }else{
          if($rs->price == 0){
              $info['list'] = '<div>Xin lỗi. Sản phẩm này chưa có giá</div>';
          }else{
              $check_cart = $this->vnitcart->_check_cart_detail($productid); 
              if($check_cart){
                  
                  $data['s_qty'] = $check_cart->s_qty + $qty;
                  $data['s_price'] = $rs->price * $qty;
                  if($rs->discount_date_begin >= time() && $rs->discount_price > 0){
                    $data['s_discount'] = $check_cart->s_discount + $rs->discount_price;
                  }
                  if($rs->promote_date_end > time()){
                      $data['s_promote'] = $rs->promote_title;
                  }
                  $this->vnitcart->_update_cart_detail($data,$productid);
              }else{
                  $data['session_id'] = cookie_mycart();
                  $data['productid'] = $productid;
                  $data['productname'] = $rs->productname;
                  $data['s_qty'] = $qty;
                  $data['s_price'] = $rs->price;
                  if($rs->discount_date_begin >= time() && $rs->discount_price > 0){
                    $data['s_discount'] = $rs->discount_price;
                  }
                  if($rs->promote_date_end > time()){
                      $data['s_promote'] = $rs->promote_title;
                  }
                  $this->vnitcart->_insert_cart_detail($data);
              }
              $this->vnitcart->_total_product();
              $this->vnitcart->_total_price();
               
              $info['list'] = '<div><b>Sản phẩm:</b> '.$rs->productname.'</div>';
              $info['list'] .= '<div><b>Giá:</b> '.number_format($rs->price,0,'.','.').' vnd</div>';
              $info['total_price'] = number_format(cookie_total_price(),0,'.','.');
              $info['total_cart'] = cookie_total_qty();
              $info['productname'] = $rs->productname;
          }
            
        }
        echo json_encode($info);
    }
  
    function mini_cart(){
        $list = $this->vcart->list_product();
        if(count($list) > 0){
            $data['list'] = '<ul>';
            foreach($list as $rs):
            $data['list'] .= '<li>
                                <a href="'.site_url('product/'.vnit_change_title($rs->productname).'-'.$rs->productid).'">'.$rs->productname.'</a>
                                <p><b>'.$rs->s_qty.'</b> x '.number_format($rs->s_price,0,'.','.').'</p>
                              </li>';
            endforeach;
            $data['list'] .= '<ul>';
            $data['checkout'] = '<a href="'.site_url('thanh-toan/gio-hang').'" class="bt_pay pay">Thanh toán</a>';
        }else{
            $data['list'] = 'Giỏ hàng trống';
        }

        echo json_encode($data);
    }    
}

