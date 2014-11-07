<?php
class left extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->model('left_model','left');
        $this->load->model('danhmuc_model','danhmuc');
        $this->load->helper('file');
    }
    
    function ds(){
        //$this->write_index();
       	$this->write_quangcao();
        $data['title'] = 'Danh sách quảng cáo chuyên mục';
        $listcat = $this->left->get_all_danhmuc();
        $data['delete'] = icon_dels('quangcao/left/dels');
        $catid = (int)$this->uri->segment(4);
        
        /* if($catid == 0){
            $catid = $listcat[0]->catid;
        } */
        $catname = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid))->catname;
        write_log(92,289,'Xem danh sách quảng cáo trang chi tiết danh mục: '.$catname);
        $data['catid'] = $catid;
        $data['add'] = 'quangcao/left/add/'.$catid.'|'.icon_add('quangcao/left/add');
        $data['list'] = $this->left->get_all_quangcao($catid);
        $data['listcat'] = $listcat;
        $this->_templates['page'] = 'left/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $catid = $this->uri->segment(4);
        $data['title'] = 'Thêm mới quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'quangcao/left/ds/'.$catid;
        //get list city
        $data['listcity'] 			= $this->vdb->find_by_list('city',array('parentid'=>0,'site'=>1));
        //validate
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'alobuy0862779988/adv/left/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userleft')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $vdata['images'] = $result['file_name'];               
                }                    
            }
            $vdata['cat_id'] 	= $this->input->post('cat_id');
            $vdata['city_id']	= $this->input->post('city_id');
            $vdata['name'] 		= $this->input->post('name');
            $vdata['price'] 	= str_replace('.', '', $this->input->post('price')) ;
            $vdata['summary'] 	= $this->input->post('summary');
            $vdata['link'] 		= $this->input->post('link');
            $vdata['ordering'] = $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published');
            $vdata['position'] = 2;
            if($id = $this->vdb->update('left',$vdata)){
                $catname = $this->vdb->find_by_id('shop_cat',array('catid'=>$vdata['cat_id']))->catname;
                write_log(92,299,'Thêm quảng cáo trang chi tiết: '.$vdata['name'].', danh muc: '.$catname);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'quangcao/left/ds/'.$this->input->post('cat_id');
                }else{
                    $url = 'quangcao/left/edit/'.$id;
                }
                redirect($url);
                
            }
        }
        $data['catid'] = $catid;
        $data['listcat'] = $this->left->get_all_danhmuc();
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'left/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $catid = $this->uri->segment(5);
        $data['title'] = 'Cập nhật quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'quangcao/left/ds';
        //get list city
        $data['listcity'] 			= $this->vdb->find_by_list('city',array('parentid'=>0,'site'=>1));
        //validate
        
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'alobuy0862779988/adv/left/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userleft')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $vdata['images'] = $result['file_name'];               
                }                    
            }else{
                $vdata['images'] = $this->input->post('img_old');
            }
            $vdata['cat_id'] 	= $this->input->post('cat_id');
            $vdata['city_id']	= $this->input->post('city_id');
            $vdata['name'] 		= $this->input->post('name');
            $vdata['price'] 	= str_replace('.', '', $this->input->post('price')) ;
            $vdata['summary'] 	= $this->input->post('summary');
            $vdata['link'] 		= $this->input->post('link');
            $vdata['ordering'] = $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published');
            $vdata['position'] = 2;
            if($this->vdb->update('left',$vdata,array('id'=>$id))){
                $catname = $this->vdb->find_by_id('shop_cat',array('catid'=>$vdata['cat_id']))->catname;
                write_log(92,300,'Cập nhật quảng cáo trang chi tiết: '.$vdata['name'].', danh muc: '.$catname);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'quangcao/left/ds/'.$vdata['cat_id'];
                }else{
                    $url = uri_string();
                }
                redirect($url);
                
            }
        }
        $data['catid'] = $catid;
        $data['listcat'] = $this->left->get_all_danhmuc();
        $data['rs'] = $this->vdb->find_by_id('left',array('id'=>$this->uri->segment(4)));
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'left/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');

            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $name = $this->vdb->find_by_id('left',array('id'=>$ar_id[$i]))->name;  
                    if($this->vdb->delete('left',array('id'=>$ar_id[$i]))){
                        write_log(92,301,'Xóa quảng cáo: '.$name); 
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('quangcao/left/ds/'.$page);
    }
    
    //***
    function write_index(){
    	
    	$str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_index language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
    	//$str .= "\n\$config['advtop_total'] = $total;\n";
        	
    	$listadv = $this->left->get_limit_qc(0);
    
    	$i = 1;
    	$total = count($listadv);
    	$str .= "\n\$config['advleft_total_index'] = $total;";
    	foreach($listadv as $val):
    	$name 	= $val->name;
    	$price 	= number_format($val->price,0,'.','.');
    	$summary = $val->summary;
    	$link 	= $val->link;
    	$img 	= $val->images;
    	$str .= "\n\$config['advleft_name_index"."_$i'] = '$name';";
    	$str .= "\n\$config['advleft_price_index"."_$i'] = '$price';";
    	$str .= "\n\$config['advleft_summary_index"."_$i'] = '$summary';";
    	$str .= "\n\$config['advleft_link_index"."_$i'] = '$link';";
    	$str .= "\n\$config['advleft_img_index"."_$i'] = '$img';\n";
    	$i ++;
    	endforeach;
    
    	
    	$str .= "\n\n/* End of file config_index*/";
    	write_file(ROOT_ADMIN.'config/config_left.php', $str);
    }
    
    //***
    function write_quangcao(){
    	//get list city
    	$listCity  = $this->vdb->find_by_list('city',array('parentid'=>0,'site'=>1));
    	if (sizeof($listCity)>0){
    		foreach ($listCity as $valCity):
    			//get list category
        $list = $this->vdb->find_by_list('shop_cat',0,array('ordering'=>'asc'));
        $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_qcleft language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
        //$str .= "\n\$config['advtop_total'] = $total;\n"; 
        
        foreach($list as $rs):
        $catid = $rs->catid;
        $listadv = $this->left->get_limit_qc($rs->catid, $valCity->city_id);
            
            $i = 1;
            $total = count($listadv);
            $str .= "\n\$config['advleft_total_".$catid."'] = $total;";
            foreach($listadv as $val):
                $name 	= $val->name;
                $price 	= number_format($val->price,0,'.','.');
                $summary = $val->summary;
                $link 	= $val->link;
                $img 	= $val->images;
                $str .= "\n\$config['advleft_name_".$catid."_$i'] = '$name';";
                $str .= "\n\$config['advleft_price_".$catid."_$i'] = '$price';";
                $str .= "\n\$config['advleft_summary_".$catid."_$i'] = '$summary';";
                $str .= "\n\$config['advleft_link_".$catid."_$i'] = '$link';";
                $str .= "\n\$config['advleft_img_".$catid."_$i'] = '$img';\n";
                $i ++;
            endforeach;
        
        endforeach;
    	  $str .= "\n\n/* End of file config_qcchitiet*/";        
		        write_file(ROOT_ADMIN.'config/config_qcleft_'.$valCity->city_id.'.php', $str);
		        write_file(ROOT.'technogory/config/config_qcleft_'.$valCity->city_id.'.php', $str);
		    endforeach;
    	}
    }
}