<?php
class manage extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('manage_model','manage');
        $this->pre_message = "";
    }
    
    function listmanage(){
        $data['title'] = 'Quản lý thuộc tính nhóm sản phẩm';
        write_log(68,214,'Danh sách thuộc tính nhóm sản phẩm'); 
        $config['base_url'] = base_url().'features/manage/listmanage/';  
        $config['total_rows']   =  $this->manage->find_num_category();
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   15;
        $config['uri_segment'] = 4; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->manage->find_all_category($config['per_page'],$this->uri->segment(4));
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add_group(){
        
        $page = $this->uri->segment(5);
        $data['title'] = 'Thêm mới nhóm thuộc tính';
        $data['apply'] = true;
        $data['cancel'] = 'features/manage/listmanage/'.$page;
        $data['category'] = $this->manage->get_all_main_category(0);
        
        $this->form_validation->set_rules('fea[description]','Nhóm thuộc tính','required');
        $this->form_validation->set_rules('fea[ordering]','Sắp xếp','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $fea = $this->input->post('fea');
            $fea['slug'] = vnit_change_title($fea['description']);
            $fea['feature_type'] = $this->input->post('feature_type');
            if($feature_id = $this->vdb->update('shop_features',$fea)){
                write_log(68,215,'Thêm nhóm thuộc tính: '.$fea['description']);
                $this->session->userdata('message','Lưu thành công');
                redirect('features/manage/listmanage/'.$page);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add_group';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
    function edit_group(){
        $feature_id = $this->uri->segment(4);
        $page = $this->uri->segment(5);
        $data['title'] = 'Cập nhật nhóm thuộc tính';
        $data['apply'] = true;
        $data['cancel'] = 'features/manage/listmanage/'.$page;
        $data['category'] = $this->manage->get_all_main_category(0);
        $data['rs'] = $this->manage->get_edit_group($feature_id);
        $this->form_validation->set_rules('fea[description]','Nhóm thuộc tính','required');
        $this->form_validation->set_rules('fea[ordering]','Sắp xếp','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $fea = $this->input->post('fea');
            $fea['slug'] = vnit_change_title($fea['description']);
            $fea['feature_type'] = $this->input->post('feature_type');
            if($this->vdb->update('shop_features',$fea,array('feature_id'=>$id))){
                write_log(68,217,'Cập nhật nhóm thuộc tính: '.$fea['description']); 
                $this->session->userdata('message','Lưu thành công');
                redirect('features/manage/listmanage/'.$page);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'edit_group';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function del_group(){
        $feature_id = $this->uri->segment(4);
        $page = $this->uri->segment(5);
        $ft = $this->vdb->find_by_id('shop_features',array('feature_id'=>$feature_id))->description;
        if($this->vdb->delete('shop_features',array('parent_id'=>$feature_id))){
            $this->vdb->delete('shop_features_cat',array('feature_id'=>$feature_id));
            $this->vdb->delete('shop_features',array('feature_id'=>$feature_id));
            write_log(68,219,'Xóa nhóm thuộc tính: '.$ft); 
            $this->session->userdata('message','Xóa thành công');
            redirect('features/manage/listmanage/'.$page);
        }
    }
    
    function del_field(){
        $feature_id = $this->uri->segment(4);
        $page = $this->uri->segment(5);
        $ft = $this->vdb->find_by_id('shop_features',array('feature_id'=>$feature_id))->description;
        if($this->vdb->delete('shop_features',array('feature_id'=>$feature_id))){
            write_log(68,220,'Xóa thuộc tính: '.$ft); 
            $this->session->userdata('message','Xóa thành công');
            redirect('features/manage/listmanage/'.$page); 
        }
    }
    
    
    
    function add_field(){
        $feature_id = $this->uri->segment(4);
        $page = $this->uri->segment(5);
        $data['title'] = 'Thêm mới thuộc tính';
        $data['apply'] = true;
        $data['cancel'] = 'features/manage/listmanage/'.$page;

        $data['rs'] = $this->manage->get_edit_group($feature_id);
        $this->form_validation->set_rules('fea[description]','Nhóm thuộc tính','required');
        $this->form_validation->set_rules('fea[ordering]','Sắp xếp','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $fea = $this->input->post('fea');
            $fea['slug'] = vnit_change_title($fea['description']);
            //$fea['feature_type'] = $this->input->post('feature_type');
            if($feature_id = $this->vdb->update('shop_features',$fea)){
                write_log(68,216,'Thêm thuộc tính: '.$fea['description']); 
                $this->session->userdata('message','Lưu thành công');
                redirect('features/manage/listmanage/'.$page);
            }
        }
        $data['listfeatures'] = $this->manage->getlist_features();
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add_field';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit_field(){
        $feature_id = $this->uri->segment(4);
        $page = $this->uri->segment(5);
        $data['title'] = 'Cập nhật thuộc tính';
        $data['apply'] = true;
        $data['cancel'] = 'features/manage/listmanage/'.$page;

        $data['rs'] = $this->manage->get_edit_group($feature_id);
        $this->form_validation->set_rules('fea[description]','Nhóm thuộc tính','required');
        $this->form_validation->set_rules('fea[ordering]','Sắp xếp','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $fea = $this->input->post('fea');
            $fea['display_on_product'] = $this->input->post('display_on_product');
            $fea['display_on_catalog'] = $this->input->post('display_on_catalog');
            //$fea['feature_type'] = $this->input->post('feature_type');  
            $fea['slug'] = vnit_change_title($fea['description']);
            if($this->vdb->update('shop_features',$fea,array('feature_id'=>$id))){
                write_log(68,218,'Cập nhật thuộc tính: '.$fea['description']); 
                $this->session->userdata('message','Lưu thành công');
                redirect('features/manage/listmanage/'.$page);
            }
        }
        $data['listfeatures'] = $this->manage->getlist_features();
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'edit_field';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function feature_cat(){
        $data['title'] = 'Thuộc tính/ Nhóm sản phẩm';
        $listmaincat = $this->manage->get_all_main_category(0); 
        $catid = (int)$this->uri->segment(4);
        $cat_id = ($catid !=0)?$catid:$listmaincat[0]->catid;
        $data['listmaincat'] = $listmaincat;
        $data['list'] = $this->manage->get_all_main_category($cat_id);
        $data['cat_id'] = $cat_id;
        $this->_templates['page'] = 'features_cat';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add_features_cat(){
        $data['title'] = 'Thêm thuộc tính cho nhóm sản phẩm';   
        $catid = $this->uri->segment(4);
        $maincat = $this->uri->segment(5);
        $data['listfea'] = $this->manage->getlist_features();
        $this->form_validation->set_rules('catid','','');
        if($this->form_validation->run()){
            $catid = $this->input->post('catid');
            $catname = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid))->catname;
            $ar_id = $this->input->post('ar_id');
            $this->vdb->delete('shop_features_cat',array('catid'=>$catid));
            write_log(69,221,'Thêm/ Cập nhật thuộc tính cho danh mục sản phẩm: '.$catname);
            for($i = 0; $i < sizeof($ar_id); $i++){
                if($ar_id[$i]){
                    $vdata['catid'] = $catid;
                    $vdata['feature_id'] = $ar_id[$i];
                    $vdata['ordering'] = $this->input->post('order_'.$ar_id[$i]);
                    $this->vdb->update('shop_features_cat',$vdata);
                     
                }
            }
            $this->session->set_flashdata('message','Lưu thành công');
            redirect('features/manage/add_features_cat/'.$catid.'/'.$maincat);
        }
        $data['list']  = $this->manage->get_features_cat($catid);
        $this->_templates['page'] = 'add_features_cat';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function save_display_on_catalog(){
        $feature_id = $this->input->post('feature_id');
        $thuoctinh = $this->input->post('thuoctinh');
        $giatri = $this->input->post('giatri');
        $vdata[$thuoctinh] = $giatri;
        $this->vdb->update('shop_features',$vdata,array('feature_id'=>$feature_id));
    }
}