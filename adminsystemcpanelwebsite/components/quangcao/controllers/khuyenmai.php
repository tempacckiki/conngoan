<?php
class khuyenmai extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
    }
    function index(){
        $data['title'] = 'Quảng cáo khu vực khuyến mãi';
        $data['apply'] = true;
        $data['khm1'] = $this->vdb->find_by_id('ads',array('position'=>'khuyenmai','id'=>1),array('id'=>'asc'));
        $data['khm2'] = $this->vdb->find_by_id('ads',array('position'=>'khuyenmai','id'=>2),array('id'=>'asc'));
        $this->form_validation->set_rules('name1','Khuyến mãi 1','required');
        $this->form_validation->set_rules('link1','Link 1','required');
        $this->form_validation->set_rules('name2','Khuyến mãi 2','required');
        $this->form_validation->set_rules('link2','Link 2','required');
        if($this->form_validation->run() === false){
            $this->pre_message = validation_errors();
        }else{
            $name1 = $this->input->post('name1');
            $link1 = $this->input->post('link1');
            $name2 = $this->input->post('name2');
            $link2 = $this->input->post('link2');
            $published = $this->input->post('published');
            if($_FILES["userfile1"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/khuyenmai/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userfile1')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();                     
					//get file name
                    $fileName 	=  $result['file_name'];
                 	//resize 
		        	if(!empty($fileName)){
		        		 $this->load->helper('img_helper');	    	        		
		        		//vnit_resize_image(ROOT.'data/adv/khuyenmai/'.$fileName,ROOT.'data/adv/khuyenmai/thumb/'.$fileName,90,90,false);
		        		vnit_resize_image(ROOT.'data/adv/khuyenmai/'.$fileName,ROOT.'data/adv/khuyenmai/thumb/'.$fileName,390,80,false);
		        	}
		        	 $images1 = $fileName; 
                }                    
            }else{
                $images1 = $this->input->post('images1');
            }
            
            if($_FILES["userfile2"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/khuyenmai/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userfile2')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    //get file name
                    $fileName 	=  $result['file_name'];
                 	//resize 
		        	if(!empty($fileName)){
		        		 $this->load->helper('img_helper');	    	        		
		        		//vnit_resize_image(ROOT.'data/adv/khuyenmai/'.$fileName,ROOT.'data/adv/khuyenmai/thumb/'.$fileName,90,90,false);
		        		vnit_resize_image(ROOT.'data/adv/khuyenmai/'.$fileName,ROOT.'data/adv/khuyenmai/thumb/'.$fileName,390,80,false);
		        	}
		        	 $images2 = $fileName; 
		        	 
                                 
                }                    
            }else{
                $images2 = $this->input->post('images2');
            }
            $vdata1['name'] = $name1;
            $vdata1['link'] = $link1;
            $vdata1['images'] = $images1;
            $vdata1['published'] = $published;
            $this->vdb->update('ads',$vdata1,array('id'=>1));
            
            $vdata2['name'] = $name2;
            $vdata2['link'] = $link2;
            $vdata2['images'] = $images2;
            $vdata2['published'] = $published;
            $this->vdb->update('ads',$vdata2,array('id'=>2));
            if($published == 1){
                $this->write_km(1);
            }else{
                $this->write_km(0);
            }
            $this->session->set_flashdata('message','Lưu thành công');
            redirect('quangcao/khuyenmai');
            
        }
        $this->_templates['page'] = 'khuyenmai/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function write_km($pub){
    	//path image
    	$imgPath   = base_url_site().'site/templates/fyi/images/';
    		
        $this->load->helper('file');
        if($pub == 1){
            $km1 = $this->vdb->find_by_id('ads',array('position'=>'khuyenmai','id'=>1),array('id'=>'asc'));
            $km2 = $this->vdb->find_by_id('ads',array('position'=>'khuyenmai','id'=>2),array('id'=>'asc'));
            $str = "<div class=\"adv-horizontal\">";
            $str .="<div class=\"kmleft\">";
                $str .="<a href=\"".$km1->link."\" title=\"".$km1->name."\">"; 
                    $str .="<img src=\"".$imgPath."placeholder.gif"."\" data-original=\"".base_url_site()."data/adv/khuyenmai/thumb/".$km1->images."\" alt=\"".$km1->name."\" width=\"390\" height=\"80\">";
                $str .="</a>";
            $str .="</div>";
            $str .="<div class=\"kmright\">";
                $str .="<a href=\"".$km2->link."\" title=\"".$km2->name."\">"; 
                    $str .="<img src=\"".$imgPath."placeholder.gif"."\" data-original=\"".base_url_site()."data/adv/khuyenmai/thumb/".$km2->images."\" alt=\"".$km2->name."\" width=\"390\" height=\"80\">";
                $str .="</a>";
            $str .="</div>";
            $str .= "</div>";
        }else{
            $str = "";
        }
        write_file(ROOT.'site/config/home/khuyenmai.db', $str); 
    }
}
