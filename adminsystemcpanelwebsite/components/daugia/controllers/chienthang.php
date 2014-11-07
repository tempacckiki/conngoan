<?php
class chienthang extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('chienthang_model','chienthang');
        $this->group_id = $this->session->userdata('group_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->pre_message = "";
        $this->mainmenu = 'sandaugia';
    }
    function ds(){
        $data['title'] = 'Dành chiến thắng';
        //$data['delete'] = true;
        $catid = (int)$this->uri->segment(4);
        $field = $this->uri->segment(6);
        $order = $this->uri->segment(7);          


        $config['base_url'] = base_url().'daugia/chienthang/ds/'; 
        $config['total_rows']   =  $this->chienthang->get_num_phiendaugia();
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 4; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->chienthang->get_all_phiendaugia($config['per_page'],$this->uri->segment(4));
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message; 
        $this->_templates['page'] = 'chienthang/index';
        $this->templates->load($this->_templates['page'],$data);
    }
}
