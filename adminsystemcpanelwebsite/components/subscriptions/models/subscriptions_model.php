<?php
class subscriptions_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_num(){
        return $this->db->get('subscriptions')->num_rows();
    }
    
    function  get_all($num, $offset){
        return $this->db->get('subscriptions',$num, $offset)->result();
    }

    public function getAllEmailSubscription(){
        return $this->db->get('subscriptions')->result();
    }
}
