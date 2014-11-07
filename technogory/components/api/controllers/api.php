<?php
class api extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('api_model','api');
    }
    /**
     * Method ajax_login_fyi
     * Return <object>
     */
    function ajax_login_fyi(){
    	//get info email & pass
    	$email_login 	= addslashes($this->input->post('email'));
    	$password_login = addslashes($this->input->post('pass'));    	
    	if($email_login == '' || $password_login == ''){
    	 	$data['error'] = 1;
    		$data["msg"] = lang('vuilongnhapemaimatkhau');
    	}else{
	    	//load data memeber
	    	$this->member 			= $this->load->database('member', TRUE);	    	
    		if($this->vdb->find_by_id('user',array('email'=>$email_login))){
	    	if($rs = $this->vdb->find_by_id('user',array('email'=>$email_login,'password'=>md5($password_login)))){		    	
		    	//load library
		    	$this->load->library('auth');
		    	$this->auth->sign_in_ajax($rs->user_id); 
		    	$data['error'] = 0;
		    	$data['msg'] = "Đăng nhập thành công!.Cảm ơn bạn đã dùng dịch vụ của chúng tôi!.";
	    	}else{
		    	$data['error'] = 1;
		    	$data['msg'] = lang('dangnhapthatbai');
	    	}
	    	
	    	}else{
		    	$data['error'] = 1;
		    	$data['msg'] = lang('emailkhongtontai');
	    	}
    	}
    	echo json_encode($data);
    }
    
    /**
     * Method 
     */
 	function ajax_filter(){
        // Catid
        $catid                   = $this->input->post('catid');
        
 		//get manufacture
        //$arrAjaxManu              = explode(',', $this->input->post("manufactureid"));
    	$arrAjaxManu		 	 = $this->input->post("manufactureid");
    	//Color
        //$arrAjaxColor              = explode(',', $this->input->post("color"));
    	$arrAjaxColor		 	 =  trim($this->input->post("color"),',');
    	
    	//variant
        //$arrAjaxVariant              = explode(',', $this->input->post("variant"));
    	$arrAjaxVariant		 	 = trim($this->input->post("variant"),',');
    	
    	if($arrAjaxManu > 0){
	    	$manufactureid		 = $arrAjaxManu;
	    	//$catID				 = end($arrAjaxManu);
	    	$namUrlCat			 = $this->vdb->find_by_id("shop_cat", array('catid'=>$catid))->caturl;
	    	$namUrl				 = $this->vdb->find_by_id("shop_manufacture", array('manufactureid'=>$manufactureid))->name_url;
	    	$data["catid"] 		 = $catid;
	    	$data["name_url"] 	 = $namUrlCat.'-'.$namUrl;
	    	$data["idManuface"]  = $manufactureid;
            
            
            if($arrAjaxVariant != '' && $arrAjaxColor == ''){
                $data['input_get'] = "?varian=".$arrAjaxVariant;
            }else if($arrAjaxColor != '' && $arrAjaxVariant ==''){
                $data['input_get'] = "?color=".$arrAjaxColor;
            }else if($arrAjaxColor != '' && $arrAjaxVariant != ''){
                $data['input_get'] = "?varian=".$arrAjaxVariant.'&color='.$arrAjaxColor;
            }else{
                $data['input_get'] = "";
            }

            
    	}else{
    		$variant_id		 	 = $arrAjaxVariant;
    		//$catID				 = end($arrAjaxVariant);
    		$namUrlCat			 = $this->vdb->find_by_id("shop_cat", array('catid'=>$catid))->caturl;
	    	$namUrl				 = $this->vdb->find_by_id("shop_feature_variant_descriptions", array('variant_id'=>$variant_id))->variant;
	    	//$data["catid"] 		 = $catID;
	    	$data["name_url"] 	 = $namUrlCat.'-'.vnit_change_title($namUrl);
	    	$data["idVarian"] 	 = $variant_id;
    	}
        $data['catid'] = $catid;
    	
    	echo json_encode($data);
    }
    
    
    function ajax_manuf(){
        $catid = (int)$this->input->post('catid');
        $manufactureid = (int)$this->input->post('manufactureid');
        $color = $this->input->post('color');
        $variant = $this->input->post('variant');
        if($manufactureid != 0){
            $data['idManuface'] = $manufactureid;
            $namUrlCat             = $this->vdb->find_by_id("shop_cat", array('catid'=>$catid))->caturl;
            $namUrl                = $this->vdb->find_by_id("shop_manufacture", array('manufactureid'=>$manufactureid))->name_url;
            $data["name_url"]      = $namUrlCat.'-'.$namUrl; 
            $data['maincat']       = 1;
        }else{
            $data['maincat']        = 0;
        }
        
        $data['catid'] = $catid;
        echo json_encode($data);
    }
    
    function sendmail_content(){
        $this->load->helper('mail_helper');
        
          $email_from = $this->input->post('email_from');
          $email_to = $this->input->post('email_to');
          $fullname_from = $this->input->post('fullname_from');
          $subject = $this->input->post('subject');
          $message = "Đây là email  được gửi bởi ".$fullname_from." (".$email_from."). Có thể đây sẽ là 1 liên kết thú vị cho bạn:";
          $message .='<a href="'.$this->input->post('url_send').'">'.$this->input->post('url_send').'</a>';
          if(send_mail_to_friend($fullname_from,$email_from,$email_to,$subject,$message)){
              $data['msg'] = 'Gửi E-mail thành công';
          }else{
              $data['msg'] = 'Gửi Email không thành công';
          }

          echo json_encode($data);
    }
    
    function setlang(){
        $lang = $this->input->post('lang');
        $langs = explode('|',$lang);
        $this->session->set_userdata(array('lang'=>$langs[0]));
        $this->session->set_userdata(array('lang_site'=>$langs[1]));
    }
    
    /******Rating********/
    function rating(){
        $ip = $_SERVER['REMOTE_ADDR'];
        $time = time();
        $time_old = $time-864000;
        $this->db->where('date_line < ',$time_old);
        $this->db->delete('shop_rating_history');
        $session_id = $this->session->userdata('session_id');
        $rating = $this->input->post('rating');
        $text = strip_tags($this->input->post('rating'));
        $id = $this->input->post('id');
        $this->db->where('productid',$id);
        $query = $this->db->get('shop_rating');
        if($query->num_rows() > 0){
            $result = $this->db->query("update shop_rating set counter = counter + 1, value = value + ".$rating." Where productid=".$id);
            //$result = $this->db->query("update productstaticstic set TotalRatingPoint = TotalRatingPoint + 1 Where ProductID=".$id);
            
        }else{
            $this->db->query("insert into shop_rating (productid,counter,value) values ($id,'1',$rating)");
        }
        $this->db->query("INSERT INTO shop_rating_history(productid,rating_ip,rating_session_id,date_line) values($id,'$ip','$session_id',$time)");
     
    } 

    function getrating(){
      $id = $this->uri->segment(3);
      echo $this->api->loadRating($id);
    }  
    /******End rating********/
    
    /***************
    * Đăng ký nhận deal
    */
    function dangkynhandeal(){
        $email = $this->input->post('email');
        $check = $this->vdb->find_by_id('signup_deal',array('email'=>$email));
        if($check){
            $data['msg'] = 'Email của bạn đã được đăng ký';
        }else{
            $vdata['email'] = $email;
            if($this->vdb->update('signup_deal',$vdata)){
                $data['msg'] = 'Đăng ký nhận Deal thành công';
            }else{
                $data['msg'] = 'Đăng ký nhận Deal không thành công';
            }
        }
        echo json_encode($data);
    }
    
    /**************
    * Dang ky Sesssion cho website
    * 
    */
    function closepopcity(){
        $city_id = $this->input->post('city_id');
        $row = $this->vdb->find_by_id('city',array('city_id'=>$city_id));
        if($row){
            $this->session->set_userdata('city_site',$row->city_id);
            $data['error'] = 0;
        }else{
            $data['error'] = 1;
            $data['msg'] = 'Khu vực không tồn tại. Vui lòng chọn lại';
        }
        echo json_encode($data);
    }
    
    function clickqc(){
        $link = $this->input->get('link');
        redirect($link);
    }
    
    function reset_captcha(){
        $data['captcha'] = _make_captcha();
        echo json_encode($data);
    }
    
    // Gui lien ket toi ban be
    
    function send_to_friend(){
        $this->load->helper('mail_helper');
        $ten_nguoinhan = $this->input->post('ten_nguoinhan');
        $email_nguoinhan = $this->input->post('email_nguoinhan');
        $ten_cuaban = $this->input->post('ten_cuaban');
        $email_cuaban = $this->input->post('email_cuaban');
        $noidung = $this->input->post('noidung');
        $mabaove = $this->input->post('mabaove');
        if(!_check_mabaove($mabaove)){
            $data['error'] = 1;
            $data['msg'] = 'Mã bảo vệ không đúng. Vui lòng nhập lại';
        }else{
            $subject = 'Gửi Email cho bạn bè';
            if(send_mail_to_friend($ten_cuaban,$email_cuaban,$email_nguoinhan,$subject,$noidung)){
                $data['error'] = 0;
                $data['msg'] = 'Email của bạn đã được gửi tới '.$ten_nguoinhan.'('.$email_nguoinhan.') thành công';
            }else{
                $data['error'] = 1;
                $data['msg'] = 'Có lỗi. Email chưa được gửi đi';
            }
        }
        echo json_encode($data);
    }
    
    function send_comment(){
        $vdata['productid'] = $this->input->post('productid');
        $vdata['title'] = $this->input->post('title');
        $vdata['fullname'] = $this->input->post('fullname');
        $vdata['email'] = $this->input->post('email');
        $vdata['content'] = $this->input->post('content');
        $vdata['add_date'] = time();
        $vdata['published'] = 1;
        if($commentid = $this->vdb->update('shop_comment',$vdata)){
            $val = $this->vdb->find_by_id('shop_comment',array('commentid'=>$commentid));
            $data['list'] ='<li class="commentlast" id="'.$val->commentid.'">';
                $data['list'] .='<div class="commentuser"><div class="img"><img width="75" alt="" src="http://localhost/2012/fyi/data/no_avatar.png"></div></div>
                <div class="infocomment">
                    <div class="arrow"></div>
                    <div class="boxcomment">
                        <div class="info_user_comment"><span>'.$val->fullname.'</span> <span>'.date('H:i:s d/m/Y',$val->add_date).'</span></div>
                        <p>'.$val->content.'</p>
                    </div>
                </div>
            </li>';
            $data['error'] = 0;
            $data['msg'] = 'Xin cảm ơn.<br />Bạn đã gửi nhận xét thành công';
        }else{
            $data['error'] = 1;
            $data['msg'] = 'Có lỗi. Vui lòng kiểm tra lại';
        }
        echo json_encode($data);
    }
    
    function loadcomment(){
        $offset = $this->input->post('page') + 1;
        $productid = $this->input->post('productid');
        $limit = 5;
        $num = $this->api->get_num_comment($productid);
        if($offset!=0) 
            $start = ($offset - 1) * $limit;
        else
            $start = 0;
        $listcomment = $this->api->get_all_comment($limit,$start,$productid);
        $data['list'] = '';
        foreach($listcomment as $val):
        $data['list'] .='<li class="commentlast" id="'.$val->commentid.'">';
            $data['list'] .='<div class="commentuser"><div class="img"><img width="75" alt="" src="http://localhost/2012/fyi/data/no_avatar.png"></div></div>
            <div class="infocomment">
                <div class="arrow"></div>
                <div class="boxcomment">
                    <div class="info_user_comment"><span>'.$val->fullname.'</span> <span>'.date('H:i:s d/m/Y',$val->add_date).'</span></div>
                    <p>'.$val->content.'</p>
                </div>
            </div>
        </li>';
        endforeach;
        if(count($listcomment) > 0){
            $data['show_more'] = '<a href="javascript:;" onclick="func_morecomment('.$offset.')">Xem thêm nhận xét</a>';
        }else{
            $data['show_more'] = '';
        }
        echo json_encode($data);
    }
    
    // Lay thong tin ban do cua diem bao hanh
    function diembaohanh(){
        $id = $this->input->post('branch_id');
        $rs = $this->vdb->find_by_id('shop_manufacture_security',array('id'=>$id));
        $data['name'] = 'ALOBUY VIET NAM';
        $data['address'] = $rs->address.','.$this->vdb->find_by_id('city',array('city_id'=>$rs->parent_id))->city_name.','.$this->vdb->find_by_id('city',array('city_id'=>$rs->city_id))->city_name;
        $data['phone'] = $rs->phone;
        $data['website'] = $rs->website;
        $data['timework'] = $rs->time_working;
        $data['lat'] = $rs->lat;
        $data['lng'] = $rs->lng;
        echo json_encode($data);
    }
    
    // Dang ky nhan mail khuyen mai
    function subscriptions(){
        $email = $this->input->post('email');
        $check = $this->vdb->find_by_id('subscriptions',array('email'=>$email));
        if($check){
            $data['error'] = 1;
            $data['msg'] = 'Email của bạn đã được đăng ký';
        }else{
            $vdata['email'] = $email;
            $this->vdb->update('subscriptions',$vdata);
            $data['error'] = 0;
            $data['msg'] = 'Cảm ơn! Email của bạn đã được đăng ký thành công';
        }
        echo json_encode($data);
    }
    
    // Thong tin cua tung sieu thi
    function getmarket(){
        $id = $this->input->post('id');
        $data['address'] = $this->config->item('market_address_'.$id);
        $data['phone'] = $this->config->item('market_phone_'.$id);
        $data['fax'] = $this->config->item('market_fax_'.$id);
        $data['email'] = $this->config->item('market_email_'.$id);
        $data['id'] = $id;
        echo json_encode($data);
    }
    
    function get_map_market(){
        $this->load->library('gmap');
        $id = $this->uri->segment(3);
        $name = $this->config->item('market_name_'.$id);
        $address = $this->config->item('market_address_'.$id);
        $phone = $this->config->item('market_phone_'.$id);
        $fax = $this->config->item('market_fax_'.$id);
        $email = $this->config->item('market_email_'.$id);
        $lat = $this->config->item('market_lat_'.$id);
        $lng = $this->config->item('market_lng_'.$id);
        
        $this->gmap->GoogleMapAPI(); 
        $this->gmap->setMapType('map'); 
        $this->gmap->addMarkerByAddress($address,'alobuy.vn',"<b>".$name."</b><br />".$address."<br />Điện thoại: ".$phone." <br />Email: ".$email);
        $data['headerjs'] = $this->gmap->getHeaderJS();
        $data['headermap'] = $this->gmap->getMapJS();
        $data['onload'] = $this->gmap->printOnLoad();
        $data['map'] = $this->gmap->printMap();
        $data['sidebar'] = $this->gmap->printSidebar();
        
        $this->_templates['page'] = 'map_market';
        $this->load->view($this->_templates['page'],$data);
    }
    
      function callforme(){
          $data['title'] = 'Call';
          $id = $this->uri->segment(3);
          $data['rs'] = $this->vdb->find_by_id('shop_product',array('productid'=>$id));
          $this->_templates['page'] = 'call';
          $this->load->view($this->_templates['page'],$data);
      }
      
      function send_callforme(){
          //$catid = $this->input->post('catid');
          $productid = $this->input->post('productid');
          $fullname = $this->input->post('fullname');
          $phone = $this->input->post('phone');
          $content = $this->input->post('content');
          if($fullname != '' && $phone != '' && $content != ''){
              $vdata['productid'] = $productid;
              $vdata['fullname'] = $fullname;
              $vdata['phone'] = $phone;
              $vdata['content'] = $content;
              $vdata['add_date'] = time();
              $this->vdb->update('callforme',$vdata);
              $data['error'] = 0;
              $data['msg'] = 'Xin cảm ơn. Chúng tôi đã nhận được yêu cầu của bạn';
          }else{
              $data['error'] = 1;
              $data['msg'] = 'Gửi tư vấn không thành công';
          }
          echo json_encode($data);
      }
}


