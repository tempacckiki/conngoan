<?php
class daugia_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
 // Danh sach phien dau gia dang dien ra
    function get_num_bid(){
        if($this->cityid != 0){
            $this->db->where('city_id',$this->cityid);
        }
        $this->db->where('stop',0);
        return $this->db->get('bid_list')->num_rows();
    }
    
    function get_all_bid($num,$offset){
        if($this->cityid != 0){
            $this->db->where('city_id',$this->cityid);
        }
        $this->db->where('stop',0);
        $this->db->order_by('time_begin','desc');
        return $this->db->get('bid_list',$num,$offset)->result();
    }
    
    //Lay danh sach hinh anh cua san pham
    function get_list_img_by_product($productid){
        $this->db->where('productid',$productid);
        return $this->db->get('product_bid_img')->result();
    }
    
    function set_auto_stop(){
        $time_server = ($this->config->item('time_server') * 60);
        $list = $this->vdb->find_by_list('bid_list',array('stop'=>0));
        foreach($list as $rs):
            if( ( ($rs->time_end - (time() + $time_server)) <= 0) || ($rs->price_last >=  $rs->price_old) ){
                $vdata['stop'] = 1;
                $this->vdb->update('bid_list',$vdata,array('id'=>$rs->id));
            }
        endforeach;
        
    }
    
    /// Phien dau gia da ket thuc
    function get_num_old(){
        $this->db->where('stop',1);
        return $this->db->get('bid_list')->num_rows();
    }
    
    function get_all_old($num,$offset){
        $this->db->where('stop',1);
        $this->db->order_by('time_last','desc');
        return $this->db->get('bid_list',$num,$offset)->result();
    }
    
    
}
