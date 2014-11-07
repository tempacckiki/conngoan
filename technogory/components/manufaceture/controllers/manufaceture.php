<?php
class manufaceture extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('category_model','category');
        $this->regions = $this->session->userdata('fyi_regions');
        $this->city_id = $this->session->userdata('city_site');
       
        $this->uri1 = $this->uri->segment('1');
        $this->uri2 = $this->uri->segment('2');
        $this->uri3 = $this->uri->segment('3');
    }

    
    
    //*************************
    function get_page_cat(){

        $get                  = $this->input->get();      
        $max = (int)$this->input->get('max');
        $min = (int)$this->input->get('min');
        $data['max'] = $max;
        $data['min'] = $min;        
        $data['total']        = rcount($get);
        $ar_feature 		  = trim($this->input->get('varian'),',');

        $manufacture 		 = end(explode('-', $this->uri->segment('2')));
        
        $color 				  = trim($this->input->post('color'),',');

        
        $hot                  = $this->input->post('hot');
        $view                 = $this->input->post('view');
        $view                 = 'view_list';
        $this->session->set_userdata(array('vnit_view'=>($view != '') ? $view : ''));
        
        $order                = $this->input->post('order');

        $data['hot']          = $hot;
        $data['order']        = $order;
        $data['view']         = $view;
        $catid                = (int)$this->uri->segment('3');
        
        $data['catid'] 		  = $catid; 
        //get itemcatID
        $itemCat			 = $this->category->get_cat_by_id($catid);
        //get manufacture
        $itemManuface		= $this->category->get_manufacture_id($manufacture);
     
       
        
        
        if($this->session->userdata('vnit_view')=='view_list'){
        	$limit  =   40;  
        }else{
        	$limit =  40; 
        }
        $data['limit']        = $limit; 
    
         
        $num                  = $this->category->get_num_product($catid,$max,$min,$hot,$ar_feature,$manufacture,$color);
        $data['num']          = $num; 
       
        //config *******************
        $config['base_url'] 		= base_url().'hang-san-xuat/'.$this->uri2.'/'. $this->uri3.'/';
        $config['total_rows']  		=  $num;;
        
        $config['per_page']   	= $limit;
        $config['uri_segment'] 	= 4;
        $this->pagination->initialize($config);
        
        $data['list']         =  $this->category->get_all_product($config['per_page'],(int) $this->uri->segment('4'), $catid, $max, $min, $hot,$order, $ar_feature, $manufacture, $color);
        
        
        $data['listcat']    	= $this->category->get_subcat($catid);
        $data['top_link']   	= $this->category->find_top_link($catid,$itemCat->parentid);
        $data['top_link_seo'] 	= 'http://alobuy.vn/'.$this->uri1.'/'.$this->uri2.'/'.$this->uri3.'.html';
        $data['spbanbanchay'] 	= $this->category->get_sanpham_banchay($catid);
        $data['listcompare'] 	= $this->vdb->find_by_list('shop_compare',array('session_id'=>cookie_mycart()));
        
        $data['title']      = $itemCat->catname.' '.$itemManuface->name;
        //set view key
        $data['catkeyword'] = $itemCat->catkeyword;
        //set view description
        $data['catdes'] 	= $itemCat->catdes;
        
        $data['pagination']    	= $this->pagination->create_links(); 
        
        $this->_templates['page'] = 'search';
        $this->templates->load($this->_templates['page'],$data,'cat');
    }
    
   
}
