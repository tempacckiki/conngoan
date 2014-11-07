<?php
class danhmuc extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('danhmuc_model','danhmuc');
         $this->load->config('config_mnews');
        $this->mnews = $this->config->item('mnews');
    }
    
    function index(){
        redirect('daugia/danhmuc/listcategory');
    }
    
    function listcategory(){
        $data['title'] = 'Quản lý Chủ đề';
        $data['add'] = 'daugia/danhmuc/add';
        $data['delete'] = true;        
        $data['sections_id'] = (int)$this->input->get('sections_id');
        $data['listsections'] = $this->vdb->find_by_list('product_category',array('site'=>2));
        $field = $this->uri->segment(5);
        $order = $this->uri->segment(6);   
        if($field == '' && $order ==''){
            $field = 'ordering';
            $order = 'asc';
        }   
        $sections_url = ($data['sections_id'] != 0) ? '?option=true&sections_id='.$data['sections_id'] : '';
        $config['suffix'] = '/'.$field.'/'.$order.$sections_url;          
        $config['base_url'] = base_url().'danhmuc/listcategory/';  
        $config['total_rows']   =  $this->danhmuc->find_by_num($data['sections_id']);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 4; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->danhmuc->find_by_all($config['per_page'],$this->uri->segment(4),$data['sections_id'],$field,$order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'danhmuc/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới Chủ đề';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'daugia/danhmuc/listcategory';
        $data['list'] = $this->vdb->find_by_list('product_category',array('site'=>2,'parent_id'=>0));
        // Form validation
        $this->form_validation->set_rules('cat[cat_title]','Tiêu đề - vi','required');
        $this->form_validation->set_rules('cat_en[cat_title]','Tiêu đề - en','required');
        $this->form_validation->set_rules('cat[published]','Hiển thị','required');
        $this->form_validation->set_rules('cat[ordering]','','');
        $this->form_validation->set_rules('cat[parent_id]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $cat_id = (int)$this->input->post('cat_id');
            $cat = $this->input->post('cat');
            $cat_en = $this->input->post('cat_en');
            $cat['cat_alias'] = vnit_change_title($cat['cat_title']);
            $cat['lang'] = vnit_lang();
            $cat['site'] = 2;
            if($cat_id = $this->vdb->update('product_category',$cat)){
                $cat_en['cat_id'] = $cat_id;
                $cat_en['cat_alias'] = vnit_change_title($cat_en['cat_title']);
                $cat_en['parent_id'] = $cat['parent_id'];
                $cat_en['ordering'] = $cat['ordering'];
                $cat_en['published'] = $cat['published'];
                $cat_en['site'] = 2;
                $this->vdb->update('product_category_en',$cat_en);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'daugia/danhmuc/listcategory';
                }else{
                    $url = 'daugia/danhmuc/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'danhmuc/add';
        $this->templates->load($this->_templates['page'],$data);
    }    
    function edit(){
        $data['title'] = 'Cập nhật Chủ đề';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'daugia/danhmuc/listcategory';        
        $data['rs'] = $this->vdb->find_by_id('product_category',array('cat_id'=>$this->uri->segment(4)));
        $data['rs_en'] = $this->vdb->find_by_id('product_category_en',array('cat_id'=>$this->uri->segment(4)));
        $data['list'] = $this->vdb->find_by_list('product_category',array('site'=>2,'parent_id'=>0));
        // Form validation
        $this->form_validation->set_rules('cat[cat_title]','Tiêu đề - vi','required');
        $this->form_validation->set_rules('cat_en[cat_title]','Tiêu đề - en','required');
        $this->form_validation->set_rules('cat[published]','Hiển thị','required');
        $this->form_validation->set_rules('cat[ordering]','','');
        $this->form_validation->set_rules('cat[parent_id]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $cat_id = (int)$this->input->post('cat_id');
            $cat = $this->input->post('cat');
            $cat_en = $this->input->post('cat_en');
            $cat['lang'] = vnit_lang();
            $cat['cat_alias'] = vnit_change_title($cat['cat_title']);
            if($this->vdb->update('product_category',$cat,array('cat_id'=>$cat_id))){
                // Update Cat en
                $cat_en['cat_alias'] = vnit_change_title($cat_en['cat_title']);
                $cat_en['parent_id'] = $cat['parent_id'];
                $cat_en['ordering'] = $cat['ordering'];
                $cat_en['published'] = $cat['published'];
                $cat_en['site'] = 2;
                $this->vdb->update('product_category_en',$cat_en,array('cat_id'=>$cat_id));
                // Update content VI;
                $con['cat_alias'] = $cat['cat_alias'];
                $this->vdb->update('product_content',$con,array('catid'=>$cat_id));
                // Update content en
                $con['cat_alias'] = $cat_en['cat_alias'];
                $this->vdb->update('product_content_en',$con,array('catid'=>$cat_id)); 
                
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'daugia/danhmuc/listcategory';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'danhmuc/edit';
        $this->templates->load($this->_templates['page'],$data);
    }  
    function save_order(){
        $id = $this->input->post('id');
        for($i = 0 ; $i< sizeof($id);$i++){
            $menu['ordering'] = $this->input->post('order_'.$id[$i]);
            $this->vdb->update('product_category',$menu,array('cat_id'=>$id[$i]));
            $this->vdb->update('product_category_en',$menu,array('cat_id'=>$id[$i]));
        }
    }    
    // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                  if($this->vdb->find_by_max('product_content','',array('catid'=>$ar_id[$i])) > 0){
                      $this->session->set_flashdata('error','Chủ đề: <b>'.$this->vdb->find_by_id('product_category',array('cat_id'=>$ar_id[$i]))->cat_title.'</b> vẫn còn bài viết. Vui lòng xóa bài viết');
                  }else{                        
                        if($this->vdb->delete('product_category', array('cat_id'=>$ar_id[$i]))){
                            $this->vdb->delete('product_category_en', array('cat_id'=>$ar_id[$i]));
                            $this->session->set_flashdata('message','Đã xóa thành công');
                        }else{
                            $this->session->set_flashdata('error','Xóa không thành công');
                        }
                  }
                }
            }
        }
        redirect('daugia/danhmuc/listcategory/'.$page);
    }      
}