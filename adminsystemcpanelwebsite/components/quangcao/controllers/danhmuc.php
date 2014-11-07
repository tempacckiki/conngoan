<?php
class danhmuc extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->model('danhmuc_model','danhmuc');
        $this->load->helper('file');
    }
    
    function ds(){
        $this->write_quangcao();
        $data['title'] = 'Danh sách danh mục';
        $listcat = $this->danhmuc->get_all_danhmuc();
        $data['delete'] = icon_dels('quangcao/danhmuc/dels');
        $catid = (int)$this->uri->segment(4);
        
        if($catid == 0){
            $catid = $listcat[0]->catid;
        }
        $catname = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid))->catname;
        write_log(79,258,'Xem danh sách quảng cáo danh mục: '.$catname);
        $data['catid'] = $catid;
        $data['add'] = 'quangcao/danhmuc/add/'.$catid.'|'.icon_add('quangcao/danhmuc/add');
        $data['list'] = $this->danhmuc->get_all_quangcao($catid);
        $data['listcat'] = $listcat;
        $this->_templates['page'] = 'danhmuc/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $catid = $this->uri->segment(4);
        $data['title'] = 'Thêm mới quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'quangcao/danhmuc/ds/'.$catid;
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'alobuy0862779988/adv/danhmuc/';
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
            $vdata['cat_id'] = $this->input->post('cat_id');
            $vdata['name'] = $this->input->post('name');
            $vdata['link'] = $this->input->post('link');
            $vdata['ordering'] = $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published');
            $vdata['position'] = 2;
            if($id = $this->vdb->update('banner',$vdata)){
                $catname = $this->vdb->find_by_id('shop_cat',array('catid'=>$vdata['cat_id']))->catname;
                write_log(79,259,'Thêm quảng cáo: '.$vdata['name'].', danh muc: '.$catname);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'quangcao/danhmuc/ds/'.$this->input->post('cat_id');
                }else{
                    $url = 'quangcao/danhmuc/edit/'.$id;
                }
                redirect($url);
                
            }
        }
        $data['catid'] = $catid;
        $data['listcat'] = $this->danhmuc->get_all_danhmuc();
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'danhmuc/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $catid = $this->uri->segment(5);
        $data['title'] = 'Cập nhật quảng cáo';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'quangcao/danhmuc/ds';
        $this->form_validation->set_rules('name','Tên quảng cáo','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'alobuy0862779988/adv/danhmuc/';
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
            $vdata['cat_id'] = $this->input->post('cat_id');
            $vdata['name'] = $this->input->post('name');
            $vdata['link'] = $this->input->post('link');
            $vdata['ordering'] = $this->input->post('ordering');
            $vdata['published'] = $this->input->post('published');
            $vdata['position'] = 2;
            if($this->vdb->update('banner',$vdata,array('id'=>$id))){
                $catname = $this->vdb->find_by_id('shop_cat',array('catid'=>$vdata['cat_id']))->catname;
                write_log(79,260,'Cập nhật quảng cáo: '.$vdata['name'].', danh muc: '.$catname); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'quangcao/danhmuc/ds/'.$vdata['cat_id'];
                }else{
                    $url = uri_string();
                }
                redirect($url);
                
            }
        }
        $data['catid'] = $catid;
        $data['listcat'] = $this->danhmuc->get_all_danhmuc();
        $data['rs'] = $this->vdb->find_by_id('banner',array('id'=>$this->uri->segment(4)));
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'danhmuc/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');

            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $name = $this->vdb->find_by_id('banner',array('id'=>$ar_id[$i]))->name;
                    if($this->vdb->delete('banner',array('id'=>$ar_id[$i]))){
                         write_log(79,261,'Xóa quảng cáo: '.$name); 
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('quangcao/danhmuc/ds/'.$page);
    }
    
    function write_quangcao(){
        $list = $this->vdb->find_by_list('shop_cat',array('parentid'=>0),array('ordering'=>'asc'));
        $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_qcdanhmuc language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
        //$str .= "\n\$config['advtop_total'] = $total;\n"; 
        
        foreach($list as $rs):
        $catid = $rs->catid;
        $listadv = $this->danhmuc->get_limit_qc($rs->catid);
            
            $i = 1;
            $total = count($listadv);
            $str .= "\n\$config['advcat_tota_".$catid."'] = $total;";
            foreach($listadv as $val):
                $name = $val->name;
                $link = $val->link;
                $img = $val->images;
                $str .= "\n\$config['advcat_name_".$catid."_$i'] = '$name';";
                $str .= "\n\$config['advcat_link_".$catid."_$i'] = '$link';";
                $str .= "\n\$config['advcat_img_".$catid."_$i'] = '$img';\n";
                $i ++;
            endforeach;
        
        endforeach;
        $str .= "\n\n/* End of file config_qcdanhmuc*/";        
        write_file(ROOT_ADMIN.'config/config_qcdanhmuc.php', $str);
    }
}