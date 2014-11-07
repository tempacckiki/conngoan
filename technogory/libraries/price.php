<?php
class CI_price{
	protected $_linkCat;
    function __construct(){
    	
        $this->CI = get_instance();
        $this->city_site = $this->CI->session->userdata('city_site');
        //get uri
       	$uriString 	= explode('/', uri_string());
       	
       	//get product id
       	$idproduct   = end($uriString);
       	$index0      = $uriString[0];
       	//get item product
       	$this->CI->db->where('productid',$idproduct);
        $this->CI->db->where('published',1);
        $itemProduct =  $this->CI->db->get('shop_product')->row();
         //set link search
         if($index0  == 'product'){
       		$this->_linkCat   = 'category/'.$itemProduct->caturl.'/'.$itemProduct->catid;
         }else{
         	$this->_linkCat   = uri_string();
         }
    }
    function get_min_max($catid){
         $max =  $this->find_max_price($catid);
         if($max == 0){
            return '';
         }else{
             if($max < 120000000 && $max > 80000000){
                 return $this->get_max_120();
             }else if($max <= 80000000 && $max > 50000000){
                 return $this->get_max_80();
             }else if($max <= 50000000 && $max > 40000000){
                 return $this->get_max_50();
             }else if($max <= 40000000 && $max > 30000000){
                 return $this->get_max_40();
             }else if($max <= 30000000 && $max > 20000000){
                 return $this->get_max_30();
             }else if($max <= 20000000 && $max > 12000000){
                 return $this->get_max_20();
             }else if($max <= 12000000 && $max > 10000000){
                 return $this->get_max_12();
             }else if($max <= 10000000 && $max > 7000000){
                 return $this->get_max_10();
             }else if($max <= 7000000 && $max > 5000000){
                 return $this->get_max_7();
             }else if($max <= 5000000){
                 return $this->get_max_5();
             }
             
         }
    }
    


    
    function get_list_product($catid){
        $this->CI->db->where('catid',$catid);
        $this->CI->db->where('published',1);
        return $this->CI->db->get('shop_product')->result();

    }
    
    function find_max_price($catid){
        $list = $this->get_list_product($catid);
        if(count($list) > 0){
            $ar_id = array();
            foreach($list as $rs):
                array_push($ar_id, $rs->productid);
            endforeach;
            $this->CI->db->select_max('giaban');
            $this->CI->db->where_in('productid',$ar_id);
            $this->CI->db->where('city_id',$this->city_site);
            $row = $this->CI->db->get('shop_price')->row();
            return $row->giaban;
        }else{
            return 0;
        }
    }
    
    function find_min_price($catid){
        $list = $this->get_list_product($catid);
        if(count($list) > 0){
            $ar_id = array();
            foreach($list as $rs):
                array_push($ar_id, $rs->productid);
            endforeach;
            $this->CI->db->select_min('giaban');
            $this->CI->db->where_in('productid',$ar_id);
            $this->CI->db->where('city_id',$this->city_site);
            $row = $this->CI->db->get('shop_price')->row();
            return $row->giaban;
        }else{
            return 0;
        }
    }
    
    function get_max_120(){
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=20000000" rel="nofollow">Dưới 20 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=20000000&max=3000000" rel="nofollow">20 triêu - 30 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=20000000&max=40000000" rel="nofollow">30 triêu - 40 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=40000000&max=60000000" rel="nofollow">40 triêu - 60 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=60000000&max=120000000" rel="nofollow">60 triêu - 120 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    function get_max_80(){
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=0&max=5000000">Dưới 5 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=5000000&max=8000000" rel="nofollow">5 triêu - 8 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=8000000&max=12000000" rel="nofollow">8 triêu - 12 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=12000000&max=20000000" rel="nofollow">12 triêu - 20 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=20000000&max=30000000" rel="nofollow">20 triêu - 30 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=30000000&max=50000000" rel="nofollow">30 triêu - 50 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=50000000&max=70000000" rel="nofollow">50 triêu - 70 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=70000000&max=80000000" rel="nofollow">70 triêu - 80 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    function get_max_50(){
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=0&max=10000000" rel="nofollow">Dưới 10 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=10000000&max=15000000" rel="nofollow">10 triêu - 15 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=15000000&max=25000000" rel="nofollow">15 triêu - 25 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=25000000&max=50000000" rel="nofollow">25 triêu - 50 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    function get_max_40(){
        $str = '<li><a href="'.site_url(uri_string()).'?min=0&max=8000000" rel="nofollow">Dưới 8 triệu</a></li>';
        $str .= '<li><a href="'.site_url(uri_string()).'?min=8000000&max=12000000" rel="nofollow">8 triêu -12 triệu</a></li>';
        $str .= '<li><a href="'.site_url(uri_string()).'?min=12000000&max=16000000" rel="nofollow">12 triêu - 16 triệu</a></li>';
        $str .= '<li><a href="'.site_url(uri_string()).'?min=16000000&max=20000000" rel="nofollow">16 triêu - 20 triệu</a></li>';
        $str .= '<li><a href="'.site_url(uri_string()).'?min=20000000&max=30000000" rel="nofollow">20 triêu - 30 triệu</a></li>';
        $str .= '<li><a href="'.site_url(uri_string()).'?min=30000000&max=4000000" rel="nofollow">30 triêu - 40 triệu</a></li>';
        $str .= '<li><a href="'.site_url(uri_string()).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    function get_max_30(){
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=0&max=5000000" rel="nofollow">Dưới 5 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=5000000&max=6000000" rel="nofollow">5 triêu - 6 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=6000000&max=7000000" rel="nofollow">6 triêu - 7 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=7000000&max=9000000" rel="nofollow">7 triêu - 9 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=9000000&max=12000000" rel="nofollow">9 triêu - 12 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=12000000&max=15000000" rel="nofollow">12 triêu - 15 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=15000000&max=20000000" rel="nofollow">15 triêu - 20 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=20000000&max=30000000" rel="nofollow">20 triêu - 30 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    
    function get_max_20(){
    
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=0&max=3000000" rel="nofollow">Dưới 3 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=3000000&max=5000000" rel="nofollow">3 triêu - 5 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=5000000&max=7000000" rel="nofollow">5 triêu - 7 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=7000000&max=12000000" rel="nofollow">7 triêu - 12 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=12000000&max=20000000" rel="nofollow">12 triêu - 20 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    function get_max_12(){
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=0&max=1500000" rel="nofollow">Dưới 1.5 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=1500000&max=2000000" rel="nofollow">1.5 triêu - 2 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=2000000&max=3000000" rel="nofollow">2 triêu - 3 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=3000000&max=4000000" rel="nofollow">3 triêu - 4 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=4000000&max=6000000" rel="nofollow">4 triêu - 6 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=6000000&max=8000000" rel="nofollow">6 triêu - 8 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=8000000&max=12000000" rel="nofollow">8 triêu - 12 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    function get_max_10(){
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=0&max=3000000" rel="nofollow">Dưới 3 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=3000000&max=4000000" rel="nofollow">3 triêu - 4 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=4000000&max=5000000" rel="nofollow">4 triêu - 5 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=5000000&max=6000000" rel="nofollow">5 triêu - 6 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=6000000&max=10000000" rel="nofollow">6 triêu - 10 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    
    function get_max_7(){
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=0&max=1000000" rel="nofollow">Dưới 1 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=1000000&max=2000000" rel="nofollow">1 triêu - 2 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=2000000&max=3000000" rel="nofollow">2 triêu - 3 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=3000000&max=5000000" rel="nofollow">3 triêu - 5 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=5000000&max=7000000" rel="nofollow">5 triêu - 7 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    
    function get_max_5(){
        $str = '<li><a href="'.site_url($this->_linkCat).'?min=0&max=500000" rel="nofollow">Dưới 500 nghìn</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=500000&max=1000000" rel="nofollow">500 nghìn - 1 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=1000000&max=2000000" rel="nofollow">1 triêu - 2 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=2000000&max=3000000" rel="nofollow">2 triêu - 3 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'?min=3000000&max=5000000" rel="nofollow">3 triêu - 5 triệu</a></li>';
        $str .= '<li><a href="'.site_url($this->_linkCat).'">Tất cả sản phẩm</a></li>';
        return $str;
    }
    
    function rounddowntohundred_max($theNumber) {
        if (strlen($theNumber)<=6) {
        $theNumber=$theNumber;
        } else {
        $theNumber=substr($theNumber, 0, strlen($theNumber) - 6)+1;

        }
        return $theNumber;

    } 

    function rounddowntohundred_min($theNumber) {
        if (strlen($theNumber)<=6) {
        $theNumber=$theNumber;
        } else {
        $theNumber=substr($theNumber, 0, strlen($theNumber) - 6)-1;

        }
        return $theNumber;

    }
}
