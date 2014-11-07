<?php
class cart extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('cart_model','cart');
        $this->load->model('openid_model','openid'); 
        $this->load->library('pagi');
        $js_array = array(
            array(base_url().'site/components/account/views/esset/cart.js')
        );
        $this->esset->js($js_array);
        $this->user_id  = $this->session->userdata('user_id');
        $this->pre_message = "";
        $this->db = $this->load->database('default', TRUE);
    }
    
    function listcart(){
        $data['title'] = 'Danh sách đơn hàng';
        $limit = 10;
        $data['limit'] = $limit; 
        $offset = (int)$this->input->post('page_no'); 
        $data['offset'] = $offset;
        $num = $this->cart->get_num_order();
        $data['num'] = $num;
        if($offset!=0) 
        $start = ($offset - 1) * $limit;
        else
        $start = 0;   
        $data['list'] =   $this->cart->get_all_order($limit,$start);
        $data['pagination']   = $this->pagi->page($num,$offset,$limit,'deal_page');
        $this->_templates['page'] = 'cart/listcart';
        $this->templates->load($this->_templates['page'],$data,'member');
    }
    
    function cartdetail(){
        $cart_id = $this->uri->segment(3);
        $data['title'] = "Chi tiết đơn hàng";
        $rs = $this->vdb->find_by_id('shop_cart',array('order_id'=>$cart_id,'user_id'=>$this->user_id,'user_id !='=>0));
        if(!$rs){
            $this->session->set_flashdata('message','Đơn hàng không tồn tại');
            redirect('giao-dich/don-hang');
        }
        $data['rs'] = $rs;
        $data['list_product'] = $this->cart->get_list_product($rs->order_id);
        $data['list_discount'] = $this->cart->get_list_discount($rs->order_id);
        $this->_templates['page'] = 'cart/cart_detail';
        $this->templates->load($this->_templates['page'],$data,'member');
    }
    
    function del(){
        $order_id = $this->uri->segment(3);
        if($this->cart->check_cart($order_id)){
            if($this->vdb->delete('shop_cart',array('order_id'=>$order_id))){
                $this->session->set_flashdata('message','Xóa đơn hàng thành công');
            }else{
                $this->session->set_flashdata('message','Xóa đơn hàng không thành công');
            }
        }else{
            $this->session->set_flashdata('message','Đơn hàng không thể xóa');
        }
        redirect('giao-dich/don-hang');
    }
    
    function xacnhandonhang(){
        $cart_id = $this->input->post('cart_id');
        $check = $this->vdb->find_by_id('shop_cart',array('order_id'=>$cart_id,'user_id'=>$this->user_id));
        if($check){
            $vdata['status'] = 2;
            $this->vdb->update('shop_cart',$vdata,array('order_id'=>$cart_id));
            $data['error'] = 0;
            $data['msg'] = 'Cảm ơn. Đơn hàng đã được xác nhận thành công';
            $data['tinhtrangdonhang'] = $this->cart_status(2);
        }else{
            $data['error'] = 1;
            $data['msg'] = 'Mã đơn hàng không tồn tại';
        }
        echo json_encode($data);
        
    }
    
    
    function message_tranfer(){
        $data['title'] = 'Thông báo chuyển khoản';
        $data['list']  = $this->cart->get_list_order_active();
        $this->form_validation->set_rules('order_id','đơn hàng','required');
        $this->form_validation->set_rules('message','nội dung','required|min_length[10]');
        if($this->form_validation->run() === false){
            $this->pre_message = validation_errors();
        }else{
            $order_id = $this->input->post('order_id');
            if($this->cart->check_cart($order_id)){
                $vdata['order_id'] = $order_id;
                $vdata['user_id'] = $this->user_id;
                $vdata['message'] = $this->input->post('message');
                $vdata['date'] = time();
                $this->vdb->update('shop_message_transfer',$vdata);
                $this->session->set_flashdata('message','Thông báo chuyển khoản thành công');
                redirect('giao-dich/thong-bao-chuyen-khoan');
            }else{
                $this->pre_message = 'Đơn hàng không tồn tại';
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'cart/message_tranfer';
        $this->templates->load($this->_templates['page'],$data,'member');
    }
    
    function cart_status($status){
      if($status == 1){
          return 'Chưa xác nhận';
      }else if($status == 2){
          return 'Đã xác nhận';
      }else if($status==3){
          return 'Đang xử lý';
      }else if($status == 4){
          return 'Hoàn thành';
      }else if($status == 5){
          return 'Đã Hủy';
      }
    }
}