<?php
class detailnews extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->model('deatailnews_model','detailnews');     
        $this->load->helper('file');
    }
    
    function ds(){
        //$this->write_index();
       	$this->write_quangcao();
        $data['title'] = 'Danh sách quảng cáo chi tiết tin tức';      
        $data['delete'] = icon_dels('quangcao/detailnews/dels');
        $id_news = (int)$this->uri->segment(4);
              
        write_log(92,289,'Xem danh sách quảng cáo trang chi tiết danh mục: '.$id_news);
        $data['catid'] 	= $id_news;
        $data['add'] 	= 'quangcao/detailnews/add/'.$id_news.'|'.icon_add('quangcao/detailnews/add');
        $data['list'] 	= $this->detailnews->get_all_quangcao($id_news);
        //set view list id new
        $listIdNews 	= $this->detailnews->get_all_danhmuc();
        $data['listNews']  = $listIdNews;
        //load templates
        $this->_templates['page'] = 'detailnews/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $id_news = $this->uri->segment(4);
        $data['title'] = 'Thêm mới quảng cáo';
        //config button 
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'quangcao/detailnews/ds/'.$id_news;
        
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] 		= ROOT.'alobuy0862779988/adv/detailnews/';
                $config['allowed_types'] 	= 'gif|jpg|png|swf';
                $config['max_size']    		= '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                                    
                if ( !$this->upload->do_upload('userleft')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $vdata['images'] = $result['file_name'];               
                }                    
            }
            $vdata['id_news'] 	= $this->input->post('id_news');
            $vdata['name'] 		= $this->input->post('name');
            $vdata['price'] 	= str_replace('.', '', $this->input->post('price')) ;
            $vdata['summary'] 	= $this->input->post('summary');
            $vdata['link'] 		= $this->input->post('link');
            $vdata['ordering'] 	= $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published'); 
                   
            if($id = $this->vdb->update('detailnews',$vdata)){
            	//save table id_news
            	$itemNews  = $this->detailnews->getItem($vdata['id_news']);
            	if (sizeof($itemNews)== 0){
            		//insert
            		$this->vdb->update('id_news',$vdata['id_news']);
            	}
                write_log(92,299,'Thêm quảng cáo trang chi tiết: '.$vdata['name'].', danh muc: '.$id_news);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'quangcao/detailnews/ds/'.$this->input->post('cat_id');
                }else{
                    $url = 'quangcao/detailnews/edit/'.$id;
                }
                redirect($url);
                
            }
        }
        $data['catid'] = $id_news;
       
        $data['message'] = $this->pre_message;
		//load templates ***
        $this->_templates['page'] = 'detailnews/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $idNews = $this->uri->segment(5);
        $data['title'] = 'Cập nhật quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'quangcao/detailnews/ds';
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'alobuy0862779988/adv/detailnews/';
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
            $vdata['id_news'] 	= $this->input->post('id_news');
            $vdata['name'] 		= $this->input->post('name');
            $vdata['price'] 	= str_replace('.', '', $this->input->post('price')) ;
            $vdata['summary'] 	= $this->input->post('summary');
            $vdata['link'] 		= $this->input->post('link');
            $vdata['ordering'] = $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published');           
            if($this->vdb->update('detailnews',$vdata,array('id'=>$id))){
            	//save table id_news
            	$itemNews  = $this->detailnews->getItem($vdata['id_news']);
            	if (sizeof($itemNews)== 0){
            		//array idnews
            		$vdataNewsID['id_news']  =  $vdata['id_news'];
            		//insert
            		$this->vdb->update('id_news', $vdataNewsID);
            	}
            	             
                write_log(92,300,'Cập nhật quảng cáo trang chi tiết: '.$vdata['name'].', danh muc: '.$idNews);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'quangcao/detailnews/ds/'.$vdata['id_news'];
                }else{
                    $url = uri_string();
                }
                redirect($url);
                
            }
        }
        $data['id_news'] = $idNews;
        
        $data['rs'] = $this->vdb->find_by_id('detailnews',array('id'=>$this->uri->segment(4)));
        $data['message'] = $this->pre_message;
        ///load templates
        $this->_templates['page'] = 'detailnews/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');

            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $name = $this->vdb->find_by_id('detailnews',array('id'=>$ar_id[$i]))->name;  
                    if($this->vdb->delete('detailnews',array('id'=>$ar_id[$i]))){
                        write_log(92,301,'Xóa quảng cáo: '.$name); 
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('quangcao/detailnews/ds/'.$page);
    }
    
    //write id news
    function writeID(){
    	$str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_qcdetailnews language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
    	
    	//write file
    	write_file(ROOT_ADMIN.'config/config_idnews.php', $str);
    }
   
    //*** write quang cao 
    function write_quangcao(){
        $list = $this->vdb->find_by_list('id_news',0,array('id'=>'asc'));
        $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_qcdetailnews language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
        //$str .= "\n\$config['advtop_total'] = $total;\n"; 
        //loop data 	
        foreach($list as $rs):
        	$id_news = $rs->id_news;
        	$listadv = $this->detailnews->get_limit_qc($rs->id_news);
            
            $i = 1;
            $total = count($listadv);
            $str .= "\n\$config['advdetail_total_".$id_news."'] = $total;";
            foreach($listadv as $val):
                $name 	= $val->name;
                $price 	= number_format($val->price,0,'.','.');
                $summary = $val->summary;
                $link 	= $val->link;
                $img 	= $val->images;
                
                $str .= "\n\$config['advdetail_name_".$id_news."_$i'] = '$name';";
                $str .= "\n\$config['advdetail_price_".$id_news."_$i'] = '$price';";
                $str .= "\n\$config['advdetail_summary_".$id_news."_$i'] = '$summary';";
                $str .= "\n\$config['advdetail_link_".$id_news."_$i'] = '$link';";
                $str .= "\n\$config['advdetail_img_".$id_news."_$i'] = '$img';\n";
                $i ++;
            endforeach;
        
        endforeach;
        $str .= "\n\n/* End of file config_qcchitiet*/";        
        write_file(ROOT_ADMIN.'config/config_qcdetailnews.php', $str);
    }
}