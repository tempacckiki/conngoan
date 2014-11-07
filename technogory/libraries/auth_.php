<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class auth {

    var $CI;
    
    /**
     * Constructor
     */
    function __construct()
    {
        // Obtain a reference to the ci super object
        $this->CI =& get_instance();
        
        $this->CI->load->library('session');
        $this->CI->load->helper('cookie');
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Check user signin status
     *
     * @access public
     * @return bool
     */
    function is_signed_in()
    {
        return $this->CI->session->userdata('user_id') ? TRUE : FALSE;
    }
    
    // --------------------------------------------------------------------
    
    /**
     * Sign user in
     *
     * @access public
     * @param int $account_id
     * @param bool $remember
     * @return void
     */
    function sign_in($account_id, $remember = FALSE)
    {

        $this->CI->db->where('published',1);
        $this->CI->db->where('user_id',$account_id);
        $row = $this->CI->db->get('user')->row();
        $this->CI->session->set_userdata($row);

        redirect(base64_decode($this->CI->uri->segment(2))); 

    }
    function sign_in_ajax($account_id)
    {

        $this->CI->db->where('published',1);
        $this->CI->db->where('user_id',$account_id);
        $row = $this->CI->db->get('user')->row();
        $this->CI->session->set_userdata($row);                      


    }    
    // --------------------------------------------------------------------
    
    /**
     * Sign user out
     *
     * @access public
     * @return void
     */
    function sign_out()
    {
        $this->CI->db->where('published',1);
        $this->CI->db->where('user_id',$this->CI->session->userdata('user_id'));
        $row = $this->CI->db->get('user')->row();        
        $this->CI->session->unset_userdata($row);               
    }
    

    
}


/* End of file Authentication.php */
/* Location: ./system/application/modules/account/libraries/Authentication.php */