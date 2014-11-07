<?php
class category extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('category_model','category');
    }
    
    function index(){
        redirect('category/listcategory');
    }
    
    function listcategory(){
        $data['title'] = 'Quản lý Chủ đề con';
        $data['add'] = 'category/add';
        $data['delete'] = true;        
        $this->category->create_menu();
        $data['sections_id'] = (int)$this->input->get('sections_id');
        $data['listsections'] = $this->vdb->find_by_list('sections',array('lang'=>vnit_lang()));
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);   
        if($field == '' && $order ==''){
            $field = 'ordering';
            $order = 'asc';
        }   
        $sections_url = ($data['sections_id'] != 0) ? '?option=true&sections_id='.$data['sections_id'] : '';
        $config['suffix'] = '/'.$field.'/'.$order.$sections_url;          
        $config['base_url'] = base_url().'category/listcategory/';  
        $config['total_rows']   =  $this->category->find_by_num($data['sections_id'],vnit_lang());
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->category->find_by_all($config['per_page'],$this->uri->segment(3),$data['sections_id'],vnit_lang(),$field,$order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }

    
    function add(){
        $data['title'] = 'Thêm mới Chủ đề con';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'category/listcategory';
                
        $data['list'] = $this->vdb->find_by_list('sections',array('lang'=>vnit_lang()));
        // Form validation
        $this->form_validation->set_rules('cat[cat_title]','Tiêu đề','required');
        $this->form_validation->set_rules('cat[published]','Hiển thị','required');
        $this->form_validation->set_rules('cat[ordering]','','');
        $this->form_validation->set_rules('cat[section]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $cat_id = (int)$this->input->post('cat_id');
            $cat = $this->input->post('cat');
            $cat['cat_alias'] = vnit_change_title($cat['cat_title']);
            $cat['lang'] = vnit_lang();
            if($this->vdb->update('category',$cat)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'category/listcategory';
                }else{
                    $url = 'category/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }    
    function edit(){
        $data['title'] = 'Cập nhật Chủ đề con';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'category/listcategory';        
        $data['rs'] = $this->vdb->find_by_id('category',array('cat_id'=>$this->uri->segment(3)));
        $data['list'] = $this->vdb->find_by_list('sections',array('lang'=>vnit_lang()));
        // Form validation
        $this->form_validation->set_rules('cat[cat_title]','Tiêu đề','required');
        $this->form_validation->set_rules('cat[published]','Hiển thị','required');
        $this->form_validation->set_rules('cat[ordering]','','');
        $this->form_validation->set_rules('cat[section]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $cat_id = (int)$this->input->post('cat_id');
            $cat = $this->input->post('cat');
            $cat['lang'] = vnit_lang();
            $cat['cat_alias'] = vnit_change_title($cat['cat_title']);
            if($this->vdb->update('category',$cat,array('cat_id'=>$cat_id))){
                $con['cat_alias'] = $cat['cat_alias'];
                $this->vdb->update('content',$con,array('catid'=>$cat_id));                
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'category/listcategory';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    }  
    function save_order(){
        $id = $this->input->post('id');
        for($i = 0 ; $i< sizeof($id);$i++){
            $menu['ordering'] = $this->input->post('order_'.$id[$i]);
            
                $this->vdb->update('category',$menu,array('cat_id'=>$id[$i]));
            
        }
    }    
      // Xoa 1 ban ghi
      function del(){
          $id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
          if($this->vdb->find_by_max('content','',array('catid'=>$id)) > 0){
              $this->session->set_flashdata('error','Chuyên mục: <b>'.$this->vdb->find_by_id('category',array('cat_id'=>$id))->cat_title.'</b> vẫn còn bài viết. Vui lòng xóa bài viết');
          }else{
             if($this->vdb->delete('category', array('cat_id'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          }
          redirect('category/listcategory/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                      if($this->vdb->find_by_max('content','',array('catid'=>$ar_id[$i])) > 0){
                          $this->session->set_flashdata('error','Chuyên mục: <b>'.$this->vdb->find_by_id('category',array('cat_id'=>$ar_id[$i]))->cat_title.'</b> vẫn còn bài viết. Vui lòng xóa bài viết');
                      }else{                        
                            if($this->vdb->delete('category', array('cat_id'=>$ar_id[$i])))
                            $this->session->set_flashdata('message','Đã xóa thành công');
                            else $this->session->set_flashdata('error','Xóa không thành công');
                      }
                    }
                }
            }
            redirect('category/listcategory/'.$page);
      }      
}