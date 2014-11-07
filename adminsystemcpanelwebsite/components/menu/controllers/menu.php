<?php
class menu extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
    }
    
    function index(){
        redirect('menu/listmenus');
    }
    
    function listmenus(){
        $data['title'] = 'Quản lý danh mục menu';
        $data['add'] = 'menu/addmenus';
        $data['delete'] = true;
        $data['list'] = $this->vdb->find_by_list('menu_type');
        $data['num'] = count($data['list']);
        $this->_templates['page'] = 'menus/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function addmenus(){
        $data['title'] = 'Thêm mới danh mục menu';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'menu/listmenus';
        // form validation 
        $this->form_validation->set_rules('menu[menutype_title]','Tên menu','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $menu = $this->input->post('menu');
            $menu['menutype'] = vnit_change_string($menu['menutype_title']);
            if($id = $this->vdb->update('menu_type',$menu)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'menu/listmenus';
                }else{
                    $url = 'menu/editmenus/'.$id;
                }
                redirect($url);
            }
        }
        $this->_templates['page'] = 'menus/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function editmenus(){
        $data['title'] = 'Cập nhật menu';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'menu/listmenus';        
        $data['rs'] = $this->vdb->find_by_id('menu_type',array('menutype_id'=>$this->uri->segment(3)));
        // form validation 
        $this->form_validation->set_rules('menu[menutype_title]','Tên menu','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $menutype_id = (int)$this->input->post('menutype_id');
            $menu = $this->input->post('menu');
            $menu['menutype'] = vnit_change_string($menu['menutype_title']);
            if($this->vdb->update('menu_type',$menu,array('menutype_id'=>$menutype_id))){
                $menus['menutype'] = vnit_change_string($menu['menutype_title']);
                $this->vdb->update('menu',$menus,array('menutype_id'=>$menutype_id));
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'menu/listmenus';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }        
        $this->_templates['page'] = 'menus/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
      // Xoa 1 ban ghi
    function delmenus(){
          $id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
          
             if($this->vdb->delete('menu_type', array('menutype_id'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('menu/listmenus/'.$page);
    }
      // Xoa nhieu ban ghi
    function delsmenus(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('menu_type', array('menutype_id'=>$ar_id[$i])))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('menu/listmenus/'.$page);
    }
    
    // Manager submenu
    function listmenu(){
        $menutype_id = $this->uri->segment(3);
        if(!$menutype_id){
            redirect('menu/listmenus');
        }
        $data['add'] = 'menu/add/?menutype='.$menutype_id.'';
        $data['delete'] = true;
        $menutype = $this->vdb->find_by_id('menu_type',array('menutype'=>$menutype_id));
        $data['list'] = $this->vdb->find_by_list('menu',array('menutype'=>$menutype_id,'parent_id'=>0,'lang'=>vnit_lang()),array('ordering'=>'asc'));
        $data['title'] = 'Quản lý Menu: '.$menutype->menutype_title;
        $data['num'] = count($data['list']);
        $this->_templates['page'] = 'menulist/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $menutype = $this->input->get('menutype');
        $data['title'] = 'Thay đổi danh mục menu';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'menu/listmenu/'.$menutype;
        
        $data['listmenu'] = $this->vdb->find_by_list('menu',array('menutype'=>$menutype,'parent_id'=>0,'lang'=>vnit_lang()));
        $data['menutype'] = $menutype;
        //Form validation
        $this->form_validation->set_rules('menu[name]','Tên menu','required');
        $this->form_validation->set_rules('menu[link]','Link menu','required');
        $this->form_validation->set_rules('menu[ordering]','Sắp xếp','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $menu = $this->input->post('menu');
            $menu['lang'] = vnit_lang();
            if($id = $this->vdb->update('menu',$menu)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'menu/listmenu/'.$menu['menutype'];
                }else{
                    $url = 'menu/edit/'.$id.'/?menutype='.$menu['menutype'];
                }
                redirect($url);                

            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'menulist/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $menutype = $this->input->get('menutype');
        $data['title'] = 'Thay đổi danh mục menu';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'menu/listmenu/'.$menutype;
        $data['rs'] = $this->vdb->find_by_id('menu',array('id'=>$this->uri->segment(3)));
        $data['listmenu'] = $this->vdb->find_by_list('menu',array('menutype'=>$menutype,'parent_id'=>0,'lang'=>vnit_lang()));
        $data['menutype'] = $menutype;
        //Form validation
        $this->form_validation->set_rules('menu[name]','Tên menu','required');
        $this->form_validation->set_rules('menu[link]','Link menu','required');
        $this->form_validation->set_rules('menu[ordering]','Sắp xếp','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $menu = $this->input->post('menu');
            $menu['lang'] = vnit_lang();
            if($this->vdb->update('menu',$menu,array('id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'menu/listmenu/'.$menu['menutype'];
                }else{
                    $url = uri_string().'/?menutype='.$menu['menutype'];
                }
                redirect($url);                
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'menulist/edit';
        $this->templates->load($this->_templates['page'],$data);
    } 
    
      // Xoa 1 ban ghi
    function del(){
          $id = $this->uri->segment(3);
          $page = $this->uri->segment(4);
          
             if($this->vdb->delete('menu', array('id'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('menu/listmenu/'.$page);
    }
      // Xoa nhieu ban ghi
    function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = $this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('menu', array('id'=>$ar_id[$i])))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('menu/listmenu/'.$page);
    }    
    
    function save_order(){
        $id = $this->input->post('id');
        for($i = 0 ; $i< sizeof($id);$i++){
            $menu['ordering'] = $this->input->post('order_'.$id[$i]);
            
                $this->vdb->update('menu',$menu,array('id'=>$id[$i]));
            
        }
    }   
}
