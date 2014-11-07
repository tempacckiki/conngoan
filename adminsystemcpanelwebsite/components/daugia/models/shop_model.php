<?php
  class shop_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }

      /*********************************|
      |                                 |
      |  Model xu ly danh muc san pham  |
      |                                 |
      |*********************************/

      
      function get_all_manufacture(){
          $this->db->order_by('manufactureid','DESC');
          return $this->db->get('shop_manufacture')->result();
      }  
      
      function get_all_product($catid,$field,$order,$num,$offset){         
          if($field!='' && $order !=''){
              $this->db->order_by($field,$order);
          }else{
             $this->db->order_by('productid','DESC');    
          }
          if($this->group_id <= 17){
              $this->db->where('del',0);
          }

          return $this->db->get('product_bid',$num,$offset)->result();
      } 
      
      function get_num_product($catid){
          if($this->group_id <= 17){
              $this->db->where('del',0);
          }
          return $this->db->get('product_bid')->num_rows();
      }

      // Lưu san pham

      function save_product(){
          $productid = (int)$this->input->post('productid');
          
          $sp = $this->input->post('sp');
         // $sp_en = $this->input->post('sp_en');
          
          // Vietnamese
          $sp['producturl'] = vnit_change_title($sp['productname']);
          $sp['price'] = str_replace('.','',$sp['price']);
          
          // English
          $sp_en['barcode'] = $sp['barcode'];
          $sp_en['manufactureid'] = $sp['manufactureid'];
          $sp_en['productname'] = ($sp_en['productname'] != '')?$sp_en['productname']:$sp['productname'];
          $sp_en['producturl'] = vnit_change_title($sp_en['productname']);
          $sp_en['price'] = str_replace('.','',$sp['price']);

          if($productid != 0){
                if($this->vdb->update('product_bid',$sp,array('productid'=>$productid))){
                    // Cap nhat thong tin cho san pham tieng Anh
                   // $this->vdb->update('product_bid_en',$sp_en,array('productid'=>$productid));
                    return true;
                }else{
                    return false;
                }
          }else{
              
              if($productid = $this->vdb->update('product_bid',$sp)){
                // Them thong tin cho san pham tieng Anh
                //$sp_en['productid'] = $productid; 
               // $this->vdb->update('product_bid_en',$sp_en);
                // Them danh sach hinh anh vao san sham
                $ar_img = $this->input->post('ar_img');
                if(sizeof($ar_img) > 0){
                    //$this->vdb->delete('shop_img',array('productid'=>$productid));
                    $k = 1;
                    for($i=0; $i < sizeof($ar_img); $i++){
                        if($ar_img[$i]){
                          $ext = strtolower(end(explode('.',$ar_img[$i])));
                          $file_name = $sp['producturl'].'-'.$k.'.'.$ext; 
                          // Hinh anh san pham san gia re
                          //vnit_resize_image(ROOT_IMG.'temp/'.$ar_img[$i],ROOT_IMG.'daugia/200/'.$file_name,200,170);
                          vnit_resize_image(ROOT.'alobuy0862779988/daugia/full_images/'.$ar_img[$i],ROOT.'alobuy0862779988/daugia/200/'.$file_name,220,180);
                          $vimg['imagepath'] = $file_name;
                          $vimg['productid'] = $productid;
                          $vimg['ordering'] = $k;
                          $this->vdb->update('product_bid_img',$vimg);
                          if($sp['productimg'] == $ar_img[$i]){
                              $img_vi['productimg'] = $file_name;
                              $this->vdb->update('product_bid',$img_vi,array('productid'=>$productid));
                              $img_en['productimg'] = $file_name;
                              //$this->vdb->update('product_bid_en',$img_vi,array('productid'=>$productid)); 
                          }
                          $k++;
                      }
                    }
                }             
                           
                 return $productid; 
              }else{
                  return false;
              }
          }
      }
      
      function get_max_order_img($productid){
          $this->db->select_max('ordering');
          $this->db->where('productid',$productid);
          $row = $this->db->get('product_bid_img')->row();
          return $row->ordering;
      }
      
      function delete_product($productid){

          // Xoa hinh anh
          $list = $this->get_img_by_product_id($productid);
          foreach($list as $rs):
            unlink(ROOT_IMG.'daugia/200/'.$rs->imagepath);
          endforeach;
          $this->db->where('productid',$productid);
          $this->db->delete('product_bid_img');
          
          $this->db->where('productid',$productid);
          if($this->db->delete('product_bid')){
            //  $this->vdb->delete('product_bid_en',array('productid'=>$productid));
              return true;
          }else{
              return false;
          }
          
      }
      
      // Xoa tam san pham chơ xử lý
      function delete_product_status($productid){
          $vdata['del'] = 1;
          if($this->vdb->update('product_bid',$vdata,array('productid'=>$productid))){
              $this->db->update('product_bid_en',$vdata,array('productid'=>$productid));
              return true;
          }else{
              return false;
          }
      }

      
      
      // Kiem tra session anh cua san pham
      function get_img_by_session($session){
          $this->db->where('session_id',$session);
          $query = $this->db->get('shop_img');
          return $query->result();
      }
      
      // Danh sach hinh anh cua san pham
      function get_img_by_product_id($ProductID){
          $this->db->where('productid',$ProductID);
          return $this->db->get('shop_img')->result();
      }      
      
      /*******
      * Du lieu cap nhat
      */
      
      // Lay du lieu tu 1 record
      function get_product_by_id($productid,$lang = ''){
          $this->db->where('productid',$productid);
          return $this->db->get('product_bid'.$lang)->row();
      }

      
      function get_list_img_edit($productid){
          $this->db->where('productid',$productid);
          return $this->db->get('product_bid_img')->result();
      }


      /**********
      * Proces Ajax Shopping
      */
      function add_img($filename,$ProductID,$session){
          if($ProductID!=0){
              if($filename!=''){
                  vnit_resize_image(ROOT.'data/shop/product/500/'.$filename,ROOT.'data/shop/product/200/'.$filename,200,200);
                  vnit_resize_image(ROOT.'data/shop/product/500/'.$filename,ROOT.'data/shop/product/80/'.$filename,80,80);
                  vnit_resize_image(ROOT.'data/shop/product/500/'.$filename,ROOT.'data/shop/product/40/'.$filename,40,40);
              }  
          }  
          $data = array(
            'imagepath' => $filename,
            'productid' => (int)$ProductID,
            'session_id' => ($ProductID!=0)?'':$session
          );
          $this->db->insert('shop_img',$data);
          
          return $this->db->insert_id();;
      }
  }
?>
