<?php
class phiendaugia_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_num_phiendaugia(){
        if($this->group_id <= 17){
          $this->db->where('bid_del',0);
        }
        return $this->db->get('bid_list')->num_rows();
    }
    
    function get_all_phiendaugia($field,$order,$num,$offset){
        if($this->group_id <= 17){
          $this->db->where('bid_del',0);
        }
        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('id','desc');
        }
        return $this->db->get('bid_list',$num,$offset)->result();
    }
    
    function delete($id){
        if($this->vdb->delete('bid_list',array('id'=>$id))){
            $this->vdb->delete('bid_history',array('bid_id'=>$id));
            return true;
        }else{
            return false;
        }
    }
    
    function delete_status($id){
        $vdata['bid_del'] = 1;
        if($this->vdb->update('bid_list',$vdata,array('id'=>$id))){
          return true;
        }else{
          return false;
        }
    }
    
    // Lich su Bid
    
    function get_num_history($id){
        $this->db->where('bid_id',$id);
        return $this->db->get('bid_history')->num_rows();
    }
    
    function get_all_history($num,$offset,$id){
        $this->db->where('bid_id',$id);
        $this->db->order_by('bid_time','desc');
        return $this->db->get('bid_history',$num,$offset)->result();
    }
}
