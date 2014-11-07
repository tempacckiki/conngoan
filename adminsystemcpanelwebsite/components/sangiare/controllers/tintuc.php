<?php
class tintuc extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('tintuc_model','tintuc');
    }
    
    function index(){
        redirect('sangiare/tintuc/listcontent');
    }
    
    function listcontent(){
        $data['title'] = 'Quản lý bài viết';
        $data['add'] = 'sangiare/tintuc/add';
        $data['delete'] = true;
        
        $data['sections_id'] = (int)$this->input->get('sections_id');
        $data['cat_id'] = (int)$this->input->get('cat_id');
        $data['key'] = $this->input->get('key');
        $data['listcategory'] = $this->tintuc->get_all_category($data['sections_id']);
        
        $field = $this->uri->segment(5);
        $order = $this->uri->segment(6);          
        
        $sections_id = ($data['sections_id'] != 0) ? '&sections_id='.$data['sections_id'] : '';
        $cat_id = ($data['cat_id'] != 0) ? '&cat_id='.$data['cat_id'] : '';
        $key = ($data['key'] != '') ? '&key='.$data['key'] : '';
        
        $config['suffix'] = '/'.$field.'/'.$order.'?option=true'.$sections_id.$cat_id.$key;          
        $config['base_url'] = base_url().'sangiare/tintuc/listcontent/';  
        $config['total_rows']   =  $this->tintuc->find_by_num($data['sections_id'], $data['cat_id'], $data['key']);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 4; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->tintuc->find_by_all($config['per_page'], $this->uri->segment(4), $data['sections_id'], $data['cat_id'], $data['key'], $field, $order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'tintuc/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    function add(){
        $data['title'] = 'Thêm mới bài viết';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'sangiare/tintuc/listcontent';        
        $data['list'] = $this->vdb->find_by_list('category',array('site'=>2,'parent_id'=>0));
        
        // Form validation
        $this->form_validation->set_rules('con[title]','Tiêu đề - vi','required');
        $this->form_validation->set_rules('con_en[title]','Tiêu đề - en','required');
        $this->form_validation->set_rules('content','Nội dung - vi','required');
        $this->form_validation->set_rules('content_en','Nội dung - en','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = (int)$this->input->post('id');
            $con = $this->input->post('con');
            $con_en = $this->input->post('con_en');
            $attr = $this->input->post('attr');
            // Content - VI
            $con['title_alias'] = vnit_change_title($con['title']);
            $con['cat_alias'] = ($con['catid'] != 0)?$this->vdb->find_by_id('category',array('cat_id'=>$con['catid'],'lang'=>vnit_lang()))->cat_alias:'';
            $con['fulltext'] = $this->input->post('content');
            $con['created_by'] = $this->session->userdata('user_id');
            $con['created'] = time();
            $con['site'] = 2;
            $con['attr'] ='';
            $con['attr'] .= 'show_intro='.$attr['show_intro'];
            $con['attr'] .= '&show_author='.$attr['show_author'];
            $con['attr'] .= '&show_date='.$attr['show_date'];
            $con['attr'] .= '&show_editdate='.$attr['show_editdate'];
            $con['attr'] .= '&show_print='.$attr['show_print'];
            $con['attr'] .= '&show_email='.$attr['show_email'];
            $con['attr'] .= '&show_comment='.$attr['show_comment'];
            $con['attr'] .= '&show_other='.$attr['show_other'];
            // Content - En
            
            $con_en['title_alias'] = vnit_change_title($con_en['title']);
            $con_en['catid'] = $con['catid'];
            $con_en['cat_alias'] = ($con['catid'] != 0)?$this->vdb->find_by_id('category',array('cat_id'=>$con['catid'],'site'=>2))->cat_alias:'';
            $con_en['fulltext'] = $this->input->post('content_en');
            $con_en['created_by'] = $this->session->userdata('user_id');
            $con_en['created'] = time();
            $con_en['site'] = 2;
            $con_en['attr'] ='';
            $con_en['attr'] .= 'show_intro='.$attr['show_intro'];
            $con_en['attr'] .= '&show_author='.$attr['show_author'];
            $con_en['attr'] .= '&show_date='.$attr['show_date'];
            $con_en['attr'] .= '&show_editdate='.$attr['show_editdate'];
            $con_en['attr'] .= '&show_print='.$attr['show_print'];
            $con_en['attr'] .= '&show_email='.$attr['show_email'];
            $con_en['attr'] .= '&show_comment='.$attr['show_comment'];
            $con_en['attr'] .= '&show_other='.$attr['show_other'];
            
              if($this->input->post('images')!=''){
                  $this->load->helper('img_helper');
                  $news_img = $this->input->post('images');
                  $filename = end(explode('/',$news_img));
                  $news_img_thumb = 'data/content/'.$filename;
                  vnit_resize_image(ROOT.$news_img,ROOT.$news_img_thumb,200,200,false);
                  $con['images'] = $news_img;
                  $con['images_thumb'] = $news_img_thumb;
                  $con_en['images'] = $news_img;
                  $con_en['images_thumb'] = $news_img_thumb;
              }
            if($id = $this->vdb->update('content',$con)){
                $con_en['id'] = $id;
                $this->vdb->update('content_en',$con_en);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sangiare/tintuc/listcontent';
                }else{
                    $url = 'sangiare/tintuc/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'tintuc/add';
        $this->templates->load($this->_templates['page'],$data);
    }    
    function edit(){
        $data['title'] = 'Cập nhật bài viết';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'sangiare/tintuc/listcontent';
        
        $data['list'] = $this->vdb->find_by_list('category',array('site'=>2,'parent_id'=>0));
        $data['rs'] = $this->vdb->find_by_id('content',array('id'=>$this->uri->segment(4),'site'=>2));
        $data['rs_en'] = $this->vdb->find_by_id('content_en',array('id'=>$this->uri->segment(4),'site'=>2));
        // Form validation
        $this->form_validation->set_rules('con[title]','Tiêu đề - vi','required');
        $this->form_validation->set_rules('con_en[title]','Tiêu đề - en','required');
        $this->form_validation->set_rules('content','Nội dung - vi','required');
        $this->form_validation->set_rules('content_en','Nội dung - en','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $this->load->helper('img');
            $id = (int)$this->input->post('id');
            // Update content vi
            $con = $this->input->post('con');
            $con_en = $this->input->post('con_en');
            $attr = $this->input->post('attr');
            $con['title_alias'] = vnit_change_title($con['title']);
            $con['cat_alias'] = ($con['catid'] != 0)?$this->vdb->find_by_id('category',array('cat_id'=>$con['catid'],'lang'=>vnit_lang()))->cat_alias:'';
            $con['fulltext'] = $this->input->post('content');
            $con['modified'] = time();
            $con['attr'] ='';
            $con['attr'] .= 'show_intro='.$attr['show_intro'];
            $con['attr'] .= '&show_author='.$attr['show_author'];
            $con['attr'] .= '&show_date='.$attr['show_date'];
            $con['attr'] .= '&show_editdate='.$attr['show_editdate'];
            $con['attr'] .= '&show_print='.$attr['show_print'];
            $con['attr'] .= '&show_email='.$attr['show_email'];
            $con['attr'] .= '&show_comment='.$attr['show_comment'];
            $con['attr'] .= '&show_other='.$attr['show_other'];
            
            // Update content en
            $con_en['title_alias'] = vnit_change_title($con_en['title']);
            $con_en['catid'] = $con['catid'];
            $con_en['cat_alias'] = ($con['catid'] != 0)?$this->vdb->find_by_id('category',array('cat_id'=>$con['catid'],'site'=>2))->cat_alias:'';
            $con_en['fulltext'] = $this->input->post('content_en');
            $con_en['created_by'] = $this->session->userdata('user_id');
            $con_en['created'] = time();
            $con_en['site'] = 2;
            $con_en['attr'] ='';
            $con_en['attr'] .= 'show_intro='.$attr['show_intro'];
            $con_en['attr'] .= '&show_author='.$attr['show_author'];
            $con_en['attr'] .= '&show_date='.$attr['show_date'];
            $con_en['attr'] .= '&show_editdate='.$attr['show_editdate'];
            $con_en['attr'] .= '&show_print='.$attr['show_print'];
            $con_en['attr'] .= '&show_email='.$attr['show_email'];
            $con_en['attr'] .= '&show_comment='.$attr['show_comment'];
            $con_en['attr'] .= '&show_other='.$attr['show_other'];
            
            if($this->input->post('images')!=''){
                if($data['rs']->images_thumb != ''){
                    unlink(ROOT.$data['rs']->images_thumb);
                }
                  $this->load->helper('img_helper');
                  $news_img = $this->input->post('images');
                  $filename = end(explode('/',$news_img));
                  $news_img_thumb = 'data/content/'.$filename;
                  vnit_resize_image(ROOT.$news_img,ROOT.$news_img_thumb,200,200,false);
                  $con['images'] = $news_img;
                  $con['images_thumb'] = $news_img_thumb; 
                  $con_en['images'] = $news_img;
                  $con_en['images_thumb'] = $news_img_thumb; 
            }            
            
            if($this->vdb->update('content',$con,array('id'=>$id))){
                $this->vdb->update('content_en',$con_en,array('id'=>$id));
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sangiare/tintuc/listcontent';
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'tintuc/edit';
        $this->templates->load($this->_templates['page'],$data);
    }  
    // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    if($this->vdb->delete('content', array('id'=>$ar_id[$i]))){
                        $this->vdb->delete('content_en', array('id'=>$ar_id[$i]));
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('sangiare/tintuc/listcontent/'.$page);
    }          
}
