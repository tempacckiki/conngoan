<?php
class sections extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
    }
    
    function index(){
        redirect('sections/listsections');
    }
    
    function listsections(){
        $data['title'] = 'Quản lý Nhóm tin';
        $data['add'] = 'sections/add';
        $data['delete'] = true;
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);       
        if($field == '' && $order ==''){
            $field = 'ordering';
            $order = 'asc';
        }
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'sections/listsections/';  
        $config['total_rows']   =  $this->vdb->find_by_num('sections',array('lang'=>vnit_lang()));
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->vdb->find_by_all('sections',$config['per_page'],$this->uri->segment(4),array('lang'=>vnit_lang()),$field,$order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới Nhóm tin';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'sections/listsections';
        // Form validation
        $this->form_validation->set_rules('sections[sections_title]','Tên nhóm tin','required');
        $this->form_validation->set_rules('sections[published]','Hiển thị','required');
        $this->form_validation->set_rules('sections[ordering]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $sections_id = (int)$this->input->post('sections_id');
            $sections = $this->input->post('sections');
            $sections['sections_alias'] = vnit_change_title($sections['sections_title']);
            $sections['lang'] = vnit_lang();
            if($id = $this->vdb->update('sections',$sections)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sections/listsections';
                }else{
                    $url = 'sections/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }    
    function edit(){
        $data['title'] = 'Cập nhật Nhóm tin';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'sections/listsections';
               
        $data['rs'] = $this->vdb->find_by_id('sections',array('sections_id'=>$this->uri->segment(3)));
        // Form validation
        $this->form_validation->set_rules('sections[sections_title]','Tên nhóm tin','required');
        $this->form_validation->set_rules('sections[published]','Hiển thị','required');
        $this->form_validation->set_rules('sections[ordering]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $sections_id = (int)$this->input->post('sections_id');
            $sections = $this->input->post('sections');
            $sections['lang'] = vnit_lang();
            $sections['sections_alias'] = vnit_change_title($sections['sections_title']);
            if($this->vdb->update('sections',$sections,array('sections_id'=>$sections_id))){
                $con['sections_alias'] = $sections['sections_alias'];
                $this->vdb->update('content',$con,array('sections_id'=>$sections_id));
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sections/listsections';
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
            
                $this->vdb->update('sections',$menu,array('sections_id'=>$id[$i]));
            
        }
    }     
      // Xoa 1 ban ghi
      function del(){
          $id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
          if($this->vdb->find_by_max('category','',array('section'=>$id)) > 0){
              $this->session->set_flashdata('error','Chủ đề: <b>'.$this->vdb->find_by_id('sections',array('sections_id'=>$id))->sections_title.'</b> vẫn còn chủ đề con. Vui lòng xóa chủ đề con');                            
          }else{
             if($this->vdb->delete('sections', array('sections_id'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          }
          redirect('sections/listsections/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->find_by_max('category','',array('section'=>$ar_id[$i])) > 0){
                            $this->session->set_flashdata('error','Chủ đề: <b>'.$this->vdb->find_by_id('sections',array('sections_id'=>$ar_id[$i]))->sections_title.'</b> vẫn còn chủ đề con. Vui lòng xóa chủ đề con');                            
                        }else{
                            if($this->vdb->delete('sections', array('sections_id'=>$ar_id[$i])))
                            $this->session->set_flashdata('message','Đã xóa thành công');
                            else $this->session->set_flashdata('error','Xóa không thành công');
                        }
                    }
                }
            }
            redirect('sections/listsections/'.$page);
      }      
}
