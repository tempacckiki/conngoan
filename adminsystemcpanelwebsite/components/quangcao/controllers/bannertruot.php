<?php
class bannertruot extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->helper('file');
       
        
        //load model
        $this->load->model("bannertruot_model","banner");
    } 
    
    function index(){
        $data['title'] = 'Quảng cáo banner trượt'; 
        $data['save'] = true;
        
        //get list city
        $data['listcity'] 			= $this->vdb->find_by_list('city',array('parentid'=>0,'site'=>1));
        
       //validate        
        $this->form_validation->set_rules('arrID_Left','ID arrID_Left','required');
        $this->form_validation->set_rules('arrID_Right','ID right','required');
       
        if($this->form_validation->run() == FALSE){
            $this->pre_message = validation_errors();
        }else{            
        	//get city_id
        	$city_id   = $this->input->post('city_id');
        	//get array id    
            $vdataLeftHead = $this->input->post('arrID_Left');
            $vdataLeft	= explode(',', $vdataLeftHead);
           //get all product
           $listLeft = $this->banner->get_all_product($vdataLeft,$city_id);
        
           // right 1
            
            $vdataRightHead = $this->input->post('arrID_Right');          
            $vdataRight = explode(',', $vdataRightHead);          
            
            //get all product
            $listRight = $this->banner->get_all_product($vdataRight,$city_id);
          
            //config 
            $strConfig   = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');";
            $strConfig   .= "\n\$config['bannertruotLeft'] = '$vdataLeftHead';";
            $strConfig   .= "\n\$config['bannertruotRight'] = '$vdataRightHead';";
           
            $strConfig   .= "/* End of file config_bannertruot*/";
            
            // write config
            write_file(ROOT.'adminsystemcpanelwebsite/config/config_bannertruot_'.$city_id.'.php', $strConfig);
            
            // Write File .db ===============================================

            $str = '';
                                   
            if($this->input->post('active') == 1){              	
            	$str .= '<div id="vt_l" class="bns" style="position: fixed; bottom: 0px; display: block;">';
            	$str .='<ul>'; 
                $i = 1;  
            	foreach($listLeft as $valLeft) :
            		$giathitruong 	= number_format($valLeft->giathitruong,0,'.','.');
            		$giaban 		= number_format($valLeft->giaban,0,'.','.');
            		$imgLeft		= base_url_static()."alobuy0862779988/0862779988product/80/".$valLeft->productimg;
            		$link 			= base_url_site()."san-pham/".vnit_change_title($valLeft->productname).'-'.$valLeft->productid.".html";
                    $style 			= ($i == 3)?'style="border-bottom:0px"':'';
	                $str .='<li '.$style.'>';  
	                $str .='<a href="'.$link.'" target="_blank">  
	                    <div class="title">'.$valLeft->productname.'</div>
	                    <div class="img" align="center"><img src="'.$imgLeft.'" width="100" height="90" alt="'.$valLeft->productname.'"></div>
	                    <div class="price_old"> '.$giathitruong.' VND</div>
	                    <div class="price"> '.$giaban.' VND</div>
	                    </a>
	                ';  
	                $str .='</li>';    
                    $i++;
           		endforeach;
            $str .='</ul>';
            $str .= '</div>';
            $str .= '<div id="vt_r" class="bns" style="position: fixed; bottom: 0px; display: block;"> ';
            $str .='<ul>';
            
            foreach($listRight as $val) :
	            $giathitruong 	= number_format($val->giathitruong,0,'.','.');
	            $giaban 		= number_format($val->giaban,0,'.','.');
	            $imgRight		= base_url_static()."alobuy0862779988/0862779988product/80/".$val->productimg;
	            $link 			= base_url_site()."san-pham/".vnit_change_title($val->productname).'-'.$val->productid .".html";
                $style = ($i == 3)?'style="border-bottom:0px"':'';
                $str .='<li '.$style.'>';
                $str .='<a href="'.$link.'" target="_blank">
                    <div class="title">'.$val->productname.'</div>
                    <div class="img" align="center"><img src="'.$imgRight.'" width="100" height="90" alt="'.$val->productname.'"></div>
                    <div class="price_old"> '.$giathitruong.' VND</div>
                    <div class="price"> '.$giaban.' VND</div>
                    </a>
                ';  
                $str .='</li>';    
            endforeach;
            $str .='</ul>';
            $str .= '</div>';
            
                
            }
           
            //**
            write_file(ROOT.'technogory/config/home/bannertruot'.$city_id.'.db', $str);
          //  write_log(77,253,'Cập nhật Quảng cáo banner trượt');
           
            
            $this->session->userdata('message','Lưu thành công');
            redirect('quangcao/bannertruot');
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannertruot/index';
        $this->templates->load($this->_templates['page'],$data);
    }
   
    /**
     * load_bannerID
     */
    function load_bannerID(){
    	//***
    	$city_id 	= $this->input->post('city_id');
    	//load config
    	$this->load->config('config_bannertruot_'.$city_id);
    	
    	$ids_left	= $this->config->item("bannertruotLeft");
    	$ids_Right	= $this->config->item("bannertruotRight");
    	
    	//load config
    	$data['strLeft'] = '<input type="text" name="arrID_Left" value="'.$ids_left.'" class="w250">';
    	$data['strRight'] = '<input type="text" name="arrID_Right" value="'.$ids_Right.'" class="w250">';
    	
    	echo json_encode($data);
    }
}
