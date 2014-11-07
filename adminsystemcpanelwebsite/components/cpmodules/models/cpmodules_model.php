<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class cpmodules_model extends CI_Model{
    function __construct() {
        parent::__construct();
    }
    
    // Show list modules
    function get_all_modules($field,$order,$lang,$num,$offset){
        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);    
        }else{
            $this->db->order_by('ordering','asc');
        }

        $this->db->where('lang',$lang);
        return $this->db->get('modules',$num,$offset)->result();
    }
    
    function get_num_modules($lang){
        $this->db->where('lang',$lang);
        return $this->db->get('modules')->num_rows();
    }
}
?>
