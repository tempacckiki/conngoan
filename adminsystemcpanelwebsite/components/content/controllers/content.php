<?php
class content extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('content_model','content');
    }
    
    function index(){
        redirect('content/listcontent');
    }
    
    function listcontent(){
        $data['title'] = 'Quản lý bài viết';
        $data['add'] = 'content/add';
        $data['delete'] = true;
        
        $data['sections_id'] = (int)$this->input->get('sections_id');
        $data['cat_id'] = (int)$this->input->get('cat_id');
        $data['key'] = $this->input->get('key');
        $data['listsections'] = $this->content->get_all_section(vnit_lang());
        $data['listcategory'] = $this->content->get_all_category($data['sections_id'],vnit_lang());
        
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);          
        
        $sections_id = ($data['sections_id'] != 0) ? '&sections_id='.$data['sections_id'] : '';
        $cat_id = ($data['cat_id'] != 0) ? '&cat_id='.$data['cat_id'] : '';
        $key = ($data['key'] != '') ? '&key='.$data['key'] : '';
        
        $config['suffix'] = '/'.$field.'/'.$order.'?option=true'.$sections_id.$cat_id.$key;          
        $config['base_url'] = base_url().'content/listcontent/';  
        $config['total_rows']   =  $this->content->find_by_num($data['sections_id'], $data['cat_id'], $data['key'],vnit_lang());
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->content->find_by_all($config['per_page'], $this->uri->segment(3), $data['sections_id'], $data['cat_id'], $data['key'],vnit_lang(), $field, $order);
        $data['pagination']    = $this->pagination->create_links();         
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    function add(){
        $data['title'] = 'Thêm mới bài viết';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'content/listcontent';        
        $data['sectionslist'] = $this->vdb->find_by_list('sections',array('lang'=>vnit_lang()));
        
        // Form validation
        $this->form_validation->set_rules('con[title]','Tiêu đề','required');
        $this->form_validation->set_rules('content','Nội dung','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = (int)$this->input->post('id');
            $catid = explode('-',$this->input->post('catid'));
            $con = $this->input->post('con');
            $attr = $this->input->post('attr');
            $con['title_alias'] = vnit_change_title($con['title']);
            $con['sections_id'] = $catid[0];
            $con['sections_alias'] = $this->vdb->find_by_id('sections',array('sections_id'=>$catid[0],'lang'=>vnit_lang()))->sections_alias;
            $con['catid'] = $catid[1];
            $con['cat_alias'] = ($catid[1] != 0)?$this->vdb->find_by_id('category',array('cat_id'=>$catid[1],'lang'=>vnit_lang()))->cat_alias:'';
            $con['fulltext'] = $this->input->post('content');
            $con['created_by'] = $this->session->userdata('user_id');
            $con['created'] = time();
            $con['lang'] = vnit_lang();
            $con['attr'] ='';
            $con['attr'] .= 'show_intro='.$attr['show_intro'];
            $con['attr'] .= ',show_author='.$attr['show_author'];
            $con['attr'] .= ',show_date='.$attr['show_date'];
            $con['attr'] .= ',show_editdate='.$attr['show_editdate'];
            $con['attr'] .= ',show_print='.$attr['show_print'];
            $con['attr'] .= ',show_email='.$attr['show_email'];
            $con['attr'] .= ',show_comment='.$attr['show_comment'];
              if($this->input->post('images')!=''){
                  $this->load->helper('img_helper');
                  $news_img = $this->input->post('images');
                  $filename = end(explode('/',$news_img));
                  $news_img_thumb = 'data/content/'.$filename;
                  vnit_resize_image(ROOT.$news_img,ROOT.$news_img_thumb,200,200,false);
                  $con['images'] = $news_img;
                  $con['images_thumb'] = $news_img_thumb;
              }
            if($id = $this->vdb->update('content',$con)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'content/listcontent';
                }else{
                    $url = 'content/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }    
    function edit(){
        $data['title'] = 'Cập nhật bài viết';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'content/listcontent';
        
        $data['sectionslist'] = $this->vdb->find_by_list('sections',array('lang'=>vnit_lang()));
        $data['rs'] = $this->vdb->find_by_id('content',array('id'=>$this->uri->segment(3),'lang'=>vnit_lang()));
        // Form validation
        $this->form_validation->set_rules('con[title]','Tiêu đề','required');
        $this->form_validation->set_rules('content','Nội dung','required');
        $this->form_validation->set_rules('con[published]','','');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $this->load->helper('img');
            $id = (int)$this->input->post('id');
            $catid = explode('-',$this->input->post('catid'));
            $con = $this->input->post('con');
            $attr = $this->input->post('attr');
            $con['title_alias'] = vnit_change_title($con['title']);
            $con['sections_id'] = $catid[0];
            $con['sections_alias'] = $this->vdb->find_by_id('sections',array('sections_id'=>$catid[0],'lang'=>vnit_lang()))->sections_alias;
            $con['catid'] = $catid[1];
            $con['cat_alias'] = ($catid[1] != 0)?$this->vdb->find_by_id('category',array('cat_id'=>$catid[1],'lang'=>vnit_lang()))->cat_alias:'';
            $con['fulltext'] = $this->input->post('content');
            //$con['create_by'] = $this->session->userdata('user_id');
            $con['modified'] = time();
            $con['attr'] ='';
            $con['attr'] .= 'show_intro='.$attr['show_intro'];
            $con['attr'] .= ',show_author='.$attr['show_author'];
            $con['attr'] .= ',show_date='.$attr['show_date'];
            $con['attr'] .= ',show_editdate='.$attr['show_editdate'];
            $con['attr'] .= ',show_print='.$attr['show_print'];
            $con['attr'] .= ',show_email='.$attr['show_email'];
            $con['attr'] .= ',show_comment='.$attr['show_comment'];
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
            }            
            
            if($this->vdb->update('content',$con,array('id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'content/listcontent';
                }else{
                    $url = uri_string();
                }
                redirect($url);
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
             if($this->vdb->delete('content', array('id'=>$id)))
                $this->session->set_flashdata('message','Đã xóa thành công');
            else $this->session->set_flashdata('message','Xóa không thành công');
          redirect('content/listcontent/'.$page);
      }
      // Xoa nhieu ban ghi
      function dels(){
            if(!empty($_POST['ar_id']))
            {
                $page = (int)$this->input->post('page');
                $ar_id = $this->input->post('ar_id');
                for($i = 0; $i < sizeof($ar_id); $i ++) {
                    if ($ar_id[$i]){
                        if($this->vdb->delete('content', array('id'=>$ar_id[$i])))
                        $this->session->set_flashdata('message','Đã xóa thành công');
                        else $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
            redirect('content/listcontent/'.$page);
      }          
}
