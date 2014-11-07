<?php
class login_model extends CI_Model{
    function __construc(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE);
    }
    
    function check_user($user_id){
        $this->member = $this->load->database('member', TRUE);
        $this->member->where('user_id',$user_id);
        return $this->member->get('user')->row();
    }
    

}
?>
