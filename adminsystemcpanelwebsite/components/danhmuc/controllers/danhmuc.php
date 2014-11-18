<?php
require_once (ROOT . 'debug/debug.php');

class danhmuc extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('danhmuc_model','danhmuc');
        $this->load->model('nhomhang_model','nhomhang', false, CODEIGNITER_ADMIN_DIR . 'components/nhomhang/models/');

        $this->load->model('vcache_model','vcache');  
        $this->pre_message = "";
        $this->load->helper('file');
        $this->nhomhang->create_menu();

    }
    
    function ds(){
      $this->vcache->tab(); 
      $data['title'] = 'Danh mục sản phẩm';
      write_log(64,195,'Xem danh mục sản phẩm'); 
      $data['delete'] = icon_dels('danhmuc/dels');
      $data['add'] = 'danhmuc/add|'.icon_add('danhmuc/add');
      $maincat = (int)$this->uri->segment(3);
      $data['listmaincat'] = $this->danhmuc->get_main_cat(0); 
      $data['list'] = $this->danhmuc->get_main_cat($maincat);   
      $data['num'] = count($data['list']);     
      $data['message'] = $this->pre_message;          
      $this->_templates['page'] = 'index';
      $this->templates->load($this->_templates['page'],$data);
    }
    
    function get_subcat(){
        $maincat = $this->uri->segment(3);
        $rs = $this->vdb->find_by_id('shop_cat',array('catid'=>$maincat));
        $data['title'] = 'Danh mục thuộc nhóm hàng: '.$rs->catname;
        $data['add'] = 'danhmuc/add/'.$rs->catid;
        $data['delete'] = true;
        $data['listmaincat'] = $this->danhmuc->get_main_cat(0);
        $data['list'] = $this->danhmuc->get_main_cat($maincat);  
        $this->_templates['page'] = 'sub_index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    // Them moi chuyen muc

    function add(){
      $data['maincat'] = $this->uri->segment(4);
      $data['subcat'] = $this->uri->segment(3);
      $data['title'] = 'Thêm mới';
      $data['save'] = true;
      $data['apply'] = true;
      if($data['subcat'] != ''){
          $data['cancel'] = 'danhmuc/get_subcat/'.$data['subcat'];
      }else{
          $data['cancel'] = 'danhmuc/ds/';
      }
      $data['listcat'] = $this->danhmuc->get_main_cat();
      $data['listnxs'] = $this->danhmuc->get_all_manufacture();

      // Form validation
      $this->form_validation->set_rules('catname','Tên danh mục','trim|required');
      $this->form_validation->set_rules('catkeyword','','');
      $this->form_validation->set_rules('catdes','','');
      $catname = $this->input->post('catname');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          $page = $this->input->post('page');
          if($id = $this->danhmuc->save_cat()){
              write_log(64,196,'Thêm danh mục sản phẩm: '.$catname); 
              $this->vcache->cat();
              $this->session->set_flashdata('message','Lưu thành công');
              $option =  $this->input->post('option');
              if($option == 'save'){
                  if($data['subcat'] != ''){
                      $url = 'danhmuc/get_subcat/'.$data['maincat'];
                  }else{
                      $url = 'danhmuc/ds/';
                  }
              }else{
                  $url = 'danhmuc/edit/'.$id;
              }
              redirect($url);
          }else{
              $this->pre_message = 'Lưu không thành công';
          }

      }

      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'add';
      $this->templates->load($this->_templates['page'],$data);
    }
    
    // Cap nhat chuyen muc
    function edit(){
      $data['title'] = 'Cập nhật danh mục';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'danhmuc/ds';
      $data['listcat'] = $this->danhmuc->get_main_cat(); 
      $data['rs'] = $this->vdb->find_by_id('shop_cat',array('catid'=>$this->uri->segment(3)));
      $data['rs_en'] = $this->vdb->find_by_id('shop_cat_en',array('catid'=>$this->uri->segment(3)));
      $data['listnxs'] = $this->danhmuc->get_all_manufacture();   
      $data['listcat'] = $this->danhmuc->get_main_cat();
      // Form validation
      $this->form_validation->set_rules('catname','Tên danh mục','trim|required');
      $this->form_validation->set_rules('catkeyword','','');
      $this->form_validation->set_rules('catdes','','');
      $catname = $this->input->post('catname');  
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors(); 
      }else{
          $page = $this->input->post('page');
          if($this->danhmuc->save_update_cat()){
              write_log(64,197,'Cập nhật danh mục sản phẩm: '.$catname); 
                $this->vcache->cat();
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                  $data['subcat'] = $this->uri->segment(3);
                  if($data['subcat'] != ''){
                      $url = 'danhmuc/get_subcat/'.$this->uri->segment(4);
                  }else{
                      $url = 'danhmuc/ds/';
                  }
                }else{
                    $url = uri_string();
                }
                redirect($url);
          }else{
              $this->pre_message = 'Lưu không thành công';
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'edit';
      $this->templates->load($this->_templates['page'],$data);
    }
  
    // Xoa 1 ban ghi
    function del(){
        $id = $this->uri->segment(3);
        $page = $this->uri->segment(4);
        $dm = $this->vdb->find_by_id('shop_cat',array('catid'=>$id))->catname;
        if($this->danhmuc->check_subcat($id)){
            if($this->danhmuc->check_product_incat($id)){
                if($this->danhmuc->delete_cat($id)){
                    write_log(64,199,'Xóa danh mục sản phẩm: '.$dm); 
                    $this->vcache->cat();
                    $this->session->set_flashdata('message','Xóa danh mục: <b>'.$dm.'</b> thành công');
                }else{
                    $this->session->set_flashdata('message','Xóa danh mục: <b>'.$dm.'</b>không thành công');
                }
            }else{
                $this->session->set_flashdata('message','Danh mục: <b>'.$dm.'</b> vẫn còn sản phẩm. Không thể xóa');
            }

        }else{
            $this->session->set_flashdata('message','Danh mục: <b>'.$dm.'</b> vẫn tồn tại danh mục con. Không thể xóa');
        }
        redirect('danhmuc/get_subcat/'.$page);
    }
    
    
    function dels(){
        $ar_id = $this->input->post('ar_id');
        $page = $this->input->post('page');
        $msg = '';
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                $dm = $this->vdb->find_by_id('shop_cat',array('catid'=>$ar_id[$i]))->catname;
                if($this->danhmuc->check_subcat($ar_id[$i])){
                    if($this->danhmuc->check_product_incat($ar_id[$i])){
                        if($this->danhmuc->delete_cat($ar_id[$i])){
                            $this->vcache->cat();
                            write_log(64,199,'Xóa danh mục sản phẩm: '.$dm); 
                            $this->session->set_flashdata('message','Xóa danh mục: <b>'.$dm.'</b> thành công');
                        }else{
                            $this->session->set_flashdata('message','Xóa danh mục: <b>'.$dm.'</b>không thành công');
                        }
                    }else{
                        $this->session->set_flashdata('message','Danh mục: <b>'.$dm.'</b> vẫn còn sản phẩm. Không thể xóa');
                    }

                }else{
                    $this->session->set_flashdata('message','Danh mục: <b>'.$dm.'</b> vẫn tồn tại danh mục con. Không thể xóa');
                }
            }
        }
        
        //$this->session->set_flashdata('message',$msg);
        redirect('danhmuc/get_subcat/'.$page);
    }
    
    function change_status(){
        $catid = $this->input->post('catid');
        $thuoctinh = $this->input->post('thuoctinh');
        $giatri = $this->input->post('giatri');
        $vdata[$thuoctinh] = $giatri;
        $this->vdb->update('shop_cat',$vdata,array('catid'=>$catid));
        $this->vcache->tab(); 
    }
    
    // Sap xep nha san xuat theo danh muc
    
    function nsx(){
        $catid = $this->uri->segment(3);
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = base64_decode($this->uri->segment(4));
        $row = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid));
        $data['title'] = 'Sắp xếp Hãng sản xuất theo danh mục: '.$row->catname;
        $data['row'] = $row;
        $data['list'] = $this->danhmuc->get_list_nsx($catid);
        $this->form_validation->set_rules('cat','','');
        if($this->form_validation->run()){
            $catid = $this->input->post('catid');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i++){
                $vdata['ordering'] = $this->input->post('id_'.$ar_id[$i]);
                $this->vdb->update('shop_cat_manufacture',$vdata,array('catid'=>$catid,'manufactureid'=>$ar_id[$i]));
            }
            $this->session->set_flashdata('message','Lưu thành công');
            $option =  $this->input->post('option');
            if($option == 'save'){
                $url = base64_decode($this->uri->segment(4));
            }else{
                $url = uri_string();
            }
            redirect($url);
        }
        $this->_templates['page'] = 'nsx';
        $this->templates->load($this->_templates['page'],$data);
    }
}