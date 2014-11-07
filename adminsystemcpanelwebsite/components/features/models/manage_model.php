<?php
class manage_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function find_num_category(){
        $this->db->where('parent_id',0);
        return $this->db->get('shop_features')->num_rows();
    }
    
    function find_all_category($num,$offset){
        $this->db->where('parent_id',0);
        $this->db->order_by('shop_features.parent_id','asc');
        return $this->db->get('shop_features',$num,$offset)->result();
    }
    
    function get_subcat($parent_id){
        $this->db->order_by('ordering','asc');
        $this->db->where('shop_features.parent_id',$parent_id);
        return $this->db->get('shop_features')->result();
    }
    
    function get_edit_group($feature_id){
        $this->db->where('shop_features.feature_id',$feature_id);
        return $this->db->get('shop_features')->row();
    }
    
    function getlist_features(){
        $this->db->where('shop_features.parent_id',0);
        $this->db->order_by('shop_features.parent_id','asc');
        return $this->db->get('shop_features')->result();
    }
    
    function get_all_main_category($parentid){
        if($parentid != 0){
            $this->db->where('parentid',$parentid);
        }else{
            $this->db->where('parentid',0);
        }
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }
    
    function get_features_cat($catid){
        $this->db->select('shop_features_cat.*,shop_features.feature_id, shop_features.feature_type, shop_features.parent_id, shop_features.description, shop_features.full_description, shop_features.slug');
        $this->db->join('shop_features_cat','shop_features_cat.feature_id = shop_features.feature_id');
        $this->db->where('shop_features_cat.catid',$catid);
        $this->db->order_by('shop_features_cat.ordering','asc');
        return $this->db->get('shop_features')->result();
    }
}
