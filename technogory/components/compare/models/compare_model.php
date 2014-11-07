<?php
class compare_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_ar_product($ar_id){
        $this->db->select('shop_product.*, shop_price.*');
        $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        $this->db->where('shop_price.city_id',$this->city_id);
        $this->db->where_in('shop_product.productid',$ar_id);
        return $this->db->get('shop_product')->result();
    }
    function get_features_list($catid,$prentid=0){
        $this->db->select('shop_features.*, shop_features_cat.*');
        $this->db->join('shop_features_cat','shop_features_cat.feature_id = shop_features.feature_id');
        $this->db->where('shop_features_cat.catid',$catid);
        $this->db->where('shop_features.parent_id',$prentid);
        $this->db->order_by('shop_features_cat.ordering','asc');
        return $this->db->get('shop_features')->result();
    }

    function get_item_features($feature_id){
        $this->db->where('parent_id',$feature_id);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_features')->result();
    }   
}
