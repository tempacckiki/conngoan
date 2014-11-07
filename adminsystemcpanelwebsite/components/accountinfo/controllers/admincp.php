<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class admincp extends CI_Controller{
    protected $_templates;
    function __construct() {
        parent::__construct();
    }
    
    function index(){
        $this->fcache_model->write_file_cat();
        $data['title'] = 'Bảng điều khiển';
        $this->_templates['page'] = 'index';
        write_log(0,0,'Đăng nhập hệ thống');
        $this->templates->load($this->_templates['page'],$data);
    }
}
?>
