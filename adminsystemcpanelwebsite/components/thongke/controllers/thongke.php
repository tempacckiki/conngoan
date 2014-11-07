<?php
class thongke extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('thongke_model','thongke');
        $this->pre_message = "";
    }
    
    function index(){
        $data['title'] = 'Thống kê đơn hàng';
        $data['list'] = $this->thongke->get_main_cat();
        $data['listcity'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $this->form_validation->set_rules('tungay','Từ ngày','required');
        $this->form_validation->set_rules('denngay','Đến ngày','required');
        if($this->form_validation->run() == FALSE){
            $this->pre_message = validation_errors();
        }else{
            $data['catid'] = $this->input->post('catid');
            $data['city_id'] = $this->input->post('city_id');
            $tungay = $this->input->post('tungay');
            $denngay = $this->input->post('denngay');
            $status = $this->input->post('status');
            $order_field = explode('|',$this->input->post('order'));
            $field = $order_field[0];
            $order = $order_field[1];
            $data['list'] = $this->thongke->get_all_order($tungay,$denngay,$status,$data['city_id'],$field,$order);
            $this->_templates['page'] = 'thongke';
            $this->load->view($this->_templates['page'],$data);
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
}
