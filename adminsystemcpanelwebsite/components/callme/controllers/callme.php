<?php
class callme extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('callme_model','callme');
    }
    
    function ds(){
      $data['title'] = 'Liên hệ tư vấn';
      $data['delete'] = icon_dels('callme/dels');
      $field = $this->uri->segment(4);
      $order = $this->uri->segment(5);   
      if($field =='' && $order == ''){
          $field = 'id';
          $order = 'desc';
      } 
      write_log(90,293,"Xem danh sách liên hệ tư vấn");      
      $config['suffix'] = '/'.$field.'/'.$order;            
      $config['base_url'] = base_url().'callme/ds/';  
      $config['total_rows']   =  $this->callme->get_num_callme();
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   30;
      $config['uri_segment'] = 3; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->callme->get_all_callme($config['per_page'],$this->uri->segment(3),$field,$order);
      $data['pagination']    = $this->pagination->create_links(); 
      $this->_templates['page'] = 'index';
      $this->templates->load($this->_templates['page'],$data);
    }
    
    function edit(){
        $data['title'] = 'Liên hệ tư vấn';
        $data['apply'] = true;
        $data['save'] = true;
        $data['cancel'] = 'callme/ds/'.$this->uri->segment(4);
        $data['rs'] = $this->callme->get_callme_by_id($this->uri->segment(3));
        $this->form_validation->set_rules('id','','');
        if($this->form_validation->run()){
            $id = $this->input->post('id');
            $vdata['notes'] = $this->input->post('notes');
            $vdata['checked'] = $this->input->post('checked');
            if($this->vdb->update('callforme',$vdata,array('id'=>$id))){
                write_log(90,294,"Cập nhật liên hệ tư vấn sản phẩm: ".$data['rs']->productname); 
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'callme/ds/'.$this->uri->segment(4);
                }else{
                    $url = uri_string();
                }
                redirect($url);
            }
        }
        $this->_templates['page'] = 'edit';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function del(){
        $page = $this->uri->segment(4);
        $id = $this->uri->segment(3);
        $productname = $this->callme->get_callme_by_id($id)->productname;
        if($this->vdb->delete('callforme',array('id'=>$id))){
            write_log(90,296,"Xóa liên hệ tư vấn sản phẩm: ".$productname); 
            $this->session->userdata('message','Xóa thành công');
        }else{
            $this->session->set_flashdata('message','Xóa không thành công');
        }
        redirect('callme/ds/'.$page);
    }
    
    function dels(){
        $page = $this->input->post('page');
        $ar_id = $this->input->post('ar_id');
        for($i = 0; $i < sizeof($ar_id); $i++){
            if($ar_id[$i]){
                $productname = $this->callme->get_callme_by_id($ar_id[$i])->productname;
                if($this->vdb->delete('callforme',array('id'=>$ar_id[$i]))){
                    write_log(90,295,"Xóa liên hệ tư vấn sản phẩm: ".$productname);
                    $this->session->userdata('message','Xóa thành công');
                }else{
                    $this->session->set_flashdata('message','Xóa không thành công');
                }
            }
        }
        redirect('callme/ds/'.$page);
    }
}
