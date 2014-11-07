<?php
class subscriptions extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('subscriptions_model','subscriptions');
    }
    
    function index(){
        $data['title'] = 'Đăng ký nhận khuyến mãi qua Email';
        $config['base_url'] = base_url().'subscriptions/index/';  
        $config['total_rows']   =  $this->subscriptions->get_num();
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->subscriptions->get_all($config['per_page'], $this->uri->segment(3));
        $data['pagination']    = $this->pagination->create_links(); 
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
}
