<?php
/**************************
* Controller Shop - Gian hang
* Author: DEV MyTran
* Email: devmytran@gmail.com
* Date: 17/06/2011
***************************/
require_once (ROOT . 'debug/debug.php');

class shop extends CI_Controller{
  protected $_templates;
  function __construct(){
      parent::__construct();
      $this->pre_message = "";
      $this->load->helper('img_helper');
      $this->load->model('shop_model','shop');
      $js_array = array(
            array(base_url().'components/product/views/esset/add_product.js'),
            array(base_url().'components/product/views/esset/product.js')
      );
      $this->esset->js($js_array);
      $this->group_id = $this->session->userdata('group_id');
      $this->user_id = $this->session->userdata('user_id');
  }
  
  function index(){
      
  }
  /*********************************|
  |                                 |
  |  Controller xu ly thuoc tinh    |
  |                                 |
  |*********************************/        
  // Danh sach thuoc tinh chinh
  function listattr(){
      $parentid = (int)$this->uri->segment(4);
      $data['title'] = 'Danh sách thuộc tính';
      $data['add'] = 'product/shop/addattr';
      $data['list'] = $this->shop->get_all_attr($parentid);
      $data['num'] = count($data['list']);
      $this->_templates['page'] = 'attr/list';
      $this->templates->load($this->_templates['page'],$data);
  }
  // Them moi thuoc tinh
  function addattr(){
      $data['title'] = 'Thêm mới thuộc tính';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'product/shop/listattr';      
      $data['listcat'] = $this->shop->get_all_attr();
      $this->form_validation->set_rules('attr[type_name]','Tên thuộc tính','trim|required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          $attr = $this->input->post('attr');
          if($id = $this->vdb->update('shop_type',$attr)){
                $mainid = $this->input->post('mainid');
                $this->session->set_flashdata('message','Lưu thành công');
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'product/shop/listattr/'.$attr['parentid'];
                }else{
                   $url = 'product/shop/editattr/'.$id.'/'.$attr['parentid'];
                }
                redirect($url);              

          }else{
              $this->pre_message = 'Lưu không thành công';
          }
      }
      $this->_templates['page'] = 'attr/add';
      $this->templates->load($this->_templates['page'],$data);
  }
  // Chinh sua thuoc tinh
  function editattr(){
      $data['title'] = 'Cập nhật thuộc tính';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'product/shop/listattr';          
      $data['rs'] = $this->shop->get_attr_by_id($this->uri->segment(4));
      $data['listcat'] = $this->shop->get_all_attr();
      $this->form_validation->set_rules('attr[type_name]','Tên thuộc tính','trim|required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          $id = $this->input->post('id');
          $attr = $this->input->post('attr');
          if($this->vdb->update('shop_type',$attr,array('type_id'=>$id))){
              $mainid = $this->input->post('mainid');
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'product/shop/listattr/'.$mainid;
                }else{
                    $url = uri_string();
                }
                redirect($url);
          }else{
              $this->pre_message = 'Lưu không thành công';
          }
      }
      $this->_templates['page'] = 'attr/edit';
      $this->templates->load($this->_templates['page'],$data);
  } 
  
  // Danh sach san pham
  function listproduct(){
      $data['title'] = 'Danh sách sản phẩm';
      $data['add'] = 'product/shop/add|'.icon_add('product/shop/add');
      $data['delete'] = icon_dels('product/shop/dels');
	  
   //***********************
     //echo ROOT."admin/config/config_price_". $this->user_id.".php";
   //load config
  	 if(file_exists(ROOT."adminsystemcpanelwebsite/config/config_price_". $this->user_id.".php")){
      	$this->load->config("config_price_".$this->user_id);
        $data["user_idPrice"]  	= $this->config->item("user_id");
      	$data["addPrice"]  		= $this->config->item("addPrice");
     	$data["editPrice"]  	= $this->config->item("editPrice");
  	 }else{
  	 	$data["user_idPrice"]  = "";
      	$data["addPrice"]     = "";
     	$data["editPrice"]    = "";
  	 }
  	 
  	 
      if($this->group_id == 18){
        $data['listcat'] = $this->shop->get_main_cat(); 
      }else{
        $data['listcat'] = $this->dm->list_main();   
      }
      $catid = (int)$this->uri->segment(4);
      if($catid != 0){
          $catname = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid))->catname;
          write_log(62,185,'Xem danh sách sản phẩm danh mục: '.$catname); 
      }
      $city_id = (int)$this->uri->segment(5);
      $page = (int)$this->uri->segment(6);
      $field = $this->uri->segment(7);
      $order = $this->uri->segment(8);   
             
      $barcode = $this->input->get('barcode');
      $productkey = $this->input->get('productkey');
      if($barcode != '' && $productkey != ''){
            $url_get = "/?barcode=".$barcode.'&productkey='.$productkey;
      }else{
            if($barcode != ''){
                $url_get = "/?barcode=".$barcode; 
            }else if($productkey != ''){
                $url_get = "/?productkey=".$productkey; 
            }else{
                $url_get = '';
            }
      }
      $data['barcode'] = $barcode;
      $data['productkey'] = $productkey;
      $data['catid'] = $catid;
      $data['city_id'] = $city_id;
      $config['suffix'] = '/'.$field.'/'.$order.$url_get;
      $config['base_url'] = base_url().'product/shop/listproduct/'.$catid.'/'.$city_id; 
      $config['total_rows']   =  $this->shop->get_num_product($catid, $city_id, $barcode, $productkey);
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   20;
      $config['uri_segment'] = 6; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->shop->get_all_product($config['per_page'], $this->uri->segment(6),$catid, $city_id, $barcode, $productkey,$field,$order);
      // lytk_log_message(ROOT . 'debug/logs/', "error", 'tkly --  -- list -- ' . print_r($data['list'], true));

      $data['list_city'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
      $data['pagination']    = $this->pagination->create_links();           
      $data['message'] = $this->pre_message;           
      $this->_templates['page'] = 'products/list';
      $this->templates->load($this->_templates['page'],$data);
  }
  //*****************************
  function add(){
   	if(file_exists(ROOT."adminsystemcpanelwebsite/config/config_price_". $this->user_id.".php")){
      	$this->load->config("config_price_".$this->user_id);
        $data["user_idPrice"]  	= $this->config->item("user_id");
      	$data["addPrice"]  		= $this->config->item("addPrice");
     	$data["editPrice"]  	= $this->config->item("editPrice");
  	 }else{
  	 	$data["user_idPrice"]  = "";
      	$data["addPrice"]     = "";
     	$data["editPrice"]    = "";
  	 }
  	 
  	 
      $data['title'] = 'Thêm mới sản phẩm';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'product/shop/listproduct';      
      $data['list_type'] = $this->shop->get_all_attr();
      $data['listmanufacture'] = $this->shop->get_all_manufacture();
      $data['listcat'] = $this->shop->get_main_cat();
      $data['listcolor'] = $this->shop->get_list_color();
      $data['listcity']  = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
      $this->form_validation->set_rules('productname','Tên sản phẩm','required');
      $this->form_validation->set_rules('mieuta','','');
      $this->form_validation->set_rules('baiviet','','');     
      $this->form_validation->set_rules('video','','');
      $this->form_validation->set_rules('phukien','','');
      $this->form_validation->set_rules('soluong','','');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          if($id = $this->shop->save_product_add()){
              $catid = $this->input->post('catid');
              $productname = $this->input->post('productname');
              write_log(62,186,'Thêm mới sản phẩm: '.$productname); 
              $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                    $url = 'product/shop/listproduct/'.$catid.'/25';
                }else{
                    $url = 'product/shop/edit/'.$id;
                }
                redirect($url);
          }else{
              $this->pre_message = 'Lưu không thành công';
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'products/add';
      $this->templates->load($this->_templates['page'],$data);
  }
  //*****************************
  function edit(){
      $data['title'] = 'Cập nhật sản phẩm';
      $data['title'] = 'Cập nhật';
      $data['save'] = true;
      $data['apply'] = true;
      
   //***********************
     //echo ROOT."admin/config/config_price_". $this->user_id.".php";
   //load config
  	 if(file_exists(ROOT."adminsystemcpanelwebsite/config/config_price_". $this->user_id.".php")){
      	$this->load->config("config_price_".$this->user_id);
        $data["user_idPrice"]  	= $this->config->item("user_id");
      	$data["addPrice"]  		= $this->config->item("addPrice");
     	$data["editPrice"]  	= $this->config->item("editPrice");
  	 }else{
  	 	$data["user_idPrice"]  	= "";
      	$data["addPrice"]     	= "";
     	$data["editPrice"]    	= "";
  	 }
  	 
  	 
      $data['cancel'] = 'product/shop/listproduct/'.$this->uri->segment(5).'/'.$this->uri->segment(6);      
      $productid = (int)$this->uri->segment(4);
      $data['rs'] = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
     

      $listcity  = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
      $data['city_select'] = $listcity[0]->city_id;
      $data['listcity']  = $listcity;
      $data['listmanufacture'] = $this->shop->get_manufacture_by_cat($data['rs']->catid); 
      $data['list_attr'] = $this->shop->get_features_list($data['rs']->catid);
      $data['list_img'] = $this->shop->get_list_img_edit($productid);
      $data['listcat'] = $this->shop->get_main_cat();
      $data['listimgratore'] = $this->vdb->find_by_list('shop_img_rotare',array('productid'=>$productid),array('ordering'=>'asc'));
      $data['listcolor'] = $this->shop->get_list_color();
      
      $this->form_validation->set_rules('productname','Tên sản phẩm','required');
      
      //$this->form_validation->set_rules('productname_en','Tên sản phẩm - en','required');
      $this->form_validation->set_rules('phukien','','');
      $this->form_validation->set_rules('soluong','','');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          if($this->shop->save_product_edit()){
              $this->fcache_model->write_file_hot();
              $this->fcache_model->write_file_muanhieu();
              
              $productname = $this->input->post('productname');
              write_log(62,187,'Cập nhật sản phẩm: '.$productname); 
              $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'product/shop/listproduct/'.(int)$this->uri->segment(5).'/'.(int)$this->uri->segment(6);
                }else{
                    $url = uri_string();
                }
                redirect($url);
          }else{
              $this->pre_message = 'Lưu không thành công';
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'products/edit';
      $this->templates->load($this->_templates['page'],$data);
  }
  
  // Gia san pham theo TInh, Thanh pho
  function getprice(){
      $city_id = $this->input->post('city_id');
      $productid = $this->input->post('productid');
      $data['rs'] = $this->vdb->find_by_id('shop_price',array('productid'=>$productid,'city_id'=>$city_id));
      if($data['rs']){
          $data['tangpham'] = $this->vdb->find_by_list('shop_gifts',array('productid'=>$productid,'city_id'=>$city_id),array('dateend'=>'asc'));
          $this->_templates['page'] = 'products/price/edit';  
      }else{
          $this->_templates['page'] = 'products/price/add';    
      }
      $this->load->view($this->_templates['page'],$data);
  }
  
  function save_price(){
       $productid = $this->input->post('productid');
       $giaban = str_replace('.','',$this->input->post('giaban'));
       $giamgia = str_replace('.','',$this->input->post('giamgia'));
       $giathitruong = str_replace('.','',$this->input->post('giathitruong'));
       $phantram = $this->input->post('per_miennam');
       $tinhtrang = $this->input->post('tinhtrang_miennam');
       $tinhtrang_text = $this->input->post('tinhtrang_miennam_text');
       $vat = $this->input->post('vat');
       $city_id = (int)$this->input->post('city_id');
       
       if($city_id != 0){
           $city = $this->vdb->find_by_id('city',array('city_id'=>$city_id));
           $check = $this->vdb->find_by_id('shop_price',array('productid'=>$productid,'city_id'=>$city_id));
           if($check){
               //$vdata['productid'] = $productid;
               $vdata['giathitruong'] = $giathitruong;
               $vdata['giamgia'] = $giamgia;
               $vdata['giaban'] = $giaban;
               $vdata['phantram'] = $phantram;
               $vdata['tinhtrang'] = $tinhtrang;
               $vdata['tinhtrang_text'] = $tinhtrang_text;
               //$vdata['city_id'] = $city_id;
               $vdata['vat'] = $vat;
               $vdata['lastupdate'] = time();
               $this->vdb->update('shop_price',$vdata,array('productid'=>$productid,'city_id'=>$city_id));
               $data['msg'] = "Cập nhật giá Tỉnh, Thành phố: <b>".$city->city_name.'</b> thành công';
           }else{
               $vdata['productid'] = $productid;
               $vdata['giathitruong'] = $giathitruong;
               $vdata['giamgia'] = $giamgia;
               $vdata['giaban'] = $giaban;
               $vdata['phantram'] = $phantram;
               $vdata['tinhtrang'] = $tinhtrang;
               $vdata['tinhtrang_text'] = $tinhtrang_text;
               $vdata['city_id'] = $city_id;
               $vdata['vat'] = $vat;
               $vdata['lastupdate'] = time();
               $this->vdb->update('shop_price',$vdata); 
               $data['msg'] = "Thêm mới giá Tỉnh, Thành phố: <b>".$city->city_name.'</b> thành công';
           }
           $this->fcache_model->write_file_hot();
           $this->fcache_model->write_file_muanhieu();
           $this->db->delete('shop_gifts',array('productid'=>$productid,'city_id'=>$city_id));
           $tangpham_miennam_name = $this->input->post('tangpham_miennam_name');

           for($i = 0; $i < sizeof($tangpham_miennam_name); $i++){
                if($tangpham_miennam_name[$i]){
                    $vdatas['productid'] = $productid;
                    $vdatas['name'] = $tangpham_miennam_name[$i];
                    $vdatas['city_id'] = $city_id;
                    $this->vdb->update('shop_gifts',$vdatas);
                }
           }
           $data['error'] = 0;
       }else{
           $data['error'] = 1;
           $data['msg'] = 'Vui lòng chọn Tỉnh, Thành phố';
       }
       $data['city_id'] = $city_id;
       echo json_encode($data);
  }
  
  //*****************************
  function get_feature_add(){
      $catid = $this->input->post('catid');
      $data['list_attr'] = $this->shop->get_features_list($catid);
      $this->_templates['page'] = 'products/features/add';
      $this->load->view($this->_templates['page'],$data);
  }
  //*****************************
  function get_feature_edit(){
      $catid = $this->input->post('catid');
      $data['productid'] = $this->input->post('productid');
      $data['list_attr'] = $this->shop->get_features_list($catid);
      $this->_templates['page'] = 'products/features/add';
      $this->load->view($this->_templates['page'],$data);
  } 
  //*****************************
  function save_ajax(){
      $vprice['giathitruong'] = str_replace('.','',$this->input->post('giathitruong'));
      $vprice['giaban'] = str_replace('.','',$this->input->post('giaban'));
      $vprice['giamgia'] = str_replace('.','',$this->input->post('giamgia'));
      $vprice['phantram'] = ($vprice['giamgia'] * 100)/ $vprice['giathitruong'];
      $vprice['tinhtrang'] =$this->input->post('tinhtrang');
      $vprice['thutu'] =$this->input->post('thutu');
      
      $vproduct['sphot'] =$this->input->post('sphot');
      $vproduct['spmoi'] =$this->input->post('spmoi');
      $vproduct['spkhuyenmai'] =$this->input->post('spkhuyenmai');
      $vproduct['home'] = (int)$this->input->post('home');
      
      $productid = $this->input->post('productid');
      $city_id = $this->input->post('city_id');
      
      if($this->vdb->update('shop_product',$vproduct,array('productid'=>$productid))){
          $this->vdb->update('shop_price',$vprice,array('productid'=>$productid,'city_id'=>$city_id));
          
          $data['msg'] = 'Lưu thành công';
      }else{
          $data['msg'] = 'Lưu không thành công';
      }
      echo json_encode($data);
  }

  // Xoa 1 ban ghi
  function delproduct(){
    $id 	= $this->uri->segment(4);
    $uri4 	= $this->uri->segment(5);
    $uri5 	= $this->uri->segment(6);
    $sp = $this->vdb->find_by_id('shop_product',array('productid'=>$id))->productname;   
    if($this->shop->delete_product($id)){
        write_log(62,189,'Xóa sản phẩm: '.$sp); 
        $this->session->set_flashdata('message','Đã xóa thành công');
    }else{
        $this->session->set_flashdata('message','Xóa không thành công');
    }
    redirect('product/shop/listproduct/'.$uri4.'/'.$uri5);
  }
  // Xoa nhieu ban ghi
  function delsproduct(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $catid = (int)$this->input->post('catid');
            $city_id = (int)$this->input->post('city_id');
         
            $ar_id = $this->input->post('ar_id');
            
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $sp = $this->vdb->find_by_id('shop_product',array('productid'=>$ar_id[$i]))->productname;   
                    if($this->shop->delete_product($ar_id[$i]))
                    {
                        write_log(62,188,'Xóa sản phẩm: '.$sp);
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }
                    
                    else $this->session->set_flashdata('error','Xóa không thành công');
                }
            }
        }
        redirect('product/shop/listproduct/'.$catid.'/'.$city_id.'/'.$page);
  }
  
  // Danh sách hang san xuat theo danh muc
  function get_manufacture(){
      $catid = $this->input->post('catid');
      $list = $this->shop->get_manufacture_by_cat($catid);
      $data['list'] = '';
      foreach($list as $rs):
        $data['list'] .= '<option value="'.$rs->manufactureid.'">'.$rs->name.'</option>';
      endforeach;
      echo json_encode($data);
  }
              
  /**************************************8
  * Ajax Request
  ----------------------------------*/
  
  function get_list_ajax_attr(){
      $type_id =  (int)$this->input->post('type_id');
      $data['list'] = '';
      if($type_id!=0){
      $list = $this->shop->get_all_attr($type_id);
      if(count($list) > 0){
      $data['list'] .= '<table class="form">';
        foreach($list as $rs):
            $data['list'] .='<tr>';
                $data['list'] .='<td class="label">'.$rs->type_name.'</td>';
                $data['list'] .='<td><input type="text" class="w300" value="" name="value'.$rs->type_id.'"><input type="hidden" value="'.$rs->type_id.'" name="ar_id[]"></td>';
            $data['list'] .='</tr>';
        endforeach;
      $data['list'] .='</table>';
      }
      }
      echo json_encode($data);
  }
  
  // Upload hinh san pham
  
  function uploader(){
        $this->load->helper('img_helper');
        $productid = $this->uri->segment(4);
        $rs = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
        $order = $this->shop->get_max_order_img($productid);
        $ordering = $order + 1;
        $product_img_name = $rs->producturl.'-'.$ordering;
        $dir = ROOT.'alobuy0862779988/templ/';
        $size=$_FILES['uploadfile']['size'];
        if($size>204857600)
        {
            echo "error";
            unlink($_FILES['uploadfile']['tmp_name']);
        }            
        $filename = stripslashes($_FILES['uploadfile']['name']);

        $extension = end(explode('.',$filename));                 
 
        $file_name = $product_img_name.'.'.$extension;
        $filename = $dir.$file_name;

        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $filename)) { 
            vnitResizeImage($filename,ROOT.'alobuy0862779988/0862779988product/500/'.$file_name,500,500);
            vnitResizeImage($filename,ROOT.'alobuy0862779988/0862779988product/300/'.$file_name,300,300);
            vnitResizeImage($filename,ROOT.'alobuy0862779988/0862779988product/190/'.$file_name,190,190);
            vnitResizeImage($filename,ROOT.'alobuy0862779988/0862779988product/80/'.$file_name,80,80);
            vnitResizeImage($filename,ROOT.'alobuy0862779988/0862779988product/40/'.$file_name,40,40);              
            $vimg['productid'] = $productid;
            $vimg['imagepath'] = $file_name;
            $vimg['ordering'] = $ordering;
            $imgid = $this->vdb->update('shop_img',$vimg);
            echo $file_name.'|'.$imgid;
        } else {
            echo 'error';
        }
  }
  
    // Xoa anh san pham
    
    function del_img_product(){
        $imageid = $this->input->post('idimg');
        $rs = $this->vdb->find_by_id('shop_img',array('imageid'=>$imageid));
        unlink(ROOT.'alobuy0862779988/0862779988product/40/'.$rs->imagepath);
        unlink(ROOT.'alobuy0862779988/0862779988product/80/'.$rs->imagepath);
        unlink(ROOT.'alobuy0862779988/0862779988product/190/'.$rs->imagepath);
        unlink(ROOT.'alobuy0862779988/0862779988product/300/'.$rs->imagepath);
        unlink(ROOT.'alobuy0862779988/0862779988product/500/'.$rs->imagepath);
        $this->vdb->delete('shop_img',array('imageid'=>$imageid));
        
    }
    
 
  // Controller Shop - Commnet
  
  function listcomment(){
      $data['title'] = 'Danh sách bình luận';
      write_log(73,236,'Xem danh sách bình luận'); 
      $data['delete'] = icon_dels('product/shop/delscomment');
      $field = $this->uri->segment(5);
      $order = $this->uri->segment(6);          
      $config['suffix'] = '/'.$field.'/'.$order; 
      $config['base_url'] = base_url().'product/shop/listcomment/';
      $config['total_rows']   =  $this->shop->get_num_comment();
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   20;
      $config['uri_segment'] = 4; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->shop->get_all_comment($field,$order,$config['per_page'],$this->uri->segment(4));
      $data['pagination']    = $this->pagination->create_links();           
      $data['message'] = $this->pre_message;    
      
      $this->_templates['page'] ='comment/list';
      $this->templates->load($this->_templates['page'],$data);
  }
  
  function editcomment(){
      $data['title'] = 'Cập nhật bình luận';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'product/shop/listcomment';       
      $data['rs'] = $this->shop->get_comment_by_id($this->uri->segment(4));
      //Form validation
      $this->form_validation->set_rules('fullname','Người gửi bình luận','required');
      $this->form_validation->set_rules('content','Nội dung','required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors();
      }else{
          $id = $this->input->post('commentid');
          $page = $this->input->post('page');
          $com['fullname'] = $this->input->post('fullname');
          $com['title'] = $this->input->post('title');
          $com['content'] = $this->input->post('content');
          $com['published'] = $this->input->post('published');
          if($this->vdb->update('shop_comment',$com,array('commentid'=>$id))){
              write_log(73,237,'Cập nhật bình luận');
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'product/shop/listcomment/'.$page;
                }else{
                    $url = uri_string();
                }
                redirect($url);              
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'comment/edit';
      $this->templates->load($this->_templates['page'],$data);
  }
  // Xoa 1 ban ghi
  function delcomment(){
      $id = $this->uri->segment(4);
      $page = $this->uri->segment(5);
        if($this->shop->delete_comment($id)){
            write_log(73,239,'Xóa bình luận'); 
            $this->session->set_flashdata('message','Đã xóa thành công');
        }
            
        else $this->session->set_flashdata('message','Xóa không thành công');
      redirect('product/shop/listcomment/'.$page);
  }
  // Xoa nhieu ban ghi
  function delscomment(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $title = $this->shop->get_comment_by_id($ar_id[$i])->title; 
                    if($this->shop->delete_comment($ar_id[$i]))  {
                        write_log(73,238,'Xóa bình luận');
                        $this->session->set_flashdata('message','Đã xóa thành công'); 
                    }
                    
                    else $this->session->set_flashdata('error','Xóa không thành công');
                }
            }
        }
        redirect('product/shop/listcomment/'.$page);
  }
  
  /****************
  * Upload Templ 
  */
  
    function uploader_templ(){
        $this->load->helper('img_helper');
        $productid = $this->uri->segment(4);
        if($_FILES["uploadfile"]["size"] > 0){
            $config['upload_path'] = ROOT.'alobuy0862779988/templ/';
            $config['allowed_types'] = 'gif|jpg|png|swf';
            $config['max_size']    = '100000';
            $this->load->library('upload', $config);
            $this->upload->initialize($config);                     
                   
            if ( !$this->upload->do_upload('uploadfile')){
                $this->pre_message =  $this->upload->display_errors();
            }else{                         
                $result =  $this->upload->data();
                echo $file_name = $result['file_name'];               
            }                    
        }
    }
    
    // Ảnh xoay 360 Templ
    function uploader_rotare_tmpl(){
        session_start();
        $dir_rotare = ROOT.'alobuy0862779988/img_rotare_tmpl';  
        $productid = $this->input->post('productid');
        //$rs = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
        $order = $this->shop->get_max_order_img_rotare_tmpl($productid);
        $ordering = $order + 1;
        $product_img_name = 'fyi_vn_'.$productid.'-'.$ordering;
        
        if(!is_dir($dir_rotare.'/'.$productid)){
            mkdir($dir_rotare.'/'.$productid);
            chmod($dir_rotare.'/'.$productid,0777);
        }
        
        $dir = ROOT.'alobuy0862779988/img_rotare_tmpl/'.$productid.'/'; 
        
        $size=$_FILES['Filedata']['size'];
        if($size>204857600)
        {
            echo "error";
            unlink($_FILES['Filedata']['tmp_name']);
        }            
        $filename = stripslashes($_FILES['Filedata']['name']);
        $extension = end(explode('.',$filename));
        $filename = $dir.$product_img_name.'.'.$extension;
        $filename_add = 'data/img_rotare_tmpl/'.$productid.'/'.$product_img_name.'.'.$extension;
        $file_ext = $product_img_name.'.'.$extension;
        if (move_uploaded_file($_FILES['Filedata']['tmp_name'], $filename)) {
            $vimg['productid'] = $productid;
            $vimg['imagepath'] = $filename_add;
            $vimg['ordering'] = $ordering;
            $vimg['random'] = $productid;
            $idimg = $this->vdb->update('shop_img_rotare_temp',$vimg);
                            
            echo $idimg.'|'.$filename_add.'|'.$ordering;
        } else {
            echo 'error';
        }
        sleep(1);
    } 

    public function globalsettings(){
        $data['title'] = 'Thiết lập cho webiste';

        $this->form_validation->set_rules('itemcategory','Số lượng sản phẩm hiện thị mỗi category ở trang chủ','required');       
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            // delete old data
            $this->shop->deleteGlobalSettings(); 
            // insert new data
            $aVals = array(
                'itemcategory' => $this->input->post('itemcategory'), 
                'linkfacebook' => $this->input->post('linkfacebook'), 
                'linkgoogleplus' => $this->input->post('linkgoogleplus'), 
                'linkyoutube' => $this->input->post('linkyoutube'), 
                'accountskype' => $this->input->post('accountskype'), 
                'accountyahoo' => $this->input->post('accountyahoo'), 
            );
            $id = $this->shop->addGlobalSettings($aVals);
        }

        $aGlobalSetting = $this->shop->getGlobalSettings();        
        if(count($aGlobalSetting) > 0){
          $aGlobalSetting = $aGlobalSetting[0];
          $aGlobalSetting->data = (array)json_decode($aGlobalSetting->data);
          $data['aGlobalSetting'] = $aGlobalSetting;
        }

        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'products/globalsettings';
        $this->templates->load($this->_templates['page'],$data);      
    }
}
