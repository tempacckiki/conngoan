<?php
class contact extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->lang->load('contact',$this->session->userdata('lang_site'));
        $css_array = array(
                array(base_url().'technogory/components/contact/views/esset/contact.css')
          ); 
        $this->esset->css($css_array);                 
        $this->load->library('gmap');
        
        $js_array = array(          
            array(base_url().'technogory/templates/system/js/map_api.js'),
            array('http://maps.google.com/maps/api/js?sensor=true'),
        );
        $this->esset->js($js_array);
        
        $this->pre_message = "";
    }
    
    function index(){
        $data['title'] = lang('contact.name');
        $this->link[0] = 'Liên hệ';
        $rs  = $this->vdb->find_by_list('supermarkets',array(), array('id'=>'ASC'));
        
        $data['items'] = $rs;
        // From validation
        $this->form_validation->set_rules('contact[fullname]',lang('contact.fullname'),'required');
        $this->form_validation->set_rules('contact[phone]',lang('contact.phone'),'required');
        $this->form_validation->set_rules('contact[email]','E-mail','required');
        $this->form_validation->set_rules('contact[content]',lang('contact.content'),'required');
        if($this->form_validation->run() === FALSE){
            $this->pre_message = validation_errors();
        }else{
            $contact = $this->input->post('contact');
            $contact['datesend'] = time();
            if($this->vdb->update('contact_row',$contact)){
                $this->load->helper('mail_helper');
                $contact_name = 'Hệ thống';
                $contact_email = 'info@360vnit.com';
                $to = $rs->email;
                $subject = 'Mail được gửi tự động từ liên hệ';
                $message ="Họ tên: ".$contact['fullname'];
                $message .="<br />Điện thoại: ".$contact['phone'];
                $message .="<br />E-mail: ".$contact['email'];
                $message .="<br />Nội dung: ".$contact['content'];
                send($to,$subject,$message,$contact_name,$contact_email);
                $this->session->set_flashdata('message',lang('contact.sendok'));
                redirect('contact');
            }
        }
        
        //show map
       
    	$this->gmap->GoogleMapAPI(); 
        $this->gmap->setMapType('map'); 
        $this->gmap->width= '1000px';
        $this->gmap->addMarkerByAddress('17/11 Nguyễn Hữu Tiến, Phường Tây Thạnh, Quận Tân Phú, Tp. Hồ Chí Minh','ALOBUY VIỆT NAM - WEBSITE TMĐT SỐ 1 VIỆT NAM','<b>'.'</b>'.'<br />Địa chỉ:17/11 Nguyễn Hữu Tiến, P Tây Thạnh, Q Tân Phú, HCM '.'<br />Điện thoại: (08) 62 77 99 88'.' - Fax: (08) 6267 2381'.'<br />Email:info@alobuy.vn ');
        $data['headerjs'] 	= $this->gmap->getHeaderJS();
        $data['headermap'] 	= $this->gmap->getMapJS();
        $data['onload'] 	= $this->gmap->printOnLoad();
        $data['map']	 	= $this->gmap->printMap();
        $data['sidebar'] 	= $this->gmap->printSidebar(); 
       
        
        $data['message'] = $this->pre_message;
        //**load templates*******************
        $this->_templates['page']  = 'index';
        $this->templates->load($this->_templates['page'],$data,'home');
    }
    
    function show_map(){
        $rs  = $this->vdb->find_by_list('supermarkets',array(), array('id'=>'ASC'));
        $data['rs'] = $rs;        
        $this->gmap->GoogleMapAPI(); 
        $this->gmap->setMapType('map'); 
        
       
        $data['sidebar'] = $this->gmap->printSidebar();      
        $this->_templates['page']  = 'map';
        $this->load->view($this->_templates['page'],$data);          
    }
}
