<?php
  class shop_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }

      
      /***********************************|
      |                                   |
      |  Model xu ly thuoc tinh san pham  |
      |                                   |
      |***********************************/      
      
      /*********************************|
      |                                 |
      |  Model xu ly danh muc san pham  |
      |                                 |
      |*********************************/
      // Lay danh sach nha san xuat theo chuyen muc
      function get_manufacture_by_cat($catid){
          $this->db->select('shop_manufacture.*, shop_cat_manufacture.*');
          $this->db->join('shop_manufacture','shop_manufacture.manufactureid = shop_cat_manufacture.manufactureid');
          $this->db->where('shop_cat_manufacture.catid',$catid);
          return $this->db->get('shop_cat_manufacture')->result();
      }
      
      function get_all_manufacture(){
          $this->db->order_by('manufactureid','DESC');
          return $this->db->get('shop_manufacture')->result();
      }
      
      function get_manufacture_by_id($catid,$manufactureid){
          $this->db->where('catid',$catid);
          $this->db->where('manufactureid',$manufactureid);
          if($this->db->get('shop_cat_manufacture')->row()){
              return true;
          }else{
              return false;
          }
      }
      
      // Hien thi danh sach thuoc tinh
      function get_all_attr($parentid = 0){
          $this->db->where('parentid',$parentid);
          return $this->db->get('shop_type')->result();
      }
      function get_attr_by_id($type_id){
          $this->db->where('type_id',$type_id);
          return $this->db->get('shop_type')->row();
      }
      
      // Luu thuoc tinh san pham
      
      function save_attr(){
          $type_id = (int)$this->uri->segment(3);
          $data = array(
            'type_name' => $this->input->post('type_name'),
            'parentid' => (int)$this->input->post('parentid'),
            'IsActive' => (int)$this->input->post('IsActive')
          );
          if($type_id != 0){
              $this->db->where('type_id',$type_id);
              if($this->db->update('shop_type',$data)){
                  return true;
              }else{
                  return false;
              }
          }else{
              if($this->db->insert('shop_type',$data)){
                  return true;
              }else{
                  return false;
              }
          }
      }
      
      // Hien thi danh sach chuyen mục tin tuc
      function get_all_cat($maincat=0,$field,$order,$num,$offset){
          if($field!='' && $order !=''){
              $this->db->order_by($field,$order);
          }else{
             $this->db->order_by('catid','DESC');    
          }         
          $this->db->where('parentid',$maincat);
          return $this->db->get('shop_cat',$num,$offset)->result();
      }
      function get_num_cat($maincat=0){
          $this->db->where('parentid',$maincat);
          return $this->db->get('shop_cat')->num_rows();
      } 
      
      // Get list main cat 
      function get_main_cat(){
          $this->db->where('parentid',0);
          return $this->db->get('shop_cat')->result();
      }
      
      // Get list sub cat
      function get_sub_cat($CatID){
          $this->db->where('parentid',$CatID);
          return $this->db->get('shop_cat')->result();
      } 
      // GET cat
      function get_cat_by_id($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('shop_cat')->row();
      }
     
      
      /*********************************|
      |                                 |
      |  Model xu ly san pham           |
      |                                 |
      |*********************************/    
      
      function get_all_product($catid,$field,$order,$num,$offset){
          if($catid != 0){
              $ar_cat = $this->get_arr_cat($catid);
              $this->db->where_in('catid',$ar_cat);
          }          
          if($field!='' && $order !=''){
              $this->db->order_by($field,$order);
          }else{
             $this->db->order_by('productid','DESC');    
          }
          if($this->group_id <= 17){
              $this->db->where('del',0);
          }
          $this->db->where('site',2);
          return $this->db->get('shop_product',$num,$offset)->result();
      } 
      
      function get_num_product($catid){
          if($catid != 0){
              $ar_cat = $this->get_arr_cat($catid);
              $this->db->where_in('catid',$ar_cat);
          } 
          if($this->group_id <= 17){
              $this->db->where('del',0);
          }
          $this->db->where('site',2);
          return $this->db->get('shop_product')->num_rows();
      }
      
      function get_arr_cat($catid){
          $ar_cat = array($catid);
          $this->db->where('parentid',$catid);
          $list = $this->db->get('shop_cat')->result();
          foreach($list as $rs):
            array_push($ar_cat, $rs->catid);
          endforeach;
          return $ar_cat;
      }
      

      
      // Lưu san pham
      function get_urlcat_by_id($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('shop_cat')->row()->caturl;
      }
      function save_product(){
          $productid = (int)$this->input->post('productid');
          
          $sp = $this->input->post('sp');
          $sp_en = $this->input->post('sp_en');
          
          // Vietnamese
          $sp['producturl'] = vnit_change_title($sp['productname']);
          $sp['giathitruong_miennam'] = str_replace('.','',$sp['giathitruong_miennam']);
          $sp['sphot'] = $this->input->post('sphot');
          $sp['spmoi'] = $this->input->post('spmoi');
          $sp['spkhuyenmai'] = $this->input->post('spkhuyenmai');
          $sp['site'] = 2; 
          
          // English
          $sp_en['barcode'] = $sp['barcode'];
          $sp_en['catid'] = $sp['catid'];
          $sp_en['manufactureid'] = $sp['manufactureid'];
          $sp_en['productname'] = $sp_en['productname'];
          $sp_en['producturl'] = vnit_change_title($sp['productname']);
          $sp_en['giathitruong_miennam'] = str_replace('.','',$sp['giathitruong_miennam']);
          $sp_en['baohanh'] = vnit_change_title($sp['baohanh']);
          $sp_en['productimg'] = $sp['productimg'];
          $sp_en['spkhuyenmai'] = $this->input->post('spkhuyenmai');
          $sp_en['spmoi'] = $this->input->post('spmoi');
          $sp_en['sphot'] = $this->input->post('sphot');
          $sp_en['site'] = 2;
          if($productid != 0){
                if($this->vdb->update('shop_product',$sp,array('productid'=>$productid))){
                    // Cap nhat thong tin cho san pham tieng Anh
                    $this->vdb->update('shop_product_en',$sp_en,array('productid'=>$productid));
                    // Xoa thuoc tinh truoc khi luu
                    $this->db->where('product_id',$productid);
                    $this->db->delete('shop_features_values');
                    
                    // Them thuoc tinh cua san pham
                    $ar_var = $this->input->post('ar_var');
                    for($i = 0; $i < sizeof($ar_var); $i ++) {
                        if ($ar_var[$i]){
                            $variant = $this->input->post('variant_'.$ar_var[$i]);
                            $variant_new = $this->input->post('new_variant_'.$ar_var[$i]);
                            $variant_type = $this->input->post('variant_type_'.$ar_var[$i]);
                            $vattr['product_id'] = $productid;
                            if($variant == 'select_disable'){
                                if($variant_new != ''){
                                    $vdata_new['variant'] = $variant_new;
                                    $variant_id = $this->vdb->update('shop_feature_variant_descriptions',$vdata_new);
                                    
                                    $feature_variants['variant_id'] = $variant_id;
                                    $feature_variants['feature_id'] = $ar_var[$i];
                                    $this->vdb->update('shop_feature_variants',$feature_variants);
                                }else{
                                    $variant_id =0;
                                }
                            }else{
                                if($variant_type == 'T'){
                                    $value = $variant;
                                    $variant_id = 0;
                                }else{
                                    $variant_id = $variant;
                                    $value = '';
                                }
                                
                            }
                            $vattr['feature_id'] = $ar_var[$i];
                            $vattr['variant_id'] = $variant_id;
                            $vattr['value'] = $value;
                            
                            $this->vdb->update('shop_features_values',$vattr);
                        }
                    } 
                    
                    // Them hinh anh
                    $ar_img = $this->input->post('ar_img');
                    if(sizeof($ar_img) > 0){
                        $this->vdb->delete('shop_img',array('productid'=>$productid));
                        for($i=0; $i < sizeof($ar_img); $i++){
                            if($ar_img[$i]){
                              // Hinh anh san pham san gia re
                              vnit_resize_image(ROOT.'data/shop/product/500/'.$ar_img[$i],ROOT.'data/sangiare/500/'.$ar_img[$i],400,300);
                              vnit_resize_image(ROOT.'data/shop/product/500/'.$ar_img[$i],ROOT.'data/sangiare/200/'.$ar_img[$i],200,200);
                              $vimg['imagepath'] = $ar_img[$i];
                              $vimg['productid'] = $productid;
                              $this->vdb->update('shop_img',$vimg);
                          }
                        }
                    }
                  
                    return true;
                }else{
                    return false;
                }
          }else{
              
              if($productid = $this->vdb->update('shop_product',$sp)){
                // Them thong tin cho san pham tieng Anh
                $sp_en['productid'] = $productid; 
                $this->vdb->update('shop_product_en',$sp_en);
                // Them danh sach hinh anh vao san sham
                $ar_img = $this->input->post('ar_img');
                if(sizeof($ar_img) > 0){
                    $this->vdb->delete('shop_img',array('productid'=>$productid));
                    for($i=0; $i < sizeof($ar_img); $i++){
                        if($ar_img[$i]){

                          // Hinh anh san pham san gia re
                          vnit_resize_image(ROOT.'data/shop/product/500/'.$ar_img[$i],ROOT.'data/sangiare/500/'.$ar_img[$i],400,300);
                          vnit_resize_image(ROOT.'data/shop/product/500/'.$ar_img[$i],ROOT.'data/sangiare/200/'.$ar_img[$i],200,200);
                          $vimg['imagepath'] = $ar_img[$i];
                          $vimg['productid'] = $productid;
                          $this->vdb->update('shop_img',$vimg);
                      }
                    }
                }             
                           
                 return $productid; 
              }else{
                  return false;
              }
          }
      }
      
      
      
      function delete_product($productid){
          // Xoa thuoc tinh
          $this->db->where('productid',$productid);
          $this->db->delete('shop_attr');
          // Xoa hinh anh
          $list = $this->get_img_by_product_id($productid);
          foreach($list as $rs):
            unlink(ROOT.'data/sangiare/200/'.$rs->imagepath);
            unlink(ROOT.'data/sangiare/500/'.$rs->imagepath);
          endforeach;
          $this->db->where('productid',$productid);
          $this->db->delete('shop_img');
          
          $this->db->where('productid',$productid);
          if($this->db->delete('shop_product')){
              return true;
          }else{
              return false;
          }
          
      }
      
      // Xoa tam san pham chơ xử lý
      function delete_product_status($productid){
          $vdata['del'] = 1;
          if($this->vdb->update('shop_product',$vdata,array('productid'=>$productid))){
              $this->db->update('shop_product_en',$vdata,array('productid'=>$productid));
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
          return $this->db->get('shop_product'.$lang)->row();
      }
      
      function get_list_attr_by_product($productid){
          $this->db->select('shop_attr.*, shop_type.*');
          $this->db->join('shop_type','shop_type.type_id = shop_attr.type_id');
          $this->db->where('shop_attr.productid',$productid);
          $this->db->order_by('shop_attr.type_id','ASC');
          return $this->db->get('shop_attr')->result();
      }
      
      function get_list_img_edit($productid){
          $this->db->where('productid',$productid);
          return $this->db->get('shop_img')->result();
      }

      /*******************
      * Lay du lieu thuoc tinh san pham
      */
      
      function get_features_list($catid,$prentid=0){
         $this->db->select('shop_features.*, shop_features_cat.*');
         $this->db->join('shop_features_cat','shop_features_cat.feature_id = shop_features.feature_id');
         $this->db->where('shop_features_cat.catid',$catid);
         $this->db->where('shop_features.parent_id',$prentid);
         $this->db->order_by('shop_features_cat.ordering','asc');
         return $this->db->get('shop_features')->result();
      }
      
      function get_item_features($feature_id){
          $this->db->where('parent_id',$feature_id);
          $this->db->order_by('ordering','asc');
          return $this->db->get('shop_features')->result();
      }
      
      function get_variants_fea($feature_id){
         $this->db->select('shop_features.*, shop_features_cat.*');
         $this->db->join('shop_features_cat','shop_features_cat.feature_id = shop_features.feature_id');
         $this->db->where('shop_features_cat.catid',$catid);
         $this->db->where('shop_features.parent_id',$prentid);
         return $this->db->get('shop_features')->result();
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
      
      /**********
      * Comment
      */
      function get_all_comment($field,$order,$num,$offset){
          if($field != '' || $order != ''){
              $this->db->order_by($field,$order);
          }else{
              $this->db->order_by('commentid','desc');
          }
          return $this->db->get('shop_comment',$num,$offset)->result();
      }
      
      function get_num_comment(){
          return $this->db->get('shop_comment')->num_rows();
      }
       
      function get_comment_by_id($commentid){
          $this->db->select('shop_product.productname,shop_comment.*');
          $this->db->join('shop_product','shop_product.productid = shop_comment.productid');
          $this->db->where('shop_comment.commentid',$commentid);
          return $this->db->get('shop_comment')->row();
      } 
      
      function save_comment(){
          $commentid = (int)$this->uri->segment(3);
          $this->db->where('commentid',$commentid);
          if($this->db->update('shop_comment',$this->input->post('comment'))){
              return true;
          }else{
              return false;
          }
      } 
      
      function delete_comment($commentid)     {
          $this->db->where('commentid',$commentid);
          if($this->db->delete('shop_comment')){
              return true;
          }else{
              return false;
          }
      }
  }
?>
