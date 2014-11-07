<?php
class category_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    /*-----------------------------------+
     * 
     +---------------------------------- */
    function get_all_product($num,$offset,$catid,$max,$min,$hot='all',$order='price_asc'){
    	//get list catID
    	$ar_cat = $this->get_ar_cat($catid);
    
    	$sql = "
	    	SELECT
	    	pro.productid, pro.catid, pro.productname, pro.producturl, pro.tinhnang, pro.productimg, pro.manufactureid, pro.tinhnang,pro.phukien, pro.sphot,shop_price.*
	    	FROM
	    	shop_product as pro LEFT JOIN shop_features_values as f ON pro.productid = f.product_id JOIN shop_price ON pro.productid = shop_price.productid
	    	WHERE
	    	pro.published = 1
	    	AND	    	
    		pro.catid IN (" . implode(', ', $ar_cat).")";
    	
        $sql .= " AND shop_price.city_id =".$this->city_id;
        $sql .=" AND shop_price.giaban != 0";
       
        
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
            $sql .=" ORDER BY pro.productid desc ";
        }
        $sql .= "LIMIT $num OFFSET $offset";
        return $this->db->query($sql)->result();
        $this->db->close();
        //return $this->db->get('shop_product',$num,$offset)->result();
    }
	
	
    
    function get_num_product($catid,$max,$min,$hot='all'){
        $ar_cat = $this->get_ar_cat($catid);
        $sql = "
                SELECT 
                    pro.productid
                FROM 
                    shop_product as pro LEFT JOIN shop_features_values as f ON pro.productid = f.product_id  JOIN shop_price ON pro.productid = shop_price.productid
                WHERE 
                    pro.published = 1
                AND                    
                pro.catid IN (" . implode(', ', $ar_cat).")";
        
        $sql .=" AND shop_price.giaban != 0";
        $sql .= " AND shop_price.city_id =".$this->city_id;
       
        
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
        $this->db->close(); 
    }
    
    function get_subcat($catid){
        $this->db->where('published',1);
        $this->db->where('parentid',$catid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
        $this->db->close();
    }
    
    
    /*****************Danh sach san pham ban chay **********/
    function get_sanpham_banchay($catid){
    	$arrCat = $this->get_ar_cat($catid);
    	$this->db->select("shop_product.*,shop_price.*");
    	$this->db->join("shop_price","shop_price.productid = shop_product.productid");  
        $this->db->where('shop_price.city_id',$this->city_id);
        $this->db->where('published',1);
        $this->db->where_in('catid',$arrCat);
        $this->db->where('shop_price.giaban !=',0);
        $this->db->order_by('shop_price.giaban','ASC');
        $this->db->limit(12);
        return $this->db->get('shop_product')->result();
        $this->db->close();
    }
    
  
    /*---------------------------------+
    
    +--------------------------------*/
    
    public function get_ar_cat($catid){
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
              $list1 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$val1->caturl.'-'.$val1->catid).'" itemprop="url"><span itemprop="title">'.$val1->catname.'</span></a></div>';
              $list2 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$val->caturl.'-'.$val->catid).'" itemprop="url"><span itemprop="title">'.$val->catname.'</span></a></div>';
              $list3 = '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="'.site_url('chuyen-muc/'.$cat->caturl.'-'.$cat->catid).'" itemprop="url"><span itemprop="title">'.$cat->catname.'</span></a></div>';
              return $list1.$list2.$list3;
          }
      }
    }
    
    
    
// Tim link theo chuyen muc
    function find_top_link_seo($catid,$parentid){
      $cat = $this->get_cat_by_id($catid); 
      if($parentid == 0){
          return site_url('chuyen-muc/'.$cat->caturl.'-'.$cat->catid);
      }else{
          $this->db->where('catid',$parentid);
          $val = $this->db->get('shop_cat')->row();
          if($val->parentid == 0){
              $list1 = site_url('chuyen-muc/'.$val->caturl.'-'.$val->catid);
              $list2 = site_url('chuyen-muc/'.$cat->caturl.'-'.$cat->catid);
              if(!empty($list1))
              	return $list1;
              elseif(!empty($list2))
              	return $list2;
          }else{
              $val1 = $this->vdb->find_by_id('shop_cat',array('catid'=>$val->parentid));
              $list1 = site_url('chuyen-muc/'.$val1->caturl.'-'.$val1->catid);
              $list2 = site_url('chuyen-muc/'.$val->caturl.'-'.$val->catid);
              $list3 = site_url('chuyen-muc/'.$cat->caturl.'-'.$cat->catid);
              if(!empty($list1))
              	return $list1;
              elseif(!empty($list2))
              	return $list2;
              elseif(!empty($list3))
              	return $list3;
          }
      }
    }
    
    /*---------------------------------+
     * 
     +---------------------------------*/
    function get_cat_by_id($catid){
      $this->db->where('catid',$catid);
      return $this->db->get('shop_cat')->row();
      $this->db->close();
    }
  
	
}
