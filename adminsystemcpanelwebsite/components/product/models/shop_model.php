<?php
/**************************
* Model Shop Gian hang
* Author: DEV MyTran
* Email: devmytran@gmail.com
* Date: 17/06/2011
***************************/
  class shop_model extends CI_Model{
      function __construct(){
          parent::__construct();    
      }
      // Lay danh sach nha san xuat theo chuyen muc
      function get_manufacture_by_cat($catid){
          $ar_id = $this->get_ar_manufacture($catid);
          $this->db->select('shop_manufacture.*, shop_cat_manufacture.*');
          $this->db->join('shop_manufacture','shop_manufacture.manufactureid = shop_cat_manufacture.manufactureid');
          $this->db->where_in('shop_cat_manufacture.catid',$ar_id);
          $this->db->group_by('shop_cat_manufacture.manufactureid');
          $this->db->order_by('shop_manufacture.name','asc');
          return $this->db->get('shop_cat_manufacture')->result();
      }
      
      function get_ar_manufacture($catid){
          $val = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid));
          $ar_id = array($catid);
          if($val->parentid != 0){
              $val1 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val->parentid));
              if($val1->parentid != 0){
                  array_push($ar_id,$val1->catid);
                  $val2 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val1->parentid));
                  if($val2->parentid != 0){
                      array_push($ar_id,$val2->catid);
                      $val3 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val2->parentid));
                      if($val3->parentid != 0){
                          array_push($ar_id,$val3->catid);
                      }
                  }
              }
          }
          return $ar_id;
      }
      
      function get_all_manufacture(){
          $this->db->order_by('name','asc');
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
      
      /***********************************|
      |                                   |
      |  Model xu ly thuoc tinh san pham  |
      |                                   |
      |***********************************/      
      
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
      
      /*********************************|
      |                                 |
      |  Model xu ly danh muc san pham  |
      |                                 |
      |*********************************/
      
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
          $this->db->order_by('ordering','asc');
          return $this->db->get('shop_cat')->result();
      }
      
      // Get list sub cat
      function get_sub_cat($CatID){
          
          $this->db->where('parentid',$CatID);
          $this->db->order_by('ordering','asc');
          return $this->db->get('shop_cat')->result();  
      }
      
      function check_per_dm($catid){
          if($this->group_id == 18){
              return true;
          }else{
              $this->db->where('catid',$catid);
              $this->db->where('user_id',$this->user_id);
              return $this->db->get('phanquyen_danhmuc')->row();
          }
         
      }
       
      // GET cat
      function get_cat_by_id($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('shop_cat')->row();
      }
      // Save Cat
      
      function save_cat(){
          $CatID = (int)$this->input->post('catid');
          $ar_cat = $this->input->post('cat');
          $img_main = (string)$this->input->post('img_main');
          if($img_main!=''){
              $filename = end(explode('/',$img_main));
              vnit_resize_image(ROOT.$img_main,ROOT.'alobuy0862779988/shop/cat/118_98/'.$filename,118,98);
              vnit_resize_image(ROOT.$img_main,ROOT.'alobuy0862779988/shop/cat/32_32/'.$filename,32,32);
              $ar_cat['img_main'] = $img_main;
              $ar_cat['img_thumb'] = $filename;              
          }else{
              $ar_cat['img_main'] = '';
              $ar_cat['img_thumb'] = '';
          }
          $catname = $this->input->post('catname');
          
          $ar_cat['catname'] = $catname;
          $ar_cat['caturl'] = vnit_change_title($catname);
          if($CatID != 0){
              $this->db->where('catid',$CatID);
              if($this->db->update('shop_cat',$ar_cat)){
                  // Cat nhat url danh muc trong san pham
                  $data_update_url = array(
                    'caturl'=> vnit_change_title($catname)
                  );
                  $this->db->where('catid',$CatID);
                  $this->db->update('shop_cat',$data_update_url);
                  // Them moi them nsx vao chuyen muc
                  $this->db->where('catid',$CatID);
                  $this->db->delete('shop_cat_manufacture');
                  
                  $arr_id = $this->input->post('ar_id');
                  for($i=0;$i<sizeof($arr_id);$i++){
                      if($arr_id[$i]){
                         $data_nsx = array(
                            'catid' => $CatID,
                            'manufactureid' => $arr_id[$i]
                         );  
                         $this->db->insert('shop_cat_manufacture',$data_nsx);
                      }
                  }                  
                  return true;
              }else{
                  return false;
              }
          }else{
              if($this->db->insert('shop_cat',$ar_cat)){
                  $CatID = $this->db->insert_id();
                  $arr_id = $this->input->post('ar_id');
                  for($i=0;$i<sizeof($arr_id);$i++){
                      if($arr_id[$i]){
                         $data_nsx = array(
                            'catid' => $CatID,
                            'manufactureid' => $arr_id[$i]
                         );  
                         $this->db->insert('shop_cat_manufacture',$data_nsx);
                      }
                  }                   
                  return $CatID;
              }else{
                  return false;
              }
          }
      }      
      // Xoa chuyen muc
      function delete_cat($catid){
          $this->db->where('catid',$catid);
          if($this->db->delete('shop_cat')){
              return true;
          }else{
              return false;
          }
      }   
      
      /*********************************|
      |                                 |
      |  Model xu ly san pham           |
      |                                 |
      |*********************************/    
      
      function get_all_product($num,$offset,$catid,$city_id, $barcode, $productkey,$field,$order){
          if($city_id == 0){
              return array();
          }else{
              //if($this->group_id ==18){
                  if($catid != 0){  
                     $ar_cat = $this->get_arr_cat($catid);  
                     //var_dump($ar_cat);
                  }
                  $this->db->select('shop_product.*, shop_price.*');
                  $this->db->distinct('shop_product.productid');
                  $this->db->join('shop_price','shop_price.productid = shop_product.productid');
                  $this->db->where('shop_price.city_id',$city_id);
                  if($catid != 0){
                      $this->db->where_in('catid',$ar_cat);
                  }  
                  if($barcode != ''){
                      
                      $this->db->where('shop_product.productid',$barcode);
                      $this->db->or_where('shop_product.barcode',$barcode); 
                  }
                  if($productkey != ''){
                      $this->db->like('shop_product.productname',$productkey);
                  }
                  if($field!='' && $order !=''){
                      $this->db->order_by($field,$order);
                  }else{
                     $this->db->order_by('shop_product.productid','DESC');    
                  }
                  return $this->db->get('shop_product',$num,$offset)->result(); 
              //}else{
                  //return array();
              //}  
          }
      } 
      
      function get_num_product($catid,$city_id, $barcode, $productkey){
          if($city_id == 0){
              return 0;
          }else{ 
              //if($this->group_id ==18){     
                  if($catid != 0){  
                     $ar_cat = $this->get_arr_cat($catid);  
                  }
                  $this->db->select('shop_product.*, shop_price.*');
                  $this->db->join('shop_price','shop_price.productid = shop_product.productid');
                  $this->db->where('shop_price.city_id',$city_id);
                  if($catid != 0){
                      $this->db->where_in('catid',$ar_cat);
                  }
                  if($barcode != ''){
                        $this->db->where('shop_product.productid',$barcode);
                      $this->db->or_where('shop_product.barcode',$barcode); 
                  }
                  if($productkey != ''){
                      $this->db->like('shop_product.productname',$productkey);
                  }
                  return $this->db->get('shop_product')->num_rows();
              //}else{
                  //return 0;
              //} 
          }

      }
      
      function get_arr_cat($catid){
          if($this->group_id == 18){
              // Cap 1
              $ar_cat = array($catid);
              $this->db->where('parentid',$catid);
              $list = $this->db->get('shop_cat')->result();
              foreach($list as $rs): 
                    $list1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->catid));
                    array_push($ar_cat, $rs->catid);
                    if(count($list1) > 0){
                        foreach($list1 as $rs1):
                            $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs1->catid));
                            array_push($ar_cat, $rs1->catid);
                            if(count($list2) > 0){  
                                foreach($list2 as $rs2):
                                   array_push($ar_cat, $rs2->catid);
                                endforeach;
                            }
                        endforeach;
                    }
              endforeach; 
              return $ar_cat;
          }else{
              $ar_cat = array($catid);
              $list = $this->vdb->find_by_list('phanquyen_danhmuc',array('parentid'=>$catid,'user_id'=>$this->user_id));  
              if(count($list) > 0){ 
                  foreach($list as $rs1):
                  array_push($ar_cat,$rs1->catid);
                  if($rs1->cap != 'cap3'){
                     $list2 = $this->vdb->find_by_list('phanquyen_danhmuc',array('parentid'=>$rs1->catid,'user_id'=>$this->user_id)); 
                     foreach($list2 as $rs2):
                     array_push($ar_cat,$rs2->catid); 
                     if($rs2->cap != 'cap3'){
                        $list3 = $this->vdb->find_by_list('phanquyen_danhmuc',array('parentid'=>$rs2->catid,'user_id'=>$this->user_id)); 
                        foreach($list3 as $rs3):
                            array_push($ar_cat,$rs3->catid);
                            if($rs3->cap == 'cap3'){
                                $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs3->catid)); 
                                foreach($list2 as $val1):
                                    $list3 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$val1->catid));
                                    array_push($ar_cat, $val1->catid);
                                        foreach($list3 as $val2):
                                           array_push($ar_cat, $val2->catid);
                                        endforeach;
                                   
                                endforeach; 
                            }
                        endforeach;
                     }else{
                            $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs2->catid)); 
                            foreach($list2 as $val1):
                                $list3 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$val1->catid));
                                array_push($ar_cat, $val1->catid);
                                    foreach($list3 as $val2):
                                       array_push($ar_cat, $val2->catid);
                                    endforeach;
                               
                            endforeach;  
                     }
                     endforeach;
                  }else{
                        $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs1->catid)); 
                        foreach($list2 as $rs2):
                            $list3 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs2->catid));
                            array_push($ar_cat, $rs2->catid);
                                foreach($list3 as $rs3):
                                   array_push($ar_cat, $rs3->catid);
                                endforeach;
                           
                        endforeach;
                  }
                  endforeach;
              }else{
                    $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$catid)); 
                    foreach($list2 as $rs2):
                        $list3 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs2->catid));
                        array_push($ar_cat, $rs2->catid);
                            foreach($list3 as $rs3):
                               array_push($ar_cat, $rs3->catid);
                            endforeach;
                       
                    endforeach;
              }
              return $ar_cat;
          }
      }
      

      
      // Lưu san pham
      function get_urlcat_by_id($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('shop_cat')->row()->caturl;
      }
      function save_product_add(){
          $barcode              = $this->input->post('barcode');
          $productname          = $this->input->post('productname');
          $producturl           = vnit_change_title($productname);
          $catid                = $this->input->post('catid');
          $manufactureid        = $this->input->post('manufactureid');
          $sphot                = $this->input->post('sphot');
          $spmoi                = $this->input->post('spmoi');
          $spkhuyenmai          = $this->input->post('spkhuyenmai');
          $baohanh              = $this->input->post('baohanh');
          $deal              	= $this->input->post('deal');
          $phukien              = $this->input->post('phukien');
          $soluong              = $this->input->post('soluong');
          $mieuta               = $this->input->post('mieuta');
          $tinhnang             = $this->input->post('tinhnang');
          $baiviet              = $this->input->post('baiviet');
          $video                = $this->input->post('video');
          $thongsokythuat       = $this->input->post('thongsokythuat'); 
          $show_attr            = $this->input->post('show_attr'); 
          $tragop               = $this->input->post('tragop'); 
          
        
          

          // Khoi tao du lieu VI;
          $vidata['barcode']                    = $barcode;
          $vidata['productname']                = $productname;
          $vidata['producturl']                 = $producturl;
          $vidata['catid']                      = $catid;
          $vidata['manufactureid']              = $manufactureid;
          $vidata['sphot']                      = $sphot;
          $vidata['spmoi']                      = $spmoi;
          $vidata['spkhuyenmai']                = $spkhuyenmai;
          $vidata['baohanh']                    = $baohanh;
          $vidata['deal']                    = $deal;
 
          $vidata['phukien']                    = $phukien;
          $vidata['soluong']                    = $soluong;
          $vidata['tinhnang']                   = $tinhnang;
          $vidata['mieuta']                     = $mieuta;
          $vidata['baiviet']                    = $baiviet;
          $vidata['video']                      = $video;
          $vidata['thongsokythuat']             = $thongsokythuat;
          $vidata['show_attr']                  = $show_attr;
          $vidata['tragop']                     = $tragop;  
          
         
          if($productid = $this->vdb->update('shop_product',$vidata)){
              
                
                // Cap nhat gia cho TP.HCM
                
                $giaban = str_replace('.','',$this->input->post('giaban'));
                $giamgia = str_replace('.','',$this->input->post('giamgia'));
                $giathitruong = str_replace('.','',$this->input->post('giathitruong'));
                $phantram = $this->input->post('per_miennam');
                $tinhtrang = $this->input->post('tinhtrang_miennam');
                $tinhtrang_text = $this->input->post('tinhtrang_miennam_text');
                $vat = $this->input->post('vat');
                $city_id = (int)$this->input->post('city_id');
                
                $vprice['productid'] = $productid;
                $vprice['giathitruong'] = $giathitruong;
                $vprice['giamgia'] = $giamgia;
                $vprice['giaban'] = $giaban;
                $vprice['phantram'] = $phantram;
                $vprice['tinhtrang'] = $tinhtrang;
                $vprice['tinhtrang_text'] = $tinhtrang_text;
                $vprice['city_id'] = $city_id;
                $vprice['vat'] = $vat;
                $vprice['thutu'] = 9999; 
                $vprice['lastupdate'] = time();
                $this->vdb->update('shop_price',$vprice);
                

                $tangpham_miennam_name = $this->input->post('tangpham_miennam_name');
                for($i = 0; $i < sizeof($tangpham_miennam_name); $i++){
                    if($tangpham_miennam_name[$i]){
                        $vtangpham['productid'] = $productid;
                        $vtangpham['name'] = $tangpham_miennam_name[$i];
                        $vtangpham['city_id'] = $city_id;
                        $this->vdb->update('shop_gifts',$vtangpham);
                    }
                }
               
                // Xử lý hình ảnh sản phẩm
                $folder_tmpl = ROOT.'alobuy0862779988/templ/';
                $ar_img = $this->input->post('ar_img');
                $k = 1;
                for($i = 0; $i < sizeof($ar_img); $i++){
                    if($ar_img[$i]){
                        $ext = '.'.end(explode('.',$ar_img[$i]));
                        $img_name = str_replace($ext,'',$ar_img[$i]);
                       $img_name_new = $producturl.'-'.$k.$ext;
                       
                        vnitResizeImage($folder_tmpl.$ar_img[$i], ROOT.'alobuy0862779988/0862779988product/500/'.$img_name_new, 500, 500); 
                        vnitResizeImage($folder_tmpl.$ar_img[$i], ROOT.'alobuy0862779988/0862779988product/300/'.$img_name_new,300,300);
                        vnitResizeImage($folder_tmpl.$ar_img[$i], ROOT.'alobuy0862779988/0862779988product/190/'.$img_name_new,190,190);
                        vnitResizeImage($folder_tmpl.$ar_img[$i], ROOT.'alobuy0862779988/0862779988product/80/'.$img_name_new,80,80);
                        vnitResizeImage($folder_tmpl.$ar_img[$i], ROOT.'alobuy0862779988/0862779988product/40/'.$img_name_new,40,40);
                        
                        
                        $vimg['productid'] = $productid;
                        $vimg['imagepath'] = $img_name_new;
                        $vimg['ordering'] = $k;
                        $this->vdb->update('shop_img',$vimg);
                        if($ar_img[$i] == $this->input->post('productimg')){
                            $vup_product['productimg'] = $img_name_new;
                            $this->vdb->update('shop_product',$vup_product,array('productid'=>$productid));
                        }
                        
                        unlink($folder_tmpl.$ar_img[$i]);
                        $k++;
                    }
                }
              
                
                // Xu ly anh Ratore 360
                $random_img_ratore = $this->input->post('random_img_ratore');
                $list_rato = $this->vdb->find_by_list('shop_img_rotare_temp',array('random'=>$random_img_ratore),array('ordering'=>'asc'));
                // Tao thu muc
                $dir_rotare = ROOT.'data/img_rotare'; 
                if(!is_dir($dir_rotare.'/'.$productid)){
                    mkdir($dir_rotare.'/'.$productid);
                    chmod($dir_rotare.'/'.$productid,0777);
                }
                $dir = ROOT.'alobuy0862779988/img_rotare/'.$productid.'/';
                $new_dir ='alobuy0862779988/img_rotare/'.$productid.'/';
                
                $k = 1;
                foreach($list_rato as $val):
                    $ext = '.'.end(explode('.',$val->imagepath)); 
                    $img_name_new = $producturl.'-'.$k.$ext;
                    $file = ROOT.$val->imagepath;
                    $newfile = $dir.$img_name_new; 
                    if (copy($file, $newfile)) {
                       $vrato['productid'] = $productid;
                       $vrato['imagepath'] = $new_dir.$img_name_new;
                       $vrato['ordering'] = $k;
                       $this->vdb->update('shop_img_rotare',$vrato);
                    }
                    $k ++;
                endforeach;

                // Thuoc tinh san pham
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
                
                
               return $productid; 
          }else{
              return false;
          }
      }
      
      function save_product_edit(){
          $productid            = $this->input->post('productid');
          $barcode              = $this->input->post('barcode');
          $productname          = $this->input->post('productname');
          $productimg           = $this->input->post('productimg');
          $producturl           = vnit_change_title($productname);
          $catid                = $this->input->post('catid');
          $manufactureid        = $this->input->post('manufactureid');
          $sphot                = $this->input->post('sphot');
          $spmoi                = $this->input->post('spmoi');
          $spkhuyenmai          = $this->input->post('spkhuyenmai');
          $baohanh              = $this->input->post('baohanh');
          $deal             	= $this->input->post('deal');
          $phukien              = $this->input->post('phukien');
          $soluong              = $this->input->post('soluong');
          $mieuta               = $this->input->post('mieuta');
          $tinhnang             = $this->input->post('tinhnang');
          $baiviet              = $this->input->post('baiviet');
          $video                = $this->input->post('video');
          $thongsokythuat       = $this->input->post('thongsokythuat');
          $show_attr            = $this->input->post('show_attr');
          $tragop            	= $this->input->post('tragop');
          
          
      

          // Khoi tao du lieu VI;
          $vidata['barcode']                    = $barcode;
          $vidata['productname']                = $productname;
          $vidata['productimg']                 = $productimg; 
          $vidata['producturl']                 = $producturl;
          $vidata['catid']                      = $catid;
          $vidata['manufactureid']              = $manufactureid;
          $vidata['sphot']                      = $sphot;
          $vidata['spmoi']                      = $spmoi;
          $vidata['spkhuyenmai']                = $spkhuyenmai;
          $vidata['baohanh']                    = $baohanh;
          $vidata['deal']                   	 = $deal;

          $vidata['phukien']                    = $phukien;
          $vidata['soluong']                    = $soluong;
          $vidata['tinhnang']                   = $tinhnang;
          $vidata['mieuta']                     = $mieuta;
          $vidata['baiviet']                    = $baiviet;
          $vidata['video']                      = $video;
          $vidata['thongsokythuat']             = $thongsokythuat;
          $vidata['show_attr']                  = $show_attr;
          $vidata['tragop']                     = $tragop;

          
          
          if($this->vdb->update('shop_product',$vidata,array('productid'=>$productid))){
                
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
                // Insert color in product;
                $ar_color            = $this->input->post('ar_color');
                $this->vdb->delete('shop_color_product',array('productid'=>$productid));
                for($i = 0; $i < sizeof($ar_color); $i++){
                    if($ar_color[$i]){
                       $vcolor['icolor']  = $ar_color[$i];
                       $vcolor['catid'] = $catid;
                       $vcolor['productid'] = $productid;
                       $this->vdb->update('shop_color_product',$vcolor);
                    }
                }
                
                      
               return $productid; 
          }else{
              return false;
          }
      }
      
      
      function delete_product($productid){
          // Xoa thuoc tinh
          $this->db->where('productid',$productid);
          $this->db->delete('shop_attr');
          // Xoa hinh anh
          $list = $this->get_img_by_product_id($productid);
          foreach($list as $rs):
            unlink(ROOT.'alobuy0862779988/0862779988product/40/'.$rs->imagepath);
            unlink(ROOT.'alobuy0862779988/0862779988product/80/'.$rs->imagepath);
            unlink(ROOT.'alobuy0862779988/0862779988product/190/'.$rs->imagepath);
            unlink(ROOT.'alobuy0862779988/0862779988product/300/'.$rs->imagepath);
            unlink(ROOT.'alobuy0862779988/0862779988product/500/'.$rs->imagepath);
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
      
      function get_max_order_img($productid){
          $this->db->select_max('ordering');
          $this->db->where('productid',$productid);
          $row = $this->db->get('shop_img')->row();
          return $row->ordering;
      }
      
      function get_max_order_img_rotare($productid){
          $this->db->select_max('ordering');
          $this->db->where('productid',$productid);
          $row = $this->db->get('shop_img_rotare')->row();
          return $row->ordering;
      }
      
      function get_max_order_img_rotare_tmpl($random){
          $this->db->select_max('ordering');
          $this->db->where('random',$random);
          $row = $this->db->get('shop_img_rotare_temp')->row();
          return $row->ordering;
      }
      
      // Danh sach hinh anh cua san pham
      function get_img_by_product_id($ProductID){
          $this->db->where('productid',$ProductID);
          return $this->db->get('shop_img')->result();
      } 
      
      function get_list_color(){
          $this->db->order_by('icolor','asc');
          return $this->db->get('shop_color')->result();
      }
      
      /*******
      * Du lieu cap nhat
      */
      
      // Lay du lieu tu 1 record
      function get_product_by_id($productid){
          $this->db->where('productid',$productid);
          return $this->db->get('shop_product')->row();
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

