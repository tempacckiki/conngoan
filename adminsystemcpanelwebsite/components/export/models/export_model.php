<?php
class export_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    // Get list main cat 
    function get_main_cat(){
      $this->db->where('parentid',0);
      $this->db->order_by('ordering','asc');
      return $this->db->get('shop_cat')->result();
    }

    // Get list sub cat
    function get_sub_cat($CatID){
      $this->db->where('parentid',$CatID);
      $this->db->order_by('ordering','asc');
      return $this->db->get('shop_cat')->result();
    }
    
    function get_all_product($nhomhang, $city_id, $tungay, $denngay, $field, $order){
        $ar_id = $this->get_arr_cat($nhomhang);
        $this->db->select('shop_product.phukien,shop_product.productid, shop_product.catid, shop_product.manufactureid, shop_product.productname, shop_product.baohanh, shop_product.barcode, shop_price.*');
        $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        
        $this->db->where_in('catid',$ar_id); 
        $this->db->where('shop_price.city_id',$city_id); 
        if($tungay != '' && $denngay != ''){
            $this->db->where('lastupdate >=',strtotime('00:00:00 '.$tungay));
            $this->db->where('lastupdate <=',strtotime('23:59:59 '.$denngay));
        }
        if($field == 'price'){
            $this->db->order_by('giaban',$order);
        }else{
            $this->db->order_by($field, $order);
        }
        return $this->db->get('shop_product')->result();
    }
    
    function get_all_product_noprice($nhomhang){
        $ar_id = $this->get_arr_cat($nhomhang); 
        $this->db->where_in('catid',$ar_id);  
        return $this->db->get('shop_product')->result();
    }
    
    function get_gifts($productid,$khuvuc){
        $this->db->where('dateend >=',date('Y-m-d',time()));
        $this->db->where('local',$khuvuc);
        $this->db->where('productid',$productid);
        return $this->db->get('shop_gifts')->result();
    }
    
    function get_tangpham($productid, $city_id){
        $this->db->where('productid',$productid);
        $this->db->where('city_id',$city_id);
        return $this->db->get('shop_gifts')->row();
    }
    
      // Dua ra danh sach cac chuyen muc con theo mang
      function get_arr_cat($catid){
          $ar_id = array($catid);
          $this->db->where('parentid',$catid);
          $list = $this->db->get('shop_cat')->result();
          if(count($list) > 0){
              foreach($list as $rs):
                $infocat = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->parentid));
                array_push($ar_id,$rs->catid);
                if(count($infocat) > 0)
                {
                    foreach($infocat as $rs1):
                        array_push($ar_id,$rs1->catid);
                    endforeach;
                }
              endforeach;
          }
          return $ar_id;
      } 
}
