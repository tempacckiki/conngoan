<?php
class openid extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        
        //load model
        $this->load->model('openid_model','openid');
        $this->user_id = $this->session->userdata('user_id');
        $this->load->library('auth');
		$this->load->library('vopenid');
        $this->lang->load('openid',$this->session->userdata('lang_site'));

        $this->group_id = $this->session->userdata('group_id');
        $this->user_id = $this->session->userdata('user_id');
        $this->pre_message = "";
        //init css
        $cssArray  = array(
        		array(base_url().'technogory/templates/default/css/cart-more.css')
        );
      /*   $js_array = array(
            array(base_url().'technogory/templates/system/js/jquery.validate.min.js')
        );
        $this->esset->js($js_array); */
        $this->esset->css($cssArray);
    }
    /**
     * Methos Login
     */
    function login_fyi(){
    	$data['title'] = lang('dangnhap');
    	//set top link
    	$data['top_link']	= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="javascript:;" itemprop="url"><span itemprop="title">'.lang('dangnhap').'</span></a></div>';
    	
    	if($this->session->userdata('user_id')){
    		redirect('thanh-toan/thong-tin-giao-nhan');
    	}
    	$this->form_validation->set_rules('email',lang('emaildangnhap'),'required|valid_email|callback__check_email_login');
    	$this->form_validation->set_rules('password',lang('matkhau'),'required|min_length[6]|max_length[12]');
    	if($this->form_validation->run() === FALSE){
    		$this->pre_message = validation_errors();
    	}else{
    
    		$email = $this->input->post('email');
    		$password = md5($this->input->post('password'));
    		
    		$check = $this->openid->check_account_login($email, $password);
    		 
    		if($check){
    			if($check->published == 1){
    				$this->auth->sign_in($check->user_id);
    			}else{
    				$this->pre_message = lang('taikhoanchuakichhoat');
    			}
    		}else{
    			$this->pre_message = lang('dangnhapthatbai');
    		}
    	}
    	$data['message'] = $this->pre_message;
    	$this->_templates['page'] = 'login_fyi';
    	$this->templates->load($this->_templates['page'],$data,'member');
    }
    /**
     * Method ajax_login_fyi
     * Return <object>
     */
    function ajax_login_fyi(){
    	//get info email & pass
    	$email_login 	= $this->input->post('email');
    	$password_login = $this->input->post('pass');
    	/* if($email_login == '' || $password_login == ''){
    		$data['error'] = 1;
    		$data["msg"] = lang('vuilongnhapemaimatkhau');
    	}else{
    		//load data memeber
    		$this->member 			= $this->load->database('member', TRUE);
    		if($this->vdb->find_by_id('user',array('email'=>$email_login))){
    			if($rs = $this->vdb->find_by_id('user',array('email'=>$email_login,'password'=>md5($password_login)))){
    				$data['error'] = 0;
    				$this->auth->sign_in_ajax($rs->user_id);
    			}else{
    				$data['error'] = 1;
    				$data['msg'] = lang('dangnhapthatbai');
    			}
    		}else{
    			$data['error'] = 1;
    			$data['msg'] = lang('emailkhongtontai');
    		}
    	} */
    	echo json_encode($email_login);
    }
    
    
    function connect_google(){
        if(!$this->vopenid->mode) {
          if(isset($_GET['login'])) {
            $this->vopenid->identity = 'https://www.google.com/accounts/o8/id'; //https://www.yahoo.com  - https://www.google.com/accounts/o8/id
            $this->vopenid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
            header('Location: ' . $this->vopenid->authUrl());
          }              
        } elseif($this->vopenid->mode == 'cancel') {
              $this->session->set_flashdata('message','Bạn đã hủy không sử dụng tài khoản Google để đăng nhập.');
              redirect();              
          
        } else {
          if($this->vopenid->validate()){
            $identity = $this->vopenid->identity;
            $attributes = $this->vopenid->getAttributes();
            $email = $attributes['contact/email'];
            $first_name = $attributes['namePerson/first'];
            $last_name = $attributes['namePerson/last']; 
            $fullname = $first_name.' '.$last_name;
            $is_login = $this->openid->check_is_create_openid($email,$identity);
           
            if($is_login != 0){
                $this->auth->sign_in_open_id($is_login);     
            }else{
                $AccountID = $this->openid->create_account($email,$fullname,$identity);    
                $this->auth->sign_in_open_id($AccountID);     
            }
            
                                            
          }else{
              $this->session->set_flashdata('message','Bạn đang đăng nhập bằng tài khoản Google.');
              redirect();
          }
        }
    }
    function connect_yahoo(){
      if(!$this->vopenid->mode) {
          if(isset($_GET['login'])) {
            $this->vopenid->identity = 'https://www.yahoo.com'; //https://www.yahoo.com  - https://www.google.com/accounts/o8/id
            $this->vopenid->required = array('namePerson/first', 'namePerson/last', 'contact/email');
            header('Location: ' . $this->vopenid->authUrl());
          }              
      } elseif($this->vopenid->mode == 'cancel') {
              $this->session->set_flashdata('message','Bạn đã hủy không sử dụng tài khoản Yahoo để đăng nhập.');
              redirect();              
          
      } else {
          if($this->vopenid->validate()){
            $identity = $this->vopenid->identity;
            $attributes = $this->vopenid->getAttributes();
            $email = $attributes['contact/email'];
            //$first_name = $attributes['namePerson/first'];
            //$last_name = $attributes['namePerson/last']; 
            $email_tmpl = explode('@',$email);
            $fullname = $email_tmpl[0];
            $is_login = $this->openid->check_is_create_openid($email,$identity);
            $is_email = $this->openid->is_email($email);
            if($is_login!=0){
                $this->auth->sign_in($is_login);     
            }else if($is_email){
                $AccountID = $this->openid->update_openid($email,$identity);
                $this->auth->sign_in_open_id($AccountID);
            }else{
                $AccountID = $this->openid->create_account($email,$fullname,$identity);    
                $this->auth->sign_in_open_id($AccountID);     
            }
            
                                            
          }else{
              $this->session->set_flashdata('message','Bạn đang đăng nhập bằng tài khoản Yahoo.');
              redirect();
          }
      }          
    }
    
    function connect_fb(){
        $data['title'] = "fb";
        require ROOT.'technogory/libraries/facebook/facebook.php';
        $facebook = new Facebook(array(
          'appId'  => '313825038706683',
          'secret' => '9d01ce6386857fbb1006d5d2153e61c5',
        ));
        $user = $facebook->getUser();

        if ($user) {
              try {
                $user_profile = $facebook->api('/me');
              } catch (FacebookApiException $e) {
                error_log($e);
                $user = null;
              }
        }
        if ($user) {
          $logoutUrl = $facebook->getLogoutUrl();
        } else {
          $loginUrl = $facebook->getLoginUrl();
        }
        
        if ($user){// Da dang nhap
            $fb_id  = $user_profile['id'];
            $fb_name  = $user_profile['name'];
            $fb_email  = $user_profile['email'];
            $fb_gender  = $user_profile['gender'];
            $fb_birthday  = $user_profile['birthday'];
            $check = $this->openid->is_email_fb($fb_email);
            if($check){
                // Dang nhap khi da ton tai Email
                $this->auth->sign_in_open_id($check->user_id); 
            }else{
                // Dang ky thanh vien;
                $vdata['group_id'] = 1;
                $vdata['fullname'] = $fb_name;
                $vdata['email'] = $fb_email;
                $ns = explode('/',$fb_birthday);
                if(count($ns) > 1){
                $vdata['brithday'] = $ns[2].'-'.$ns[0].'-'.$ns[1];
                }
                $vdata['male'] = ($fb_gender == 'male')?1:0;
                $vdata['is_openid'] = 1;
                $vdata['create_time'] = time();
                $vdata['published'] = 1;
                $user_id = $this->openid->save_account_fb($vdata);
                $this->auth->sign_in_open_id($user_id);  
            }
        }else{ // Chua dang nhap
            header('Location: '.$loginUrl);
        }

            
    } 
    /*-------------------------------------+
     * Register function
     ++++++++++++++++++++++++++++++++++++++++*/
    function connectRegister(){
        $data['title']      = lang('dangkytaikhoan');
      	//set top link
        $data['top_link']	= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="javascript:;" itemprop="url"><span itemprop="title">'.lang('dangkytaikhoan').'</span></a></div>';
        $data['listcity']   = $this->vdb->find_by_list('city',array('published'=>1,'parentid '=>0)); 
        $data['img']        = $this->_make_captcha();
        $this->form_validation->set_rules('email',lang('emaildangnhap'),'required|valid_email|callback__check_email');
        $this->form_validation->set_rules('password',lang('matkhau'),'required|min_length[6]|max_length[12]');
        $this->form_validation->set_rules('re_password',lang('nhaplaimatkhau'),'required|min_length[6]|max_length[12]|matches[password]');
        $this->form_validation->set_rules('fullname',lang('hovaten'),'required');
        $this->form_validation->set_rules('phone',lang('dienthoai'),'required');
        $this->form_validation->set_rules('address',lang('diachi'),'required');
        $this->form_validation->set_rules('city_id',lang('tinhthanhpho'),'required');
        $this->form_validation->set_rules('district_id',lang('quanhuyen'),'required');
        $this->form_validation->set_rules('code','Mã bảo vệ','trim|required|callback__check_captcha');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $vdata['group_id'] = 1;
            $vdata['email'] = $this->input->post('email');
            $vdata['password'] = md5($this->input->post('password'));
            $vdata['fullname'] = $this->input->post('fullname');
            $vdata['phone'] = $this->input->post('phone');
            $vdata['address'] = $this->input->post('address');
            $vdata['city_id'] = $this->input->post('city_id');
            $vdata['district_id'] = $this->input->post('district_id');
            $vdata['is_openid'] = 0;
            $vdata['create_time'] = time();
            $vdata['published'] = 0;
            $vdata['active_code'] = createRandomCode();
            $this->member = $this->load->database('member', TRUE); 
            if($this->member->insert('user',$vdata)){
            	
                $id = $this->member->insert_id();
                $this->member = $this->load->database('member', TRUE); 
                $vup['user_code'] = vnit_barcode('ALO_',$id,8);
                $this->member->update('user',$vup,array('user_id'=>$id));
                $rs = $this->openid->get_user($id);
               
                // Gui thong tin dang nhap qua email
                $this->load->helper('mail_helper');
                $templates = $this->openid->get_email_templates('fyi_dangkytaikhoan');
               
                // Subject
                $subject_php = addslashes($templates->subject);
                eval("\$subject=\"$subject_php\";");
                // Content
                $email 		= $rs->email;
                $matkhau 	= $this->input->post('password');
                $hovaten 	= $rs->fullname;
                $diachi 	= $rs->address;
                $quanhuyen 	= $this->vdb->find_by_id('city',array('city_id'=>$rs->district_id))->city_name;
                $thanhpho 	= $this->vdb->find_by_id('city',array('city_id'=>$rs->city_id))->city_name;
                $dienthoai 	= $rs->phone;
                $url 		= anchor('kich-hoat-tai-khoan/'.$id.'/'.$rs->active_code,'<b>Kích hoạt</b>');
                $to 		= $email;
                $template_text= addslashes($templates->content);
              
                eval("\$body=\"$template_text\";");
                send_mail_templates($to,$subject,$body);
                
                $this->session->set_flashdata('message',"Tạo tài khoản thành công!");
                redirect('dang-ky');
            }else{
                $this->session->set_flashdata('error',"Tạo tài khoản không thành công!");
            }
        }
        $data['message'] = $this->pre_message;
        
        // Load templates**************************
        $this->_templates['page'] = 'register';
        $this->templates->load($this->_templates['page'],$data,'member');
    }
    
    function active(){
        $data['title'] = lang('kichhoattaikhoan');
        $user_id = $this->uri->segment(2);
        $active_code = $this->uri->segment(3);
        //get user
        $rs = $this->openid->get_user($user_id);
      	
        if(!$rs){
            $data['msg'] = "Tài khoản này không tồn tại!";
        }else{
            if($rs->active_code == ""){
                $data['msg'] = lang('taikhoandaduockichhoat');
            }else if($rs->active_code != $active_code){
                $data['msg'] = "Mã kích hoạt không chính xác!.";
            }else{
                $vdata['active_code'] 	= "";
                $vdata['active_shop'] 	= 1;
                $vdata['published'] 	= 1;
                $this->member 			= $this->load->database('member', TRUE); 
                $this->member->update('user',$vdata,array('user_id'=>$user_id));
               
                //mess    
                $data['msg'] = "Bạn đã kích hoạt tài khoản thành công!";
                $this->member 			= $this->load->database('member', FALSE);
                //set lai data
               $this->db = $this->load->database('default', TRUE); 
            }
        }
        $this->_templates['page'] = 'active';
        $this->templates->load($this->_templates['page'],$data,'member');
    }
    
    function _check_email($email){
        $this->member = $this->load->database('member', TRUE);
        $this->member->where('email',$email);
        $check = $this->member->get('user')->row();
        if($check){
            $this->form_validation->set_message('_check_email', 'Email đã tồn tại trên hệ thống');
            return FALSE;
        }else{
            return TRUE;
        }
    }
    
   
    function ajax_connect_fyi(){
        $email = $this->input->post('email');
        if($this->vdb->find_by_id('user',array('email'=>$email))){
            $data['error'] = 1;
            $data['msg'] = 'Email đã tồn tại trên hệ thống. Vui lòng chọn Email khác';
        }else{
            $vdata['group_id'] = 1;
            $vdata['email'] = $email;
            $vdata['password'] = md5($this->input->post('password'));
            $vdata['fullname'] = $this->input->post('fullname');
            $vdata['phone'] = $this->input->post('phone');
            $vdata['address'] = $this->input->post('address');
            $vdata['city_id'] = $this->input->post('city_id');
            $vdata['is_openid'] = 0;
            $vdata['create_time'] = time();
            $vdata['published'] = 0;
            $vdata['active_code'] = createRandomCode();
            if($id = $this->vdb->update('user',$vdata)){
                $vup['user_code'] = vnit_barcode('FYI_',$id,8);
                $this->vdb->update('user',$vup,array('user_id'=>$id));
                $rs = $this->vdb->find_by_id('user',array('user_id'=>$id));
                // Gui thong tin dang nhap qua email
                $this->load->helper('mail_helper');
                $templates = $this->vdb->find_by_id('email_templates',array('slug'=>'fyi_dangkytaikhoan'));
                // Subject
                $subject_php = addslashes($templates->subject);
                eval("\$subject=\"$subject_php\";");
                // Content
                $email = $rs->email;
                $hovaten = $rs->fullname;
                $diachi = $rs->address;
                $quanhuyen = $this->vdb->find_by_id('city',array('city_id'=>$rs->district_id))->city_name;
                $thanhpho = $this->vdb->find_by_id('city',array('city_id'=>$rs->city_id))->city_name;
                $dienthoai = $rs->phone;
                $url = anchor('kich-hoat-tai-khoan/'.$id.'/'.$rs->active_code,'<b>Kích hoạt</b>');
                $to = $email;
                $template_text=addslashes($templates->content);
                eval("\$body=\"$template_text\";");
                send_mail_templates($to,$subject,$body);
                
                $data['error'] = 0;
                $data['msg'] = 'Tạo tài khoản thành công. Vui lòng kiểm tra Email để kích hoạt tài khoản';
                
            }else{
                $data['error'] = 1;
                $data['msg'] = lang('dangnhapthatbai'); 
            }
        }
        echo json_encode($data);

    }
    
    function _check_email_login($email){
        $this->member = $this->load->database('member', TRUE);
        $this->member->where('email',$email);
        $check = $this->member->get('user')->row();
        if($check){
            return TRUE;
        }else{
            $this->form_validation->set_message('_check_email_login', 'Email không tồn tại trên hệ thống');
            return FALSE;
        }
    }
    
    function sign_out(){
        $this->auth->sign_out();
        redirect();
    }
    
    function change_pass(){
        $data['title'] = 'Đổi mật khẩu';
        $data['rs'] = $this->openid->get_user_by_id();
        $this->form_validation->set_rules('pass_old',lang('matkhaucu'),'required|callback__check_pass');
        $this->form_validation->set_rules('pass_new',lang('matkhaumoi'),'required|min_length[5]|max_length[12]');
        $this->form_validation->set_rules('re_pass_new',lang('nhapmatkhaumoi'),'required|min_length[5]|max_length[12]|matches[pass_new]');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $vdata['password'] = md5($this->input->post('pass_new'));
            $this->member = $this->load->database('member', TRUE); 
            if($this->member->update('user',$vdata,array('user_id'=>$this->user_id))){
                $this->db = $this->load->database('default', TRUE);
                $this->session->set_flashdata('message',lang('doimatkhauthanhcong'));
                redirect(uri_string());
            }else{
                $this->pre_message = lang('doimatkhaukhongthanhcong');
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'change_pass';
        $this->templates->load($this->_templates['page'],$data,'member');
        
    }
    
    function _check_pass($pass_old){
        $this->member = $this->load->database('member', TRUE);
        $password = md5($pass_old);
        $check = $this->openid->check_pass($password);
        $this->db = $this->load->database('default', TRUE);
        if($check){
            return TRUE;
        }else{
            $this->form_validation->set_message('_check_pass', 'Mật khẩu cũ bạn nhập không đúng');
            return FALSE;
        }
    }
    /*
    function change_avatar(){
        $data['title'] = 'Đổi hình đại diện';
        $data['rs'] = $this->openid->get_user_by_id();
        $this->db = $this->load->database('default', TRUE);  
        if(isset($_FILES['userfile'])){
            $config['upload_path'] = ROOT_IMG.'temp/';
            $config['allowed_types'] = 'gif|jpg|png';
            $config['max_size']    = '1000';
            $config['max_width']  = '1024';
            $config['max_height']  = '768'; 
            $this->load->library('upload', $config);
            $this->upload->initialize($config);                     
                   
            if ( !$this->upload->do_upload()){
                $this->pre_message =  $this->upload->display_errors();
            }else{                         
                $result =  $this->upload->data();
                $file_name = $result['file_name'];
                $filetype = end(explode('.',$file_name));
                $file_name_new = vnit_change_title($this->session->userdata('fullname'));
                $avatar_new = $file_name_new.'.'.$filetype;
                $avatar_url = $avatar_new;
                $this->load->helper('img_helper');
                vnit_resize_image(ROOT_IMG.'temp/'.$file_name,ROOT_IMG.'avatar/'.$avatar_new,110,110);
       
                if($this->openid->update_avatar($avatar_url)){
                    if(file_exists(ROOT_IMG.'temp/'.$file_name)){
                        unlink(ROOT_IMG.'temp/'.$file_name);
                    }
                    $this->session->set_flashdata('message',"Hình đại điện đã được thay đổi thành công");
                }else{
                    $this->session->set_flashdata('message',"Không thành công");
                }  
                 redirect('u/doi-hinh-dai-dien');                   
            }                    
        } 
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'change_avatar';
        $this->templates->load($this->_templates['page'],$data,'member');
    }
    */
    function change_info(){
        $data['title'] = 'Thông tin tài khoản';
        $data['message'] = $this->pre_message;
        $data['listcity'] = $this->vdb->find_by_list('city',array('published'=>1,'parentid '=>0));
        $data['rs'] = $this->openid->get_user_by_id();
        $this->db = $this->load->database('default', TRUE);
        $this->form_validation->set_rules('fullname','Họ và tên','required');
        $this->form_validation->set_rules('phone','Điện thoại','required');
        $this->form_validation->set_rules('address','Địa chỉ','required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $vdata['fullname'] = $this->input->post('fullname');
            $vdata['phone'] = $this->input->post('phone');
            $vdata['address'] = $this->input->post('address');
            $vdata['city_id'] = $this->input->post('city_id');
            $vdata['district_id'] = $this->input->post('district_id');
            $vdata['male'] = (int)$this->input->post('male');
            $vdata['brithday'] = $this->input->post('date_y').'-'.$this->input->post('date_m').'-'.$this->input->post('date_d');
            $this->member = $this->load->database('member', TRUE); 
            if($this->member->update('user',$vdata,array('user_id'=>$this->session->userdata('user_id')))){
                $this->session->set_flashdata('message',lang('capnhatthanhcong'));
                redirect(uri_string());
            }else{
                $this->pre_message = lang('capnhatkhongthanhcong');
            }
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'info';
        $this->templates->load($this->_templates['page'],$data,'member');
    }
    
    function _check_email_find_pass($email){
        $this->member = $this->load->database('member', TRUE);
        $this->member->where('email',$email);
        $check = $this->member->get('user')->row();
        if($check){
            return TRUE;
        }else{
            $this->form_validation->set_message('_check_email_find_pass', 'Email không tồn tại trên hệ thống');
            return FALSE;
        }
    }
    /**
     * Method find_pass
     */
    function find_pass(){
        $data['title'] = 'Lấy lại mật khẩu';
        //set top link
        $data['top_link']	= '<div itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="javascript:;" itemprop="url"><span itemprop="title">Lấy lại mật khẩu</span></a></div>';
        
        
        $this->form_validation->set_rules('email','Email đăng nhập','required|valid_email|callback__check_email_find_pass');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $this->load->helper('mail_helper');
            $this->db = $this->load->database('default', TRUE);
            $templates = $this->openid->get_email_templates('fyi_quenmatkhau');
            $matkhaumoi = createRandomPassword();
            $to = $this->input->post('email');
            $vdata['password'] = md5($matkhaumoi);
            $this->member = $this->load->database('member', TRUE);
            $this->member->update('user',$vdata,array('email'=>$this->input->post('email')));
            $subject = $templates->subject;
            $template_text=addslashes($templates->content);
            eval("\$body=\"$template_text\";");
            send_mail_templates($to,$subject,$body);
            $this->session->set_flashdata('message','Mật khẩu mới được gửi tới email của bạn. Vui lòng kiểm tra Email');
            redirect('u/quen-mat-khau');
        }
        $data['message'] = $this->pre_message;
        $this->_templates['page'] = 'find_pass';
        $this->templates->load($this->_templates['page'],$data,'member');
    }
    
    function get_district(){
        $city_id = $this->input->post('city_id');
        $data['list'] = '<option value="">'.lang('chonquanhuyen').'</option>';
        $list = $this->vdb->find_by_list('city',array('parentid'=>$city_id,'parentid !='=>0));
        foreach($list as $val):
            $data['list'] .='<option value="'.$val->city_id.'">'.$val->city_name.'</option>';
        endforeach;
        echo json_encode($data);
    }
    
    // Tạo tài khoản khi mua hang
    
    function create_account_order(){
        $this->form_validation->set_rules('email_login_pay','','');
        if($this->form_validation->run()){
            $email = $this->input->post('email_login_pay');
            $password = $this->input->post('pass_pay');
            if($this->openid->is_email($email)){
                $data['error'] = 1;
                $data['msg'] = 'Email của bạn đã tồn tại trong hệ thống';
            }else{
                $data['email'] = $email;
                $data['passwd'] = $password;
                $data['msg'] = 'Thông tin tài khoản đã được lưu';
                $data['error'] = 0;
            }
            echo json_encode($data);
        }else{
            $data['title'] = 'Tạo tài khoản';
            $this->_templates['page'] = 'create_account_order';
            $this->load->view($this->_templates['page'],$data);
        }
    }
    
    function _make_captcha(){
        $this ->load -> helper('captcha');
        $vals = array(
            'img_path' => './captcha/', // PATH for captcha ( *Must mkdir (htdocs)/captcha )
            'img_url' => base_url().'captcha/', // URL for captcha img
            'img_width' => 120, // width
            'img_height' => 30, // height
            'font_path'     => './system/fonts/chaudoc.ttf',
            'expiration' => 600 
        ); 
        // Create captcha
        $cap = create_captcha( $vals ); 
        // Write to DB
        if ( $cap ) {
            $data = array(
                'captcha_id' => '',
                'captcha_time' => $cap['time'],
                'ip_address' => $this -> input -> ip_address(),
                'word' => $cap['word'] 
            );
            $query = $this -> db -> insert_string( 'captcha', $data );
            $this -> db -> query( $query );
        }else {
            return "Mã an toàn không hoạt động" ;
        }
        return $cap['image'] ;
    }
    function _check_captcha($code){ 
        // Delete old data ( 2hours)
        $this->db = $this->load->database('default', TRUE);
        $expiration = time()-600 ;
        $sql = " DELETE FROM captcha WHERE captcha_time < ? ";
        $binds = array($expiration);
        $query = $this->db->query($sql, $binds);

        //checking input
        $sql = "SELECT COUNT(*) AS count FROM captcha WHERE word = ? AND ip_address = ? AND captcha_time > ?";
        $binds = array($code, $this->input->ip_address(), $expiration);
        $query = $this->db->query($sql, $binds);
        $row = $query->row();

        if ( $row -> count > 0 ){
            return true;
        }else{
            $this->form_validation->set_message('_check_captcha', 'Mã bảo vệ không đúng');
            return false;
        }
    }

}
