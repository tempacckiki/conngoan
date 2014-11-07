<?php
/**************************
* Controller API - Ajax
* Author: Tran Ngoc Duoc
* Email: tranngocduoc@gmail.com
* Date: 17/06/2011
***************************/
  class api extends CI_Controller{
      function __construct(){
          parent::__construct();
      }
      
      // Tuy chinh hien thi trang thai cua ban ghi 
      function publish(){
          $status = $this->input->post('status');
          $id = $this->input->post('id');
          $field = $this->input->post('field');
          $table = $this->input->post('table');
          $link = $this->input->post('link');
          if($status==0){
              $pub = 1;
          }else{
              $pub = 0;
          }
          $this->db->set('published',$pub);
          $this->db->where($field,$id);
          $this->db->update($table);
          echo icon_active("'$table'","'$field'",$id,$pub,$link);
      }
      
      // SET ngon ngu
      
      function setlang(){
          $lang = $this->input->post('lang');
          $this->session->set_userdata(array('lang_admin'=>$lang));
      }
      
  }