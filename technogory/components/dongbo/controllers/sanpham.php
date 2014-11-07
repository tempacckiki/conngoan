<?php
class sanpham extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->helper('img');
        $this->load->model('sanpham_model','sanpham');
    }
    
    function index(){
        $data['title'] ='Đồng bộ sản phẩm';
        // Xoa session offset
        $this->session->set_userdata('offset',0);

        $this->session->set_userdata('begin', 0);
        $this->_templates['page'] = 'sanpham/index';
        $this->templates->load($this->_templates['page'],$data,'dongbo');
    }
    
    function miennam(){
      $total_record = 17680; //$this->sanpham->get_all_sanpham();
      $offset = $this->session->userdata('offset');
      $limit = 100;
      $list = $this->sanpham->get_list_sanpham($limit,$offset);
      $current = round(100/(($total_record / $limit)),1);
                                                                                       
      $begin = $this->session->userdata('begin');
      $session_time = $this->session->userdata('time');        

        foreach($list as $rs):
            $vdata['productid'] = $rs->ProductID;
            $vdata['city_id'] = 25;
            $vdata['giaban'] = $rs->PriceCty;
            $vdata['giathitruong'] = $rs->Price;
            $vdata['giamgia'] = $rs->Price - $rs->PriceCty;
            $vdata['phantram'] = ($rs->Price > 0)?(($rs->Price - $rs->PriceCty) * 100) / $rs->Price:0;
            $vdata['vat'] = $rs->VAT;
            $vdata['tinhtrang'] = $rs->ProductStatus;
            $vdata['tinhtrang_text'] = $rs->ProductStatusText;
            $vdata['thutu'] = $rs->Ordering;
            $vdata['lastupdate'] = strtotime($rs->LastUpdate);
            $this->db = $this->load->database('default',true); 
            $this->db->insert('shop_price',$vdata);
         
       

        endforeach;
      
      $begin = $begin + $current;
      $this->session->set_userdata('begin',$begin); 
      
      $offset = $offset + $limit;
      $this->session->set_userdata('offset',$offset);
      $data['begin'] = $begin;
      $data['offset'] = $offset;
      $data['total'] = $total_record;
      echo json_encode($data);      
      
    }
 
    function miennam_(){
        $list = $this->sanpham->get_sanpham();
        $i = 1;
        foreach($list as $rs):
            $vdata['productid'] = $rs->ProductID;
            $vdata['city_id'] = 25;
            $vdata['giaban'] = $rs->PriceCty;
            $vdata['giathitruong'] = $rs->Price;
            $vdata['giamgia'] = $rs->Price - $rs->PriceCty;
            $vdata['phantram'] = ($rs->Price > 0)?(($rs->Price - $rs->PriceCty) * 100) / $rs->Price:0;
            $vdata['vat'] = $rs->VAT;
            $vdata['tinhtrang'] = $rs->ProductStatus;
            $vdata['tinhtrang_text'] = $rs->ProductStatusText;
            $vdata['thutu'] = $rs->Ordering;
            $vdata['lastupdate'] = strtotime($rs->LastUpdate);
            $this->db = $this->load->database('default',true); 
            if($this->db->insert('shop_price',$vdata)){
            echo '<div>|_'.$i.'_| ID:'. $rs->ProductID.' - San pham: '.$rs->ProductName.' <span style="color:#249AF5">OK</span></div>';
            }else{
                echo '<div>|_'.$i.'_| ID:'. $rs->ProductID.' - San pham: '.$rs->ProductName.' <span style="color:#FF0000">ERROR</span></div>';
            }
            $i = $i + 1;
            sleep(0.1); 
        
        endforeach;
        
    }
    function mienbac_(){
        $list = $this->sanpham->get_sanpham();
        $i = 1;
        foreach($list as $rs):
            $vdata['productid'] = $rs->ProductID;
            $vdata['city_id'] = 26;
            $vdata['giaban'] = $rs->PriceHNPromo;
            $vdata['giathitruong'] = $rs->PriceHN;
            $vdata['giamgia'] = $rs->PriceHN - $rs->PriceHNPromo;
            $vdata['phantram'] = ($rs->PriceHN > 0)?(($rs->PriceHN - $rs->PriceHNPromo) * 100) / $rs->PriceHN:0;
            $vdata['vat'] = $rs->VAT2;
            $vdata['tinhtrang'] = $rs->ProductStatusHN;
            $vdata['tinhtrang_text'] = $rs->ProductStatusTextHN;
            $vdata['thutu'] = $rs->OrderHN;
            $vdata['lastupdate'] = strtotime($rs->LastUpdate);
            $this->db = $this->load->database('default',true); 
            if($this->db->insert('shop_price',$vdata)){
            echo '<div>|_'.$i.'_| ID:'. $rs->ProductID.' - San pham: '.$rs->ProductName.' <span style="color:#249AF5">OK</span></div>';
            }else{
                echo '<div>|_'.$i.'_| ID:'. $rs->ProductID.' - San pham: '.$rs->ProductName.' <span style="color:#FF0000">ERROR</span></div>';
            }
            $i = $i + 1;

        
        endforeach;
        
    }
    function active(){
        $list = $this->sanpham->get_sanpham();
        $i = 1;
        foreach($list as $rs):
            $this->load->database('fyi',true);
            $catid = $this->sanpham->get_danhmuc_by_id($rs->ProductID);
            $vdata['productid'] = $rs->ProductID;
            $vdata['barcode']  = $rs->ProductCode;
            $vdata['catid'] = $catid;
            $vdata['productname'] = $rs->ProductName;
            $vdata['producturl'] = vnit_change_title($rs->ProductName);
            $vdata['manufactureid'] = $rs->MenufactureID;
            $vdata['productimg'] = $rs->ProductImg;
            // Mien Bac
            $vdata['giaban_mienbac'] = $rs->PriceHNPromo;
            $vdata['giathitruong_mienbac'] = $rs->PriceHN;
            $vdata['giamgia_mienbac'] = $rs->PriceHN - $rs->PriceHNPromo;
            $vdata['per_mienbac'] = ($rs->PriceHN > 0)?(($rs->PriceHN - $rs->PriceHNPromo) * 100) / $rs->PriceHN:0;
            $vdata['vat_mienbac'] = $rs->VAT2;
            // Mien Nam
            $vdata['giaban_miennam'] = $rs->PriceCty;
            $vdata['giathitruong_miennam'] = $rs->Price;
            $vdata['giamgia_miennam'] = $rs->Price - $rs->PriceCty;
            $vdata['per_miennam'] = ($rs->Price > 0)?(($rs->Price - $rs->PriceCty) * 100) / $rs->Price:0;
            $vdata['vat_miennam'] = $rs->VAT;
            
            // Tinh trang mien bac
            $vdata['tinhtrang_mienbac'] = $rs->ProductStatusHN;
            $vdata['tinhtrang_mienbac_text'] = $rs->ProductStatusTextHN;
            
            // Tinh trang mien nam
            $vdata['tinhtrang_mienbac'] = $rs->ProductStatus;
            $vdata['tinhtrang_mienbac_text'] = $rs->ProductStatusText;
            
            $vdata['baohanh'] = $rs->ProductWarranty;
            $vdata['thutu_mienbac'] = $rs->OrderHN;
            $vdata['thutu_miennam'] = $rs->Ordering;
            $vdata['published'] = 1;
            $this->db = $this->load->database('default',true); 
            if($this->db->insert('shop_product',$vdata)){
            echo '<div>|_'.$i.'_| ID:'. $rs->ProductID.' - San pham: '.$rs->ProductName.' <span style="color:#249AF5">OK</span></div>';
            }else{
                echo '<div>|_'.$i.'_| ID:'. $rs->ProductID.' - San pham: '.$rs->ProductName.' <span style="color:#FF0000">ERROR</span></div>';
            }
            $i = $i + 1;
            sleep(0.1); 
        endforeach;
     
    }
}
