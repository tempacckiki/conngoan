<?php
class hinhanh extends CI_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model('hinhanh_model','hinhanh');
        $this->load->helper('img');
    }
    
    function index(){
          // Xoa session offset
          $this->session->set_userdata('offset',0);

          $this->session->set_userdata('begin', 0);           
          $this->_templates['page'] = 'hinhanh';
          $this->templates->load($this->_templates['page'],$data,'dongbo');
    }

    
    function process(){
      $total_record = $this->hinhanh->get_num_hinhanh();
      $offset = $this->session->userdata('offset');
      $limit = 20;
      $list = $this->hinhanh->get_all_img($limit,$offset);
      $current = round(100/(($total_record / $limit)),1);
                                                                                       
      $begin = $this->session->userdata('begin');
      $session_time = $this->session->userdata('time');
        $root_old =  getenv("DOCUMENT_ROOT").'/uploads/images/';
        $root_new = ROOT.'data/img_product/';
        foreach($list as $rs):
             $vdata['imageid'] = $rs->ImageID;
             $vdata['productid'] = $rs->ProductID;
             $vdata['imagepath'] = $rs->ImagePath;
             $this->db = $this->load->database('default',true); 
             $this->db->insert('shop_img',$vdata);
             
            
            vnit_resize_image($root_old.$rs->ImagePath,$root_new.'500/'.$rs->ImagePath,500,500);
            vnit_resize_image($root_old.$rs->ImagePath,$root_new.'300/'.$rs->ImagePath,300,300);
            vnit_resize_image($root_old.$rs->ImagePath,$root_new.'200/'.$rs->ImagePath,200,200);
            vnit_resize_image($root_old.$rs->ImagePath,$root_new.'80/'.$rs->ImagePath,80,80);
            vnit_resize_image($root_old.$rs->ImagePath,$root_new.'40/'.$rs->ImagePath,40,40);
            
            //unlink($file_root);
            sleep(0.5);
            
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
    
    
    /*function index(){
        $root_old =  getenv("DOCUMENT_ROOT").'/uploads/images/1336094312.jpg';
        $root_new = ROOT.'data/1336094312.jpg';
        vnit_resize_image($root_old,$root_new,500,500); 
    }*/
    
    function active(){
        /*
        $root_old =  getenv("DOCUMENT_ROOT").'/uploads/images/';
        $root_new = ROOT.'data/img_product/';
        $list = $this->hinhanh->get_all_img();
        foreach($list as $rs):
             $vdata['imageid'] = $rs->ImageID;
             $vdata['productid'] = $rs->ProductID;
             $vdata['imagepath'] = $rs->ImagePath;
             $this->db = $this->load->database('default',true); 
             $this->db->insert('shop_img',$vdata);
             

            vnit_resize_image($root_old.$rs->ImagePath,$root_new.'500/'.$rs->ImagePath,500,500);
            vnit_resize_image($file_root.$rs->ImagePath,$root_new.'300/'.$rs->ImagePath,300,300);
            vnit_resize_image($file_root.$rs->ImagePath,$root_new.'200/'.$rs->ImagePath,200,200);
            vnit_resize_image($file_root.$rs->ImagePath,$root_new.'80/'.$rs->ImagePath,80,80);
            vnit_resize_image($file_root.$rs->ImagePath,$root_new.'40/'.$rs->ImagePath,40,40);
            //unlink($file_root);
            sleep(0.5);
            
        endforeach;
        */
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
    
    
}
