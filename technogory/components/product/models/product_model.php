<?php
  class product_model extends CI_Model{
      function __construct(){
          parent::__construct();
      }
      // Hien thi danh sach san pham
      function get_all_product($ar_id,$num,$offset,$hot=0,$order='price_desc'){
          if($hot!=0){
            $this->db->where('product_option',$hot);
          }
          // Sap xep
          if($order == 'price_desc'){
              $this->db->order_by('price','DESC');
          }else if($order == 'price_asc'){
              $this->db->order_by('price','ASC');
          }else if($order == 'name_asc'){
              $this->db->order_by('productname','ASC');
          }else if($order == 'name_desc'){
              $this->db->order_by('productname','DESC');
          }else{
              $this->db->order_by('productid','DESC');
          }
          $this->db->where_in('catid',$ar_id);
          $this->db->where('published',1);
          return $this->db->get('shop_product',$num,$offset)->result();
      }
      
      function get_num_product($ar_id,$hot=0){
          if($hot!=0){
            $this->db->where('product_option',$hot);
          }
          $this->db->where('published',1);
          $this->db->where_in('catid',$ar_id);
          return $this->db->get('shop_product')->num_rows();
      }
      
      function get_info_cat($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('shop_cat')->row();
      }
      // Tim link theo chuyen muc
      function find_top_link($catid,$parentid){
          $cat = $this->get_cat_by_id($catid);
          if($parentid == 0){
              return '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$cat->caturl.'-'.$cat->catid).'" itemprop="url"><span itemprop="title">'.$cat->catname.'</span></a></div>';
          }else{
              $this->db->where('catid',$parentid);
              $val = $this->db->get('shop_cat')->row();
              if($val->parentid == 0){
                  $list1 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$val->caturl.'-'.$val->catid).'" itemprop="url"><span itemprop="title">'.$val->catname.'</span></a></div>';
                  $list2 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$cat->caturl.'-'.$cat->catid).'" itemprop="url"><span itemprop="title">'.$cat->catname.'</span></a></div>';
                  return $list = $list1.$list2;
              }else{
                  $val1 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val->parentid));
                  if($val1->parentid == 0){
                      $list1 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$val1->caturl.'-'.$val1->catid).'" itemprop="url"><span itemprop="title">'.$val1->catname.'</span></a></div>';
                      $list2 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$val->caturl.'-'.$val->catid).'" itemprop="url"><span itemprop="title">'.$val->catname.'</span></a></div>';
                      $list3 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$cat->caturl.'-'.$cat->catid).'" itemprop="url"><span itemprop="title">'.$cat->catname.'</span></a></div>';
                      return $list1.$list2.$list3;
                  }else{
                     $val2 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val1->parentid)); 
                      $list1 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$val1->caturl.'-'.$val2->catid).'" itemprop="url"><span itemprop="title">'.$val2->catname.'</span></a></div>';
                      $list2 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$val1->caturl.'-'.$val1->catid).'" itemprop="url"><span itemprop="title">'.$val1->catname.'</span></a></div>';
                      $list3 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$val->caturl.'-'.$val->catid).'" itemprop="url"><span itemprop="title">'.$val->catname.'</span></a></div>';
                      $list4 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$cat->caturl.'-'.$cat->catid).'" itemprop="url"><span itemprop="title">'.$cat->catname.'</span></a></div>';
                      return $list1.$list2.$list3.$list4;
                  }
              }
          }
      }
      

      
      // TIm chuyen mục chinh
      function find_main_cat($catid,$parentid){
          if($parentid==0){
              return $catid;
          }else{
              $this->db->where('catid',$parentid);
              $val =  $this->db->get('shop_cat')->row();
              if($val->parentid == 0){
                  return $val->catid;
              }else{
                  $val1 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val->parentid));
                  if($val1->parentid == 0){
                      return $val1->catid;
                  }else{
                      return $val1->parentid;
                  }
              }
          }
          
      }
      
      function get_cat_by_id($catid){
          $this->db->where('catid',$catid);
          return $this->db->get('shop_cat')->row();
      }
      
    /*********************
    * Begin Chi tiet san pham
    */
      
      // Chi tiet san pham
      function get_product_by_id($productid){
          $this->db->select('shop_product.*, shop_price.*');
          $this->db->join('shop_price','shop_price.productid = shop_product.productid');
          $this->db->where('shop_product.productid',$productid);
         $this->db->where('shop_price.city_id',$this->city_id);
          return $this->db->get('shop_product')->row();
      }
      
      //**********************************************
      // Dua ra danh sach cac chuyen muc con theo mang
      function get_arr_cat($catid){
          $ar_id = array($catid);
          $this->db->where('parentid',$catid);
          $this->db->where('published',1);
          $list = $this->db->get('shop_cat')->result();
          if(count($list) > 0){
              foreach($list as $rs):
                $infocat = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->parentid,'published'=>1));
                array_push($ar_id,$rs->catid);
                if(count($infocat) > 0)
                {
                    foreach($infocat as $rs1):
                        array_push($ar_id,$rs1->catid);
                    endforeach;
                }
              endforeach;
          }
          return $ar_id;
      }
      
      
      function get_gifts($productid){

          $this->db->where('productid',$productid);
          $this->db->where('city_id',$this->city_id);
          return $this->db->get('shop_gifts')->result();
      }
      
      // Danh sach thuoc tinh theo tung nhom san pham
      
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

      // San pham cung hang san xuat
      function get_sanpham_cunghang($catid,$manufactureid,$productid){
          $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.tinhnang, shop_product.producturl,shop_product.phukien, shop_product.manufactureid, shop_price.*');
          $this->db->join('shop_price','shop_price.productid = shop_product.productid');
          $this->db->where('shop_price.city_id',$this->city_id);
          $this->db->where('shop_product.catid',$catid);
          $this->db->where('shop_price.giaban >',0);
          $this->db->where('published',1);
          $this->db->where('manufactureid',$manufactureid);
          $this->db->where('shop_product.productid !=',$productid);
          $this->db->limit(3);
          return $this->db->get('shop_product')->result();
      }
      
      // San pham cung hang san xuat
      function getAllManuFacture($catid,$manufactureid,$productid){
      	$this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.tinhnang, shop_product.producturl,shop_product.phukien, shop_product.manufactureid, shop_price.*');
      	$this->db->join('shop_price','shop_price.productid = shop_product.productid');
      	$this->db->where('shop_price.city_id',$this->city_id);
      	$this->db->where('shop_product.catid',$catid);
      	$this->db->where('shop_price.giaban >',0);
      	$this->db->where('published',1);
      	$this->db->where('manufactureid',$manufactureid);
      	$this->db->where('shop_product.productid !=',$productid);
      	$this->db->limit(3);
      	return $this->db->get('shop_product')->result();
      }
      
      
      //*------------------------------------+
      function getManufactur($catID){
      	//$this->db->select(' shop_cat_manufacture.*,shop_product.productid, shop_product.manufactureid');
      //	$this->db->join('shop_product','shop_product.manufactureid = shop_cat_manufacture.manufactureid');
      	$this->db->where("catid", $catID);
      	$this->db->order_by('manufactureid',"random");
      	$this->db->limit(3);
      	return $this->db->get('shop_cat_manufacture')->result();
      }
      
      // San pham gia tuong duong
      function get_sanpham_tuongduong($catid, $price, $productid){
          $price_min = $price - 500000;
          $price_max = $price + 500000;
          $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.tinhnang, shop_product.producturl,shop_product.phukien, shop_product.manufactureid, shop_price.*');
          $this->db->join('shop_price','shop_price.productid = shop_product.productid');
          $this->db->where('shop_price.city_id',$this->city_id);
          $this->db->where('catid',$catid);
          $this->db->where('published',1);
          $this->db->where('shop_product.productid !=',$productid);
          $this->db->where('shop_price.giaban >=',$price_min);
          $this->db->where('shop_price.giaban <=',$price_max);
          $this->db->where('shop_price.giaban >',0);
          $this->db->limit(3);
          return $this->db->get('shop_product')->result();
      }
      
      // San pham mua nhieu
      function get_sanpham_muanhieu($catid,$productid){
          $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.tinhnang, shop_product.producturl, shop_product.manufactureid, shop_price.*');
          $this->db->join('shop_price','shop_price.productid = shop_product.productid');
          $this->db->where('shop_price.city_id',$this->city_id);
          $this->db->where('shop_product.catid',$catid);
          $this->db->where('shop_product.productid !=',$productid);
          $this->db->where('shop_price.giaban >',0);
          $this->db->where('published',1);
          $this->db->order_by('buyer','desc');
          $this->db->limit(5);
          return $this->db->get('shop_product')->result();
      }
      
      /*****************
      * Load Comment in Product
      */
      
      function get_list_comment($productid){
          $this->db->where('published',1);
          $this->db->where('productid',$productid);
          $this->db->order_by('add_date','desc');
          $this->db->limit(5);
          return $this->db->get('shop_comment')->result();
      }
      
      function gettangpham($productid){
        $this->db->where('productid',$productid);
        return $this->db->get('shop_gifts')->row();
      }
    /*******************
    * End Chi tiet san pham
    */
      
    /*****************
    * Rating
    */
    function loadRating($id){
        $this->db->where('productid',$id);
        $query = $this->db->get('shop_rating');
        $item = $query->row();
        $rating = (@round($item->value / $item->counter,1)) * 20;
        return $rating;
    }  
    
    function check_session_rating($id){
        $session_id = $this->session->userdata('session_id');
        $this->db->where('rating_session_id',$session_id);
        $this->db->where('productid',$id);
        $query = $this->db->get('shop_rating_history');
        if($query->num_rows() > 0){
          return 1;
        }else{
          return 0;
        }
    } 
    /// End Rating
    
  // Begin Diem bao hanh
    function get_all_city_by_product($manufacture_id){
        $this->db->select('shop_manufacture_security.city_id, city.*');
        $this->db->join('shop_manufacture_security','shop_manufacture_security.city_id = city.city_id');
        $this->db->where('shop_manufacture_security.manufactureid',$manufacture_id);
        $this->db->group_by('shop_manufacture_security.city_id');
        $this->db->order_by('city.ordering','asc');
        return $this->db->get('city')->result();
    }
    
    function get_quanhuyen($city_id, $manufacture_id){
        $this->db->select('shop_manufacture_security.city_id,shop_manufacture_security.parent_id, city.*');
        $this->db->join('shop_manufacture_security','shop_manufacture_security.parent_id = city.city_id');
        $this->db->where('shop_manufacture_security.city_id',$city_id);
        $this->db->where('shop_manufacture_security.manufactureid',$manufacture_id);
        $this->db->group_by('shop_manufacture_security.parent_id');
        $this->db->order_by('city.ordering','asc');
        return $this->db->get('city')->result();
    }
    
    function get_ds_diembaohanh($city_id, $parent_id, $manufactureid){
        $this->db->where('city_id',$city_id);
        $this->db->where('parent_id',$parent_id);
        $this->db->where('manufactureid',$manufactureid);
        return $this->db->get('shop_manufacture_security')->result();
    }
    
    
    
    // Begin list City
    public function get_allCity(){
    	$this->db->where("parentid",0);    	    
    	$this->db->order_by('city.ordering','asc');
    	return $this->db->get('city')->result();
    }
    
 
    
    
   
    
    /// End Diem bao hanh
    
   // Search key
   function get_all_product_by_key($num, $offset, $productkey){
       $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.producturl, shop_product.manufactureid, shop_price.*');
       $this->db->join('shop_price','shop_price.productid = shop_product.productid');
       $this->db->where('shop_price.city_id',$this->city_id);
       $this->db->where('published',1);
       $this->db->where('shop_price.giaban !=',0);
       $this->db->like('productname',$productkey);  
       $this->db->order_by('productname');
       return $this->db->get('shop_product',$num,$offset)->result();
   }
   
   function get_num_product_by_key($productkey){
       $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.producturl, shop_product.manufactureid, shop_price.*');
       $this->db->join('shop_price','shop_price.productid = shop_product.productid');
       $this->db->where('shop_price.city_id',$this->city_id);
       $this->db->where('published',1);
       $this->db->where('shop_price.giaban !=',0);
       $this->db->like('productname',$productkey);
       return $this->db->get('shop_product')->num_rows();
   }
  
  }

