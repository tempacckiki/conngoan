<?php
class nhomhang extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('nhomhang_model','nhomhang');
        $this->load->model('vcache_model','vcache');
        $this->pre_message = "";
        $this->load->helper('file');
    }
    
    function dsnhomhang(){
        $data['title'] = 'Danh sách nhóm hàng';
        write_log(63,190,'Xem danh sách nhóm hàng'); 
        $maincat = (int)$this->uri->segment(4);
        $data['delete'] = icon_dels('nhomhang/dels');
        $data['add'] = 'nhomhang/add|'.icon_add('nhomhang/add');
        $this->nhomhang->create_menu();
        $this->vcache->tab();
        $field = $this->uri->segment(5);
        $order = $this->uri->segment(6);          
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'shop/listcat/'.$maincat;  
        $config['total_rows']   =  $this->nhomhang->get_num_nhomhang();
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 5; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->nhomhang->get_all_nhomhang($config['per_page'],$this->uri->segment(5),$field,$order);
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message;          
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    // Them moi nhom hang
    function add(){
        $data['title'] = 'Thêm mới nhóm hàng';
        $data['apply'] = true;
        $data['save'] = true;                
        $data['cancel'] = 'nhomhang/dsnhomhang';
        // Form validation
        $this->form_validation->set_rules('catname','Tên nhóm hàng','trim|required');

        $this->form_validation->set_rules('cat[ordering]','Sắp xếp','trim|required');
        $this->form_validation->set_rules('cat[parentid]','','');
        $this->form_validation->set_rules('cat[catkeyword]','','');
        $this->form_validation->set_rules('cat[catdes]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $page = $this->input->post('page'); 
            $cat = $this->input->post('cat');
            $catname = $this->input->post('catname');
            $catname_en = $this->input->post('catname_en');
            $cat['catname'] = $catname;
            $cat['caturl'] = vnit_change_title($catname);
            
            /*$cat_en['catname'] = $catname_en;
            $cat_en['caturl'] = vnit_change_title($catname_en);
            $cat_en['ordering'] = $cat['ordering'];
            $cat_en['ishome'] = $cat['ishome'];
            $cat_en['istab'] = $cat['istab'];
            $cat_en['ismenuleft'] = $cat['ismenuleft'];
            $cat_en['nolink'] = $cat['nolink'];
            $cat_en['catkeyword'] = $cat['catkeyword'];
            $cat_en['catdes'] = $cat['catdes'];
            $cat_en['published'] = $cat['published']; */
            if($catid = $this->vdb->update('shop_cat',$cat)){
                write_log(63,191,'Thêm nhóm hàng: '.$catname); 
                //$cat_en['catid'] = $catid;
                //$this->vdb->update('shop_cat_en',$cat_en);
                $this->session->set_flashdata('message','Thêm mới thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'nhomhang/dsnhomhang/';
                }else{
                    $url = 'nhomhang/edit/'.$catid;
                }
                redirect($url);
            }else{
                $this->pre_message = 'Thêm mới không thành công';
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'nhomhang/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    // Cap nhat nhom hang
    
    function edit(){
        $data['title'] = 'Cập nhật nhóm hàng';
        $data['apply'] = true;
        $data['save'] = true;                
        $data['cancel'] = 'nhomhang/dsnhomhang';
        $catid = $this->uri->segment(3);
        // Form validation
        $this->form_validation->set_rules('catname','Tên nhóm hàng','trim|required');

        $this->form_validation->set_rules('cat[ordering]','Sắp xếp','trim|required');
        $this->form_validation->set_rules('cat[parentid]','','');
        $this->form_validation->set_rules('cat[catkeyword]','','');
        $this->form_validation->set_rules('cat[catdes]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = $this->input->post('id');
            $cat = $this->input->post('cat');
            $catname = $this->input->post('catname');
            $ishome = $this->input->post('ishome');
            $istab = $this->input->post('istab');
            $ismenuleft = $this->input->post('ismenuleft');
            $nolink = $this->input->post('nolink');
            $published = $this->input->post('published');
            $vmenu['ordercat'] = $cat['ordering'];
            
            if($_FILES["userfile"]["size"] > 0){
                $config['upload_path'] = ROOT.'data/img_cat/';
                $config['allowed_types'] = 'gif|jpg|png|swf';
                $config['max_size']    = '10000';
                $this->load->library('upload', $config);
                $this->upload->initialize($config);                     
                       
                if ( !$this->upload->do_upload()){
                    $this->pre_message =  $this->upload->display_errors();
                }else{                         
                    $result =  $this->upload->data();
                    $img_main = $result['file_name'];               
                }                    
            }else{
                $img_main = $this->input->post('img_main');
            }
            
            $this->vdb->update('built_menu',$vmenu,array('maincat'=>$id));
            // DB lang Vi
            $cat['ishome'] = $ishome;
            $cat['istab'] = $istab;
            $cat['ismenuleft'] = $ismenuleft;
            $cat['nolink'] = $nolink;
            $cat['published'] = $published;
            $cat['catname'] = $catname; 
            $cat['img_main'] = $img_main; 
            
            
            $catname_en = $this->input->post('catname_en');
            $cat['caturl'] = vnit_change_title($catname);
            
            /*$cat_en['catname'] = $catname_en;
            $cat_en['caturl'] = vnit_change_title($catname_en);
            $cat_en['ordering'] = $cat['ordering'];
            $cat_en['ishome'] = $ishome;
            $cat_en['istab'] = $istab;
            $cat_en['ismenuleft'] = $ismenuleft;
            $cat_en['nolink'] = $nolink;
            $cat_en['catkeyword'] = $cat['catkeyword'];
            $cat_en['catdes'] = $cat['catdes'];
            $cat_en['published'] = $published; */
            if($this->vdb->update('shop_cat',$cat,array('catid'=>$id))){
                write_log(63,192,'Cập nhật nhóm hàng: '.$cat['catname']); 
                //$this->vdb->update('shop_cat_en',$cat_en,array('catid'=>$id));
                $this->session->set_flashdata('message','Cập nhật thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'nhomhang/dsnhomhang';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }else{
                $this->pre_message = 'Cập nhật không thành công';
            }
        }
        $data['rs_vi'] = $this->vdb->find_by_id('shop_cat',array('catid'=>$catid));
        $data['rs_en'] = $this->vdb->find_by_id('shop_cat_en',array('catid'=>$catid));
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'nhomhang/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    // Xoa 1 nhom hang
    function del(){
        $id = $this->uri->segment(3);
        $total = $this->vdb->find_by_num('shop_cat',array('parentid'=>$id));
        $nh = $this->vdb->find_by_id('shop_cat', array('catid'=>$this->uri->segment(3)))->catname;
        if($total > 0){
            $this->session->set_flashdata('message','Không thể xóa. Vẫn còn danh mục sản phẩm');
        }else{
            $this->vdb->delete('shop_cat',array('catid'=>$id));
            $this->vdb->delete('shop_cat_en',array('catid'=>$id));
            write_log(63,194,'Xóa nhóm hàng: '.$nh); 
            $this->session->set_flashdata('message','Xóa thành công');
        }
        redirect('nhomhang/dsnhomhang');
    }
    // Xoa nhieu nhom hang
    function dels(){
        if(!empty($_POST['ar_id'])){
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $total = $this->vdb->find_by_num('shop_cat',array('parentid'=>$ar_id[$i]));
                    if($total > 0){ 
                        $this->session->set_flashdata('message','Không thể xóa. Vẫn còn danh mục sản phẩm');  
                    }else{
                        $nh = $this->vdb->find_by_id('shop_cat', array('catid'=>$ar_id[$i]))->catname;
                        $this->vdb->delete('shop_cat',array('catid'=>$ar_id[$i]));
                        $this->vdb->delete('shop_cat_en',array('catid'=>$ar_id[$i]));
                        write_log(63,193,'Xóa nhóm hàng :'.$nh); 
                        $this->session->set_flashdata('message','Xóa thành công');
                    }
                }
            }
        }
        redirect('nhomhang/dsnhomhang/');
    }
}
