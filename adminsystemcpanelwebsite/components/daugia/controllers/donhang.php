<?php
class donhang extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('donhang_model','donhang');
        $this->pre_message = "";
        $this->load->config('config_mdaugia');
        $this->mdaugia = $this->config->item('mdaugia');
    }
    
    function ds(){
        $data['title'] = 'Danh sách đơn hàng';
        $data['delete'] = true;
        $uri4 = $this->uri->segment(4);
        $data['offset'] = $this->uri->segment(5);
        $field = $this->uri->segment(6);
        $order = $this->uri->segment(7);          
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'daugia/donhang/ds/'.$uri4;
        $config['total_rows']   =  $this->donhang->get_num_donhang($uri4);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 5; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->donhang->get_all_donhang($config['per_page'],$this->uri->segment(5),$uri4,$field,$order);
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message;  
        $this->_templates['page'] = 'donhang/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function chitiet(){
        $cart_id = $this->uri->segment(4);
        $tinhtrang = $this->uri->segment(5);
        $offset = $this->uri->segment(6);
        $rs = $this->donhang->get_chitiet($cart_id);
        $data['title'] = 'Chi tiết đơn hàng :'.$rs->barcode;
        $data['cancel'] = 'daugia/donhang/ds/'.$tinhtrang.'/'.$offset;
        $data['rs'] = $rs;
        $data['cheap']  = $this->vdb->find_by_id('cheap_list',array('id'=>$rs->cheap_id));
        $data['giamgia'] = $this->donhang->get_all_giamgia($cart_id);
        $data['tonggiamgia'] = $this->donhang->get_sum_giamgia($cart_id);
        $sql = "UPDATE cheap_cart SET moinhat = 0 WHERE cart_id=".$cart_id;
        $this->db->query($sql);
        $this->form_validation->set_rules('id','','');
        if($this->form_validation->run()){

            $id = $this->input->post('id');
            $cart = $this->input->post('cart');
            if($rs->admin_user_id ==0){
                $cart['admin_user_id'] = $this->session->userdata('user_id');
            }
            $this->vdb->update('cheap_cart',$cart,array('cart_id'=>$cart_id));
            $this->session->set_flashdata('message','Cập nhật thành công');
            redirect(uri_string());
        }
        $this->_templates['page'] = 'donhang/detail';
        $this->templates->load($this->_templates['page'],$data);
    }
    

    
    function guiemail(){
        $cart_id = $this->input->post('cart_id');
        $ghichukh = $this->input->post('ghichukh');
        $data['msg'] = 'Gửi Email tới khách hàng thành công';
        echo json_encode($data);
    }
    // Xoa 1 don hang
    function del(){
          $cart_id = $this->uri->segment(4);
          $tinhtrang = $this->uri->segment(5);
          $page = $this->uri->segment(6);
          if($this->vdb->delete('cheap_cart',array('cart_id'=>$cart_id))){
              $this->session->set_flashdata('message','Đã xóa thành công');
          }else{ 
              $this->session->set_flashdata('error','Xóa không thành công');
          }
          redirect('daugia/donhang/ds/'.$tinhtrang.'/'.$page);
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
                    if($this->vdb->delete('cheap_cart',array('cart_id'=>$ar_id[$i]))){
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{ 
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('daugia/donhang/ds/'.$tinhtrang.'/'.$page);
    }     
}
