<?php
class vnit extends CI_Controller{
      protected $_templates;
      function __construct(){
         parent::__construct();
         $this->load->model('vnit_model','vnit');
         if($this->session->userdata('lang')=='vi'){
            $this->langdb = "";
         }else{
            $this->langdb = "_en";
         }
         $this->city_id = $this->session->userdata('city_site');
         $this->fyi_regions = $this->session->userdata('fyi_regions');       
      }
      
      function index(){
     	
      	  $data['top_link_seo'] = 'http://local.dev/alobuyvn/';
          $data['title'] = $this->config->item('site_name');
          $data['listtab'] = $this->vnit->get_all_tab_ngang();
          $data['lastnews'] = $this->vnit->get_lastnew();
          $data['noibat'] = $this->vnit->get_noibat();
          $data['listcat'] = $this->vnit->get_cat_new();
         
          $data['spmuanhieu'] = $this->vnit->get_sanphammuanhieu();
          $this->_templates['page'] = 'index';
          $this->templates->load($this->_templates['page'],$data,'home');
         
      }
      
      function getListProductCat(){
      	  //get cat ID;
      	  $catID  				= $this->input->post("catid");
      	  $data["catId"] 		= $this->input->post("catid");
          //get list product ************************ 
         // $data["listproduct"] = $this->vnit->getlistproduct($catID);
          
          //*** load templates ************************
          $this->_templates['page'] = 'ajaxLoad';
          $this->load->view($this->_templates['page'],$data);
      }
     /*-------------------------------+
     * @return: templates ****
     +-------------------------------*/
	public function getListProductCatHot(){
      	  //get cat ID;
      	  $catID  				= $this->input->post("catid");
      	  $data["catId"] 		= $this->input->post("catid");
          //get list product ************************ 
         // $data["listproduct"] = $this->vnit->getlistproduct($catID);
          
          //*** load templates ************************
          $this->_templates['page'] = 'ajaxLoadHot';
          $this->load->view($this->_templates['page'],$data);
      }
     
    /*-------------------------------+
     * @
     +-------------------------------*/
	function ajaxvideo(){
      	$id			 	 = (int)$this->input->post("id");
      	$row   		 	 = $this->vdb->find_by_id("video_news", array('video_id'=>$id));
      	//get list video lien quan
      	$listVideo 	  = $this->vdb->find_by_list("video_news", array('video_id !='=>$id,'published'=>1),array('created'=>'DESC'));
      	
      	$video_url		 = (!empty($row->video_url))?$row->video_url:$row->video_link;
      	$videoName		 = $row->video_title;
      	if(sizeof($listVideo)>0){
      		
      		foreach ($listVideo as $valVideo){
      			$data['relativeItems']  .= '<li><a href="javascript:;" onclick="getvideo('.$valVideo->video_id.');">'.$valVideo->video_title.'</a></li>';
      		}
      	}
      	
      	$data['fileVideo']  	 		 = '<p class="name-vd">'.$videoName.'</p><div id="videoList"></div><script type="text/javascript">jwplayer("videoList").setup({"flashplayer":"'.base_url().'technogory/templates/default/js/player.swf","file":"'.$video_url.'","autostart":true,"width":300,"height":240,"controlbar":"bottom","Smoothing": true});</script>';
      	      	
      	echo json_encode($data);
      }
}