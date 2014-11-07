<?php
class account extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->group = $this->vdb->find_by_list('user_group');
        $this->load->model('account_model','account');
        $js_array = array(
            array(base_url().'components/account/views/esset/account.js')
        );
        $this->esset->js($js_array);
        $this->pre_message = "";
         
    }
    
    function index(){
        redirect('account/listaccount');
    }
    
    function listaccount(){
        
        write_log(61,180,'Xem danh sách thành viên');
        $data['title'] = 'Danh sách thành viên';
        $data['add'] = 'account/add';
        $data['delete'] = true;
        $data['listcity'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $city_id = $this->input->get('city_id');
        $data['city_id'] = $city_id;
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);   
        if($field == '' && $order ==''){
            $field = 'user_id';
            $order = 'desc';
        }               
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'account/listaccount/';  
        $config['total_rows']   =  $this->account->get_num_user($city_id);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   1000;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->account->get_all_user($config['per_page'],$this->uri->segment(3),$city_id,$field,$order);

        $data['pagination']    = $this->pagination->create_links();          
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function listaccountAddmin(){        
        //write_log(61,180,'Xem danh sách thành viên');
        $data['title'] = 'Danh sách thành viên';
        $data['add'] = 'account/add';
        $data['delete'] = true;
        $data['listcity'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $city_id = $this->input->get('city_id');
        $data['city_id'] = $city_id;
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);   
        if($field == '' && $order ==''){
            $field = 'user_id';
            $order = 'desc';
        }               
       
        $config['suffix'] = '/'.$field.'/'.$order;          
        $config['base_url'] = base_url().'account/listaccount/';  
        $config['total_rows']   =  $this->account->get_num_userAdmin($city_id);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        
        $data['list'] =   $this->account->get_all_userAdmin($config['per_page'],$this->uri->segment(3),$city_id,$field,$order);

        $data['pagination']    = $this->pagination->create_links();          
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    
    function add(){
        $data['title'] = 'Thêm mới thành viên';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'account/listaccount';   
        $data['listcity'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));      
        // Form valdidation
        $this->form_validation->set_rules('user[fullname]','Họ và tên','required');
        //$this->form_validation->set_rules('user[username]','Tên đăng nhập','required|callback__checkusername');
        $this->form_validation->set_rules('user[email]','Email đăng nhập','required|valid_email|callback__checkemail');
        $this->form_validation->set_rules('password','Mật khẩu','required');
        $this->form_validation->set_rules('re_password','Mật khẩu nhập lại','required|matches[password]');
        $this->form_validation->set_rules('user[city_id]','Tỉnh, Thành phố','required');
        $this->form_validation->set_rules('user[district_id]','Quận, Huyện','required');
        if($this->form_validation->run() === FALSE){
             $this->pre_message = validation_errors();
        }else{
             $user = $this->input->post('user');
             $user['password'] = md5($this->input->post('password'));
             $user['create_time'] = time();
             $user['active_shop'] = 1;
             $this->member = $this->load->database('member', TRUE);
             if($this->member->insert('user',$user)){
                $id = $this->member->insert_id();
                write_log(61,181,'Thêm mới thành viên: '.$user['fullname']); 
                $this->session->set_flashdata('message','Lưu thành công');
                $this->member = $this->load->database('member', TRUE);
                $vdata['user_code'] = vnit_barcode('FYI_',$id,8);
                $this->member->update('user',$vdata,array('user_id'=>$id));
                $option =  $this->input->post('option');
                if($option == 'save'){
                    $url = 'account/listaccount';
                }else{
                    $url = 'account/edit/'.$id;
                }
                redirect($url);
             }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'add';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function _checkusername($username){
        $this->member = $this->load->database('member', TRUE);
        $this->member->where('username',$username);
        $row = $this->member->get('user')->row();
        if($row){
            $this->form_validation->set_message('_checkusername', 'Tên đăng nhập đã tồn tại trên hệ thống'); 
            return FALSE;
        }else{
            return true;
        }
    }
    function _checkemail($email){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('email',$email);
        $row = $this->member->get('user')->row();
        if($row){
            $this->form_validation->set_message('_checkemail', 'Email đã tồn tại trên hệ thống'); 
            return FALSE;
        }else{
            return true;
        }
    } 
    
    function edit(){
        $data['title'] = 'Cập nhật thành viên';
        $data['save'] = true;
        $data['apply'] = true;
        $data['cancel'] = 'account/listaccount'; 
        $user_id = $this->uri->segment(3);        
        
        $data['listcity'] = $this->vdb->find_by_list('city',array('parentid'=>0),array('ordering'=>'asc'));
        $data['rs'] = $this->account->find_by_member($user_id);
        // Form valdidation
        $this->form_validation->set_rules('user[fullname]','Họ và tên','required');
        //$this->form_validation->set_rules('user[username]','Tên đăng nhập','required|callback__checkusernameedit');
        $this->form_validation->set_rules('user[email]','Email đăng nhập','required|valid_email|callback__checkemailedit');
        //$this->form_validation->set_rules('password','Mật khẩu','required');
        $this->form_validation->set_rules('re_password','Mật khẩu nhập lại','matches[password]');
        if($this->form_validation->run() === FALSE){
             $this->pre_message = validation_errors();
        }else{
             $user = $this->input->post('user');
             $user_id = $this->input->post('user_id');
             $password = $this->input->post('password');
             
             if($password !=''){
                $user['password'] = md5($password);
             }
             $user['user_code'] = vnit_barcode('FYI_',$user_id,8);
             $user['active_shop'] = 1;
             $this->member = $this->load->database('member', TRUE);
             if($this->member->update('user',$user,array('user_id'=>$user_id))){
                 write_log(61,182,'Cập nhật thông tin thành viên: '.$user['fullname']);
                $this->session->set_flashdata('message','Lưu thành công');
                $option =  $this->input->post('option');
                if($option == 'save'){
                   $url = 'account/listaccount/';
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
    
    function _checkusernameedit($username){
        $this->db->where('user_id !=',$this->uri->segment(3));
        $this->db->where('username',$username);
        $row = $this->db->get('user')->row();
        if($row){
            $this->form_validation->set_message('_checkusernameedit', 'Tên đăng nhập đã tồn tại trên hệ thống'); 
            return FALSE;
        }else{
            return true;
        }
    }
    function _checkemailedit($email){
        $this->db->where('user_id !=',$this->uri->segment(3));
        $this->db->where('email',$email);
        $row = $this->db->get('user')->row();
        if($row){
            $this->form_validation->set_message('_checkemailedit', 'Email đã tồn tại trên hệ thống'); 
            return FALSE;
        }else{
            return true;
        }
    } 
    
    function del(){
        $this->member = $this->load->database('member', TRUE);
        $id = $this->uri->segment(3);                                              
        $page = $this->uri->segment(4);
        $user = $this->account->find_by_member($id);
        $fullname = $user->fullname;
        if($this->member->delete('user',array('user_id'=>$id))){
            write_log(61,184,'Xóa thành viên: '.$fullname.' khỏi hệ thống');
            $this->session->set_flashdata('message','Đã xóa thành công');
        }else{
            $this->session->set_flashdata('message','Xóa không thành công');
        }
        redirect('account/listaccount/'.$page);
    }
    // Xoa nhieu ban ghi
    function dels(){
        if(!empty($_POST['ar_id']))
        {
            $this->member = $this->load->database('member', TRUE);
            $page = (int)$this->input->post('page');
            $ar_id = $this->input->post('ar_id');
            for($i = 0; $i < sizeof($ar_id); $i ++) {
                if ($ar_id[$i]){
                    $user = $this->account->find_by_member($ar_id[$i]);
                    $fullname = $user->fullname;
                    if($this->member->delete('user',array('user_id'=>$ar_id[$i]))){ 
                        write_log(61,183,'Xóa thành viên: '.$fullname.' khỏi hệ thống'); 
                        $this->session->set_flashdata('message','Đã xóa thành công');
                    }else{
                        $this->session->set_flashdata('error','Xóa không thành công');
                    }
                }
            }
        }
        redirect('account/listaccount/'.$page);
    }  
      
    function export(){
        $tungay = $this->input->post('tungay');
        $denngay = $this->input->post('denngay');
        $city_id = $this->input->post('city_id');
        $data['tungay'] = $tungay;
        $data['denngay'] = $denngay;
        $data['city_id'] = $city_id;
        $data['list'] = $this->account->get_account_by_date($tungay, $denngay, $city_id);
        $this->_templates['page'] ='export';
        $this->load->view($this->_templates['page'],$data);
    }
      
    function get_district(){
        $city_id = $this->input->post('city_id');
        $data['list'] = '<option value="">Chọn Quận, Huyện</option>';
        $list = $this->vdb->find_by_list('city',array('parentid'=>$city_id,'parentid !='=>0));
        foreach($list as $val):
            $data['list'] .='<option value="'.$val->city_id.'">'.$val->city_name.'</option>';
        endforeach;
        echo json_encode($data);
    }
    
    
    // Lich su truy cap
    function history(){
        $data['title'] = 'Lịch sử truy cập';
        $data['list'] = $this->account->get_all_admin();
        $this->_templates['page'] = 'history';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    // Xem lich su truy cap cua 1 thanh vien
    function view_history(){
        $data['title'] = 'Lịch sử truy cập';
        $key = $this->input->get('date');
        if($key != ''){
            $key_url = '?date='.$key;
            $begin = strtotime('0:0:0 '.$key);
            $end = strtotime('23:59:0 '.$key);
        }else{
            $key_url = '';
            $begin = 0;
            $end = 0;
        }

        $user_id = $this->uri->segment(3); 
        $data['key'] = $key;
        $data['user_id'] = $user_id;
        $config['suffix'] = $key_url;         
        $config['base_url'] = base_url().'account/view_history/'.$user_id;  
        $config['total_rows']   =  $this->account->get_num_history($user_id, $begin, $end);
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 4; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->account->get_all_history($config['per_page'],$this->uri->segment(4),$user_id, $begin, $end);
        $data['pagination']    = $this->pagination->create_links();
        $this->_templates['page'] = 'view_history';
        $this->templates->load($this->_templates['page'],$data);
    }
}
