<?php
require_once (ROOT . 'debug/debug.php');

class vnit_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->load->config('config_auto');

    }

    public function getContactSite(){
        return $this->db->get('contact')->result();
    }

    public function getProductByProductIds($aProductIds, $iLimit = null){
        $result = array();
        $sProductIds = implode(',', $aProductIds);
        $sProductIds = trim($sProductIds, ',');

        $limit = 4;
        if(null != $iLimit){
            $limit = $iLimit;
        }
        $aGlobalSetting = $this->helper->getGlobalSettings();
        if(count($aGlobalSetting) > 0){
          $aGlobalSetting = $aGlobalSetting[0];
          $aGlobalSetting->data = (array)json_decode($aGlobalSetting->data);
          $limit = $aGlobalSetting->data['itemcategory'];
        }

        $sql = '';
        $sql .= " SELECT shop_product.productid, shop_product.barcode, shop_product.sphot
                    , shop_product.productimg, shop_product.tinhnang, shop_product.productname,shop_product.phukien,shop_product.producturl, shop_product.manufactureid, shop_price.* "
                . " FROM `shop_product` AS shop_product "
                . " JOIN shop_price AS shop_price ON (shop_price.productid = shop_product.productid) "
                . " WHERE 1=1 "
                    . " AND shop_product.productid IN (" . $sProductIds . ") "
                    . " AND shop_product.published = 1 "
                . " ORDER BY shop_product.productid DESC "
                . " LIMIT 0 , {$limit} "
                ;

        $query = $this->db->query($sql);
        if ($this->db->_error_number() > 0) {
            return array();
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result[] = $row;
            }
        }

        $query->free_result();

        return $result;
    }

    public function getLatestNews($count = 5){
        $result = array();
        $sWhere = '';
        $limit = $count;
        $sql = '';
        $sql .= " SELECT news_detail.* "
                . '  FROM news_detail AS news_detail 
                     WHERE 1=1 '
                . " ORDER BY news_detail.newsid DESC "
                . " LIMIT 0 , {$limit} "
                ;

        $query = $this->db->query($sql);
        if ($this->db->_error_number() > 0) {
            return array();
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result[] = $row;
            }
        }

        $query->free_result();

        return $result;   
    }

    public function getRandomNews(){
        $result = array();
        $sWhere = '';
        $limit = 5;
        $sql = '';
        $sql .= " SELECT news_detail.* "
                . '  FROM news_detail AS news_detail JOIN
                           (SELECT CEIL(RAND() *
                                         (SELECT MAX(newsid)
                                            FROM news_detail)) AS newsid)
                            AS r2
                     WHERE news_detail.newsid >= r2.newsid'
                . " ORDER BY news_detail.newsid DESC "
                . " LIMIT 0 , {$limit} "
                ;

        $query = $this->db->query($sql);
        if ($this->db->_error_number() > 0) {
            return array();
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result[] = $row;
            }
        }

        $query->free_result();

        return $result;        
    }

    public function getRandomOffsetProduct(){
        $result = array();
        $sql = '';
        $sql .= " SELECT FLOOR(RAND() * COUNT(shop_product.productid)) AS `offset` FROM `shop_product` "
                ;

        $query = $this->db->query($sql);
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result[] = $row;
            }
        }

        $query->free_result();

        return $result;
    }

    public function getRandomProduct($iLimit = null){
        $result = array();
        $sWhere = '';
        $limit = 5;
        if(null != $iLimit){
            $limit = $iLimit;
        }
        $sql = '';
        $sql .= " SELECT shop_product.productid, shop_product.barcode, shop_product.sphot
                    , shop_product.productimg, shop_product.tinhnang, shop_product.productname,shop_product.phukien,shop_product.producturl, shop_product.manufactureid, shop_price.* "
                . '  FROM shop_product AS shop_product JOIN
                           (SELECT CEIL(RAND() *
                                         (SELECT MAX(productid)
                                            FROM shop_product)) AS productid)
                            AS r2
                    JOIN shop_price AS shop_price ON (shop_price.productid = shop_product.productid)
                     WHERE shop_product.productid >= r2.productid'
                . " ORDER BY shop_product.productid DESC "
                . " LIMIT 0 , {$limit} "
                ;

        $query = $this->db->query($sql);
        if ($this->db->_error_number() > 0) {
            return array();
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result[] = $row;
            }
        }

        $query->free_result();

        return $result;

    }

    public function getProductByStatus($status){
        $result = array();
        $sWhere = '';
        switch ($status) {
            case 'hot':
                $sWhere .= ' AND shop_product.sphot = 1 ';
                break;
            case 'banchay':
                $sWhere .= ' AND shop_product.spbanchay = 1 ';
                break;
        }
        $limit = 5;
        $sql = '';
        $sql .= " SELECT shop_product.productid, shop_product.barcode, shop_product.sphot
                    , shop_product.productimg, shop_product.tinhnang, shop_product.productname,shop_product.phukien,shop_product.producturl, shop_product.manufactureid, shop_price.* "
                . " FROM `shop_product` AS shop_product "
                . " JOIN shop_price AS shop_price ON (shop_price.productid = shop_product.productid) "
                . " WHERE 1=1 "
                    . $sWhere
                    . " AND shop_product.published = 1 "
                . " ORDER BY shop_product.productid DESC "
                . " LIMIT 0 , {$limit} "
                ;
        $query = $this->db->query($sql);
        if ($this->db->_error_number() > 0) {
            return array();
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result[] = $row;
            }
        }

        $query->free_result();

        return $result;
    }

    public function getProductImageByProductId($productid){
        $this->db->where('productid',$productid);
        return $this->db->get('shop_img')->result();
    }

    public function getProductByMainCatId($catid){
        $result = array();
        $listCat = $this->getRecursiveChildCatByParentId($catid, 1);
        $listCatId = array($catid);
        foreach ($listCat as $key => $value) {
            $listCatId[] = $value->catid;
        }
        $sListCatId = implode(',', $listCatId);
        $sListCatId = trim($sListCatId, ',');

        $limit = 4;
        $aGlobalSetting = $this->helper->getGlobalSettings();
        if(count($aGlobalSetting) > 0){
          $aGlobalSetting = $aGlobalSetting[0];
          $aGlobalSetting->data = (array)json_decode($aGlobalSetting->data);
          $limit = $aGlobalSetting->data['itemcategory'];
        }

        $sql = '';
        $sql .= " SELECT shop_product.productid, shop_product.barcode, shop_product.sphot
                    , shop_product.productimg, shop_product.tinhnang, shop_product.productname,shop_product.phukien,shop_product.producturl, shop_product.manufactureid, shop_price.* "
                . " FROM `shop_product` AS shop_product "
                . " JOIN shop_price AS shop_price ON (shop_price.productid = shop_product.productid) "
                . " WHERE 1=1 "
                    . " AND shop_product.catid IN (" . $sListCatId . ") "
                    . " AND shop_product.published = 1 "
                . " ORDER BY shop_product.productid DESC "
                . " LIMIT 0 , {$limit} "
                ;

        // $this->db->select('shop_product.productid, shop_product.productimg, shop_product.tinhnang, shop_product.productname,shop_product.phukien,shop_product.producturl, shop_product.manufactureid, shop_price.*');
        // $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        // $this->db->where('shop_price.city_id',$city_id);
        // if($catid > 0){
        //     $this->db->where_in('shop_product.catid',$ar_catid);
        // }
        // $this->db->where('shop_product.home',1);
        // $this->db->where('shop_price.giaban >',0);
        // $this->db->order_by('shop_product.orderhome','asc');
        // $this->db->limit(8);




        $query = $this->db->query($sql);
        if ($this->db->_error_number() > 0) {
            return array();
        }

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $result[] = $row;
            }
        }

        $query->free_result();

        return $result;
    }

    public function getRecursiveChildCatByParentId($parentid, $published = 1){
        $this->db->select('catid, catname,caturl');
        $this->db->where('published', $published);
        $this->db->where('parentid', $parentid);
        // return $this->db->get('shop_cat')->result();
        $aRows = $this->db->get('shop_cat')->result();
        foreach ($aRows as $key => $value) {
            $aRows = array_merge($aRows, $this->getRecursiveChildCatByParentId($value->catid));
        }
        return $aRows;
    }

    // Hien thi danh mục chinh
    function get_all_tab_ngang(){
        $this->db->select('catid, catname,caturl,img_main');
        $this->db->where('published',1);
        $this->db->where('parentid',0);
        $this->db->where('ishome',1);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }

    // Hien thi danh muc cap 2
    function get_istab_by_cat($catid){
        $this->db->select('catid, catname,caturl');
        $this->db->where('published',1);
        $this->db->where('parentid',$catid);
        $this->db->where('istab',1);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }

    function get_subcat($catid){
        $this->db->select('catid, catname,caturl');
        $this->db->where('published',1);
        $this->db->where('parentid',$catid);
        $this->db->order_by('ordering','asc');
        return $this->db->get('shop_cat')->result();
    }
    //Lay danh muc san pham
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

    // San pham hot

    function get_all_hot(){
        $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.producturl, shop_product.manufactureid, shop_price.*');
        $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        $this->db->where('shop_price.city_id',$this->city_id);
        $this->db->where('sphot',1);
        $this->db->order_by('thutu','asc');
        $this->db->limit(8);
        return $this->db->get('shop_product')->result();
    }

    function get_sanphammuanhieu(){
        $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.producturl, shop_product.manufactureid, shop_price.*');
        $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        $this->db->where('shop_price.city_id',$this->city_id);
        $this->db->where('published',1);
        $this->db->order_by('buyer','desc');
        $this->db->limit(6);
        return $this->db->get('shop_product')->result();
    }


    /*************
    * San pham giam gia l>=30%;
    */

    function getlistproduct($catid = 0){
        if($catid > 0){
            $ar_catid = $this->vdb->get_ar($catid);
        }
        $this->db->select('shop_product.productid, shop_product.productimg, shop_product.productname, shop_product.producturl, shop_product.manufactureid, shop_price.*');
        $this->db->join('shop_price','shop_price.productid = shop_product.productid');
        $this->db->where('shop_price.city_id',$this->city_id);
        if($catid > 0){
            $this->db->where_in('shop_product.catid',$ar_catid);
        }
        $this->db->where('shop_product.home',1);
        $this->db->order_by('shop_product.orderhome','asc');
        $this->db->limit(8);
        return $this->db->get('shop_product')->result();

    }


    //*********************
    //TIn Tuc
    function get_lastnew(){
        $this->db->where('hot',0);
        $this->db->where('published',1);
        $this->db->order_by('newsid','desc');
        $this->db->limit(8);
        return $this->db->get('news_detail')->result();
    }

    function get_noibat(){
        $this->db->where('hot',1);
        $this->db->where('published',1);
        $this->db->order_by('newsid','desc');
        $this->db->limit(5);
        return $this->db->get('news_detail')->result();
    }

    function get_cat_new($parentid = 0){
        $this->db->where('parentid',$parentid);
        $this->db->where('published',1);
        $this->db->order_by('ordering','asc');
        return $this->db->get('news_cat',6)->result();
    }







}

