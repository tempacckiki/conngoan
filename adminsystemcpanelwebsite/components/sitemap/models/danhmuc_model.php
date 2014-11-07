<?php
class danhmuc_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
     /*********************************|
      |                                 |
      |  Model xu ly san pham           |
      |                                 |
      |*********************************/    
      
      function get_all_product($catid){       
         $this->db->select('shop_product.productid, shop_product.producturl');
                  //$this->db->distinct('shop_product.productid');
                  //$this->db->join('shop_price','shop_price.productid = shop_product.productid');
                  //$this->db->where('shop_price.city_id',$city_id);
         $this->db->where('catid',$catid);
         $this->db->where('published',1);
                  
         return $this->db->get('shop_product')->result(); 
             
          
      } 
      
      
    // Get list main cat 
    function get_main_cat($maincat = 0){
        $this->db->where('parentid',$maincat);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }
    
    // Hien thi danh sach chuyen mục tin tuc
    function get_all_cat($num, $offset, $maincat=0, $field, $order){
         
        $this->db->where('parentid',$maincat);
        return $this->db->get('shop_cat',$num,$offset)->result();
    }
    
    function get_num_cat($maincat=0){
        $this->db->where('parentid',$maincat);
        return $this->db->get('shop_cat')->num_rows();
    }    
    
    // Get list sub cat
    function get_sub_cat($CatID){
        $this->db->where('parentid',$CatID);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    } 
    
    // Get Manufacture
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

    
    // Lưu danh mục san pham
    
    function save_cat(){
        $ar_id = $this->input->post('ar_id');
        
        $catname = $this->input->post('catname');
        $caturl = vnit_change_title($catname);
        $parentid = $this->input->post('parentid');
        $ordering = $this->input->post('ordering');
        $ishome = $this->input->post('ishome');
        $istab = $this->input->post('istab');
        $ismenuleft = $this->input->post('ismenuleft');
        $nolink = $this->input->post('nolink');
        $catkeyword = $this->input->post('catkeyword');
        $catdes = $this->input->post('catdes');
        $published = $this->input->post('published');
        
        $catname_en = $this->input->post('catname_en');
        $caturl_en = vnit_change_title($catname_en);
        // DB lang Vi;
        $vidata['catname'] = $catname;
        $vidata['caturl'] = $caturl;
        $vidata['parentid'] = $parentid;
        $vidata['ordering'] = $ordering;
        $vidata['ishome'] = $ishome;
        $vidata['istab'] = $istab;
        $vidata['ismenuleft'] = $ismenuleft;
        $vidata['nolink'] = $nolink;
        $vidata['catkeyword'] = $catkeyword;
        $vidata['catdes'] = $catdes;
        $vidata['published'] = $published;
        
        // DB lang EN;
        $endata['catname'] = $catname_en;
        $endata['caturl'] = $caturl_en;
        $endata['parentid'] = $parentid;
        $endata['ordering'] = $ordering;
        $endata['ishome'] = $ishome;
        $endata['istab'] = $istab;
        $endata['ismenuleft'] = $ismenuleft;
        $endata['nolink'] = $nolink;
        $endata['catkeyword'] = $catkeyword;
        $endata['catdes'] = $catdes;
        $endata['published'] = $published;
        
        // Upload File
        if(isset($_FILES['userfile'])){
            $config['upload_path'] = ROOT.'data/templ/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']    = '1000';
            $config['max_width']  = '1024';
            $config['max_height']  = '768'; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);                     
                   
            if ( !$this->upload->do_upload()){
                $this->pre_message =  $this->upload->display_errors();
            }else{                         
                $result =  $this->upload->data();
                $file_name = $result['file_name'];
                
                $filetype = end(explode('.',$file_name));
                $filename = $caturl;
                $img_new = time().'-'.$filename.'.'.$filetype;
                $this->load->helper('img_helper');
                vnit_resize_image(ROOT.'data/templ/'.$file_name,ROOT.'data/img_cat/'.$img_new,150,150,false);
                $endata['img_main'] = $img_new;                  
                $vidata['img_main'] = $img_new;                  
            }                    
        }
        // Insert Vi
        if($catid = $this->vdb->update('shop_cat',$vidata)){
            // Insert En
            /*$endata['catid'] = $catid;
            $this->vdb->update('shop_cat_en',$endata);*/

            // Them moi them nsx vao chuyen muc
            for($i=0;$i<sizeof($ar_id);$i++){
                  if($ar_id[$i]){
                     $data_nsx = array(
                        'catid' => $catid,
                        'manufactureid' => $ar_id[$i]
                     );  
                     $this->db->insert('shop_cat_manufacture',$data_nsx);
                  }
            }                  
            
            return $catid;
        }else{
            return false;
        }
    }
    
    // Cap nhat danh mục san pham
    
    function save_update_cat(){
        $ar_id = $this->input->post('ar_id');
        $catid = $this->input->post('catid');
        $catname = $this->input->post('catname');
        $caturl = vnit_change_title($catname);
        $parentid = $this->input->post('parentid');
        $ordering = $this->input->post('ordering');
        $ishome = $this->input->post('ishome');
        $istab = $this->input->post('istab');
        $ismenuleft = $this->input->post('ismenuleft');
        $nolink = $this->input->post('nolink');
        $catkeyword = $this->input->post('catkeyword');
        $catdes = $this->input->post('catdes');
        $published = $this->input->post('published');
        
        $catname_en = $this->input->post('catname_en');
        $caturl_en = vnit_change_title($catname_en);
        // DB lang Vi;
        $vidata['catname'] = $catname;
        $vidata['caturl'] = $caturl;
        $vidata['parentid'] = $parentid;
        $vidata['ordering'] = $ordering;
        $vidata['ishome'] = $ishome;
        $vidata['istab'] = $istab;
        $vidata['ismenuleft'] = $ismenuleft;
        $vidata['nolink'] = $nolink;
        $vidata['catkeyword'] = $catkeyword;
        $vidata['catdes'] = $catdes;
        $vidata['published'] = $published;
        
        // DB lang EN;
        $endata['catname'] = $catname_en;
        $endata['caturl'] = $caturl_en;
        $endata['parentid'] = $parentid;
        $endata['ordering'] = $ordering;
        $endata['ishome'] = $ishome;
        $endata['istab'] = $istab;
        $endata['ismenuleft'] = $ismenuleft;
        $endata['nolink'] = $nolink;
        $endata['catkeyword'] = $catkeyword;
        $endata['catdes'] = $catdes;
        $endata['published'] = $published;
        
        // Upload File
        if(isset($_FILES['userfile'])){
            $config['upload_path'] = ROOT.'data/templ/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']    = '1000';
            $config['max_width']  = '1024';
            $config['max_height']  = '768'; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);                     
                   
            if ( !$this->upload->do_upload()){
                $this->pre_message =  $this->upload->display_errors();
            }else{                         
                $result =  $this->upload->data();
                $file_name = $result['file_name'];
                
                $filetype = end(explode('.',$file_name));
                $filename = $caturl;
                $img_new = time().'-'.$filename.'.'.$filetype;
                $this->load->helper('img_helper');
                vnit_resize_image(ROOT.'data/templ/'.$file_name,ROOT.'data/img_cat/'.$img_new,150,150,false);
                $endata['img_main'] = $img_new;                  
                $vidata['img_main'] = $img_new;                  
            }                    
        }
        // Insert Vi
        if($this->vdb->update('shop_cat',$vidata,array('catid'=>$catid))){
            // Insert En
            //$this->vdb->update('shop_cat_en',$endata,array('catid'=>$catid));
            //Cap nhat caturl trong san pham
            //VI;
            $up_vi['caturl'] = $caturl;
            $this->db->update('shop_product',$up_vi,array('catid'=>$catid));
            // EN;
            //$up_en['caturl'] = $caturl_en;
            //$this->db->update('shop_product_en',$up_en,array('catid'=>$catid));

            
            // Xoa nsx vao chuyen muc
            $this->db->where('catid',$catid);
            $this->db->delete('shop_cat_manufacture');
            // Them moi them nsx vao chuyen muc 
            for($i=0;$i<sizeof($ar_id);$i++){
                  if($ar_id[$i]){
                     $data_nsx = array(
                        'catid' => $catid,
                        'manufactureid' => $ar_id[$i]
                     );  
                     $this->db->insert('shop_cat_manufacture',$data_nsx);
                  }
            }                  
            
            return $catid;
        }else{
            return false;
        }
    }
    
    /******  
    // Save Cat
    function save_cat(){
      $CatID = (int)$this->input->post('catid');
      $ar_cat = $this->input->post('cat');
      $img_main = (string)$this->input->post('img_main');
      if($img_main!=''){
          $filename = end(explode('/',$img_main));
          vnit_resize_image(ROOT.$img_main,ROOT.'data/shop/cat/118_98/'.$filename,118,98);
          vnit_resize_image(ROOT.$img_main,ROOT.'data/shop/cat/32_32/'.$filename,32,32);
          $ar_cat['img_main'] = $img_main;
          $ar_cat['img_thumb'] = $filename;              
      }else{
          $ar_cat['img_main'] = '';
          $ar_cat['img_thumb'] = '';
      }
      $catname = $this->input->post('catname');
      
      $ar_cat['catname'] = $catname;
      $ar_cat['catname_en'] = $this->input->post('catname_en');
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
    
    /*******/     
    // Xoa chuyen muc
    function delete_cat($catid){
        $this->db->where('catid',$catid);
        if($this->db->delete('shop_cat')){
          $this->vdb->delete('shop_cat_en',array('catid'=>$catid));
          return true;
        }else{
          return false;
        }
    } 
    
    function check_subcat($catid){
        $this->db->where('parentid',$catid);
        $total = $this->db->get('shop_cat')->num_rows();
        if($total > 0){
            return false;
        }else{
            return true;
        }
    }
    
    function check_product_incat($catid){
        $this->db->where('catid',$catid);
        $total = $this->db->get('shop_product')->num_rows();
        if($total > 0){
            return false;
        }else{
            return true;
        }
    }
    
    function get_list_nsx($catid){
        $this->db->select('shop_cat_manufacture.*, shop_manufacture.*');
        $this->db->join('shop_cat_manufacture','shop_manufacture.manufactureid = shop_cat_manufacture.manufactureid');
        $this->db->where('shop_cat_manufacture.catid',$catid);
        $this->db->order_by('shop_cat_manufacture.ordering','asc');
        return $this->db->get('shop_manufacture')->result();
    }
    
      

}
