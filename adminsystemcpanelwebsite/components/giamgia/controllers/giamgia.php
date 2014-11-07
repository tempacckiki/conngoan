<?php
class giamgia extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('giamgia_model','giamgia');
        $this->pre_message = "";
    }
    
    function ds(){
        $data['title'] = 'Danh sách mã giảm giá';
        write_log(85,272,'Danh sách mã giảm giá');
        $data['add'] = 'giamgia/add|'.icon_add('giamgia/add');
        $data['delete'] = icon_dels('giamgia/dels');
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);
        if($field == '' && $order ==''){
           $field = 'discount_datebegin';
           $order = 'desc';
        }
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'giamgia/ds/';
        $config['total_rows']   =  $this->giamgia->get_num_giamgia();
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->giamgia->get_all_giamgia($config['per_page'],$this->uri->segment(3),$field,$order);
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message;           
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới mã giảm giá';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'giamgia/ds';
        $this->form_validation->set_rules('dis[discount_key]','Mã giảm giá','required');
        $this->form_validation->set_rules('dis[discount_price]','Giá trị','required');
        $this->form_validation->set_rules('dis[discount_total]','Tổng phiếu','required');
        $this->form_validation->set_rules('dis[discount_datebegin]','Ngày bắt đầu','required');
        $this->form_validation->set_rules('dis[discount_dateend]','Ngày kết thúc','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $dis = $this->input->post('dis');
            $dis['discount_price'] = str_replace('.','',$dis['discount_price']);
            $dis['discount_datebegin'] = strtotime($dis['discount_datebegin']);
            $dis['discount_dateend'] = strtotime($dis['discount_dateend']);
            if($id = $this->vdb->update('shop_discount',$dis)){
            write_log(85,273,'Thêm mã giảm giá');
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'giamgia/ds';
                }else{
                    $url = 'giamgia/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $data['title'] = 'Cập nhật mã giảm giá';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'giamgia/ds';
        $this->form_validation->set_rules('dis[discount_key]','Mã giảm giá','required');
        $this->form_validation->set_rules('dis[discount_price]','Giá trị','required');
        $this->form_validation->set_rules('dis[discount_total]','Tổng phiếu','required');
        $this->form_validation->set_rules('dis[discount_datebegin]','Ngày bắt đầu','required');
        $this->form_validation->set_rules('dis[discount_dateend]','Ngày kết thúc','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $dis = $this->input->post('dis');
            $dis['discount_price'] = str_replace('.','',$dis['discount_price']);
            $dis['discount_datebegin'] = strtotime($dis['discount_datebegin']);
            $dis['discount_dateend'] = strtotime($dis['discount_dateend']);
            if($this->vdb->update('shop_discount',$dis,array('discount_id'=>$id))){
                write_log(85,274,'Cập nhật mã giảm giá'); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'giamgia/ds';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        $data['rs'] = $this->vdb->find_by_id('shop_discount',array('discount_id'=>$this->uri->segment(3)));
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){  
                    if($this->vdb->delete('shop_discount',array('discount_id'=>$ar_id[$i]))){
                        write_log(85,275,'Xóa nhiều mã giảm giá'); 
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }
                    
                    else $this->session->set_flashdata('error','Xóa không thành công');
                }
            }
        }
        redirect('giamgia/ds/'.$page);
    }
}