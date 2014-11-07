<?php
class cauhinh extends CI_Controller{
    function __construct(){
        parent::__construct();
        //$this->load->model('cauhinh_model','cauhinh');
        $this->load->helper('file');
        $this->pre_message = "";
        $this->mainmenu = 'sangiare';
    }
    
    
    function configshow(){
    	$this->load->config('config_show');
    	$data['save'] = true; 
    	$data['title']			 = 'Cấu hình hiển thị banner';
    	
    	//set view
    	 $data['site_close'] = $this->config->item('view-banner');
    	
    	$this->form_validation->set_rules('view-banner','Chọn hình thức hiển thị','required');
    	 if($this->form_validation->run() == FALSE){
            $this->pre_message = validation_errors();
        }else{
        	$site_close = $this->input->post('view-banner');
        	$str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File Config_site language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
        	
        	$str .= "\n\$config['view-banner'] = '$site_close';";   
        	 
        	$str .= "\n\n/* End of file config_site*/";        
            write_file(ROOT_ADMIN.'config/config_show.php', $str);    
            write_file(ROOT.'site/config/config_show.php', $str);    
            redirect('ads/cauhinh/configshow') ; 
        }
    	
    	$data['message'] = $this->pre_message;
    	//load templates 
    	$this->_templates['page'] = 'cauhinh/configshow';
        $this->templates->load($this->_templates['page'],$data);
    }
}
