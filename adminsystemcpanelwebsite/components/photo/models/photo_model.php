<?php
/**************************
* Model Photo
* Author: Tran Ngoc Duoc
* Email: tranngocduoc@gmail.com
* Date: 08/07/2011
***************************/
  class photo_model extends CI_Model{
      function __construct(){
          parent::__construct();
          $this->lang = $this->session->userdata('lang');
          $this->load->helper('img_helper');
      }
      /*************************************************
      |                 Model xu lu Album               |
      |                                                 |
      **************************************************/      
      /**********
      * Hien thi danh sach Album
      * 
      * @param mixed $field
      * @param mixed $order
      * @param mixed $num
      * @param mixed $offset
      */
      function get_all_album($catid,$field,$order,$num,$offset){
          if($field !='' && $order !=''){
              $this->db->order_by($field,$order);
          }else{
              $this->db->order_by('albumid','DESC');
          }
          if($catid !=0){
              $this->db->where('catid',$catid);
          }
          return $this->db->get('album',$num,$offset)->result();
      }
      
      function get_num_album($catid){
          if($catid !=0){
              $this->db->where('catid',$catid);
          }          
          return $this->db->get('album')->num_rows();
      }
      
      /**************
      * Lay thong so Album theo ID
      * 
      * @param mixed $albumid
      */
      function get_album_by_id($albumid){
          $this->db->where('albumid',$albumid);
          return $this->db->get('album')->row();
      }
      
      /********
      * Danh sach hinh anh theo Album
      * 
      * @param mixed $albumid
      */
      function get_list_img_by_album($albumid){
          $this->db->where('albumid',$albumid);
          return $this->db->get('album_img')->result();
      }
      
      /************
      * Danh sach hinh anh theo Session
      * 
      * @param mixed $sessionid
      */
      function get_list_img_by_session($sessionid){
          $this->db->where('session_id',$sessionid);
          return $this->db->get('album_img')->result();
      } 
      
      function get_list_cat(){
          $this->db->order_by('ordering','asc');
          return $this->db->get('album_cat')->result();
      }     
      
      /**************
      * Lưu Album
      * 
      */
      function save_album(){
          $catid = $this->input->post('catid');
          $rs = $this->get_cat_by_id($catid);
          $albumid = (int)$this->uri->segment(3);
          $data = array(
            'album_name' => $this->input->post('album_name'), 
            'catid' => (int)$this->input->post('catid'), 
            'caturl' => $rs->caturl,
            'album_url' => vnit_change_title($this->input->post('album_name')), 
            'album_img' => (string)$this->input->post('album_img'),
            'IsActive' => (int)$this->input->post('IsActive')
          );
          
          if($albumid != 0){
                $this->db->where('albumid',$albumid);
                if($this->db->update('album',$data)){
                    return true;
                }else{
                    return false;
                }                    
          }else{
              if($this->db->insert('album',$data)){
                  $albumid = $this->db->insert_id();
                   $list_img = $this->get_list_img_by_session($this->session->userdata('session_id'));
                   foreach($list_img as $val):
                      vnit_resize_image(ROOT.'data/album/500/'.$val->imagepath,ROOT.'data/album/210/'.$val->imagepath,210,500,false);
                      $data_img = array(
                         'albumid' => $albumid,
                         'session_id' => ''
                      );
                      $this->db->where('session_id',$this->session->userdata('session_id'));
                      $this->db->update('album_img',$data_img);
                   endforeach;
                   return $albumid;
               }else{
                   return false;
               }
          }
      }
      
      
      /*********************
      * Xoa Album
      * 
      * @param mixed $albumid
      */
      function delete($albumid){
          $row = $this->get_album_by_id($albumid);
          if(!$row){
              return false;
          }
          $list = $this->get_list_img_by_album($albumid);
          foreach($list as $val):
               unlink(ROOT.'data/album/500/'.$val->imagepath);
               unlink(ROOT.'data/album/210/'.$val->imagepath);
          endforeach;
          $this->db->where('albumid',$albumid);
          $this->db->delete('album_img');
          
          $this->db->where('albumid',$albumid);
          if($this->db->delete('album')){
              return true;
          }else{
              return false;
          }
      }
      
      /**********
      * Proces Ajax Photo
      */
      /****************
      * Them hinh anh
      * 
      * @param mixed $filename
      * @param mixed $albumid
      * @param mixed $session
      */
      function add_img($filename,$albumid,$session){
          if($albumid!=0){
              if($filename!=''){
                  vnit_resize_image(ROOT.'data/album/500/'.$filename,ROOT.'data/album/210/'.$filename,210,500,false);
              }  
          }  
          $data = array(
            'imagepath' => $filename,
            'albumid' => (int)$albumid,
            'session_id' => ($albumid!=0)?'':$session
          );
          $this->db->insert('album_img',$data);
          
          return $this->db->insert_id();;
      }   
      
      /*************************************************
      |                 Model xu ly chuyen muc          |
      |                                                 |
      **************************************************/  
      
      function get_all_cat($field,$order,$num,$offset){
          if($field !='' && $order != ''){
              $this->db->order_by($field,$order);
          }else{
              $this->db->order_by('ordering','asc');
          }
          return $this->db->get('album_cat',$num,$offset)->result();
      }
      
      function get_num_cat(){
          return $this->db->get('album_cat')->num_rows();          
      }
      
      /**************
      * Luu chuyen muc
      */
      function save_cat(){
          $catid = (int)$this->uri->segment(3);
          $data = array(
            'catname' => (string)$this->input->post('catname'),
            'caturl' => vnit_change_title((string)$this->input->post('catname')),
            'des' => (string)$this->input->post('des'),
            'img_main' => (string)$this->input->post('img_main'),
            'keyword' => (string)$this->input->post('keyword'),
            'ordering' => (int)$this->input->post('ordering'),
            'IsActive' => (int)$this->input->post('IsActive')
          );
          if($catid != 0){
              $this->db->where('catid',$catid);
              if($this->db->update('album_cat',$data)){
                  // Update Caturl trong Album
                  $data_album = array(
                      'caturl' => vnit_change_title((string)$this->input->post('catname'))
                  );
                  $this->db->where('catid',$catid);
                  $this->db->update('album',$data_album);
                  return true;
              }else{
                  return false;
              }
          }else{
              if($this->db->insert('album_cat',$data)){
                  return $this->db->insert_id();
              }else{
                  return false;
              }
          }
      }
      /**********
      * Lay chuyen muc theo ID
      * 
      * @param mixed $catid
      */
      function get_cat_by_id($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('album_cat')->row();
      }
      
      /**********
      * Kiểm tra so luong album tỏng chuyen muc
      * 
      * @param mixed $catid
      */
      
      function check_total_album($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('album')->num_rows();
      }
      
      function delete_cat($catid){

          $this->db->where('catid',$catid);
          if($this->db->delete('album_cat')){
              return true;
          }else{
              return false;
          }
      }
  }
?>
