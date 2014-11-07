<?php
 class accountinfo extends CI_Controller{
     protected $_templates;
     function __construct(){
         parent::__construct();
         $this->pre_message = "";
         $this->load->model('ac_model','ac');
     }                                          
     
     function index(){
         $data['title'] = 'Thông tin tài khoản';
         $data['apply'] = true;
         $data['rs'] = $this->ac->get_ac_by_id();
         //form validation
         $this->form_validation->set_rules('user[fullname]','Họ và tên','required');
         $this->form_validation->set_rules('user[username]','Tên đăng nhập','required|callback__checkusernameedit');
         $this->form_validation->set_rules('user[email]','Tên đăng nhập','required|valid_email|callback__checkemailedit');
         $this->form_validation->set_rules('password','Mật khẩu','required');
         $this->form_validation->set_rules('re_password','Mật khẩu nhập lại','required|matches[password]');
         if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
         }else{
             $user = $this->input->post('user');
             $user_id = $this->input->post('user_id');
             $password = $this->input->post('password');
             if($password !=''){
                $user['password'] = md5($password);
             }
             if($this->vdb->update('user',$user,array('user_id'=>$user_id))){
                 $this->session->set_flashdata('message','Lưu thành công');
                 //
                // $this->session->set_userdata('');
                 $this->session->set_userdata('group_id','');
                 $this->session->set_userdata('active_shop','');
                // redirect('accountinfo');
             }
         }
         $data['message'] = $this->pre_message;
         $this->_templates['page'] = 'index';
         $this->templates->load($this->_templates['page'],$data);
     }
     
    function _checkusernameedit($username){
        $this->db->where('user_id !=',$this->session->userdata('user_id'));
        $this->db->where('username',$username);
        $row = $this->db->get('user')->row();
        if($row){
            $this->form_validation->set_message('_checkusernameedit', 'Tên đăng nhập đã tồn tại trên hệ thống'); 
            return FALSE;
        }else{
            return true;
        }
    }
    function _checkemailedit($email){
        $this->db->where('user_id !=',$this->session->userdata('user_id'));
        $this->db->where('email',$email);
        $row = $this->db->get('user')->row();
        if($row){
            $this->form_validation->set_message('_checkemailedit', 'Email đã tồn tại trên hệ thống'); 
            return FALSE;
        }else{
            return true;
        }
    }     
 }
