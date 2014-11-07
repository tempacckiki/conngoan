<?php
class baohanh extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->pre_message = "";
        $this->load->model('baohanh_model','baohanh');
    }
    
    function ds(){
       $data['delete'] = icon_dels('baohanh/dels');
      $data['title']            = 'Điểm bảo hành theo hãng sản xuất';
      
      $data['key']              = $this->input->get('key');
      $key                      = ($data['key'] != '') ? '&key='.$data['key'] : '';
      $field                    = $this->uri->segment(4);
      $order                    = $this->uri->segment(5);                    
      $config['suffix']         = '/'.$field.'/'.$order.'?option=true'.$key;          
      $config['base_url']       = base_url().'baohanh/ds/';  
      $config['total_rows']     =  $this->baohanh->get_num_manufacture($data['key']);
      $data['num']              = $config['total_rows'];
      $config['per_page']       =   20;
      $config['uri_segment']    = 3; 
      $this->pagination->initialize($config);   
      $data['list']             =   $this->baohanh->get_all_manufacture($field,$order, $data['key'],$config['per_page'],$this->uri->segment(3));
      $data['pagination']       = $this->pagination->create_links();           
      $data['message']          = $this->pre_message;          
      $this->_templates['page'] = 'index';
      $this->templates->load($this->_templates['page'],$data);        
    }
    
    
    // Danh sách điểm bao hanh theo hsx
    function dsdiembaohang(){
        $manufactureid          = $this->uri->segment(3);
        $data['add']            = 'baohanh/add/'.$manufactureid.'|'.icon_add('baohanh/add');
        //$data['delete']         = true;
        $data['cancel']         = 'baohanh/ds';
        $rs = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$manufactureid));
        write_log(66,205,'Xem danh sách điểm bảo hành của nhà sản xuất: '.$rs->name);
        $data['title']          = 'Danh sách điểm bảo hành: '.$rs->name;
        $this->_templates['page'] = 'list/index';
        $data['list']           = $this->vdb->find_by_list('shop_manufacture_security',array('manufactureid'=>$manufactureid));
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function add(){
        $js_array = array(
            array(base_url().'components/baohanh/views/esset/baohanh.js'),
            array(base_url().'templates/js/core/map_api.js'),
            array('http://maps.google.com/maps/api/js?sensor=true'),
        );
        $this->esset->js($js_array);
        $manufactureid          = $this->uri->segment(3);
        $data['title']          = 'Thêm mới điểm bảo hành';
        $data['save']           = true;
        $data['apply']          = true;
        $data['cancel']         = 'baohanh/dsdiembaohang/'.$manufactureid;
        $data['manufactureid']  = $manufactureid;
        $data['listcity']       = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $this->form_validation->set_rules('city_id','Tỉnh, Thành phố','required');
        $this->form_validation->set_rules('parent_id','Quận, Huyện','required');
        $this->form_validation->set_rules('address','Địa chỉ','required');
        $this->form_validation->set_rules('lat','Lat','required');
        $this->form_validation->set_rules('lng','lng','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message  = validation_errors();
        }else{
            $vdata['manufactureid']     = $this->input->post('manufactureid');
            $vdata['city_id']           = $this->input->post('city_id');
            $vdata['parent_id']         = $this->input->post('parent_id');
            $vdata['address']           = $this->input->post('address');
            $vdata['phone']             = $this->input->post('phone');
            $vdata['website']           = $this->input->post('website');
            $vdata['time_working']      = $this->input->post('time_working');
            $vdata['lat']               = $this->input->post('lat');
            $vdata['lng']               = $this->input->post('lng');
            $city_name                  = $this->vdb->find_by_id('city',array('city_id'=>$vdata['city_id']))->city_name;
            $districts_name             = $this->vdb->find_by_id('city',array('city_id'=>$vdata['parent_id']))->city_name;
            $vdata['full_address']      = $vdata['address'].', '.$districts_name.', '.$city_name;
            if($id = $this->vdb->update('shop_manufacture_security',$vdata)){
                $rs = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$vdata['manufactureid']));
                write_log(66,206,'Thêm điểm bảo hành của nhà sản xuất: '.$rs->name); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                    $url = 'baohanh/dsdiembaohang/'.$vdata['manufactureid'];
                }else{
                    $url = 'baohanh/edit/'.$vdata['manufactureid'].'/'.$id;
                }
                redirect($url); 
            }
        }
        $data['message']            = $this->pre_message;
        $this->_templates['page']   = 'list/add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $js_array = array(
            array(base_url().'components/baohanh/views/esset/baohanh.js'),
            array(base_url().'templates/js/core/map_api.js'),
            array('http://maps.google.com/maps/api/js?sensor=true'),
        );
        $this->esset->js($js_array);
        $manufactureid          = $this->uri->segment(3);
        $data['title']          = 'Thêm mới điểm bảo hành';
        $data['save']           = true;
        $data['apply']          = true;
        $data['cancel']         = 'baohanh/dsdiembaohang/'.$manufactureid;
        $data['manufactureid']  = $manufactureid;
        $data['rs']             = $this->vdb->find_by_id('shop_manufacture_security',array('id'=>$this->uri->segment(4)));
        $data['listcity']       = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $data['listdistrict']   = $this->vdb->find_by_list('city',array('parentid'=>$data['rs']->city_id));
        
        $this->form_validation->set_rules('city_id','Tỉnh, Thành phố','required');
        $this->form_validation->set_rules('parent_id','Quận, Huyện','required');
        $this->form_validation->set_rules('address','Địa chỉ','required');
        $this->form_validation->set_rules('lat','Lat','required');
        $this->form_validation->set_rules('lng','lng','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message  = validation_errors();
        }else{
            $id                         = $this->input->post('id');
            $vdata['manufactureid']     = $this->input->post('manufactureid');
            $vdata['city_id']           = $this->input->post('city_id');
            $vdata['parent_id']         = $this->input->post('parent_id');
            $vdata['address']           = $this->input->post('address');
            $vdata['phone']             = $this->input->post('phone');
            $vdata['website']           = $this->input->post('website');
            $vdata['time_working']      = $this->input->post('time_working');
            $vdata['lat']               = $this->input->post('lat');
            $vdata['lng']               = $this->input->post('lng');
            $city_name                  = $this->vdb->find_by_id('city',array('city_id'=>$vdata['city_id']))->city_name;
            $districts_name             = $this->vdb->find_by_id('city',array('city_id'=>$vdata['parent_id']))->city_name;
            $vdata['full_address']      = $vdata['address'].', '.$districts_name.', '.$city_name;
            if($this->vdb->update('shop_manufacture_security',$vdata,array('id'=>$id))){
                $rs = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$vdata['manufactureid']));
                write_log(66,207,'Cập nhật điểm bảo hành của nhà sản xuất: '.$rs->name); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                    $url = 'baohanh/dsdiembaohang/'.$vdata['manufactureid'];
                }else{
                    $url = uri_string();
                }
                redirect($url); 
            }
        }
        $data['message']            = $this->pre_message;
        $this->_templates['page']   = 'list/edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function del(){
        $page = $this->uri->segment(3);
        $id = $this->uri->segment(4);
        $bh = $this->vdb->find_by_id('shop_manufacture_security',array('id'=>$id))->address;
        if($this->vdb->delete('shop_manufacture_security',array('id'=>$id))){
            write_log(66,208,'Xóa điểm bảo hành: '.$bh); 
            $this->session->set_flashdata('message','Xóa thành công');
        }
        redirect('baohanh/dsdiembaohang/'.$page);
    }
    
 // Xoa nhieu bai viet
    function dels(){
        $ar_id = $this->input->post('ar_id');
       
        $page = $this->input->post('page');
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                 $title = $this->vdb->find_by_id('shop_manufacture',array('manufactureid'=>$ar_id[$i]))->name;
                 $this->vdb->delete('shop_manufacture',array('manufactureid'=>$ar_id[$i]));
               
            }
        }
        
        $this->session->set_flashdata('message','Xóa bài viết thành công');
        redirect('baohanh/ds/'.$page); 
    }
    
    function get_quan_huyen(){
        $city_id = $this->input->post('city_id');
        $list = $this->vdb->find_by_list('city',array('parentid'=>$city_id,'parentid !='=>0),array('ordering'=>'asc'));
        $data['list'] ='';
        if(count($list) > 0){
        foreach($list as $val):
            $data['list'] .='<option value="'.$val->city_id.'">'.$val->city_name.'</option>';
        endforeach;
        }else{
            $data['list'] .='<option value="">==Chọn Quận, Huyện==</option>';
        }
        echo json_encode($data);
    }
    
    function load_map(){
        $city_id = $this->input->post('city_id');
        $parentid = $this->input->post('parentid');
        $address = $this->input->post('address');
        $city_name = $this->vdb->find_by_id('city',array('city_id'=>$city_id))->city_name;
        $districts_name = $this->vdb->find_by_id('city',array('city_id'=>$parentid))->city_name;
        $data['address'] = $address.', '.$districts_name.', '.$city_name;
        echo json_encode($data);
    }
}
