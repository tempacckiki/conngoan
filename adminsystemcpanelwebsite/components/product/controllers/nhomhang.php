<?php
class nhomhang extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('nhomhang_model','nhomhang');
    }
    
    function dsnhomhang(){
        $data['title'] = 'Danh sách nhóm hàng';
        $maincat = (int)$this->uri->segment(4);
        $data['delete'] = true;
        $data['add'] = 'product/shop/addcat/'.$maincat;

        $data['listcat'] = $this->shop->get_main_cat(); 
        $field = $this->uri->segment(6);
        $order = $this->uri->segment(7);          
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'shop/listcat/'.$maincat;  
        $config['total_rows']   =  $this->shop->get_num_cat($maincat);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 5; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->shop->get_all_cat($maincat,$field,$order,$config['per_page'],$this->uri->segment(5));
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message;          
        $this->_templates['page'] = 'cat/list';
        $this->templates->load($this->_templates['page'],$data);
    }
}