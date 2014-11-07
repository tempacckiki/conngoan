<?php
class chienthang_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    function get_num_phiendaugia(){
        if($this->group_id <= 17){
          $this->db->where('bid_del',0);
        }
        $this->db->where('stop',1);
        return $this->db->get('bid_list')->num_rows();
    }
    
    function get_all_phiendaugia($num,$offset){
        if($this->group_id <= 17){
          $this->db->where('bid_del',0);
        }
        $this->db->order_by('time_last','desc');
        $this->db->where('stop',1);
        return $this->db->get('bid_list',$num,$offset)->result();
    }
}
