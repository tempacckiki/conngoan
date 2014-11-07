<?php
  class suppermarket extends CI_Controller{
      protected $_templates;
      function __construct(){
          parent::__construct();
          $this->load->model('suppermarket_model','supper');
        $js_array = array(
            array(base_url().'components/suppermarket/views/esset/baohanh.js'),
            array(base_url().'templates/js/core/map_api.js'),
            array('http://maps.google.com/maps/api/js?sensor=true'),
        );
        $this->esset->js($js_array);
      }
      function index(){
          redirect('suppermarket/listsupper');
      }
      function listsupper(){
          $this->write_suppermarket();
          $data['title'] = 'Danh sách siêu thị';
          write_log(82,264,'Xem danh sách siêu thị'); 
          $data['add'] = 'suppermarket/add|'.icon_add('suppermarket/add');
          $data['delete'] = icon_dels('suppermarket/dels'); 
          $field = $this->uri->segment(4);
          $order = $this->uri->segment(5);
          $config['suffix'] = '/'.$field.'/'.$order;
          $config['base_url'] = base_url().'suppermarket/listsupper';
          $config['total_rows'] = $this->vdb->find_by_num('supermarkets');
          $data['num'] = $config['total_rows'] ;
          $config['per_page'] = 20;
          $config['uri_segment'] = 3;
          $this->pagination->initialize($config);
          $data['list'] = $this->vdb->find_by_all('supermarkets',$config['per_page'],$this->uri->segment(3),0,$field,$order);
          $data['pagination'] = $this->pagination->create_links();
          $this->_templates['page'] = 'list';
          $this->templates->load($this->_templates['page'],$data);
      }
      function add(){
          $data['title'] = 'Thêm siêu thị';
          $data['apply']  =  true;
          $data['save'] = true;
          $data['rs'] = $this->vdb->find_by_id('faq',array('id'=>1));
          $this->form_validation->set_rules('sup[name]','Tên','required');
          $this->form_validation->set_rules('sup[address]','Đại chỉ','required');
          if($this->form_validation->run() === FALSE){
              $this->pre_message = validation_errors();
          }else{
              $id = (int)$this->input->post('id'); 
              $sup = $this->input->post('sup');
              if($id = $this->vdb->update('supermarkets',$sup)){
                    write_log(82,265,'Thêm siêu thị: '.$sup['name']); 
                    $this->session->set_flashdata('message','Lưu thành công');
                    $option =  $this->input->post('option');
                    if($option == 'save'){
                       $url = 'suppermarket/listsupper';
                    }else{
                        $url = 'suppermarket/edit/'.$id;
                    }
                    redirect($url);
                }
          }
          $data['messsage'] = $this->pre_message;
          $this->_templates['page'] = 'add';
          $this->templates->load($this->_templates['page'],$data);
      }
      function edit(){
        $data['title'] = 'Cập nhật siêu thị';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'suppermarket/listsupper';
        $data['rs'] = $this->vdb->find_by_id('supermarkets',array('id'=>$this->uri->segment(3)));
        // Form validation
        $this->form_validation->set_rules('sup[name]','Tiêu đề','required');

        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $id = (int)$this->input->post('id');
            $sup = $this->input->post('sup');
            if($this->vdb->update('supermarkets',$sup,array('id'=>$id))){
                write_log(82,266,'Cập nhật siêu thị: '.$sup['name']); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'suppermarket/listsupper';
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
    function del(){
      $id = $this->uri->segment(3);
      $name = $this->vdb->find_by_id('supermarkets',array('id'=>$id))->name;
      if($this->supper->delete($id)){
          write_log(82,268,'Xóa siêu thị: '.$name);
          $this->session->set_flashdata('message','Đã xóa thành công');  
      }
            
      else $this->session->set_flashdata('message','Xóa không thành công');
      redirect('suppermarket/listsupper/');
    }
  // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $name = $this->vdb->find_by_id('supermarkets',array('id'=>$ar_id[$i]))->name;  
                    if($this->supper->delete($ar_id[$i])){
                        write_log(82,267,'Xóa siêu thị :'.$name); 
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }
                    
                    else $this->session->set_flashdata('error','Xóa không thành công');
                }
            }
        }
        redirect('suppermarket/listsupper/');
    }
    
    function write_suppermarket(){
        $this->load->helper('file');
        $list = $this->vdb->find_by_list('supermarkets',0,array('ordering'=>'asc'));
        $total = count($list);
        $str = "<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');\n/**\n* File config_suppermarket language ".vnit_lang().".\n* Date: ".date('d/m/y H:i:s').".\n**/";
        $str .= "\n\$config['total_market'] = $total;\n"; 
        $i = 1;
        foreach($list as $rs):
            $str .= "\n\$config['market_name_$i'] = '$rs->name';";
            $str .= "\n\$config['market_address_$i'] = '$rs->address';";
            $str .= "\n\$config['market_phone_$i'] = '$rs->phone';";
            $str .= "\n\$config['market_fax_$i'] = '$rs->fax';";
            $str .= "\n\$config['market_email_$i'] = '$rs->email';";
            $str .= "\n\$config['market_lat_$i'] = '$rs->lat';";
            $str .= "\n\$config['market_lng_$i'] = '$rs->lng';\n";
        $i ++;
        endforeach;
        $str .= "\n\n/* End of file config_suppermarket*/";        
        write_file(ROOT.'site/config/config_suppermarket.php', $str);
    }
    
   
}

