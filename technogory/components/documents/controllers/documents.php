<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**************************
* Controller - Photo
* Author: Mr.Phong
* Email: phong.sttm@gmail.com
* Date: 17/06/2012
***************************/
  class documents extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->load->model('documents_model','document');
           $this->load->library('pagi');       
      }
      
      function index(){
          $data['title'] = "Download bảng giá";
          //cau hinh paginator
          $limit = 50;
          $data['limit'] 	= $limit; 
          $offset 			= (int)$this->input->post('page_no'); 
          $data['offset'] 	= $offset;
          $num = $this->document->get_num_document();
          $data['num'] 		= $num;
          if($offset!=0) 
           	$start = ($offset - 1) * $limit;
          else
          $start = 0;   
          $data['list'] =   $this->document->get_all_document($limit, $start);
          $data['pagination']   = $this->pagi->page(10,$offset,$limit,'news_page');  
          //load templates ****
          $this->_templates['page'] = 'index';
          $this->templates->load($this->_templates['page'],$data,'news');
      }
      
      function page(){
                 
          $uri2 = $this->uri->segment(3);
          $uri3 = $this->uri->segment(4);
          if($uri2 !='' && count(explode('-',$uri3))> 1){
              // Chi tiet
              $js_array = array(
                    array(base_url().'site/components/photo/views/esset/jquery.slider.js')
              );                  
              $this->esset->js($js_array);              
              $catid = end(explode('-',$uri2));
              $albumid = end(explode('-',$uri3));
              $catinfo = $this->photo->get_cat_info($catid);
              $this->link[0] = 'Hình ảnh hoạt động:photo';
              $this->link[1] = $catinfo->catname.':hinh-anh-hoat-dong/'.$catinfo->caturl.'-'.$catinfo->catid;              
              $data['rs'] = $this->photo->get_album_by_id($albumid);
              $data['list'] = $this->photo->get_listimg_by_album($albumid);
              $data['title'] = 'Chi tiet';
              
              $this->_templates['page'] = 'photo/detail';
              $this->templates->load($this->_templates['page'],$data);
          }else{
              
              
              $catid = end(explode('-',$uri2));
              $catinfo = $this->photo->get_cat_info($catid);
              $this->link[0] = 'Hình ảnh hoạt động:photo';
              $this->link[1] = $catinfo->catname;
              $data['title'] = 'Hình ảnh hoạt động: '.$catinfo->catname;
              $config['base_url'] = base_url().vnit_lang().'/photo/'.$uri2;  
              $config['total_rows']   =  $this->photo->get_num_album($catid);
              $data['num'] = $config['total_rows'];
              $config['per_page']  =   9;
              $config['uri_segment'] = 4; 
              $this->load->library('pagination');
              $this->pagination->initialize($config);   
              
              $data['list'] =   $this->photo->get_all_album($catid,$config['per_page'],$this->uri->segment(4));
              $data['pagination']    = $this->pagination->create_links();              
              $this->_templates['page'] = 'photo/cat';
              $this->templates->load($this->_templates['page'],$data);              
          }
      }
  }