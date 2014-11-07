<?php
class CI_dm{
    function __construct(){
        $this->CI = get_instance();
        $this->user_id = $this->CI->session->userdata('user_id');
    }
    
    function list_main(){
        $ar_id = $this->find_main();
        if(count($ar_id) > 0){
        $this->CI->db->where_in('catid',$ar_id);
        $this->CI->db->where('parentid',0);
        $this->CI->db->order_by('ordering','asc');
        return $this->CI->db->get('shop_cat')->result();
        }else{
            return array();
        }
    }
    
    function find_main(){
         $list = $this->get_group_main();
         $ar_id = array();
         foreach($list as $rs):
            $check = $this->get_by_dm($rs->parentid);
            if($check->parentid == 0){
                array_push($ar_id, $rs->catid);
            }else{
                $row = $this->get_parent($rs->parentid);
                if($row->parentid == 0){
                    array_push($ar_id, $row->catid);
                }else{
                   $row1 = $this->get_parent($row->parentid); 
                   if($row1->parentid == 0){
                       array_push($ar_id, $row1->catid);
                   }else{
                       $row2 = $this->get_parent($row1->parentid);
                       if($row2->parentid == 0){
                           array_push($ar_id, $row2->catid);
                       }                       
                   }
                }
            }
         endforeach;
         return $ar_id;
    }
    
    function get_group_main(){
        $this->CI->db->where('parentid !=',0);
        $this->CI->db->where('user_id',$this->user_id);
        $this->CI->db->group_by('parentid');
        return $this->CI->db->get('phanquyen_danhmuc')->result();
    }
    
    function get_parent($catid){
        $this->CI->db->where('catid',$catid);
        return $this->CI->db->get('shop_cat')->row();
    }
    
    function get_by_dm($catid){
        $this->CI->db->where('catid',$catid);
        return $this->CI->db->get('shop_cat')->row();
    }
}
