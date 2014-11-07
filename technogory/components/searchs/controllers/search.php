<?php
class search extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('search_model','search');
        $this->lang->load('search',$this->session->userdata('lang_site'));
        $this->load->library('pagi');
        $css_array = array(
            array(base_url().'site/components/content/views/esset/content.css')
        );
        $this->esset->css($css_array);
    }
    
    function result(){
        $data['title'] = lang('search.result');
        $this->link[0] = lang('search.result');
        $key = ($this->input->get('key') =='Tìm kiếm')?'':$this->input->get('key');
        $data['key'] = $key;
        $limit = 10;
        $data['limit'] = $limit; 
        $offset = (int)$this->input->post('page_no'); 
        $data['offset'] = $offset;
        $num = $this->search->get_num_search($key);
        $data['num'] = $num;
        if($offset!=0) 
            $start = ($offset - 1) * $limit;
        else
            $start = 0;   
        $data['list'] =   $this->search->get_all_search($limit,$start,$key);
        $data['pagination']   = $this->pagi->page($num,$offset,$limit);        
        $data['total_page'] = round($num/$limit,0);
        $data['current'] = ($offset == 0)?1:$offset;
        $data['page_number'] = ($offset == 1)?1: ($offset* $limit - ($limit-1) );        
        $this->_templates['page'] = 'result';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function ajax_result(){
        $key = $this->input->post('key');
        $data['key'] = $key;
        $limit = 20;
        $data['limit'] = $limit; 
        $offset = (int)$this->input->post('page_no'); 
        $data['offset'] = $offset;
        $num = $this->search->get_num_search($key);
        $data['num'] = $num;
        if($offset!=0) 
            $start = ($offset - 1) * $limit;
        else
            $start = 0;   
        $data['list'] =   $this->search->get_all_search($limit,$start,$key);
        $data['pagination']   = $this->pagi->page($num,$offset,$limit);        
        $data['total_page'] = round($num/$limit,0);
        $data['current'] = ($offset == 0)?1:$offset;
        $data['page_number'] = ($offset == 1)?1: ($offset* $limit - ($limit-1) );        
        $this->_templates['page'] = 'result';
        $this->load->view($this->_templates['page'],$data);       
    }
}
