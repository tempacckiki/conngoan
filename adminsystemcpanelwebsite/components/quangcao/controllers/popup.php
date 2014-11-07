<?php
class popup extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->helper('file');
        $this->load->config('config_popupcontent');
        $this->load->config('config_popupfoot');
    } 
    
    function content(){
        $data['title'] = 'Quảng cáo banner content';
        
        $data['save'] = true;
        $data['popup_img'] = $this->config->item('popup_img');
        $data['popup_link'] = $this->config->item('popup_link');
        $data['popup_active'] = $this->config->item('popup_active');
        $data['popup_width'] = $this->config->item('popup_width');
        $data['popup_height'] = $this->config->item('popup_height');
        $this->form_validation->set_rules('popup_img','','');
        if($this->form_validation->run()){
            
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/popupcontent/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userleft')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $anhtrai = $result['file_name'];               
                }                    
            }else{
                $anhtrai = $this->input->post('anh');
            }
            
            
            $link = $this->input->post('link');
            $active = (int)$this->input->post('active');
            $width = (int)$this->input->post('width');
            $height = (int)$this->input->post('height'); 
            $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_bannertruot language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
            $str .= "\n\$config['popup_img'] = '$anhtrai';"; 
            $str .= "\n\$config['popup_link'] = '$link';";
            $str .= "\n\$config['popup_active'] = $active;\n"; 
            $str .= "\n\$config['popup_width'] = $width;\n"; 
            $str .= "\n\$config['popup_height'] = $height;\n"; 
            $str .= "\n\n/* End of file config_popupcontent*/";        
            write_file(ROOT_ADMIN.'config/config_popupcontent.php', $str);
            write_log(80,262,'Cập nhật quảng cáo banner content');  
            $this->session->set_flashdata('message','Lưu thành công');
            redirect('quangcao/popup/content');
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'popupcontent/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    function footer(){
        $data['title'] = 'Quảng cáo banner footer';
         
        $data['save'] = true;
        $data['popup_name'] = $this->config->item('popup_f_name');
        $data['popup_img'] = $this->config->item('popup_f_img');
        $data['popup_link'] = $this->config->item('popup_f_link');
        $data['popup_active'] = $this->config->item('popup_f_active');
        $this->form_validation->set_rules('popup_img','','');
        if($this->form_validation->run()){
            if($_FILES["userleft"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/adv/popupfooter/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload('userleft')){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $anhtrai = $result['file_name'];               
                }                    
            }else{
                $anhtrai = $this->input->post('anh');
            }

            $link = $this->input->post('link');
            $name = $this->input->post('name');
            $active = (int)$this->input->post('active');
            $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_bannertruot language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
            $str .= "\n\$config['popup_f_name'] = '$name';"; 
            $str .= "\n\$config['popup_f_img'] = '$anhtrai';"; 
            $str .= "\n\$config['popup_f_link'] = '$link';";
            $str .= "\n\$config['popup_f_active'] = $active;\n"; 
            $str .= "\n\n/* End of file config_popupfoot*/";        
            write_file(ROOT_ADMIN.'config/config_popupfoot.php', $str);
            write_log(81,263,'Cập nhật quảng cáo banner footer phải');
            $this->session->set_flashdata('message','Lưu thành công');
            redirect('quangcao/popup/footer');
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'popupfooter/index';
        $this->templates->load($this->_templates['page'],$data);
    }

}
