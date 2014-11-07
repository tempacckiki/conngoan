<?php
class denghi extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('denghi_model','denghi');
        $this->pre_message = "";
    }
    // Controller Shop - Commnet

    function ds(){
      $data['title'] = 'Danh sách sản phẩm đề nghị mua nhóm';
      $data['delete'] = true;
      $field = $this->uri->segment(5);
      $order = $this->uri->segment(6);          
      $config['suffix'] = '/'.$field.'/'.$order; 
      $config['base_url'] = base_url().'sangiare/denghi/ds/';
      $config['total_rows']   =  $this->denghi->get_num_denghi();
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   20;
      $config['uri_segment'] = 4; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->denghi->get_all_denghi($field,$order,$config['per_page'],$this->uri->segment(4));
      $data['pagination']    = $this->pagination->create_links();           
      $data['message'] = $this->pre_message;    
      
      $this->_templates['page'] ='denghi/list';
      $this->templates->load($this->_templates['page'],$data);
    }

    function edit(){
      $data['title'] = 'Xem đề nghị mua nhóm';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'sangiare/denghi/ds';       
      $data['rs'] = $this->vdb->find_by_id('cheap_proposal',array('id'=>$this->uri->segment(4)));
      //Form validation
      $this->form_validation->set_rules('id','','');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors();
      }else{
          $id = $this->input->post('id');
          $page = $this->input->post('page');
          $denghi = $this->input->post('denghi');
          if($this->vdb->update('cheap_proposal',$denghi,array('id'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sangiare/denghi/ds/'.$page;
                }else{
                    $url = uri_string();
                }
                redirect($url);              
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'denghi/edit';
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
                    if($this->vdb->delete('cheap_proposal',array('id'=>$ar_id[$i])))
                    $this->session->set_flashdata('message','Đã xóa thành công');
                    else $this->session->set_flashdata('error','Xóa không thành công');
                }
            }
        }
        redirect('sangiare/denghi/ds/'.$page);
    }
}
