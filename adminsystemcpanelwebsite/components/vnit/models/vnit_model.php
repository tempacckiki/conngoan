<?php
  class vnit_model extends CI_Model{
      function __construct(){
         parent::__construct();
      }
      
      function get_content(){
      	return $this->db->get('content')->row();
      }
  }
?>
