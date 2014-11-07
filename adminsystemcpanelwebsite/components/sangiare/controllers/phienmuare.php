<?php
class phienmuare extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('phienmuare_model','phienmuare');
        $this->group_id = $this->session->userdata('group_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->pre_message = "";
    }
    
    function ds(){
        $data['title'] = 'Danh sách phiên mua rẻ';
        $data['delete'] = true;
        $catid = (int)$this->uri->segment(4);
        $field = $this->uri->segment(6);
        $order = $this->uri->segment(7);          
        $config['suffix'] = '/'.$field.'/'.$order;

        $config['base_url'] = base_url().'product/shop/listproduct/'; 
        $config['total_rows']   =  $this->phienmuare->get_num_phienmuare();
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 5; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->phienmuare->get_all_phienmuare($field,$order,$config['per_page'],$this->uri->segment(5));
        $data['pagination']    = $this->pagination->create_links();           
        $data['message'] = $this->pre_message; 
        $this->_templates['page'] = 'phienmuare/index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $data['title'] = 'Thêm mới phiên mua rẻ';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'sangiare/phienmuare/ds'; 
        $productid = $this->uri->segment(4);
        $data['listcity'] = $this->vdb->find_by_list('city',array('published'=>1,'site'=>1,'parentid'=>0),array('ordering'=>'asc'));
        $data['pro'] = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
        $this->form_validation->set_rules('data[cheap_title]','Tiêu đề-vi','required');
        $this->form_validation->set_rules('data_en[cheap_title]','Tiêu đề-en','required');
        $this->form_validation->set_rules('data[cheap_price]','Giá mua rẻ','required');
        $this->form_validation->set_rules('data[cheap_qty]','Số lượng cơ hội mua rẻ','required');
        $this->form_validation->set_rules('data[cheap_buy_limit]','Số lương/ Lần mua','required');
        $this->form_validation->set_rules('time_begin_date','Thời gian bắt đầu','required');
        $this->form_validation->set_rules('time_end_date','Thời gian kết thúc','required');
        
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();

        }else{
            
            $productid = $this->input->post('productid');
            $city_id  = $this->input->post('city_id');
            $rs_vi = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
            $rs_en = $this->vdb->find_by_id('shop_product_en',array('productid'=>$productid));
            $vdata = $this->input->post('data');
            $vdata_en = $this->input->post('data_en');
            $time_begin_date = $this->input->post('time_begin_date');
            $time_begin_h = $this->input->post('time_begin_h');
            $time_begin_i = $this->input->post('time_begin_i');
            
            $time_end_date = $this->input->post('time_end_date');
            $time_end_h = $this->input->post('time_end_h');
            $time_end_i = $this->input->post('time_end_i');
            $vdata['product_title'] = $rs_vi->productname;
            $vdata['cheap_timebegin'] = strtotime($time_begin_date.' '.$time_begin_h.':'.$time_begin_i.':0');
            $vdata['cheap_timeend'] = strtotime($time_end_date.' '.$time_end_h.':'.$time_end_i.':0');
            $vdata['cheap_price_old'] = str_replace('.','',$vdata['cheap_price_old']);
            $vdata['cheap_price'] = str_replace('.','',$vdata['cheap_price']);
            $vdata['cheap_saving'] = str_replace('.','',$vdata['cheap_saving']);
            
            $vdata['productid'] = $productid;
            $vdata['city_id'] = $city_id;
            if($id = $this->vdb->update('cheap_list',$vdata)){
                $vdata_en['id'] = $id;
                $vdata_en['productid'] = $productid;
                $vdata_en['product_title'] = $rs_vi->productname;
                $vdata_en['cheap_timebegin'] = strtotime($time_begin_date.' '.$time_begin_h.':'.$time_begin_i.':0');
                $vdata_en['cheap_timeend'] = strtotime($time_end_date.' '.$time_end_h.':'.$time_end_i.':0');
                $vdata_en['cheap_price_old'] = str_replace('.','',$vdata['cheap_price_old']);
                $vdata_en['cheap_price'] = str_replace('.','',$vdata['cheap_price']);
                $vdata_en['cheap_saving'] = str_replace('.','',$vdata['cheap_saving']);
                $vdata_en['cheap_qty'] = $vdata['cheap_qty'];
                $vdata_en['cheap_buy_limit'] = $vdata['cheap_buy_limit'];
                $vdata_en['cheap_per'] = str_replace('.','',$vdata['cheap_per']);
                $vdata_en['city_id'] = $city_id;
                $this->vdb->update('cheap_list_en',$vdata_en);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sangiare/phienmuare/ds/';
                }else{
                    $url = 'sangiare/phienmuare/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'phienmuare/add';
        $this->templates->load($this->_templates['page'],$data);
    }

    function edit(){
        $data['title'] = 'Cập nhật phiên mua rẻ';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'sangiare/phienmuare/ds'; 
        $id = $this->uri->segment(4);
        $data['listcity'] = $this->vdb->find_by_list('city',array('published'=>1,'site'=>1,'parentid'=>0),array('ordering'=>'asc'));
        $data['rs'] = $this->vdb->find_by_id('cheap_list',array('id'=>$id));
        $data['rs_en'] = $this->vdb->find_by_id('cheap_list_en',array('id'=>$id));
        $productid = $data['rs']->productid;
        $data['pro'] = $this->vdb->find_by_id('shop_product',array('productid'=>$productid));
        $this->form_validation->set_rules('data[cheap_title]','Tiêu đề-vi','required');
        $this->form_validation->set_rules('data_en[cheap_title]','Tiêu đề-en','required');
        $this->form_validation->set_rules('data[cheap_price]','Giá mua rẻ','required');
        $this->form_validation->set_rules('data[cheap_qty]','Số lượng cơ hội mua rẻ','required');
        $this->form_validation->set_rules('data[cheap_buy_limit]','Số lương/ Lần mua','required');
        $this->form_validation->set_rules('time_begin_date','Thời gian bắt đầu','required');
        $this->form_validation->set_rules('time_end_date','Thời gian kết thúc','required');
        
        
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();

        }else{
            
            $productid = $this->input->post('productid');
            $city_id  = $this->input->post('city_id');
            $vdata = $this->input->post('data');
            $vdata_en = $this->input->post('data_en');
            $time_begin_date = $this->input->post('time_begin_date');
            $time_begin_h = $this->input->post('time_begin_h');
            $time_begin_i = $this->input->post('time_begin_i');
            
            $time_end_date = $this->input->post('time_end_date');
            $time_end_h = $this->input->post('time_end_h');
            $time_end_i = $this->input->post('time_end_i');
            $vdata['cheap_timebegin'] = strtotime($time_begin_date.' '.$time_begin_h.':'.$time_begin_i.':0');
            $vdata['cheap_timeend'] = strtotime($time_end_date.' '.$time_end_h.':'.$time_end_i.':0');
            $vdata['cheap_price_old'] = str_replace('.','',$vdata['cheap_price_old']);
            $vdata['cheap_price'] = str_replace('.','',$vdata['cheap_price']);
            $vdata['cheap_saving'] = str_replace('.','',$vdata['cheap_saving']);
            $vdata['productid'] = $productid;
            $vdata['city_id'] = $city_id;
            if($this->vdb->update('cheap_list',$vdata,array('id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $vdata_en['cheap_timebegin'] = strtotime($time_begin_date.' '.$time_begin_h.':'.$time_begin_i.':0');
                $vdata_en['cheap_timeend'] = strtotime($time_end_date.' '.$time_end_h.':'.$time_end_i.':0');
                $vdata_en['cheap_price_old'] = str_replace('.','',$vdata['cheap_price_old']);
                $vdata_en['cheap_price'] = str_replace('.','',$vdata['cheap_price']);
                $vdata_en['cheap_saving'] = str_replace('.','',$vdata['cheap_saving']);
                $vdata_en['cheap_qty'] = $vdata['cheap_qty'];
                $vdata_en['cheap_buy_limit'] = $vdata['cheap_buy_limit'];
                $vdata_en['cheap_per'] = str_replace('.','',$vdata['cheap_per']);  
                $vdata_en['city_id'] = $city_id;
                $this->vdb->update('cheap_list_en',$vdata_en,array('id'=>$id));
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sangiare/phienmuare/ds/';
                }else{
                    $url = 'sangiare/phienmuare/edit/'.$id;
                }
                redirect($url);
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'phienmuare/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
  // Xoa 1 ban ghi
  function del(){
      $id = $this->uri->segment(4);
      $uri4 = $this->uri->segment(5);
      $uri5 = $this->uri->segment(6);
      if($this->group_id == 18){
          if($this->phienmuare->delete($id)){
              $this->session->set_flashdata('message','Đã xóa thành công');
          }else{
              $this->session->set_flashdata('message','Xóa không thành công');
          } 
      }else{
          if($this->phienmuare->delete_status($id)){
              $this->session->set_flashdata('message','Đã xóa thành công');
          }else{
              $this->session->set_flashdata('message','Xóa không thành công');
          }
      }

      redirect('sangiare/phienmuare/ds/'.$uri4.'/'.$uri5);
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
                        if($this->phienmuare->delete($ar_id[$i])){
                            $this->session->set_flashdata('message','Đã xóa thành công');
                        }else{
                            $this->session->set_flashdata('error','Xóa không thành công');
                        }
                    }else{
                        if($this->phienmuare->delete_status($ar_id[$i])){
                            $this->session->set_flashdata('message','Đã xóa thành công');
                        }else{
                            $this->session->set_flashdata('error','Xóa không thành công');
                        } 
                    }
                }
            }
        }
        redirect('sangiare/phienmuare/ds/'.$page);
    }
}
