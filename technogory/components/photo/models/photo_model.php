<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**************************
* Model - Photo
* Author: Tran Ngoc Duoc
* Email: tranngocduoc@gmail.com
* Date: 17/06/2011
***************************/
  class photo_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      // Danh sach chuyen muc hinh anh
      function get_list_cat(){
          $this->db->where('IsActive',1);
          $this->db->order_by('ordering','ASC');
          return $this->db->get('album_cat')->result();
      }
      
      // Danh sach Album
      
      function get_all_album($catid,$num,$offset){
          $this->db->where('catid',$catid);
          //$this->db->order_by('albumid','desc');
          return $this->db->get('album',$num,$offset)->result();
      }
      function get_num_album($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('album')->num_rows();
      } 
      
      function get_album_by_id($albumid){
          $this->db->where('albumid',$albumid);
          return $this->db->get('album')->row();
      }     
      
      function get_listimg_by_album($albumid){
          $this->db->where('albumid',$albumid);
          return $this->db->get('album_img')->result();
      }
      
      function get_cat_info($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('album_cat')->row();
      }
      
  }