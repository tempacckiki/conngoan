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
        $this->CI->load->model('vnit_model'
            , 'vnit_model'
            , false
            , CODEIGNITER_FRONTEND_DIR . '/components/vnit/models/');
        $this->CI->load->model('shop_model'
            , 'shop_model'
            , false
            , CODEIGNITER_ADMIN_DIR . '/components/product/models/');
    }

    public function getBannerAdsByPosition($position = 1){
        return $this->CI->bannerads_model->getBannerByPosition($position);
    }

    public function getRecursiveChildCatByParentId($parentid, $published = 1){
        return $this->CI->vnit_model->getRecursiveChildCatByParentId($parentid, $published);
    }

    public function getProductByMainCatId($catid){
        return $this->CI->vnit_model->getProductByMainCatId($catid);
    }

    public function getProductImageByProductId($productid){
        return $this->CI->vnit_model->getProductImageByProductId($productid);
    }

    public function getGlobalSettings(){
        return $this->CI->shop_model->getGlobalSettings();
    }

    public function getProductByStatus($status){
        return $this->CI->vnit_model->getProductByStatus($status);
    }

    public function getRandomProduct(){
        return $this->CI->vnit_model->getRandomProduct();
    }

}
