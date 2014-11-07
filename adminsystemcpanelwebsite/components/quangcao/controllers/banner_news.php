<?php
class banner_news extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->helper('file');
        $this->load->config('config_news_footer');
        
        //load model
        $this->load->model("bannertruot_model","banner");
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
    
   

}
