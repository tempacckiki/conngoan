<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class installer extends CI_Controller{
    protected $_templates;
    function __construct() {
        parent::__construct();
        $this->load->model('installer_model','installer');
    }
    
    function index(){
        $data['title'] = 'Cài đặt, tháo gỡ';
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
}
?>
