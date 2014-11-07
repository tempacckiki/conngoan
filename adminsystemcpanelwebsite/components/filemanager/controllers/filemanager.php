<?php
class filemanager extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->config('config_filemanager');
        $this->menu = $this->config->item('menu');
    }
    
    function index(){
        redirect('filemanager/images');
    }
    
    function images(){
        $data['title'] = 'Quản lý hình ảnh';
        $this->_templates['page'] = 'images';
        $this->templates->load($this->_templates['page'],$data);         
    }
    
    function filedata(){
        $data['title'] = 'Quản lý File';
        $this->_templates['page'] = 'filedata';
        $this->templates->load($this->_templates['page'],$data);        
    }
    
    function media(){
        $data['title'] = 'Quản lý Media';
        $this->_templates['page'] = 'media';
        $this->templates->load($this->_templates['page'],$data);
    }
}
