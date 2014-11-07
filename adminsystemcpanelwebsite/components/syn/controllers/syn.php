<?php
class syn extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('syn_model','syn');
    }
    
    function syn_city(){
        
        $list = $this->syn->getCity();
        foreach($list as $rs):
            $this->db = $this->load->database('default',true);   
            $city_name_en = vnit_change_string($rs->CityName);
            $vdata['city_id'] = $rs->CityID;
            $vdata['parentid'] = $rs->ParentID;
            $vdata['city_name'] = $rs->CityName;
            $vdata['city_url'] = vnit_change_title($rs->CityName);
            $vdata['ordering'] = $rs->Ordering;
            $vdata['published'] = $rs->IsActive;
            $this->db->insert('city',$vdata);
            
            $vdata_en['city_id'] = $rs->CityID;
            $vdata_en['parentid'] = $rs->ParentID;
            $vdata_en['city_name'] = $city_name_en;
            $vdata_en['city_url'] = vnit_change_title($city_name_en);
            $vdata_en['ordering'] = $rs->Ordering;
            $vdata_en['published'] = $rs->IsActive;
            $this->db->insert('city_en',$vdata_en);
        endforeach; 
        
    }
    
    function syn_user(){
        $list = $this->syn->getUser();
        foreach($list as $rs):
            $this->db = $this->load->database('default',true); 
             $vdata['user_id'] = $rs->AccountID;
             $vdata['user_code'] = vnit_barcode('FYI_',$rs->AccountID,8);
             $vdata['group_id'] = 1;
             $vdata['password'] = $rs->Passwd;
             $vdata['fullname'] = $rs->FullName;
             $vdata['email'] = $rs->Email;
             $vdata['brithday'] = $rs->Birthday;
             $vdata['male'] = $rs->Male;
             $vdata['phone'] = $rs->PhoneNumber;
             $vdata['address'] = $rs->Address;
             $vdata['city_id'] = $rs->CityID;
             $vdata['url_avatar'] = $rs->Avatar;
             $vdata['is_openid'] = $rs->IsOpenid;
             $vdata['create_time'] = $rs->RegisteredDate;
             $vdata['active_code'] = $rs->Scode;
             $vdata['published'] = $rs->IsActive;
             $this->db->insert('user',$vdata);
             
        endforeach;
    }
    
    
    function syn_danhmuc(){
        $list = $this->syn->get_category(array(488,540,910,1715,1943,1982,1988,2443));
        foreach($list as $rs):

            $this->db = $this->load->database('default',true);
            $v1['catid'] = $rs->CategoryID;
            $v1['catname'] = $rs->CategoryName;
            $v1['parentid'] = $rs->ParentID;
            $v1['caturl'] = vnit_change_title($rs->CategoryName);
            $v1['published'] = 1;
            $v1['ordering'] = $rs->Ordering;
            $this->db->insert('shop_cat',$v1);

        endforeach;
    }
    //273
    function syn_danhmuc1(){
        $list = $this->syn->get_category(array(1502));
        $data = '';
        foreach($list as $rs):
            $data .=$rs->CategoryID.',';
        endforeach; 
        echo $data;
    }
    
    function syn_sanpham1(){
        $list = $this->syn->get_sanpham(array(1523,1524,1525,1526,1527,1528,1529,1626,1672,1705,1748,1750));
        foreach($list as $rs):
        echo ''.$rs->ProductName.' - '.$rs->CategoryID.'<br />';
        endforeach;
    }
    
    function syn_sanpham(){
        $list = $this->syn->get_sanpham(array(1523,1524,1525,1526,1527,1528,1529,1626,1672,1705,1748,1750));
        foreach($list as $rs):
            $this->load->helper('img_helper');
            $vdata['productid'] = $rs->ProductID;
            $vdata['catid'] = 1502;
            $vdata['productname'] = $rs->ProductName;
            $vdata['producturl'] = vnit_change_title($rs->ProductName);
            $vdata['manufactureid'] = $rs->MenufactureID;
            $vdata['productimg'] = strtolower($rs->ProductImg);
            $vdata['mieuta'] = $rs->Description;
            if($rs->Price > 0){
            $vdata['giathitruong_miennam'] = $rs->Price;
            $vdata['giaban_miennam'] = $rs->PriceCty;
            $vdata['giamgia_miennam'] = $rs->Price - $rs->PriceCty;
            $vdata['per_miennam'] = (($rs->Price - $rs->PriceCty) * 100)/$rs->Price;
            }
            $vdata['vat_miennam'] = $rs->VAT;
            if($rs->ProductStatus == 1){
                $tinhtrang_miennam = 1;
            }else if($rs->ProductStatus == 2){
                $tinhtrang_miennam = 0;
            }else{
                $tinhtrang_miennam = '-1';
            }
            $vdata['tinhtrang_miennam'] = $tinhtrang_miennam; 
            $vdata['tinhtrang_miennam_text'] = $rs->ProductStatusText; 
            $vdata['miennam'] = $rs->IsHCM; 
            $vdata['thutu_miennam'] = $rs->Ordering; 
            if($rs->PriceHN > 0){
            $vdata['giathitruong_mienbac'] = $rs->PriceHN;
            $vdata['giaban_mienbac'] = $rs->PriceHNPromo;
            $vdata['giamgia_mienbac'] = $rs->PriceHN - $rs->PriceHNPromo;
            $vdata['per_mienbac'] = (($rs->PriceHN - $rs->PriceHNPromo) * 100)/$rs->PriceHN;
            }
            $vdata['vat_mienbac'] = $rs->VAT2; 
            if($rs->ProductStatusHN == 1){
                $tinhtrang_mienbac = 1;
            }else if($rs->ProductStatusHN == 2){
                $tinhtrang_mienbac = 0;
            }else{
                $tinhtrang_mienbac = '-1';
            }
            $vdata['tinhtrang_mienbac'] = $tinhtrang_mienbac; 
            $vdata['tinhtrang_mienbac_text'] = $rs->ProductStatusHN; 
            $vdata['mienbac'] = $rs->IsHN;
            $vdata['thutu_mienbac'] = $rs->OrderHN; 
            echo '<div>'.$rs->ProductID.'-'.$rs->ProductName.'</div>';
            $this->db = $this->load->database('default',true);  
            $this->db->where('productID',$rs->ProductID);
            $check = $this->db->get('shop_product')->row();
            if(!$check){
            $this->db->insert('shop_product',$vdata);
            $this->db->insert('shop_product_en',$vdata);
            
            $this->db = $this->load->database('default',false); 
            $this->fyi = $this->load->database('fyi',true);   
            $list_img = $this->syn->get_product_img($rs->ProductID);
            $i = 1;
            foreach($list_img as $val):
                $name = 'http://fyi.vn/uploads/images/'.$val->ImagePath;
                $file_name = end(explode('/',$name));
                $name_file = explode('.',$val->ImagePath);
                $this->_read_img($name,ROOT.'data/templ/',$name_file[0]);
                sleep(0.5);
                $vdatas['productid'] = $rs->ProductID;
                $vdatas['imagepath'] = strtolower($val->ImagePath);
                $vdatas['ordering'] = $i;
                $this->db = $this->load->database('default',true);   
                $this->db->insert('shop_img',$vdatas);
                $i ++;
                  
            endforeach;
            }
            //sleep(1);
        endforeach;
    }
    
    
    function syn_img(){
        $allowed_types = array("png","jpg","jpeg","gif");
        $this->load->helper('img_helper');
        $imgdir = ROOT.'data/templ/';
        $dimg = opendir($imgdir);
        while($imgfile = readdir($dimg))
        {
             if(in_array(strtolower(substr($imgfile,-3)),$allowed_types))
             {
              $a_img[] = $imgfile;
              sort($a_img);
              reset ($a_img);
             } 
        }

        $totimg = count($a_img); // total image number
         
        for($x=0; $x < $totimg; $x++){
                $img_name = strtolower($a_img[$x]);
                $file_root = ROOT.'data/templ/'.$a_img[$x];
                $file_root_upload = ROOT.'data/img_product/';
                vnit_resize_image($file_root,$file_root_upload.'500/'.strtolower($a_img[$x]),500,500);
                vnit_resize_image($file_root,$file_root_upload.'300/'.strtolower($a_img[$x]),300,300);
                vnit_resize_image($file_root,$file_root_upload.'200/'.strtolower($a_img[$x]),200,200);
                vnit_resize_image($file_root,$file_root_upload.'80/'.strtolower($a_img[$x]),80,80);
                vnit_resize_image($file_root,$file_root_upload.'40/'.strtolower($a_img[$x]),40,40);
                unlink($file_root);
                sleep(0.5);
        }
    }
    
    function syn_nsx(){
         $list = $this->syn->get_nsx();
         foreach($list as $rs):
            $this->db = $this->load->database('default',true);  
            $vdata['manufactureid'] = $rs->MenufactureID;
            $vdata['name'] = $rs->MenufactureName;
            $vdata['name_url'] = vnit_change_title($rs->MenufactureName);
            $vdata['images_small'] = $rs->MenufactureImg;
            $vdata['published'] = $rs->IsActive;
            $this->db->insert('shop_manufacture',$vdata);
         
         endforeach;
    }
 
    function _read_img($url, $path, $name)
    {
        if(empty($url)) return false;
        list($width, $height, $type, $attr)=@getimagesize($url);
        if(empty($width) or empty($height) or $type>3)
        {            
            $_getimg_error .= ' Can not get image from: '.$url;
            return false;
        }
        else
        {
            $image_data = @file_get_contents($url);
            switch($type)
            {
                case 1: $ext = '.gif';
                case 2: $ext = '.jpg';
                case 3: $ext = '.png';
                default: $ext = '.jpg';
            }
            $size = file_put_contents($path.$name.$ext,$image_data);
            return $size ? $path.$name.$ext : false;
        }
    }
    

}
