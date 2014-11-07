<?php
class bannertop extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->helper('file');
    }
    
    function ds(){
        $this->write_quangcao();
        $data['title'] 		= 'Danh sách quảng cáo Top';
        write_log(78,254,'Xem danh sách quảng cáo Top');
        $data['add'] 		= 'adsdeal/bannertop/add|'.icon_add('adsdeal/bannertop/add');
        $data['delete'] 	= icon_dels('adsdeal/bannertop/dels');
        $data['list'] 		= $this->vdb->find_by_list('banner_deal',array('position'=>1),array('ordering'=>'asc'));
        //load templates *************************
        $this->_templates['page'] = 'bannertop/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'adsdeal/bannertop/ds';
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/bannertopdeal/';
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
            $vdata['name'] = $this->input->post('name');
            $vdata['link'] = $this->input->post('link');
            $vdata['ordering'] = $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published');
            $vdata['position'] = 1;
            if($id = $this->vdb->update('banner_deal',$vdata)){
                write_log(78,255,'Thêm quảng cáo Top: '.$vdata['name']);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'adsdeal/bannertop/ds/';
                }else{
                    $url = 'adsdeal/bannertop/ds/edit/'.$id;
                }
                redirect($url);
                
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannertop/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $data['title'] = 'Cập nhật quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'adsdeal/bannertop/ds';
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/bannertopdeal/';
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
            $vdata['name'] = $this->input->post('name');
            $vdata['link'] = $this->input->post('link');
            $vdata['ordering'] = $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published');
            $vdata['position'] = 1;
            if($this->vdb->update('banner_deal',$vdata,array('id'=>$id))){
                write_log(78,256,'Cập nhật quảng cáo Top: '.$vdata['name']);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'adsdeal/bannertop/ds/';
                }else{
                    $url = uri_string();
                }
                redirect($url);
                
            }
        }
        $data['rs'] = $this->vdb->find_by_id('banner_deal',array('id'=>$this->uri->segment(4)));
        
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'bannertop/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');

            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $name = $this->vdb->find_by_id('banner_deal',array('id'=>$ar_id[$i]))->name;
                    if($this->vdb->delete('banner_deal',array('id'=>$ar_id[$i]))){
                         write_log(78,257,'Xóa quảng cáo Top: '.$name);
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('adsdeal/bannertop/ds/'.$page);
    }
    
    function write_quangcao(){
        $list = $this->vdb->find_by_list('banner_deal',array('position'=>1,'published'=>1),array('ordering'=>'asc'));
        $total = count($list);
       
        $i = 1;
        $str .= '<div class="lof-main-outer">';
        $str .= '<ul class="lof-main-wapper">';
        foreach($list as $rs):
            $name = $rs->name;
            $link = $rs->link;
            $img = base_url_site().'data/adv/bannertopdeal/'.$rs->images;
           
            $str .= '<li>';
            $str .= '<a href="'.$link.'" target="_blank"><img src="'.$img.'" title="'.$name.'" width="794" height="281" alt="'.$name.'"></a>';
            $str .= '</li>';
        $i ++;
        endforeach;        
        $str .= '<li></li>';        
        $str .= '</ul>';        
        $str .= '</div>';
		
        //************
        $str  .='<div class="lof-navigator-outer">';
        $str  .=' <ul class="lof-navigator">';
        foreach($list as $rs):
        	$nameItem = $rs->name;
            $linkItem = $rs->link;
            
        $str  .='<li><div>';
        $str  .=' <h3><a href="'.$linkItem.'" target="_blank">'.$nameItem.'</a> </h3>';
        $str  .='</div></li>';
        endforeach;   
        $str  .='</ul>';
        $str .= '<li></li>';  
        $str  .='</div>';
        //***
        write_file(ROOT.'site/config/config_bannertop_deal.php', $str);
    }
}
