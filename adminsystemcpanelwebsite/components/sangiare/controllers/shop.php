<?php
class shop extends CI_Controller{
  protected $_templates;
  function __construct(){
      parent::__construct();
      $this->pre_message = "";
      $this->load->helper('img_helper');
      $this->load->model('shop_model','shop');
      $js_array = array(
            array(base_url().'components/product/views/esset/add_product.js')
      );
      $this->esset->js($js_array);
      $this->group_id = $this->session->userdata('group_id');
      $this->user_id = $this->session->userdata('user_id');
  }
  
  function index(){
      
  }

  // Danh sach san pham
  function listproduct(){
      $data['title'] = 'Danh sách sản phẩm';
      $data['add'] = 'sangiare/shop/add';
      $data['delete'] = true;
      $data['listcat'] = $this->shop->get_main_cat(); 
      $catid = (int)$this->uri->segment(4);
      $field = $this->uri->segment(6);
      $order = $this->uri->segment(7);          
      $config['suffix'] = '/'.$field.'/'.$order;
      
      $config['base_url'] = base_url().'product/shop/listproduct/'.$catid; 
      $config['total_rows']   =  $this->shop->get_num_product($catid);
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   20;
      $config['uri_segment'] = 5; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->shop->get_all_product($catid,$field,$order,$config['per_page'],$this->uri->segment(5));
      $data['pagination']    = $this->pagination->create_links();           
      $data['message'] = $this->pre_message;           
      $this->_templates['page'] = 'products/list';
      $this->templates->load($this->_templates['page'],$data);
  }
  
  function add(){
      $data['title'] = 'Thêm mới sản phẩm';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'sangiare/shop/listproduct';      
      $data['list_type'] = $this->shop->get_all_attr();
      $data['listmanufacture'] = $this->shop->get_all_manufacture();
      $data['listcat'] = $this->shop->get_main_cat();
      $this->form_validation->set_rules('sp[barcode]','Mã hàng','required');
      $this->form_validation->set_rules('sp[productname]','Tên sản phẩm - vi','required');
      $this->form_validation->set_rules('sp_en[productname]','Tên sản phẩm - en','required');
      $this->form_validation->set_rules('sp[manufactureid]','Nhà sản xuất','required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          if($id = $this->shop->save_product()){
              $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sangiare/shop/listproduct/';
                }else{
                    $url = 'sangiare/shop/edit/'.$id;
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
      $data['cancel'] = 'sangiare/shop/listproduct';      
      $productid = (int)$this->uri->segment(4);
      $data['rs'] = $this->shop->get_product_by_id($productid);
      $data['rs_en'] = $this->shop->get_product_by_id($productid,'_en');
       
      $data['listmanufacture'] = $this->shop->get_manufacture_by_cat($data['rs']->catid); 
      $data['list_attr'] = $this->shop->get_features_list($data['rs']->catid);
      $data['list_img'] = $this->shop->get_list_img_edit($productid);
      $data['list_type'] = $this->shop->get_all_attr();
      $data['listcat'] = $this->shop->get_main_cat();
      
      $data['tangpham_miennam'] = $this->vdb->find_by_list('shop_gifts',array('productid'=>$productid,'local'=>1));
      $data['tangpham_mienbac'] = $this->vdb->find_by_list('shop_gifts',array('productid'=>$productid,'local'=>0));
      
      $this->form_validation->set_rules('sp[barcode]','Mã hàng','required');
      $this->form_validation->set_rules('sp[productname]','Tên sản phẩm - vi','required');
      $this->form_validation->set_rules('sp_en[productname]','Tên sản phẩm - en','required');
      $this->form_validation->set_rules('sp[manufactureid]','Nhà sản xuất','required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          if($this->shop->save_product()){
              $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sangiare/shop/listproduct/';
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
  
  function save_ajax(){
      $vdata['giathitruong_miennam'] = str_replace(',','',$this->input->post('giathitruong_miennam'));
      $vdata['giaban_miennam'] = str_replace(',','',$this->input->post('giaban_miennam'));
      $vdata['giamgia_miennam'] = str_replace(',','',$this->input->post('giamgia_miennam'));
      $vdata['giathitruong_mienbac'] = str_replace(',','',$this->input->post('giathitruong_mienbac'));
      $vdata['giaban_mienbac'] = str_replace(',','',$this->input->post('giaban_mienbac'));
      $vdata['giamgia_mienbac'] = str_replace(',','',$this->input->post('giamgia_mienbac'));
      $vdata['tinhtrang_mienbac'] =$this->input->post('tinhtrang_mienbac');
      $vdata['tinhtrang_miennam'] =$this->input->post('tinhtrang_miennam');
      $vdata['thutu_mienbac'] =$this->input->post('thutu_mienbac');
      $vdata['thutu_miennam'] =$this->input->post('thutu_miennam');
      
      $vdata['sphot'] =$this->input->post('sphot');
      $vdata['spmoi'] =$this->input->post('spmoi');
      $vdata['spkhuyenmai'] =$this->input->post('spkhuyenmai');
      
      $productid = $this->input->post('productid');
      if($this->vdb->update('shop_product',$vdata,array('productid'=>$productid))){
          $data['msg'] = 'Lưu thành công';
      }else{
          $data['msg'] = 'Lưu không thành công';
      }
      echo json_encode($data);
  }
  

  // Xoa 1 ban ghi
  function del(){
      $id = $this->uri->segment(4);
      $uri4 = $this->uri->segment(5);
      $uri5 = $this->uri->segment(6);
      $check = $this->vdb->find_by_id('cheap_list',array('productid'=>$id));
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
          $this->session->set_flashdata('message','Sản phẩm này đã tồn tại trong Phiên mua rẻ. Không thể xóa');
      }
      redirect('sangiare/shop/listproduct/'.$uri4.'/'.$uri5);
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
                    $check = $this->vdb->find_by_id('cheap_list',array('productid'=>$ar_id[$i]));
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
                        $this->session->set_flashdata('message','Sản phẩm đã tồn tại trong Phiên mua rẻ. Không thể xóa');
                    }
                }

            }
        }
        redirect('sangiare/shop/listproduct/'.$catid.'/'.$page);
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
              
  /***************
  * Ajax Request
  */
  
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
        $ProductID = $this->uri->segment(3);
        $session_info = $this->session->userdata('session_id');
        $dir = ROOT.'data/shop/product/500/';
        $dir_admin = 'data/shop/product/500/';
        //chmod($uploaddir,0777);
        $size=$_FILES['uploadfile']['size'];
        if($size>204857600)
        {
                echo "file_biger";
                unlink($_FILES['uploadfile']['tmp_name']);
                //exit;
        }            
        $filename = stripslashes($_FILES['uploadfile']['name']);
        $i = strrpos($filename,".");
        if (!$i) { return ""; }
        $l = strlen($filename) - $i;
        $extension = substr($filename,$i+1,$l);                 
        $extension = strtolower($extension); 
        $file_name = str_replace($extension,'',$filename);
        $name = time();
        $filename = $dir.$name.'.'.$extension;
        $file_ext = $name.'.'.$extension;
        if (move_uploaded_file($_FILES['uploadfile']['tmp_name'], $filename)) {              
            echo $file_ext;
        } else {
            echo 'error';
        }
  } 
}
