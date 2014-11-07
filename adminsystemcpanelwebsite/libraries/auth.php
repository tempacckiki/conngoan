<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class CI_Auth{
    function __construct(){
        $this->CI = get_instance();
    }
    
    function check_login($username,$password){
        $this->member = $this->CI->load->database('member', TRUE);
        $this->member->where('email',$username);
        $this->member->where('password',md5($password));
        $row = $this->member->get('user')->row();
        
        if($row){
            return $row->user_id;
        }else{
            return 0;
        }
    }
    
    function auth_set_login($user_id){
        $this->member = $this->CI->load->database('member', TRUE); 
        $this->member->where('user_id',$user_id);
        $row = $this->member->get('user')->row();             
        $this->CI->session->set_userdata($row);
        $admin = array('admin'=>'fyi');
     
        $this->CI->session->set_userdata($admin);
    }
}

