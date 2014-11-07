<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**************************
* Model - Photo
* Author: Tran Ngoc Duoc
* Email: tranngocduoc@gmail.com
* Date: 17/06/2011
***************************/
  class rss_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
   
      function getAllCat($catID){       
          $this->db->where('parentid',$catID);
          $this->db->where('published',1);
          $this->db->order_by('ordering','ASC');
          return $this->db->get('shop_cat')->result();
      }
     
      
  }