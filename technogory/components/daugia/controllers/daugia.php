<?php
class daugia extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('daugia_model','daugia');
        //$this->regions = $this->session->userdata('fyi_regions');
        $this->city_id = $this->session->userdata('city_site');
        $cssArray = array(
        			  array(base_url().'technogory/templates/default/css/bid.css')
        				);
        
        $jsArray = array(
        		array(base_url().'technogory/templates/default/js/bid_auction.js')
        );
        $this->esset->css($cssArray);
        $this->esset->js($jsArray);
      
    }

    function index(){
       	$data["title"]      = "Đấu giá";      
       	// Phien dau gia dang dien ra
       	$config['base_url'] 	= base_url().'/dang-dien-ra/';
       	$config['suffix'] 		= '.html';
       	$config['total_rows']   =  $this->daugia->get_num_bid();
       	$data['num'] 			= $config['total_rows'];
       	$config['per_page']  	= 8;
       	$config['uri_segment']  = 2;
       	$this->load->library('pagination');
       	$this->pagination->initialize($config);
       	
       	$data['list'] =   $this->daugia->get_all_bid($config['per_page'],$this->uri->segment(2));
      
       	$data['pagination']    = $this->pagination->create_links();
       	
       	// Phien dau gia da ketthuc
       	
       /* 	$limit = 15;
       	$data['limit'] = $limit;
       	$offset = (int)$this->input->post('page_no');
       	$data['offset'] = $offset;
       	$num = $this->vnit->get_num_old();
       	$data['num_old'] = $num;
       	if($offset!=0)
       		$start = ($offset - 1) * $limit;
       	else
       		$start = 0;
       	$data['list_old'] =   $this->vnit->get_all_old($limit,$start);
       	$data['pagination_old']   = $this->pagi->page($num,$offset,$limit,'oldpage');
       	 */
	       //load template **********************
	     $this->_templates['page'] = 'index';
	     $this->templates->load($this->_templates['page'],$data,'bid');
       
     }
        
   
    
  
}
