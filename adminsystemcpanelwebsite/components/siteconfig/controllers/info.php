<?php
class info extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->helper('file');
    }
    function index(){
        $this->load->config('config_site');
        $data['title'] = 'Cấu hình website';
        $data['save'] = true;       
        $data['site_name'] = $this->config->item('site_name');
        $data['site_close'] = $this->config->item('site_close');
        $data['site_message_close'] = $this->config->item('site_message_close');
        $data['site_des'] = $this->config->item('site_des');
        $data['site_keyword'] = $this->config->item('site_keyword');
        $this->form_validation->set_rules('site_name','Tên website','required');
        $this->form_validation->set_rules('site_close','Đóng website','required');
        $this->form_validation->set_rules('site_message_close','Thông báo đóng website','required');
        $this->form_validation->set_rules('site_des','Miêu tả','required');
        $this->form_validation->set_rules('site_keyword','Từ khóa','required');
        if($this->form_validation->run() == FALSE){
            $this->pre_message = validation_errors();
        }else{
            $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File Config_site language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
            $site_name = $this->input->post('site_name');
            $site_close = $this->input->post('site_close');
            $site_message_close = $this->input->post('site_message_close');
            $site_des = $this->input->post('site_des');
            $site_keyword = $this->input->post('site_keyword');
            $str .= "\n\$config['site_name'] = '$site_name';";  
            $str .= "\n\$config['site_close'] = $site_close;";  
            $str .= "\n\$config['site_message_close'] = '$site_message_close';";  
            $str .= "\n\$config['site_des'] = '$site_des';";  
            $str .= "\n\$config['site_keyword'] = '$site_keyword';";  
            
            $str .= "\n\n/* End of file config_site*/";        
            write_file(ROOT.'technogory/config/site/'.vnit_lang().'/config_site.php', $str);    
            write_log(60,179,'Cập nhật cấu hình hệ thống');
            redirect('siteconfig/info') ;     
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'info/index';
        $this->templates->load($this->_templates['page'],$data);
    }
}
