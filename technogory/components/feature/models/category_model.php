<?php
class category_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_ar_cat($catid){
        $ar_id = array($catid);
        $list = $this->vdb->find_by_list('shop_cat',array('parentid'=>$catid));
        foreach($list as $rs):
            $list1 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs->catid));
            array_push($ar_id,$rs->catid);
            foreach($list1 as $rs1):
                $list2 = $this->vdb->find_by_list('shop_cat',array('parentid'=>$rs1->catid)); 
                 array_push($ar_id,$rs1->catid);
                 foreach($list2 as $rs2): 
                      array_push($ar_id,$rs2->catid);
                 endforeach; 
            endforeach;
            
        endforeach;
        return $ar_id;
    }
    
    function get_all_product($num,$offset,$catid,$max,$min,$hot='all',$order='price_asc',$ar_feature = '', $manufacture = '', $color = ''){
        //$ar_cat = $this->get_ar_cat($catid);
        if($color != ''){
            $sql = "
                SELECT 
                    pro.productid, pro.catid, pro.productname, pro.producturl, pro.tinhnang, pro.productimg, pro.manufactureid, pro.tinhnang, pro.phukien, shop_price.* 
                FROM 
                    shop_product as pro LEFT JOIN shop_features_values as f ON pro.productid = f.product_id JOIN shop_price ON pro.productid = shop_price.productid JOIN shop_color_product
ON pro.productid = shop_color_product.productid
               WHERE 
                    pro.published = 1
                AND 
                    pro.catid = $catid";
                    //pro.catid IN (" . implode(', ', $ar_cat).")";
        }else{
            $sql = "
                SELECT 
                    pro.productid, pro.catid, pro.productname, pro.producturl, pro.tinhnang, pro.productimg, pro.manufactureid, pro.tinhnang,pro.phukien, shop_price.*
                FROM 
                    shop_product as pro LEFT JOIN shop_features_values as f ON pro.productid = f.product_id JOIN shop_price ON pro.productid = shop_price.productid
               WHERE 
                    pro.published = 1
                AND 
                    pro.catid = $catid";  
                    //pro.catid IN (" . implode(', ', $ar_cat).")";
        }
        $sql .= " AND shop_price.city_id =".$this->city_id;
        $sql .=" AND shop_price.giaban != 0";
        if($ar_feature != ''){
            $sql .=" AND f.variant_id IN ($ar_feature)";
        }
        if($manufacture != ''){
           $sql .=" AND pro.manufactureid IN ($manufacture)"; 
        }
        if($color != ''){
           $sql .=" AND shop_color_product.icolor IN ($color)"; 
        }
        
        if($max > 0){
        $sql .= " AND (shop_price.giaban > $min AND shop_price.giaban <= $max)";
        } 
        // Tinh trang hang
        if($hot=='hot'){
            $sql .=" AND pro.sphot = 1";
            
        }else if($hot == 'new'){
            $sql .=" AND pro.spmoi = 1";
        }else if($hot == 'promotion'){
            $sql .=" AND pro.spkhuyenmai = 1";
        }
        $sql .=" GROUP BY pro.productid ";
        // Sap xep
        if($order == 'price_desc'){
            $sql .=" ORDER BY shop_price.giaban desc ";
          
        }else if($order == 'price_asc'){
            $sql .=" ORDER BY shop_price.giaban asc ";
          
        }else if($order == 'name_asc'){
            $sql .=" ORDER BY pro.productname asc ";

        }else if($order == 'name_desc'){
            $sql .=" ORDER BY pro.productname desc ";

        }else{
            $sql .=" ORDER BY shop_price.giaban asc ";
        }
        $sql .= "LIMIT $num OFFSET $offset";
        return $this->db->query($sql)->result();
        
        //return $this->db->get('shop_product',$num,$offset)->result();
    }
    
    function get_num_product($catid,$max,$min,$hot='all',$ar_feature = '', $manufacture = '', $color = ''){
        //$ar_cat = $this->get_ar_cat($catid);
        if($color != ''){
            $sql = "
                SELECT 
                    pro.productid
                FROM 
                    shop_product as pro LEFT JOIN shop_features_values as f ON pro.productid = f.product_id JOIN shop_price ON pro.productid = shop_price.productid JOIN shop_color_product
ON pro.productid = shop_color_product.productid
               WHERE 
                    pro.published = 1
                AND 
                    pro.catid = $catid";
                    //pro.catid IN (" . implode(', ', $ar_cat).")";
        }else{
            $sql = "
                SELECT 
                    pro.productid
                FROM 
                    shop_product as pro LEFT JOIN shop_features_values as f ON pro.productid = f.product_id  JOIN shop_price ON pro.productid = shop_price.productid
                WHERE 
                    pro.published = 1
                AND 
                    pro.catid = $catid";
                ///pro.catid IN (" . implode(', ', $ar_cat).")";
        }
        $sql .=" AND shop_price.giaban != 0";
        $sql .= " AND shop_price.city_id =".$this->city_id;
        if($ar_feature != ''){
            $sql .=" AND f.variant_id IN ($ar_feature)";
        }
        
        if($manufacture != ''){
           $sql .=" AND pro.manufactureid IN ($manufacture)"; 
        }
        if($color != ''){
           $sql .=" AND shop_color_product.icolor IN ($color)"; 
        }
        
        if($max > 0){
            $sql .= " AND (shop_price.giaban > $min AND shop_price.giaban <= $max)";
        }

        // Tinh trang hang
        if($hot=='hot'){
            $sql .=" AND pro.sphot = 1";
        }else if($hot == 'new'){
            $sql .=" AND pro.spmoi = 1";
        }else if($hot == 'promotion'){
            $sql .=" AND pro.spkhuyenmai = 1";
        }
        $sql .= " GROUP BY pro.productid";
        return $this->db->query($sql)->num_rows();
    }
    
    function get_subcat($catid){
        $this->db->where('published',1);
        $this->db->where('parentid',$catid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }
    
    
    /*****************Danh sach san pham ban chay **********/
    function get_sanpham_banchay($catid){
        $this->db->where('published',1);
        $this->db->where('catid',$catid);
        $this->db->limit(10);
        return $this->db->get('shop_product')->result();
    }
    
    function gettangpham($productid){
        $this->db->where('city_id',$this->city_id);
        $this->db->where('productid',$productid);
        return $this->db->get('shop_gifts')->row();
    }
    
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
    
    // Tim link theo chuyen muc
    function find_top_link($catid,$parentid){
      $cat = $this->get_cat_by_id($catid);
      if($parentid == 0){
          return '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('category/'.$cat->caturl.'/'.$cat->catid).'" itemprop="url"><span itemprop="title">'.$cat->catname.'</span></a></div>';
      }else{
          $this->db->where('catid',$parentid);
          $val = $this->db->get('shop_cat')->row();
          if($val->parentid == 0){
              $list1 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('category/'.$val->caturl.'/'.$val->catid).'" itemprop="url"><span itemprop="title">'.$val->catname.'</span></a></div>';
              $list2 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('category/'.$cat->caturl.'/'.$cat->catid).'" itemprop="url"><span itemprop="title">'.$cat->catname.'</span></a></div>';
              return $list = $list1.$list2;
          }else{
              $val1 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val->parentid));
              $list1 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('category/'.$val1->caturl.'/'.$val1->catid).'" itemprop="url"><span itemprop="title">'.$val1->catname.'</span></a></div>';
              $list2 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('category/'.$val->caturl.'/'.$val->catid).'" itemprop="url"><span itemprop="title">'.$val->catname.'</span></a></div>';
              $list3 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('category/'.$cat->caturl.'/'.$cat->catid).'" itemprop="url"><span itemprop="title">'.$cat->catname.'</span></a></div>';
              return $list1.$list2.$list3;
          }
      }
    }
    
    
    
// Tim link theo chuyen muc
    function find_top_link_seo($catid,$parentid){
      $cat = $this->get_cat_by_id($catid); 
      if($parentid == 0){
          return site_url('category/'.$cat->caturl.'/'.$cat->catid);
      }else{
          $this->db->where('catid',$parentid);
          $val = $this->db->get('shop_cat')->row();
          if($val->parentid == 0){
              $list1 = site_url('category/'.$val->caturl.'/'.$val->catid);
              $list2 = site_url('category/'.$cat->caturl.'/'.$cat->catid);
              if(!empty($list1))
              	return $list1;
              elseif(!empty($list2))
              	return $list2;
          }else{
              $val1 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val->parentid));
              $list1 = site_url('category/'.$val1->caturl.'/'.$val1->catid);
              $list2 = site_url('category/'.$val->caturl.'/'.$val->catid);
              $list3 = site_url('category/'.$cat->caturl.'/'.$cat->catid);
              if(!empty($list1))
              	return $list1;
              elseif(!empty($list2))
              	return $list2;
              elseif(!empty($list3))
              	return $list3;
          }
      }
    }
    
    function get_cat_by_id($catid){
      $this->db->where('catid',$catid);
      return $this->db->get('shop_cat')->row();
    }
    
	function get_manufacture_id($manufaceture){
      $this->db->where('manufactureid',$manufaceture);
      return $this->db->get('shop_manufacture')->row();
    }
	function get_variant_id($variant_id){
      $this->db->where('variant_id',$variant_id);
      return $this->db->get('shop_feature_variant_descriptions')->row();
    }
 	
    
    function get_list_gifts($productid){
        $this->db->where('local',$this->regions);
        $this->db->where('productid',$productid);
        return $this->db->get('shop_gifts')->result();
    }
}
