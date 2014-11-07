<?php
class ac_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_ac_by_id(){
        $user_id = $this->session->userdata('user_id');
        $this->member = $this->load->database('member', TRUE);
        $this->member->where('user_id',$user_id);
        return $this->member->get('user')->row();
    }
}
