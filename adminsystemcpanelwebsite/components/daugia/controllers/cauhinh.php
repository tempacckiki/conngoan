<?php
class cauhinh extends CI_Controller{
    function __construct(){
        parent::__construct();
        //$this->load->model('cauhinh_model','cauhinh');
        $this->load->helper('file');
        $this->pre_message = "";
        $this->mainmenu = 'sandaugia';
    }
    function cauhinhsite(){
        $this->load->config('config_daugia');
        $data['title'] = 'Cấu hình website Sàn giá rẻ';
        $data['save'] = true;       
        // Vi
        $data['site_name_vi'] = $this->config->item('site_name_vi');
        $data['time_server'] = $this->config->item('time_server');
        $data['site_close'] = $this->config->item('site_close');
        $data['site_message_close_vi'] = $this->config->item('site_message_close_vi');
        $data['site_des_vi'] = $this->config->item('site_des_vi');
        $data['site_keyword_vi'] = $this->config->item('site_keyword_vi');
        // En
        $data['site_name_en'] = $this->config->item('site_name_en');
        $data['site_message_close_en'] = $this->config->item('site_message_close_en');
        $data['site_des_en'] = $this->config->item('site_des_en');
        $data['site_keyword_en'] = $this->config->item('site_keyword_en');
        
        $this->form_validation->set_rules('site_name_vi','Tên website - vi','required');
        $this->form_validation->set_rules('site_close','Đóng website','required');
        $this->form_validation->set_rules('site_message_close_vi','Thông báo đóng website - vi','required');
        $this->form_validation->set_rules('site_des_vi','Miêu tả - vi','required');
        $this->form_validation->set_rules('site_keyword_vi','Từ khóa - vi','required');
        
        $this->form_validation->set_rules('site_name_en','Tên website -en','required');
        $this->form_validation->set_rules('site_message_close_en','Thông báo đóng website - en','required');
        $this->form_validation->set_rules('site_des_en','Miêu tả - en','required');
        $this->form_validation->set_rules('site_keyword_en','Từ khóa - en','required');
        if($this->form_validation->run() == FALSE){
            $this->pre_message = validation_errors();
        }else{
            $str = "<?php";
            $time_server = $this->input->post('time_server');
            $site_name_vi = $this->input->post('site_name_vi');
            $site_close = $this->input->post('site_close');
            $site_message_close_vi = $this->input->post('site_message_close_vi');
            $site_des_vi = $this->input->post('site_des_vi');
            $site_keyword_vi = $this->input->post('site_keyword_vi');
            $site_name_en = $this->input->post('site_name_en');
            $site_message_close_en = $this->input->post('site_message_close_en');
            $site_des_en = $this->input->post('site_des_en');
            $site_keyword_en = $this->input->post('site_keyword_en');
            $str .= "\n\$config['time_server'] = $time_server;";  
            $str .= "\n\$config['site_name_vi'] = '$site_name_vi';";  
            $str .= "\n\$config['site_close'] = $site_close;";  
            $str .= "\n\$config['site_message_close_vi'] = '$site_message_close_vi';";  
            $str .= "\n\$config['site_des_vi'] = '$site_des_vi';";  
            $str .= "\n\$config['site_keyword_vi'] = '$site_keyword_vi';"; 
            $str .= "\n\$config['site_name_en'] = '$site_name_en';";    
            $str .= "\n\$config['site_message_close_en'] = '$site_message_close_en';";  
            $str .= "\n\$config['site_des_en'] = '$site_des_en';";  
            $str .= "\n\$config['site_keyword_en'] = '$site_keyword_en';";
            
            $str .= "\n\n/* End of file config_site*/";        
            write_file(ROOT_ADMIN.'config/config_daugia.php', $str);    
            redirect('daugia/cauhinh/cauhinhsite/info') ;     
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'cauhinh/cauhinhsite';
        $this->templates->load($this->_templates['page'],$data);
    }
}
