<?php
class nsx extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('nsx_model','nsx_model');
    }
}
