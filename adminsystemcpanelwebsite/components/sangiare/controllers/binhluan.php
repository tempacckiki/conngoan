<?php
class binhluan extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('binhluan_model','binhluan');
        $this->pre_message = "";
    }
    
    // Controller Shop - Commnet

    function ds(){
      $data['title'] = 'Danh sách bình luận';
      $data['delete'] = true;
      $field = $this->uri->segment(5);
      $order = $this->uri->segment(6);          
      $config['suffix'] = '/'.$field.'/'.$order; 
      $config['base_url'] = base_url().'sangiare/binhluan/ds/';
      $config['total_rows']   =  $this->binhluan->get_num_comment();
      $data['num'] = $config['total_rows'];
      $config['per_page']  =   20;
      $config['uri_segment'] = 4; 
      $this->pagination->initialize($config);   
      $data['list'] =   $this->binhluan->get_all_comment($field,$order,$config['per_page'],$this->uri->segment(4));
      $data['pagination']    = $this->pagination->create_links();           
      $data['message'] = $this->pre_message;    
      
      $this->_templates['page'] ='binhluan/list';
      $this->templates->load($this->_templates['page'],$data);
    }

    function editcomment(){
      $data['title'] = 'Cập nhật bình luận';
      $data['save'] = true;
      $data['apply'] = true;
      $data['cancel'] = 'sangiare/binhluan/ds';       
      $data['rs'] = $this->binhluan->get_comment_by_id($this->uri->segment(4));
      //Form validation
      $this->form_validation->set_rules('comment[fullname]','Người gửi bình luận','required');
      $this->form_validation->set_rules('comment[content]','Nội dung','required');
      if($this->form_validation->run() == false){
          $this->pre_message = validation_errors();
      }else{
          $id = $this->input->post('id');
          $page = $this->input->post('page');
          $com = $this->input->post('comment');
          if($this->vdb->update('cheap_comment',$com,array('commentid'=>$id))){
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'sangiare/binhluan/ds/'.$page;
                }else{
                    $url = uri_string();
                }
                redirect($url);              
          }
      }
      $data['message'] = $this->pre_message;
      $this->_templates['page'] = 'binhluan/edit';
      $this->templates->load($this->_templates['page'],$data);
    }
    
    function del(){
        $page = $this->uri->segment(5);
        $commentid = $this->uri->segment(4);
        if($this->vdb->delete('cheap_comment',array('commentid'=>$commentid))){
            $this->session->set_flashdata('message','Xóa thành công');
        }else{
            $this->session->set_flashdata('message','Xóa không thành công');
        }
        redirect('sangiare/binhluan/ds/'.$page);
    }
    // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    if($this->binhluan->delete_comment($ar_id[$i]))
                    $this->session->set_flashdata('message','Đã xóa thành công');
                    else $this->session->set_flashdata('error','Xóa không thành công');
                }
            }
        }
        redirect('sangiare/binhluan/ds/'.$page);
    } 

}
