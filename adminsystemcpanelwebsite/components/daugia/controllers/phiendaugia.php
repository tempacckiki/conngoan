<?php
class phiendaugia extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('phiendaugia_model','phiendaugia');
        $this->group_id = $this->session->userdata('group_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->pre_message = "";
        $this->mainmenu = 'sandaugia';
    }
    
    function ds(){
        $data['title'] = 'Danh sách phiên đấu giá';
        $data['delete'] = true;
        $catid = (int)$this->uri->segment(4);
        $field = $this->uri->segment(5);
        $order = $this->uri->segment(6);          
        $config['suffix'] = '/'.$field.'/'.$order;

        $config['base_url'] = base_url().'daugia/phiendaugia/ds/'; 
        $config['total_rows']   =  $this->phiendaugia->get_num_phiendaugia();
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   10;
        $config['uri_segment'] = 4; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->phiendaugia->get_all_phiendaugia($field,$order,$config['per_page'],$this->uri->segment(4));
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message; 
        $this->_templates['page'] = 'phiendaugia/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới phiên Đấu giá';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'daugia/phiendaugia/ds'; 
        $productid = $this->uri->segment(4);
        $data['pro'] = $this->vdb->find_by_id('product_bid',array('productid'=>$productid));
        $data['listcity'] = $this->vdb->find_by_list('city',array('published'=>1,'site'=>1,'parentid'=>0),array('ordering'=>'asc'));
        $this->form_validation->set_rules('data[cheap_title]','Tiêu đề-vi','');
        $this->form_validation->set_rules('data_en[cheap_title]','Tiêu đề-en','');
        $this->form_validation->set_rules('data[price_old]','Giá bán','required');
        $this->form_validation->set_rules('data[price_bid]','Giá đấu giá','required');
        $this->form_validation->set_rules('data[price_inc]','Giá tăng sau 1 lần Bid','required');
        $this->form_validation->set_rules('data[time_inc]','Thời gian tăng sau 1 lần Bid','required');
        $this->form_validation->set_rules('time_begin_date','Thời gian bắt đầu','required');
        $this->form_validation->set_rules('time_end_date','Thời gian kết thúc','required');
        
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();

        }else{
            
            $productid = $this->input->post('productid');
            $vdata = $this->input->post('data');

            $time_begin_date        = $this->input->post('time_begin_date');
            $time_begin_h           = (int)$this->input->post('time_begin_h');
            $time_begin_i           = (int)$this->input->post('time_begin_i');
            $time_begin_s           = (int)$this->input->post('time_begin_s');
            
            $time_end_date          = $this->input->post('time_end_date');
            $time_end_h             = (int)$this->input->post('time_end_h');
            $time_end_i             = (int)$this->input->post('time_end_i');
            $time_end_s             = (int)$this->input->post('time_end_s');

            $minute_begin           = $time_begin_i; 
            $minute_end             = $time_end_i; 
            
            $vdata['time_begin']    = strtotime($time_begin_date.' '.$time_begin_h.':'.$minute_begin.':'.$time_begin_s);
            $vdata['time_end']      = strtotime($time_end_date.' '.$time_end_h.':'.$minute_end.':'.$time_end_s);
            $vdata['time_total']    = $vdata['time_end'] - $vdata['time_begin'];
            $vdata['price_old']     = str_replace('.','',$vdata['price_old']);
            $vdata['price_bid']     = str_replace('.','',$vdata['price_bid']);
            $vdata['price_last']     = str_replace('.','',$vdata['price_last']);
            $vdata['price_saving']  = str_replace('.','',$vdata['price_saving']);
            $vdata['price_inc']     = str_replace('.','',$vdata['price_inc']);
            $vdata['productid']     = $productid;
            if($id = $this->vdb->update('bid_list',$vdata)){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'daugia/phiendaugia/ds/';
                }else{
                    $url = 'daugia/phiendaugia/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'phiendaugia/add';
        $this->templates->load($this->_templates['page'],$data);
    }

    function edit(){
        $data['title'] = 'Cập nhật phiên Đấu giá';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'daugia/phiendaugia/ds'; 
        $id = $this->uri->segment(4);
        $data['listcity'] = $this->vdb->find_by_list('city',array('published'=>1,'site'=>1,'parentid'=>0),array('ordering'=>'asc'));
        $data['rs'] = $this->vdb->find_by_id('bid_list',array('id'=>$id));

        $productid = $data['rs']->productid;
        $data['pro'] = $this->vdb->find_by_id('product_bid',array('productid'=>$productid));
        $this->form_validation->set_rules('data[cheap_title]','Tiêu đề-vi','');
        $this->form_validation->set_rules('data_en[cheap_title]','Tiêu đề-en','');
        $this->form_validation->set_rules('data[price_old]','Giá bán','required');
        $this->form_validation->set_rules('data[price_bid]','Giá đấu giá','required');
        $this->form_validation->set_rules('data[price_inc]','Giá tăng sau 1 lần Bid','required');
        $this->form_validation->set_rules('data[time_inc]','Thời gian tăng sau 1 lần Bid','required');
        $this->form_validation->set_rules('time_begin_date','Thời gian bắt đầu','required');
        $this->form_validation->set_rules('time_end_date','Thời gian kết thúc','required');
        
        
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();

        }else{
            
            $productid              = $this->input->post('productid');
            $id                     = $this->input->post('id');
            $vdata                  = $this->input->post('data');
            $time_begin_date        = $this->input->post('time_begin_date');
            $time_begin_h           = (int)$this->input->post('time_begin_h');
            $time_begin_i           = (int)$this->input->post('time_begin_i');
            $time_begin_s           = (int)$this->input->post('time_begin_s');
            
            $time_end_date          = $this->input->post('time_end_date');
            $time_end_h             = (int)$this->input->post('time_end_h');
            $time_end_i             = (int)$this->input->post('time_end_i');
            $time_end_s             = (int)$this->input->post('time_end_s');

            $minute_begin           = $time_begin_i; 
            $minute_end             = $time_end_i; 
            
            $vdata['time_begin']    = strtotime($time_begin_date.' '.$time_begin_h.':'.$minute_begin.':'.$time_begin_s);
            $vdata['time_end']      = strtotime($time_end_date.' '.$time_end_h.':'.$minute_end.':'.$time_end_s);
            $vdata['time_total']    = $vdata['time_end'] - $vdata['time_begin'];
            $vdata['price_old']     = str_replace('.','',$vdata['price_old']);
            $vdata['price_bid']     = str_replace('.','',$vdata['price_bid']);
            $vdata['price_saving']  = str_replace('.','',$vdata['price_saving']);
            $vdata['price_last']     = str_replace('.','',$vdata['price_last']);
            $vdata['price_inc']     = str_replace('.','',$vdata['price_inc']);
            $vdata['stop']          = (int)$this->input->post('stop');
            $vdata['productid']     = $productid;
            if($this->vdb->update('bid_list',$vdata,array('id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'daugia/phiendaugia/ds/';
                }else{
                    $url = 'daugia/phiendaugia/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'phiendaugia/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
  // Xoa 1 ban ghi
  function del(){
      $id = $this->uri->segment(4);
      $uri4 = $this->uri->segment(5);
      $uri5 = $this->uri->segment(6);
      if($this->group_id == 18){
          if($this->phiendaugia->delete($id)){
              $this->session->set_flashdata('message','Đã xóa thành công');
          }else{
              $this->session->set_flashdata('message','Xóa không thành công');
          } 
      }else{
          if($this->phiendaugia->delete_status($id)){
              $this->session->set_flashdata('message','Đã xóa thành công');
          }else{
              $this->session->set_flashdata('message','Xóa không thành công');
          }
      }

      redirect('daugia/phiendaugia/ds/'.$uri4.'/'.$uri5);
  }
  
    // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    if($this->group_id == 18){ 
                        if($this->phiendaugia->delete($ar_id[$i])){
                            $this->session->set_flashdata('message','Đã xóa thành công');
                        }else{
                            $this->session->set_flashdata('error','Xóa không thành công');
                        }
                    }else{
                        if($this->phiendaugia->delete_status($ar_id[$i])){
                            $this->session->set_flashdata('message','Đã xóa thành công');
                        }else{
                            $this->session->set_flashdata('error','Xóa không thành công');
                        } 
                    }
                }
            }
        }
        redirect('daugia/phiendaugia/ds/'.$page);
    }
    
    
    /*******************
    * Lịch sủ BId
    */
    
    function lichsubid(){
        $id = $this->uri->segment(4);
        $page = $this->uri->segment(5);
        $data['cancel'] = 'daugia/phiendaugia/ds/'.$page;
        $data['listcity'] = $this->vdb->find_by_list('city',array('published'=>1,'site'=>1,'parentid'=>0),array('ordering'=>'asc'));
        $data['rs'] = $this->vdb->find_by_id('bid_list',array('id'=>$id));  
        $data['title'] = "Lịch sử Bid phiên đấu giá: ".$data['rs']->product_name;
       
        $config['base_url'] = base_url().'daugia/phiendaugia/lichsubid/'.$id.'/'.$page;
        $config['total_rows']   =  $this->phiendaugia->get_num_history($id);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 6; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->phiendaugia->get_all_history($config['per_page'],$this->uri->segment(6),$id);
        $data['pagination']    = $this->pagination->create_links(); 
        $this->_templates['page'] = 'phiendaugia/lichsubid';
        $this->templates->load($this->_templates['page'],$data);
    }
}
