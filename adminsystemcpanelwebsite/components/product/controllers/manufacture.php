<?php
class manufacture extends CI_Controller{
  protected $_templates;
  function __construct(){
      parent::__construct();
      $this->pre_message = "";
      $this->uri3 = $this->uri->segment(3);
      $this->uri4 = $this->uri->segment(4);        
      $this->load->model('manufacture_model','manufacture');
      $this->load->helper('img');

  }
  
  function index(){
      $this->listmanufacture();
  }
  
  function listmanufacture(){
      $data['title'] = 'Danh sách nhà sản xuất';
      write_log(65,200,'Xem danh sách nhà sản xuất');
      $data['delete'] = icon_dels('product/manufacture/dels');
      $data['add'] = 'product/manufacture/add|'.icon_add('product/manufacture/add');
      $field = $this->uri->segment(5);
      $order = $this->uri->segment(6);          
      $config['suffix'] = '/'.$field.'/'.$order;          
      $config['base_url'] = base_url().'product/manufacture/listmanufacture/';  
      $config['total_rows']   =  $this->manufacture->get_num_manufacture();
      $data['num'] = $config['total_rows'];
      $data['page_m'] = $this->uri->segment(4);
      $config['per_page']  =   20;
      $config['uri_segment'] = 4; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->manufacture->get_all_manufacture($field,$order,$config['per_page'],$this->uri->segment(4));
      $data['pagination']    = $this->pagination->create_links();           
      $data['message'] = $this->pre_message;          
      $this->_templates['page'] = 'manufacture/list';
      $this->templates->load($this->_templates['page'],$data);
  }
  
  function add(){
      $data['title'] = 'Thêm mới';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'product/manufacture/listmanufacture';      
      $this->form_validation->set_rules('nsx[name]','Tên nhà sản xuất','trim|required');
      $this->form_validation->set_rules('nsx[images_root]','',''); 
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors();
      }else{
          $nsx = $this->input->post('nsx');
          $nsx['name_url'] = vnit_change_title($nsx['name']);

          if(isset($_FILES['userfile'])){
                $config['upload_path'] = ROOT.'data/templ/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']    = '1000';
                $config['max_width']  = '1024';
                $config['max_height']  = '768'; 
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload()){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $file_name = $result['file_name'];
                    
                    $filetype = end(explode('.',$file_name));
                    $filename = strtolower(vnit_change_title($nsx['name']));
                    $img_new = $filename.'.'.$filetype;
                    $this->load->helper('img_helper');
                    vnit_resize_image(ROOT.'data/templ/'.$file_name,ROOT.'data/img_manufacture/'.$img_new,80,40,true);
                    $nsx['images_small'] = $img_new;                  
                }                    
          }
            
          if($id = $this->vdb->update('shop_manufacture',$nsx)){
              write_log(65,201,'Thêm manufacture: '.$nsx['name']);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'product/manufacture/listmanufacture/';
                }else{
                    $url = 'product/manufacture/edit/'.$id;
                }
                redirect($url);
          }else{
              $this->pre_message  = 'Lưu không thành công';
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'manufacture/add';
      $this->templates->load($this->_templates['page'],$data);
  }
  function edit(){
      $page = $this->uri->segment(5);
      $data['title'] = 'Cập nhật';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'product/manufacture/listmanufacture/'.$page;          
      
      $data['rs'] = $this->manufacture->get_manufacture_by_id($this->uri4);
      $this->form_validation->set_rules('nsx[name]','Tên nhà sản xuất','trim|required');
      $this->form_validation->set_rules('nsx[images_root]','',''); 
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors();
      }else{
            $id = $this->input->post('id');
            $nsx = $this->input->post('nsx');
            $img_old = $this->input->post('img_old');
            $nsx['name_url'] = vnit_change_title($nsx['name']);
            //$nsx['name'] = $this->input->post('name');
            if(isset($_FILES['userfile'])){
                $config['upload_path'] = ROOT.'data/templ/';
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']    = '1000';
                $config['max_width']  = '1024';
                $config['max_height']  = '768'; 
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload()){
                    $this->pre_message =  $this->upload->display_errors();
                    $this->session->set_flashdata('message',$this->pre_message);
                    redirect(uri_string());
                }else{                         
                    $result =  $this->upload->data();
                    $file_name = $result['file_name'];
                    
                    $filetype = end(explode('.',$file_name));
                    $filename = strtolower(vnit_change_title($nsx['name']));
                    $img_new = $filename.'.'.$filetype;
                    if($img_old != ''){
                        if(file_exists(ROOT.'data/img_manufacture/'.$img_old)){
                            unlink(ROOT.'data/img_manufacture/'.$img_old);
                        }
                    }
                    $this->load->helper('img_helper');
                    vnit_resize_image(ROOT.'data/templ/'.$file_name,ROOT.'data/img_manufacture/'.$img_new,80,40,true);
                    $nsx['images_small'] = $img_new;                  
                }                    
            }else{
                $nsx['images_small'] = $this->input->post('img_old');
            } 
          
          
          if($this->vdb->update('shop_manufacture',$nsx,array('manufactureid'=>$id))){
                $ten_nsx = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$id))->name;
                write_log(65,202,'Cập nhât nhà sản xuất: '.$ten_nsx);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'product/manufacture/listmanufacture/'.$page;
                }else{
                    $url = uri_string();
                }
                redirect($url);              
          }else{
              $this->pre_message  = 'Lưu không thành công';
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'manufacture/edit';
      $this->templates->load($this->_templates['page'],$data);
  }
  
  // Xoa 1 ban ghi
  function del(){
      $id = $this->uri->segment(4);
      $page = $this->uri->segment(5);
      $mn = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$id))->name;
        if($this->manufacture->delete($id)){
            write_log(65,204,'Xóa nhà sản xuất: '.$mn);
            $this->session->set_flashdata('message','Đã xóa thành công'); 
        }else{
            $this->session->set_flashdata('message','Xóa không thành công');
        }
      redirect('product/manufacture/listmanufacture/'.$page);
  }
  // Xoa nhieu ban ghi
  function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $mn = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$ar_id[$i]))->name; 
                    if($this->manufacture->delete($ar_id[$i])){
                        write_log(65,203,'Xóa nhà sản xuất: '.$mn);
                        $this->session->set_flashdata('message','Đã xóa thành công');    
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('product/manufacture/listmanufacture/'.$page);
  }            
}
