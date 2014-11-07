<?php
class content extends CI_Controller{
	protected $_templates;
	function __construct(){
		parent::__construct();
        $this->lang->load('content',$this->session->userdata('lang_site'));
        $this->load->model('content_model','content');
        $this->uri2 = $this->uri->segment(2);
        $this->uri3 = $this->uri->segment(3);
        $this->uri4 = $this->uri->segment(4);
        $this->uri5 = $this->uri->segment(5);
        $this->uri6 = $this->uri->segment(6);
        $css_array = array(
                array(base_url().'site/components/content/views/esset/content.css')
          ); 
        $this->esset->css($css_array);  

	}
    
    function page(){
        
        if($this->uri3 == 'sendmail'){           
            $id = end(explode('-',$this->uri4));
            $data['rs'] = $this->vdb->find_by_id('content',array('id'=>$id));
            $this->load->view('sendmail/index',$data);
        }else if($this->uri3 == 'printer'){
            $id = end(explode('-',$this->uri4));
            $data['rs'] = $this->vdb->find_by_id('content',array('id'=>$id));
            $this->templates->load('printer/index',$data,'print');            
        }else  if( ($this->uri4 =='') || ( count(explode('-',$this->uri4)) <=1) ){
            $sections_id = end(explode('-',$this->uri3));
            $data['sections'] = $this->vdb->find_by_id('sections',array('sections_id'=>$sections_id));
            if( !$data['sections'] ){
                redirect();
            }
            $data['title'] = $data['sections']->sections_title;  
            $this->link[0] = $data['sections']->sections_title; 
            $config['base_url'] = base_url().vnit_lang().'/content/'.$this->uri3;  
            $config['total_rows']   =  $this->vdb->find_by_num('content',array('sections_id'=>$sections_id,'lang'=>vnit_lang()));
            $data['num'] = $config['total_rows'];
            $config['per_page']  =   10;
            $config['uri_segment'] = 4; 
            $this->load->library('pagination');
            $this->pagination->initialize($config);   
            $data['list'] =   $this->vdb->find_by_all('content',$config['per_page'],$this->uri->segment(4),array('sections_id'=>$sections_id,'lang'=>vnit_lang()),'id','desc');
            $data['pagination']    = $this->pagination->create_links();
            $data['total_page'] = round($config['total_rows']/$config['per_page'],0);
            $data['current'] = ($this->uri4 == 0)?1:($this->uri4/$config['per_page'])+1;
            $this->_templates['page'] = 'sections/index';
            $this->templates->load($this->_templates['page'],$data);
            
        }else if( count(explode('-',$this->uri5)) <=1 ){
            $catid = end(explode('-',$this->uri4));
            $data['category'] = $this->vdb->find_by_id('category',array('cat_id'=>$catid));
            if( !$data['category'] ){
                //redirect();
            }
            $sections = $this->vdb->find_by_id('sections',array('sections_id'=>$data['category']->section));
            $data['title'] = $sections->sections_title.' - '.$data['category']->cat_title;
            $this->link[0] = $data['category']->cat_title; 
            //$this->link[0] = $sections->sections_title.':content/'.$sections->sections_alias.'-'.$sections->sections_id; 
            $config['base_url'] = vnit_lang().'/content/'.$this->uri3.'/'.$this->uri4;  
            $config['total_rows']   =  $this->vdb->find_by_num('content',array('catid'=>$catid,'lang'=>vnit_lang()));
            $data['num'] = $config['total_rows'];
            
            $config['per_page']  =   10;
            $config['uri_segment'] = 5; 
            $this->load->library('pagination');
            $this->pagination->initialize($config);   
            $data['list'] =   $this->vdb->find_by_all('content',$config['per_page'],$this->uri->segment(5),array('catid'=>$catid,'lang'=>vnit_lang()),'id','desc');
            $data['pagination']    = $this->pagination->create_links();
            $data['total_page'] = round($config['total_rows']/$config['per_page'],0);
            $data['current'] = ($this->uri5 == 0)?1:($this->uri5/$config['per_page'])+1;            
            $this->_templates['page'] = 'category/index';
            $this->templates->load($this->_templates['page'],$data);
            
        }else{

            $css_array = array(
                array(base_url().'site/components/product/views/esset/jquery.fancybox-1.3.4.css')
            );
            $this->esset->css($css_array);
            $js_array = array(
                array(base_url().'site/components/product/views/esset/jquery.fancybox-1.3.4.js'),
                array(base_url().'site/components/product/views/esset/jquery.easing-1.3.pack.js'),
                array(base_url().'site/templates/system/js/jquery.validate.min.js')
            );
            $this->esset->js($js_array);            
            
            $id =  end(explode('-',$this->uri5));
            $rs = $this->vdb->find_by_id('content',array('id'=>$id));
            if(!$rs){
                redirect();
            }
            $this->db->query("UPDATE content SET hits = hits + 1 WHERE id = ".$id);
            $section = $this->vdb->find_by_id('sections',array('sections_id'=>$rs->sections_id));
            //$this->link[0] = $section->sections_title.':content/'.$section->sections_alias.'-'.$section->sections_id;
            $cat = $this->vdb->find_by_id('category',array('cat_id'=>$rs->catid));
            if($cat){
                $this->link[0] = $cat->cat_title.':content/'.$this->vdb->find_by_id('sections',array('sections_id'=>$rs->sections_id))->sections_alias.'-'.$cat->section.'/'.$cat->cat_alias.'-'.$cat->cat_id;
            }
            $data['title'] = $rs->title; 
            $data['rs'] = $rs;
            $data['list'] = $this->content->get_orther($rs->id,$rs->catid,vnit_lang());
            $this->_templates['page'] = 'article/index';
            $this->templates->load($this->_templates['page'],$data);
        }
        
        
        
    }
}
