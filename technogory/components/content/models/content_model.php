<?php
class content_model extends CI_Model{
	function __construct(){
		parent::__construct();
	}
    
    function get_orther($id,$catid,$lang){
        $this->db->where('id !=',$id);
        $this->db->where('catid',$catid);
        $this->db->where('lang',$lang);
        $this->db->order_by('created','desc');
        $this->db->limit(10);
        return $this->db->get('content')->result();
    }
}