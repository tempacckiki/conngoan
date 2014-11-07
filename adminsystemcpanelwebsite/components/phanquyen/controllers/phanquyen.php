<?php
class phanquyen extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('phanquyen_model','phanquyen');
        $css_array = array(
            array(base_url().'components/phanquyen/views/esset/phanquyen.css')
        );
        $js_array = array(
            array(base_url().'components/phanquyen/views/esset/phanquyen.js')
        );
        $this->esset->css($css_array);
        $this->esset->js($js_array);
        $this->pre_message = "";
    }
    
    function add_uri(){
    
        $list = $this->vdb->find_by_list('phanquyen',array('parentid !='=>0));
        foreach($list as $rs){
            $list_function =  $this->vdb->find_by_list('phanquyen_chucnang',array('phanquyen_id'=>$rs->id));
            foreach($list_function as $rs1):
                if($rs->module != '0'){
                    $vdata['uri1'] = $rs->module;
                    $vdata['uri2'] = $rs->component;
                    $vdata['uri3'] = $rs1->function_name;
                }else{
                    $vdata['uri1'] = $rs->component;
                    $vdata['uri2'] = $rs1->function_name;
                    $vdata['uri3'] = '';
                }
                
            
                //$vdata['user_id'] = $user_id;
                //$vdata['phanquyen_id'] = $root->id;
                //$vdata['component'] = $root->component;
                //$vdata['module'] = $root->module;
                
                //$vdata['function_name'] = $function->function_name;
                $check = $this->vdb->find_by_id('phanquyen_uri',array('function_id'=>$rs1->function_id));
                if($check){
                    $this->vdb->update('phanquyen_uri',$vdata,array('function_id'=>$rs1->function_id));
                }else{
                    $vdata['function_id'] = $rs1->function_id;
                    $this->vdb->update('phanquyen_uri',$vdata);    
                }
                
            endforeach;
            
            //$root = $this->vdb->find_by_id('phanquyen',array('id'=>$function->phanquyen_id));
            //$vdata['menu'] = $this->vdb->find_by_id('phanquyen',array('id'=>$root->parentid))->component;
            /*if($root->module != '0'){
                $vdata['uri1'] = $root->module;
                $vdata['uri2'] = $root->component;
                $vdata['uri3'] = $function->function_name;
            }else{
                $vdata['uri1'] = $root->component;
                $vdata['uri2'] = $function->function_name;
                $vdata['uri3'] = '';
            }*/

           
        }

    }
    
    function ds(){
        $data['title'] = 'Danh sách quản lý';
        $data['delete'] = true;
        $data['list'] = $this->phanquyen->get_all_user();
        ///$this->phanquyen->save_phanquyen_uri();
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
     if(file_exists(ROOT."admin/config/config_price_". $this->uri->segment('3').".php")){
      	$this->load->config("config_price_".$this->uri->segment('3'));
        $data["user_idPrice"]  	= $this->config->item("user_id");
      	$data["addPrice"]  		= $this->config->item("addPrice");
     	$data["editPrice"]  	= $this->config->item("editPrice");
  	 }else{
  	 	$data["user_idPrice"]  = "";
      	$data["addPrice"]     = "";
     	$data["editPrice"]    = "";
  	 }
    	
    	
        $data['title'] = 'Phân quyền cho thành viên: ';
        $data['save']  = true;
        $data['apply'] = true;
        $data['cancel'] = 'phanquyen/ds';
        $data['hethong'] = $this->vdb->find_by_list('phanquyen',array('parentid'=>0),array('ordering'=>'asc'));
        $this->form_validation->set_rules('user_id','','');
        if($this->form_validation->run()){
            $this->phanquyen->save_phanquyen();
            $this->session->set_flashdata('message','Lưu thành công');
            $option =  $this->input->post('option');
            if($option == 'save'){
               $url = 'phanquyen/ds/';
            }else{
                $url = uri_string();
            }
            redirect($url);
        }
        $this->_templates['page'] = 'edit';                     
        $this->templates->load($this->_templates['page'],$data);
    }
    
     // Xoa nhieu bai viet
    function dels(){
        $ar_id = $this->input->post('ar_id');
        $page = $this->input->post('page');
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
            	 $this->member = $this->load->database('member', TRUE); 		        
                 $this->vdb->delete('user',array('user_id'=>$ar_id[$i]));
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('phanquyen/ds'); 
    }
    
    // Xóa 01 bai viet
    function del(){
        $page = $this->uri->segment(4);
        $newsid = $this->uri->segment(3);
        $this->member = $this->load->database('member', TRUE); 
        if($this->vdb->delete('user',array('user_id'=>$newsid))){
            $this->session->set_flashdata('message','Xóa thành công');
        }else{
            $this->session->set_flashdata('message','Xóa không thành công');
        }
        redirect('phanquyen/ds');
    }
    
    function danhmuc(){
        $data['title'] = 'Phân quyền thành viên theo danh mục sản phẩm';
        $data['list'] = $this->phanquyen->get_all_user();  
        $this->_templates['page'] = 'danhmuc/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add_danhmuc(){
        $data['title'] = 'Phân quyền thành viên';
        $data['apply'] = true;
        $data['list'] = $this->phanquyen->get_all_danhmuc();
        $this->form_validation->set_rules('user_id','Mã thành viên','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $ar_id = $this->input->post('ar_id');
            $user_id = $this->input->post('user_id');
            $this->vdb->delete('phanquyen_danhmuc',array('user_id'=>$user_id));
            for($i = 0; $i < sizeof($ar_id); $i++){
                if($ar_id[$i]){
                    $rs = $this->vdb->find_by_id('shop_cat',array('catid'=>$ar_id[$i]));
                    $vdata['user_id'] = $user_id;
                    $vdata['catid'] = $rs->catid;
                    $vdata['parentid'] = $rs->parentid;
                    $vdata['cap'] = $this->input->post('cap_'.$ar_id[$i]);
                    $this->vdb->update('phanquyen_danhmuc',$vdata);
                }
            }
            $this->session->set_flashdata('message','Lưu thành công');
            redirect(uri_string());
        }
        $this->_templates['page'] = 'danhmuc/add';
        $this->templates->load($this->_templates['page'],$data);
    }
}
