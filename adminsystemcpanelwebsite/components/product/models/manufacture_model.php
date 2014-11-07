<?php
  class manufacture_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      
      function get_all_manufacture($field,$order,$num,$offset){
          if($field!='' && $order !=''){
              $this->db->order_by($field,$order);
          }else{
             $this->db->order_by('manufactureid','desc');    
          }
          return $this->db->get('shop_manufacture',$num,$offset)->result();
      }
      
      function get_num_manufacture(){
          return $this->db->get('shop_manufacture')->num_rows();
      }
      
      function get_manufacture_by_id($manufactureid){
          $this->db->where('manufactureid',$manufactureid);
          return $this->db->get('shop_manufacture')->row();
      }
      
      // Xoa nha san xuat
      
      function delete($id){
          $rs = $this->get_manufacture_by_id($id);
          if($rs->images_small !=''){
              unlink(ROOT.'data/img_manufacture/'.$rs->images_small);
          }
          $this->db->where('manufactureid',$id);
          if($this->db->delete('shop_manufacture')){
              return true;
          }else{
              return false;
          }
      }
  }
?>
