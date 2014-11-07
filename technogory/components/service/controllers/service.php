<?php
class service extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
    }
    
    function index(){
        $id = end(explode('-',$this->uri->segment(2)));
        $rs = $this->vdb->find_by_id('service',array('id'=>$id));
        if(!$rs){
            redirect();
        }
        $data['title'] = $rs->name;
        $data['rs'] = $rs;
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data,'detail');
    }
}