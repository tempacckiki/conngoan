<?php
class news extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('news_model','news');
        $this->load->library('pagi');
        $js = array(
            array(base_url().'site/templates/fyi/js/news.js')
        );
        $this->esset->js($js);
    }
    
    function index(){
        $data['title'] = 'Tin tức';
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
            $catinfo = $this->vdb->find_by_id('news_cat',array('catid'=>$rs->catid));  
            if($rs){
                $data['title'] 		 = $rs->title;
                $data['catinfo'] 	 = $catinfo;
                $data['rs'] 		 = $rs;
                $data['listorther']  = $this->news->get_orther_news($catinfo->catid, $rs->newsid);
                $data['listViewMax'] = $this->news->get_orther_newsView($catinfo->catid, $rs->newsid);
                //$data['listcomment'] = $this->news->get_list_comment($rs->newsid);
                //get all cat
                $listAllCat				= $this->news->getListAllCat();
                $arrCat   				=  $this->news->getParentsIdArray($listAllCat,$catinfo->catid);
                //get list thumb
                $data['listNewsthumb']  = $this->news->getAlllThumbNewsRelative($arrCat);
               
                //load templates *****************************
                $this->_templates['page'] = 'detail';
                $this->templates->load($this->_templates['page'],$data,'news');
            }else{
                redirect('news');
            }
        }else{ // Cat
            $catid = end(explode('-',$uri2));
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
                    $start = 0;   
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
    
    function send_comment(){
        $vdata['newsid'] = $this->input->post('newsid');
        $vdata['title'] = $this->input->post('title');
        $vdata['fullname'] = $this->input->post('fullname');
        $vdata['email'] = $this->input->post('email');
        $vdata['content'] = $this->input->post('content');
        $vdata['add_date'] = time();
        $vdata['published'] = 1;
        if($commentid = $this->vdb->update('news_comment',$vdata)){
            $val = $this->vdb->find_by_id('news_comment',array('commentid'=>$commentid));
            $data['list'] ='<li class="commentlast" id="'.$val->commentid.'">';
                $data['list'] .='<div class="commentuser"><div class="img"><img width="75" alt="" src="http://localhost/2012/fyi/data/no_avatar.png"></div></div>
                <div class="infocomment">
                    <div class="arrow"></div>
                    <div class="boxcomment">
                        <div class="info_user_comment"><span>'.$val->fullname.'</span> <span>'.date('H:i:s d/m/Y',$val->add_date).'</span></div>
                        <p>'.$val->content.'</p>
                    </div>
                </div>
            </li>';
            $data['error'] = 0;
            $data['msg'] = 'Xin cảm ơn.<br />Bạn đã gửi nhận xét thành công';
        }else{
            $data['error'] = 1;
            $data['msg'] = 'Có lỗi. Vui lòng kiểm tra lại';
        }
        echo json_encode($data);
    }
    
    function loadcomment(){
        $offset = $this->input->post('page') + 1;
        $productid = $this->input->post('productid');
        $limit = 5;
        $num = $this->api->get_num_comment($productid);
        if($offset!=0) 
            $start = ($offset - 1) * $limit;
        else
            $start = 0;
        $listcomment = $this->api->get_all_comment($limit,$start,$productid);
        $data['list'] = '';
        foreach($listcomment as $val):
        $data['list'] .='<li class="commentlast" id="'.$val->commentid.'">';
            $data['list'] .='<div class="commentuser"><div class="img"><img width="75" alt="" src="http://localhost/2012/fyi/data/no_avatar.png"></div></div>
            <div class="infocomment">
                <div class="arrow"></div>
                <div class="boxcomment">
                    <div class="info_user_comment"><span>'.$val->fullname.'</span> <span>'.date('H:i:s d/m/Y',$val->add_date).'</span></div>
                    <p>'.$val->content.'</p>
                </div>
            </div>
        </li>';
        endforeach;
        if(count($listcomment) > 0){
            $data['show_more'] = '<a href="javascript:;" onclick="func_morecomment('.$offset.')">Xem thêm nhận xét</a>';
        }else{
            $data['show_more'] = '';
        }
        echo json_encode($data);
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