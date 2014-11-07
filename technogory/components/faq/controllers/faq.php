<?php
class faq extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
    }
    
    function detail(){
        $id = end(explode('-',$this->uri->segment(2)));
        $rs = $this->vdb->find_by_id('faq',array('id'=>$id));
        if(!$rs){
            redirect('');
        }
        //set top link
        $data['top_link']	= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="javascript:;" itemprop="url"><span itemprop="title">Thông tin hướng dẫn</span></a></div>';
        
        
        $data['rs'] = $rs;
        $data['title'] = $rs->title;
        $this->_templates['page'] = 'detail';
        $this->templates->load($this->_templates['page'],$data,'faq');
    }
}
