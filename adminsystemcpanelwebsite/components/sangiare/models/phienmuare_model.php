<?php
class phienmuare_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_num_phienmuare(){
        if($this->group_id <= 17){
          $this->db->where('cheap_del',0);
        }
        return $this->db->get('cheap_list')->num_rows();
    }
    
    function get_all_phienmuare($field,$order,$num,$offset){
        if($this->group_id <= 17){
          $this->db->where('cheap_del',0);
        }
        if($field != '' && $order != ''){
            $this->db->order_by($field,$order);
        }else{
            $this->db->order_by('id','desc');
        }
        return $this->db->get('cheap_list',$num,$offset)->result();
    }
    
    function delete($id){
        if($this->vdb->delete('cheap_list',array('id'=>$id))){
            $this->vdb->delete('cheap_list_en',array('id'=>$id));
            $this->vdb->delete('cheap_cart',array('cheap_id'=>$id));
            $this->vdb->delete('cheap_comment',array('cheap_id'=>$id));
            return true;
        }else{
            return false;
        }
    }
    
    function delete_status($id){
        $vdata['cheap_del'] = 1;
        if($this->vdb->update('cheap_list',$vdata,array('id'=>$id))){
          $this->db->update('cheap_list_en',$vdata,array('id'=>$id));
          return true;
        }else{
          return false;
        }
    }
}
