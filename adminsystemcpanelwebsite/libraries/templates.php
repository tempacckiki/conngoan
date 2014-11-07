<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class CI_templates
{
    // Public properties
    public $settings = array();
    // Protected or private properties
    protected $_table;
    
    // Constructor
    public function __construct()
    {
        if (!isset($this->CI))
        {
            $this->CI =& get_instance();
        }
        $this->CI->load->library('user_agent');  
        if(!$this->CI->session->userdata('lang_admin')){
            $this->CI->session->set_userdata('lang_admin','vietnamese');
        }
    }
    public function load($page, $data = NULL,$layout=FALSE)
    {
        $data['page'] = $page;
        if($layout==TRUE){
                
            $this->CI->load->view('templates/skin_'.$layout, $data);
        }else{
            $this->CI->load->view('templates/skin', $data);
        }        
    }
    

}

/* End of file templates.php */
/* Location: ./admin/libraries/templates.php */