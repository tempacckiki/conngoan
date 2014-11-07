<?php
  class payment_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      function get_all_payment(){
          $this->db->order_by('ordering','asc');
          return $this->db->get('shop_payment')->result();
      }
      
      function get_payment_by_id($payment_id){
          $this->db->where('payment_id',$payment_id);
          return $this->db->get('shop_payment')->row();
      }
      
      function save_payment(){
          $payment_id = (int)$this->input->post('payment_id');
          $payment = nl2br($this->input->post('payment'));
          if($payment_id != 0){
              $this->db->where('payment_id',$payment_id);
              if($this->db->update('shop_payment',$payment)){
                  return true;
              }else{
                  return false;
              }
          }else{
              if($this->db->insert('shop_payment',$payment)){
                  return true;
              }else{
                  return false;
              }
          }
      }
  }
?>
