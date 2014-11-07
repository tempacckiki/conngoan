<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class login extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('login_model','login');
        $this->load->library('auth');
        $this->pre_message = "";
    }
    
    function index(){
        $data['title'] = 'Đăng nhập';
        $this->_templates['page'] = "index";
        
        $uri 		= $_SERVER["HTTP_HOST"];
        
        // Form validation
        $this->form_validation->set_rules('username','Tên đăng nhập','required|callback__check_username');
        $this->form_validation->set_rules('password','Mật khẩu','required');
        if($this->form_validation->run() == false){
            $this->pre_message = validation_errors();
        }else{
            $username = htmlspecialchars($this->input->post('username'));
            $password = $this->input->post('password');
            $user_id = $this->auth->check_login($username,$password);
            $check = $this->login->check_user($user_id);
        	
            if(($user_id != 0) && ($check->group_id >= 17) && ($check->active_shop >0)){            	
                $this->auth->auth_set_login($user_id);                
                $this->session->set_flashdata('message','Đăng nhập thành công');
                redirect('admincp');
            /*}else if($check->group_id < 17){
                $this->pre_message = "Tài khoản của bạn không có quyền truy cập trang quản trị";*/
            }else{
                $this->pre_message = "Đăng nhập không thành công";
            }
        }
        $data['msg'] = $this->pre_message;
        $this->templates->load($this->_templates['page'],$data,'login');
    }
    
    function _check_username($username){
        $this->member = $this->load->database('member', TRUE);  
        $this->member->select('email');
        $this->member->where('email',$username);
        $row = $this->member->get('user')->row();
        if($row){
            return true;
        }else{
            $this->form_validation->set_message('_check_username', 'Tên đăng nhập không tồn tại trên hệ thống');
            return false;
        }
    }

    
    function logout(){
        $this->session->sess_destroy();
        redirect(base_url());        
    }
}
?>
