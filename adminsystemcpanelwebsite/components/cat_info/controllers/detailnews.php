<?php
class detailnews extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->model('deatailnews_model','detailnews');     
        $this->load->model('danhmuc_model','danhmuc');
        $this->load->helper('file');
    }
    
    function ds(){
        //$this->write_index();
       	//$this->write_quangcao();
        $data['title'] = 'Danh sách thông tin sản phẩm';      
        $data['delete'] = icon_dels('cat_info/detailnews/dels');
        $id_news = (int)$this->uri->segment(4);
              
        //get list cat
        $data['listcat'] = $this->danhmuc->get_all_danhmuc();
        
        $data['catid'] 	= $id_news;
        $data['add'] 	= 'cat_info/detailnews/add/'.$id_news.'|'.icon_add('cat_info/detailnews/add');
        $data['list'] 	= $this->detailnews->get_all_quangcao($id_news);
        //set view list id new
        $listIdNews 	= $this->detailnews->get_all_danhmuc();
        $data['listNews']  = $listIdNews;
        //load templates
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $id_news = $this->uri->segment(4);
        $data['title'] = 'Thêm mới thông tin';
        //config button 
        //$data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'cat_info/detailnews/ds/'.$id_news;
        //get list cat
        $data['listcat'] = $this->danhmuc->get_all_danhmuc();
        
        $this->form_validation->set_rules('name','Tên thông tin','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{          
            $vdata['cat_id'] 	= $this->input->post('cat_id');       
            $vdata['name'] 		= $this->input->post('name');           
            $vdata['content'] 	= $this->input->post('content');          
            $vdata['ordering'] 	= $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published'); 
                   
            if($this->vdb->update('cat_info',$vdata)){            	
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'cat_info/detailnews/ds/'.$this->input->post('cat_id');
                }else{
                    $url = 'cat_info/detailnews/edit/';
                }
                redirect($url);
                
            }
        }
        
       
        $data['message'] = $this->pre_message;
		//load templates ***
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $idNews = $this->uri->segment(5);
        $data['title'] = 'Cập nhật Thông tin';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'cat_info/detailnews/ds';
        
        //get list cat
        $data['listcat'] = $this->danhmuc->get_all_danhmuc();
        
        $this->form_validation->set_rules('name','Tên thông tin','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
          
            $vdata['cat_id'] 	= $this->input->post('cat_id');
            $vdata['name'] 		= $this->input->post('name');           
            $vdata['content'] 		= $this->input->post('content');
            $vdata['ordering'] = $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published');           
            if($this->vdb->update('cat_info',$vdata,array('id'=>$id))){
            	            	
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'cat_info/detailnews/ds/'.$vdata['id_news'];
                }else{
                    $url = uri_string();
                }
                redirect($url);
                
            }
        }
        $data['id_news'] = $idNews;
        
        $data['rs'] = $this->vdb->find_by_id('cat_info',array('id'=>$this->uri->segment(4)));
        $data['message'] = $this->pre_message;
        ///load templates
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');

            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $name = $this->vdb->find_by_id('cat_info',array('id'=>$ar_id[$i]))->name;  
                    if($this->vdb->delete('cat_info',array('id'=>$ar_id[$i]))){
                        //write_log(92,301,'Xóa quảng cáo: '.$name); 
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('cat_info/detailnews/ds/'.$page);
    }
    
   
   
    //*** write quang cao 
    function write_quangcao(){
        $list = $this->vdb->find_by_list('cat_info',0,array('id'=>'asc'));
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