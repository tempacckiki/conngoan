<?php
  class suppermarket_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      function delete($id){
          $this->db->where('id',$id);
          if($this->db->delete('supermarkets')){
              return true;
          }else{
              return false;
          }
      }
  }
?>
