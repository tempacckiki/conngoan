<?php
class shop extends CI_Controller{
  protected $_templates;
  function __construct(){
      parent::__construct();
      $this->pre_message = "";
      $this->load->helper('img_helper');
      $this->load->model('shop_model','shop');
      $this->mainmenu = 'sandaugia';
      $js_array = array(
            array(base_url().'components/daugia/views/esset/daugia.js')
      );
      $this->esset->js($js_array);
      $this->group_id = $this->session->userdata('group_id');
      $this->user_id = $this->session->userdata('user_id');
  }

  // Danh sach san pham
  function listproduct(){
      $data['title'] = 'Danh sách sản phẩm';
      $data['add'] = 'daugia/shop/add';
      $data['delete'] = true;
      
      $catid = (int)$this->uri->segment(4);
      $field = $this->uri->segment(5);
      $order = $this->uri->segment(6);          
      $config['suffix'] = '/'.$field.'/'.$order;
      
      $config['base_url'] = base_url().'daugia/shop/listproduct/'; 
      $config['total_rows']   =  $this->shop->get_num_product($catid);
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   10;
      $config['uri_segment'] = 4; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->shop->get_all_product($catid,$field,$order,$config['per_page'],$this->uri->segment(4));
      $data['pagination']    = $this->pagination->create_links();           
      $data['message'] = $this->pre_message;           
      $this->_templates['page'] = 'products/list';
      $this->templates->load($this->_templates['page'],$data);
  }
  
  function add(){
      $data['title'] = 'Thêm mới sản phẩm';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'daugia/shop/listproduct';      

      $data['listmanufacture'] = $this->shop->get_all_manufacture();

      $this->form_validation->set_rules('sp[barcode]','Mã hàng','required');
      $this->form_validation->set_rules('sp[productname]','Tên sản phẩm - vi','required');
      $this->form_validation->set_rules('sp_en[productname]','Tên sản phẩm - en','');
      $this->form_validation->set_rules('sp[manufactureid]','Nhà sản xuất','required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          if($id = $this->shop->save_product()){
              $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'daugia/shop/listproduct/';
                }else{
                    $url = 'daugia/shop/edit/'.$id;
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
  
  function edit(){
      $data['title'] = 'Cập nhật sản phẩm';
      $data['title'] = 'Cập nhật';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'daugia/shop/listproduct';      
      $productid = (int)$this->uri->segment(4);
      $data['rs'] = $this->shop->get_product_by_id($productid);
     // $data['rs_en'] = $this->shop->get_product_by_id($productid,'_en');
       
      $data['listmanufacture'] = $data['listmanufacture'] = $this->shop->get_all_manufacture();
      $data['list_img'] = $this->shop->get_list_img_edit($productid);

      
      $this->form_validation->set_rules('sp[barcode]','Mã hàng','required');
      $this->form_validation->set_rules('sp[productname]','Tên sản phẩm - vi','required');
      $this->form_validation->set_rules('sp_en[productname]','Tên sản phẩm - en','');
      $this->form_validation->set_rules('sp[manufactureid]','Nhà sản xuất','required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          if($this->shop->save_product()){
              $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'daugia/shop/listproduct/';
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

  function del_img(){
      $this->load->helper('file');
      $idimg = $this->input->post('idimg');
      $rs = $this->vdb->find_by_id('product_bid_img',array('imageid'=>$idimg));
      if($this->vdb->delete('product_bid_img',array('imageid'=>$idimg))){
          if(file_exists(ROOT_IMG.'daugia/200/'.$rs->imagepath)){
              unlink(ROOT_IMG.'daugia/200/'.$rs->imagepath);
              $data['msg1'] = 'Xóa file 1 thnah cong';
          }else{
              $data['error1'] = 'File 1 không ton tai';
          }

          $data['error'] = 0;
      }else{
          $data['error'] = 1;
      }
      echo json_encode($data);
  }
  
  function uploader_edit(){
  		$this->load->helper('img_helper');
        $productid = $this->uri->segment(4);
        $rs = $this->vdb->find_by_id('product_bid',array('productid'=>$productid));
        $product_url = $rs->producturl;
        $order = $this->shop->get_max_order_img($productid);
        $ordering = $order + 1;
        $product_img_name = $product_url.'-'.$ordering;    
        $dir = ROOT.'alobuy0862779988/daugia/full_images/';
        $size=$_FILES['uploadfile']['size'];
        if($size>204857600)
        {
                echo "file_biger";
                unlink($_FILES['uploadfile']['tmp_name']);
                //exit;
        }            
        $filename = stripslashes($_FILES['uploadfile']['name']);
        $extension = strtolower(end(explode('.',$filename)));

  
        $file_name_new = $dir.$product_img_name.'.'.$extension;
        $file_ext = $product_img_name.'.'.$extension;
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file_name_new)) {
            vnit_resize_image($file_name_new,ROOT.'alobuy0862779988/daugia/200/'.$file_ext,220,180); 
          //  vnitResizeImage($filename,ROOT.'alobuy0862779988/daugia/200/'.$file_name,500,500);
           
            $vdata['productid'] = $productid;
            $vdata['imagepath'] = $file_ext;
            $vdata['ordering'] = $ordering;
            $imageid = $this->vdb->update('product_bid_img',$vdata);
            echo $file_ext.'|'.$imageid;
        } else {
            echo 'error';
        }
  }
  

  // Xoa 1 ban ghi
  function del(){
      $id = $this->uri->segment(4);
      $uri4 = $this->uri->segment(5);
      $uri5 = $this->uri->segment(6);
      $check = $this->vdb->find_by_id('bid_list',array('productid'=>$id));
      if(!$check){
          if($this->group_id == 18){
              if($this->shop->delete_product($id)){
                  $this->session->set_flashdata('message','Đã xóa thành công');
              }else{
                  $this->session->set_flashdata('message','Xóa không thành công');
              } 
          }else{
              if($this->shop->delete_product_status($id)){
                  $this->session->set_flashdata('message','Đã xóa thành công');
              }else{
                  $this->session->set_flashdata('message','Xóa không thành công');
              }
          }
      }else{
          $this->session->set_flashdata('message','Sản phẩm này đã tồn tại trong Phiên đấu giá. Không thể xóa');
      }
      redirect('daugia/shop/listproduct/'.$uri4.'/'.$uri5);
  }
  // Xoa nhieu ban ghi
  function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $catid = (int)$this->input->post('catid');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $check = $this->vdb->find_by_id('bid_list',array('productid'=>$ar_id[$i]));
                    if(!$check){
                        if($this->group_id == 18){ 
                            if($this->shop->delete_product($ar_id[$i])){
                                $this->session->set_flashdata('message','Đã xóa thành công');
                            }else{
                                $this->session->set_flashdata('error','Xóa không thành công');
                            }
                        }else{
                            if($this->shop->delete_product_status($ar_id[$i])){
                                $this->session->set_flashdata('message','Đã xóa thành công');
                            }else{
                                $this->session->set_flashdata('error','Xóa không thành công');
                            } 
                        }
                    }else{
                        $this->session->set_flashdata('message','Sản phẩm đã tồn tại trong Phiên đấu giá. Không thể xóa');
                    }
                }

            }
        }
        redirect('daugia/shop/listproduct/'.$catid.'/'.$page);
  }
  
  /****************
   * Upload Templ
  */
  
 
  
  // Upload hinh san pham
  function uploader_templ(){
  	$productid = $this->uri->segment(4);
  	if($_FILES["uploadfile"]["size"] > 0){
  		$config['upload_path'] = ROOT.'alobuy0862779988/daugia/full_images/';
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
  
  
  // Xoa anh san pham
  
  function del_img_product(){
  	$imageid = $this->input->post('idimg');
  	$rs = $this->vdb->find_by_id('product_bid_img',array('id'=>$imageid));
  	unlink(ROOT.'alobuy0862779988/0862779988product/40/'.$rs->imagepath);
  	$this->vdb->delete('product_bid_img',array('id'=>$imageid));
  
  }
  
}
