<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**************************
* Controller - Photo
* Author: Mr.Phong
* Email: phong.sttm@gmail.com
* Date: 17/06/2012
***************************/
  class rss extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->load->model('rss_model','rss');
             
      }
      
      function index(){
          $data['title'] = "RSS ALOBUY VIỆT NAM";
          $data['titleMain'] = "RSS ALOBUY VIỆT NAM";
          
        
	 //echo date('D, d M Y h:i:s O', strtotime (time()));
          
          //load templates ****
          $this->_templates['page'] = 'index';
          $this->templates->load($this->_templates['page'],$data,'faq');
      }
      
     
  }