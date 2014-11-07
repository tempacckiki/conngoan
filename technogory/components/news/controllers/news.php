<?php
class news extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('news_model','news');
        $this->load->library('pagi');
        $js = array(
            array(base_url().'technogory/templates/default/js/news.js')
        );
        $this->esset->js($js);
    }
    
    function index(){
        $data['title'] = 'ALO News - Tin tức triệu đô dành cho thế hệ Net Việt';
        $data['list_noibat'] = $this->news->get_list_noibat();
        $data['list_noibatNext'] = $this->news->get_list_noibatNext();
        
        $data['listcat'] = $this->news->get_all_cat();
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data,'news');
    }
    
    function page(){
        $uri3 = $this->uri->segment(3);
        $uri2 = $this->uri->segment(2);
        
        if($uri3 != ''){ // Detail
            $newsid = end(explode('-',$uri3));
            $rs = $this->vdb->find_by_id('news_detail',array('newsid'=>$newsid));            
            // UPdate View
            $this->db->query("UPDATE news_detail SET hits = hits + 1 WHERE newsid = ".$newsid);
            
            $catinfo = $this->vdb->find_by_id('news_cat',array('catid'=>$rs->catid));  
            if($rs){
                $data['title'] 		 = $rs->title;
                $data['catinfo'] 	 = $catinfo;
                $data['rs'] 		 = $rs;
                $data['listorther']  = $this->news->get_orther_news($catinfo->catid, $rs->newsid);
                $data['listViewMax'] = $this->news->get_orther_newsView($catinfo->catid, $rs->newsid);
                $data['listcomment'] = $this->news->get_list_comment($rs->newsid);
               //get cat id random
               $randCat	   			 =  $this->news->getAllCatArr();
               $data["randCat"]	 = $randCat;
              
               
                //load templates *****************************
                $this->_templates['page'] = 'detail';
                $this->templates->load($this->_templates['page'],$data,'news');
            }else{
                redirect('news');
            }
        }else{ // Cat
            $catid = end(explode('-',$uri2));
            //get list noi bac
            $data['list_noibat'] 	 = $this->news->get_listNoibatCatID($catid);
            
            $catinfo = $this->vdb->find_by_id('news_cat',array('catid'=>$catid));
            if($catinfo){
                $data['title'] = $catinfo->catname;
                $data['catinfo'] = $catinfo;
                $limit = 20;
                $data['limit'] = $limit; 
                $offset = (int)$this->input->post('page_no'); 
                $data['offset'] = $offset;
                $num = $this->news->get_num_news($catid);
                $data['num'] = $num;
                if($offset!=0) 
                    $start = ($offset - 1) * $limit;
                else
                    $start = 9;   
                $data['list'] =   $this->news->get_all_news($limit, $start, $catid);
                $data['pagination']   = $this->pagi->page($num,$offset,$limit,'news_page');  
                $this->_templates['page'] = 'cat';
                $this->templates->load($this->_templates['page'],$data,'news');
            }else{
                redirect();
            }
        }
    }
    
    
    function catpage(){
        $catinfo = $this->vdb->find_by_id('news_cat',array('catid'=>$this->uri->segment(3)));
        $data['catinfo'] = $catinfo;
        $limit = 20;
        $data['limit'] = $limit; 
        $offset = (int)$this->input->post('page_no'); 
        $data['offset'] = $offset;
        $num = $this->news->get_num_news($catinfo->catid);
        $data['num'] = $num;
        if($offset!=0) 
            $start = ($offset - 1) * $limit;
        else
            $start = 0;   
        $data['list'] =   $this->news->get_all_news($limit, $start, $catinfo->catid);
        $data['pagination']   = $this->pagi->page($num,$offset,$limit,'news_page');  
        $this->_templates['page'] = 'catpage';
        $this->load->view($this->_templates['page'],$data);
    }
    
    
    
    /*--------------------------------------+
     * ajaxvideo
     +------------------------------------*/
 	function ajaxvideo(){
      	$id			 	 = (int)$this->input->post("id");
      	//$row   		 	 = $this->vdb->find_by_id("video_news", array('video_id'=>$id));
      	//$video_url		 = (!empty($row->video_url))?$row->video_url:$row->video_link;
      	//$data  	 		 = '<div id="videoList"></div><script type="text/javascript">jwplayer("videoList").setup({"flashplayer":"'.base_url().'site/templates/fyi/js/player.swf","file":"'.$video_url.'","autostart":true,"width":300,"height":270,"controlbar":"bottom","Smoothing": true});</script>';      	     
      	echo json_encode($id);
      }
      
      
}