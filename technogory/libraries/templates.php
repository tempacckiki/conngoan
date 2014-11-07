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
        $this->CI->config->set_item('language',$this->CI->session->userdata('lang_site'));
        $this->CI->lang->load('site',$this->CI->session->userdata('lang_site'));
    }
    public function load($page, $data = NULL,$layout=FALSE)
    {
        $data['page'] = $page;
        if($layout==TRUE){
                
            $this->CI->load->view('templates/default/skin_'.$layout, $data);
        }else{
            $this->CI->load->view('templates/default/skin', $data);
        }        
    }
}

/* End of file System.php */
/* Location: ./application/libraries/System.php */