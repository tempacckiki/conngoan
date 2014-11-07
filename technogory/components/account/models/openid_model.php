<?php
class openid_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    function create_account($email,$fullname,$identity){
        $this->member = $this->load->database('member', TRUE); 
        $data_account = array(
            'fullname' => $fullname,
            'email' => $email,
            'group_id' => 1,
            'published' => 1,
            'is_openid' => 1,
            'url_openid' => $identity,
            'city_id' => 25,
            'create_time' =>time()
        );
        $this->member->insert('user',$data_account);
        $user_id = $this->member->insert_id();
        $data['user_code'] = vnit_barcode('FYI_',$user_id,8); 
        $this->member->update('user',$data,array('user_id'=>$user_id));
        return $user_id;
    }
      
    function check_is_create_openid($email,$identity){
        $this->member = $this->load->database('member', TRUE);  
        $this->member->where('email',$email);
        //$this->member->where('url_openid',$identity);
        $check = $this->member->get('user')->row();
        if($check){
            return $check->user_id;
        }else{
            return 0;
        }
    }
      
    function update_openid($email,$identity){
        $this->member = $this->load->database('member', TRUE);
        $rs = $this->get_account_by_email($email);
        $data_account = array(
            'is_openid' => 1,
            'url_openid' => $identity
        );
        $this->member->where('email',$email);
        $this->member->update('user',$data_account);

        return $rs->user_id;
      
    }
    function get_account_by_email($email){
        $this->member = $this->load->database('member', TRUE);
        $this->member->where('email',$email);
        $check = $this->member->get('user')->row();
        return $check;
    }
    function is_email($email){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('email',$email);
        $check = $this->member->get('user')->row();
        if($check){
            return true;
        }else{
            return false;
        }
    }
    

    
    function get_user($user_id){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('user_id',$user_id);
        return $this->member->get('user')->row();
    }
      

      
    function update_avatar($avatar){
        $this->member = $this->load->database('member', TRUE); 
        $vdata['url_avatar'] = $avatar;
        if($this->member->update('user',$vdata,array('user_id'=>$this->user_id))){
          return true;
        }else{
          return false;
        }
    }
    
    function get_user_by_id(){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('user_id',$this->session->userdata('user_id'));
        return $this->member->get('user')->row();
    }
    function check_pass($password){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('password',$password);
        $this->member->where('user_id',$this->session->userdata('user_id'));
        return $this->member->get('user')->row();
    }
    
    
    function check_account_login($email, $password){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('password',$password);
        $this->member->where('email',$email);
        return $this->member->get('user')->row();
    }
    
    function get_email_templates($slug){
        $this->db = $this->load->database('default', TRUE);
        $this->db->where('slug',$slug);
        return $this->db->get('email_templates')->row();
    }
    
    // Facebook connect
    
    function is_email_fb($email){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('email',$email);
        $check = $this->member->get('user')->row();
        return $check;
    }
    
    function save_account_fb($data){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->insert('user',$data);
        $user_id =  $this->member->insert_id();
        $vup['user_code'] = vnit_barcode('FYI_',$user_id,8);
        $this->member->update('user',$vup,array('user_id'=>$user_id));
        return $user_id;
    }
    
    
}
