<?php
require_once (ROOT . 'debug/debug.php');

class banner_news extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->helper('file');
        $this->load->config('config_news_footer');
        
        //load model
        $this->load->model("bannerads_model","bannerads_model");
    } 
    
    function index(){
        $data['title'] = 'Quảng cáo banner footer'; 
        $data['save'] = true;
       //
       $data["arrIDNews"] 	 	= $this->config->item("bannerNews");
       $data["arrIDFooter"] 	 = $this->config->item("bannerFooter");
            
        $this->form_validation->set_rules('arrIDFooter','ID footer','required');
       
        if($this->form_validation->run() == FALSE){
            $this->pre_message = validation_errors();
        }else{                    	
           // right 1
            
            $vdataRightHead = $this->input->post('arrIDFooter');          
            $vdataRight 	= explode(',', $vdataRightHead);          
            
            //get all product
            $listFooter = $this->banner->get_all_product($vdataRight,25);
           
            //config 
            $strConfig   = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');";            
            $strConfig   .= "\n\$config['bannerFooter'] = '$vdataRightHead';";
           
            $strConfig   .= "/* End of file config_bannertruot*/";
            
            // Write File ===============================================                                              
            if($this->input->post('active') == 1){              	
            
            //footer ***************************************
            $strFooter  = '';
            $strFooter  .= '<div class="adv-f">';
            $strFooter  .= '<ul class="items">';
            
            foreach($listFooter as $val) :
	            $giathitruong 	= number_format($val->giathitruong,0,'.','.');
	            $giaban 		= number_format($val->giaban,0,'.','.');
	            $imgFooter		= base_url_site()."data/img_product/80/".$val->productimg;
	            $linkFooter		= base_url_site()."product/".vnit_change_title($val->productname).'/'.$val->productid.".html";
                
                $strFooter .='<li>';
                $strFooter .='<p class="img"><a href="'.$linkFooter.'"><img src="'.$imgFooter.'" alt="'.$val->productname.'"></a></p>';
                $strFooter .='<div class="info-adv-f">';
                $strFooter .='<p class="name"><a href="'.$linkFooter.'">'.$val->productname.'</a></p>';
                $strFooter .='<p class="price-old">'.$giathitruong.' đ</p>';
                $strFooter .='<p class="price">'.$giaban.' đ</p>';
                $strFooter .='</div>';
               
                $strFooter .='</li>';    
            endforeach;
            $strFooter .='</ul>';
            $strFooter .= '</div>';            
                
            }
            //write footer ****************
            write_file(ROOT.'technogory/config/home/bannerFooter.db', $strFooter);
           
           // write_log(77,253,'Cập nhật Quảng cáo banner trượt');
            // write config 
            write_file(ROOT.'adminsystemcpanelwebsite/config/config_news_footer.php', $strConfig);
            
            
            $this->session->userdata('message','Lưu thành công');
            redirect('quangcao/banner_news');
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannernews/index';
        $this->templates->load($this->_templates['page'],$data);
    }

    public function banner1(){
        $data['title'] = 'Banner 1';

        $this->form_validation->set_rules('link','Link','required');       
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $img =  $this->input->post('img');
            if(!empty($img)){
                $this->load->helper('img_helper');
                $imgRoot    = ROOT.'alobuy0862779988/bannerads/banner1/full_images/'.$img;
                $imgThumb   = ROOT.'alobuy0862779988/bannerads/banner1/thumb/'.$img;
                vnitResizeImage($imgRoot,$imgThumb,90,90);
            }   
            // delete old data
            $this->bannerads_model->deleteByPosition(1); 
            // insert new data
            $aVals = array(
                'link' => $this->input->post('link'), 
                'images' => $this->input->post('img'), 
                'published' => $this->input->post('published'), 
                'position' => 1, 
            );
            $id = $this->bannerads_model->addBanner($aVals);
        }        

        $aBannerAds = $this->bannerads_model->getBannerByPosition(1);
        if(isset($aBannerAds->id)){
            $data['aBannerAds'] = $aBannerAds;
        }

        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannernews/banner1';
        $this->templates->load($this->_templates['page'],$data);
    }

    public function uploader_banner1(){
        // $ProductID = $this->uri->segment(3);
        /// $session_info = $this->session->userdata('session_id');
        $dir        = ROOT.'alobuy0862779988/bannerads/banner1/full_images/';
        //chmod($uploaddir,0777);
        $size=$_FILES['uploadfile']['size'];
        if($size>204857600)
        {
            echo "file_biger";
            unlink($_FILES['uploadfile']['tmp_name']);
            //exit;
        }
        $filename = stripslashes($_FILES['uploadfile']['name']);
        $i = strrpos($filename,".");
        if (!$i) { return ""; }
        $l = strlen($filename) - $i;
        $extension = substr($filename,$i+1,$l);
        $extension = strtolower($extension);
        $file_name = str_replace($extension,'',$filename);
        $name = time();
        $filename = $dir.$name.'.'.$extension;
        $file_ext = $name.'.'.$extension;
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $filename)) {
            echo $file_ext;
    
        } else {
            echo 'error';
        }
    }    
    
    public function banner2(){
        $data['title'] = 'Banner 2';

        $this->form_validation->set_rules('link','Link','required');       
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $img =  $this->input->post('img');
            if(!empty($img)){
                $this->load->helper('img_helper');
                $imgRoot    = ROOT.'alobuy0862779988/bannerads/banner2/full_images/'.$img;
                $imgThumb   = ROOT.'alobuy0862779988/bannerads/banner2/thumb/'.$img;
                vnitResizeImage($imgRoot,$imgThumb,90,90);
            }   
            // delete old data
            $this->bannerads_model->deleteByPosition(2); 
            // insert new data
            $aVals = array(
                'link' => $this->input->post('link'), 
                'images' => $this->input->post('img'), 
                'published' => $this->input->post('published'), 
                'position' => 2, 
            );
            $id = $this->bannerads_model->addBanner($aVals);
        }        

        $aBannerAds = $this->bannerads_model->getBannerByPosition(2);
        if(isset($aBannerAds->id)){
            $data['aBannerAds'] = $aBannerAds;
        }

        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannernews/banner2';
        $this->templates->load($this->_templates['page'],$data);
    }

    public function uploader_banner2(){
        // $ProductID = $this->uri->segment(3);
        /// $session_info = $this->session->userdata('session_id');
        $dir        = ROOT.'alobuy0862779988/bannerads/banner2/full_images/';
        //chmod($uploaddir,0777);
        $size=$_FILES['uploadfile']['size'];
        if($size>204857600)
        {
            echo "file_biger";
            unlink($_FILES['uploadfile']['tmp_name']);
            //exit;
        }
        $filename = stripslashes($_FILES['uploadfile']['name']);
        $i = strrpos($filename,".");
        if (!$i) { return ""; }
        $l = strlen($filename) - $i;
        $extension = substr($filename,$i+1,$l);
        $extension = strtolower($extension);
        $file_name = str_replace($extension,'',$filename);
        $name = time();
        $filename = $dir.$name.'.'.$extension;
        $file_ext = $name.'.'.$extension;
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $filename)) {
            echo $file_ext;
    
        } else {
            echo 'error';
        }
    }    
   
    public function banner3(){
        $data['title'] = 'Banner 3';

        $this->form_validation->set_rules('link','Link','required');       
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $img =  $this->input->post('img');
            if(!empty($img)){
                $this->load->helper('img_helper');
                $imgRoot    = ROOT.'alobuy0862779988/bannerads/banner3/full_images/'.$img;
                $imgThumb   = ROOT.'alobuy0862779988/bannerads/banner3/thumb/'.$img;
                vnitResizeImage($imgRoot,$imgThumb,90,90);
            }   
            // delete old data
            $this->bannerads_model->deleteByPosition(3); 
            // insert new data
            $aVals = array(
                'link' => $this->input->post('link'), 
                'images' => $this->input->post('img'), 
                'published' => $this->input->post('published'), 
                'position' => 3, 
            );
            $id = $this->bannerads_model->addBanner($aVals);
        }        

        $aBannerAds = $this->bannerads_model->getBannerByPosition(3);
        if(isset($aBannerAds->id)){
            $data['aBannerAds'] = $aBannerAds;
        }

        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannernews/banner3';
        $this->templates->load($this->_templates['page'],$data);
    }

    public function uploader_banner3(){
        // $ProductID = $this->uri->segment(3);
        /// $session_info = $this->session->userdata('session_id');
        $dir        = ROOT.'alobuy0862779988/bannerads/banner3/full_images/';
        //chmod($uploaddir,0777);
        $size=$_FILES['uploadfile']['size'];
        if($size>204857600)
        {
            echo "file_biger";
            unlink($_FILES['uploadfile']['tmp_name']);
            //exit;
        }
        $filename = stripslashes($_FILES['uploadfile']['name']);
        $i = strrpos($filename,".");
        if (!$i) { return ""; }
        $l = strlen($filename) - $i;
        $extension = substr($filename,$i+1,$l);
        $extension = strtolower($extension);
        $file_name = str_replace($extension,'',$filename);
        $name = time();
        $filename = $dir.$name.'.'.$extension;
        $file_ext = $name.'.'.$extension;
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $filename)) {
            echo $file_ext;
    
        } else {
            echo 'error';
        }
    }    

    public function adspopup(){
        $data['title'] = 'Quảng cáo popup';

        $this->form_validation->set_rules('link','Link','required');       
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $img =  $this->input->post('img');
            if(!empty($img)){
                $this->load->helper('img_helper');
                $imgRoot    = ROOT.'alobuy0862779988/bannerads/adspopup/full_images/'.$img;
                $imgThumb   = ROOT.'alobuy0862779988/bannerads/adspopup/thumb/'.$img;
                vnitResizeImage($imgRoot,$imgThumb,90,90);
            }   
            // delete old data
            $this->bannerads_model->deleteByPosition(4); 
            // insert new data
            $aVals = array(
                'link' => $this->input->post('link'), 
                'images' => $this->input->post('img'), 
                'published' => $this->input->post('published'), 
                'position' => 4, 
            );
            $id = $this->bannerads_model->addBanner($aVals);
        }        

        $aBannerAds = $this->bannerads_model->getBannerByPosition(4);
        if(isset($aBannerAds->id)){
            $data['aBannerAds'] = $aBannerAds;
        }

        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannernews/adspopup';
        $this->templates->load($this->_templates['page'],$data);
    }

    public function uploader_adspopup(){
        // $ProductID = $this->uri->segment(3);
        /// $session_info = $this->session->userdata('session_id');
        $dir        = ROOT.'alobuy0862779988/bannerads/adspopup/full_images/';
        //chmod($uploaddir,0777);
        $size=$_FILES['uploadfile']['size'];
        if($size>204857600)
        {
            echo "file_biger";
            unlink($_FILES['uploadfile']['tmp_name']);
            //exit;
        }
        $filename = stripslashes($_FILES['uploadfile']['name']);
        $i = strrpos($filename,".");
        if (!$i) { return ""; }
        $l = strlen($filename) - $i;
        $extension = substr($filename,$i+1,$l);
        $extension = strtolower($extension);
        $file_name = str_replace($extension,'',$filename);
        $name = time();
        $filename = $dir.$name.'.'.$extension;
        $file_ext = $name.'.'.$extension;
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $filename)) {
            echo $file_ext;
    
        } else {
            echo 'error';
        }
    }    
}
