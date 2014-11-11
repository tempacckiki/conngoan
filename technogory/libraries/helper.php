<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once (ROOT . 'debug/debug.php');

class helper {

    var $CI;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        // Obtain a reference to the ci super object
        $this->CI =& get_instance();

        // load model
        $this->CI->load->model('bannerads_model'
            , 'bannerads_model'
            , false
            , CODEIGNITER_ADMIN_DIR . 'components/quangcao/models/');
    }

    public function getBannerAdsByPosition($position = 1){
        return $this->CI->bannerads_model->getBannerByPosition($position);
    }
    
    
}
