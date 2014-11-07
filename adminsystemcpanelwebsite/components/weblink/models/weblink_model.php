<?php
   class weblink_model extends CI_Model{
       function __construct(){
          parent::__construct();
      }
      function get_all_customer($field,$order,$num,$offset){
          if($field !='' && $order !=''){
              $this->db->order_by($field,$order);
          }else{
              $this->db->order_by('weblink_id','DESC');
          }
          return $this->db->get('weblink',$num,$offset)->result();
      }
      
      function get_num_customer(){
          return $this->db->get('weblink')->num_rows();
      }
      
      function get_customer_by_id($kh_id){
          $this->db->where('weblink_id',$kh_id);
          return $this->db->get('weblink')->row();
      }
      
      // Lưu thong tin khach hang
      
      function save_weblink(){
          $kh_id = (int)$this->uri->segment(3);
          if($kh_id !=0 ){
              $rs = $this->get_customer_by_id($kh_id);
              if($this->input->post('images') != ''){
                if($rs->weblink_img!=''){
                    unlink(ROOT.$rs->weblink_img);
                  }
              }
          }
          if($this->input->post('images')!=''){
              $this->load->helper('img_helper');
              $img = $this->input->post('images');
              $filename = end(explode('/',$img));
              $customer_thumb = ROOT.'data/weblink/'.$filename;
              $images = 'data/weblink/'.$filename;
              vnit_resize_image(ROOT.$img,ROOT.$images,140,90,true);
          }else{
              $images = '';
          }          
          $data = array(
            'name' => $this->input->post('name'),
            'weblink_img' => (string)$images,
            'link' => (string)$this->input->post('link'),
          );
          
          if($kh_id !=0 ){
              $this->db->where('weblink_id',$kh_id);
              if($this->db->update('weblink',$data)){
                  return true;
              }else{
                  return false;
              }
          }else{
              if($this->db->insert('weblink',$data)){
                  return true;
              }
          }
      }
      
      function delete($kh_id){
          $rs = $this->get_customer_by_id($kh_id);
          if($rs->weblink_img !=''){
              unlink(ROOT.$rs->weblink_img);
          }
          $this->db->where('weblink_id',$kh_id);
          if($this->db->delete('weblink')){
              return true;
          }else{
              return false;
          }
      }      
   }
?>
