<?php
class search extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('search_model','search');
        $this->load->library('pagi');
        $this->regions = $this->session->userdata('fyi_regions');
        $this->city_id = $this->session->userdata('city_site');
        //css
        $css_array = array(
        		array(base_url_static().'technogory/templates/default/css/search.css?v=alobuy.vn')
        );
        $this->esset->css($css_array);
    }
    /**
     * Method search
     * Return <Object>
     */
    function result(){
    	//set title
      $data['title'] = 'Tìm kiếm';
      $ajax = $this->input->post('ajax');
      $productkey = $this->input->get('p');
      $data['productkey'] = $productkey;
      $limit = 30;
      $data['limit'] 	= $limit; 
      $offset		 	= (int)$this->input->post('page_no'); 
      $data['offset'] 	= $offset;
      //get total 
      $num 				= $this->search->get_num_product_by_key($productkey);
      
      $data['total'] = $num;
      if($offset!=0) 
        $start = ($offset - 1) * $limit;
      else
        $start = 0;   
      //get list product **
      $data['list'] 		=   $this->search->get_all_product_by_key($limit,$start,$productkey);
      //set page
      $data['pagination']   = $this->pagi->page($num,$offset,$limit,'searchresult_page');  
      
      $this->_templates['page'] = 'result';
      if($ajax == 1){
        $this->load->view($this->_templates['page'],$data);  
      }else{
        $this->templates->load($this->_templates['page'],$data,'faq');
      }
   }

}
