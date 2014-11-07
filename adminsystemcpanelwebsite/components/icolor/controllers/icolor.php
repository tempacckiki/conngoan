<?php
class icolor extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
    }
    
    function ds(){
        $data['title'] = 'Bảng mã mầu sản phẩm';
        write_log(67,209,'Xem danh sách bảng mã mầu'); 

        $data['add'] = 'icolor/add|'.icon_add('icolor/add');
        $data['list'] = $this->vdb->find_by_list('shop_color',0,array('icolor'=>'asc'));
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới mã mầu';
        $data['apply'] = true;
        $data['save'] = true;
        $data['cancel'] = 'icolor/ds';
        $this->form_validation->set_rules('name','Tên mầu','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $name = $this->input->post('name');
            //$cl = $this->input->post('color');
            if($_FILES["userfile"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/iconcolor/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                          
                if ( !$this->upload->do_upload()){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $images = $result['file_name'];               
                }                    
            }else{
                $images = '';
            }
            $vdata['color'] = $name;
            $vdata['images'] = $images;
            if($id = $this->vdb->update('shop_color',$vdata)){
                write_log(67,210,' Thêm mã mầu: '.$name); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'icolor/ds';
                }else{
                    $url = 'icolor/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $data['title'] = 'Cập nhật mã mầu';
        $data['apply'] = true;
        $data['save'] = true;
        $data['cancel'] = 'icolor/ds';
        $this->form_validation->set_rules('name','Tên mầu','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $name = $this->input->post('name');
            if($_FILES["userfile"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/iconcolor/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                          
                if ( !$this->upload->do_upload()){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $images = $result['file_name'];               
                }                    
            }else{
                $images = $this->input->post('img_old');
            }
            $id = $this->input->post('id');
            $vdata['color'] = $name;
            $vdata['images'] = $images;
            if($this->vdb->update('shop_color',$vdata,array('icolor'=>$id))){
                write_log(67,211,'Cập nhật mã mầu: '.$name); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'icolor/ds';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        $data['rs'] = $this->vdb->find_by_id('shop_color',array('icolor'=>$this->uri->segment(3)));
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function check_total($icolor){
        $this->db->where('icolor',$icolor);
        $total = $this->db->get('shop_color_product')->num_rows();
        if($total > 0){
            return false;
        }else{
            return true;
        }
    }
    
    function del(){
        $id = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $mn = $this->vdb->find_by_id('shop_color',array('icolor'=>$id))->color; 
        if($this->check_total($id)){
            if($this->vdb->delete('shop_color',array('icolor'=>$id))){
                write_log(67,213,'Xóa mã mầu: '.$mn);
                $this->session->set_flashdata('message','Đã xóa thành công'); 
            }else{
                $this->session->set_flashdata('message','Xóa không thành công');
            }
        }else{
            $this->session->set_flashdata('message','Mã mầu: '.$mn.' còn tồn tại trong sản phẩm. Không xóa được');
        }
        redirect('icolor/ds/'.$page);
    }
}
