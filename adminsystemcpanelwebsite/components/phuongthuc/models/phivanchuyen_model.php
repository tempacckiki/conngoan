<?php
class phivanchuyen_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_city($parentid = 0){
        $this->db->where('parentid',$parentid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('city')->result();
    }
}
