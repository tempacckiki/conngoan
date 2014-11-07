<?php
class support_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_list_city($type){
        $this->db->select('city.*, support.*');
        $this->db->join('city','city.city_id = support.city_id');
        $this->db->where('type',$type);
        $this->db->group_by('support.city_id');
        return $this->db->get('support')->result();
    }
}
