<?php
class support extends CI_Controller{
    protected $_templates;
    function __construct(){
        parent::__construct();
        $this->load->model('support_model','support');
        
    }
    
    function ds(){
        $this->write_config(); 
        $data['title'] = 'Hỗ trợ trực tuyến theo tỉnh thành';
          
        $field = $this->uri->segment(4);
        $order = $this->uri->segment(5);   
        if($field =='' && $order == ''){
          $order = 'asc';
        }       
        $config['suffix'] = '/'.$field.'/'.$order;            
        $config['base_url'] = base_url().'support/ds/';  
        $config['total_rows']   =  $this->vdb->find_by_num('city',array('parentid'=>0));
        $data['num'] = $config['total_rows'];
        $config['per_page']  =   20;
        $config['uri_segment'] = 3; 
        $this->pagination->initialize($config);   
        $data['list'] =   $this->vdb->find_by_all('city',$config['per_page'],$this->uri->segment(3),array('parentid'=>0),$field,$order);
        $data['pagination']    = $this->pagination->create_links(); 
        $this->_templates['page'] = 'index';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function yahoo(){
        $city_id = $this->uri->segment(3);
        $data['title'] = 'Hỗ trợ Online qua Yahoo';
        write_log(83,269,'Hỗ trợ Online qua Yahoo');
        $data['apply'] = true;
        $data['save'] = true;
        $data['cancel'] = 'support/ds';
        $data['list'] = $this->vdb->find_by_list('support',array('type'=>'1','city_id'=>$city_id),array('id'=>'asc'));
        $data['city_id'] = $city_id;
        $this->form_validation->set_rules('type','','');
        if($this->form_validation->run()){
            $ar_nick = $this->input->post('ar_nick');
            $ar_name = $this->input->post('ar_name');
            $this->vdb->delete('support',array('type'=>1,'city_id'=>$city_id));
            for($i = 0; $i < sizeof($ar_nick); $i++){
                if($ar_nick[$i]){
                    $vdata['name'] = $ar_name[$i];
                    $vdata['nick'] = $ar_nick[$i];
                    $vdata['type'] = $this->input->post('type');
                    $vdata['city_id'] = $this->input->post('city_id');
                    $this->vdb->update('support',$vdata);
                }
            }
            $this->session->set_flashdata('message','Lưu thành công');
            $option =  $this->input->post('option');
            if($option == 'save'){
               $url = 'support/ds';
            }else{
                $url = 'support/yahoo/'.$city_id;
            }
            redirect($url);
        }
        $this->_templates['page'] = 'yahoo';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function skype(){
        $city_id = $this->uri->segment(3);
        $data['title'] = 'Hỗ trợ Online qua Skype';
        write_log(83,270,'Hỗ trợ Online qua Skype');
        $data['apply'] = true;
        $data['save'] = true;
        $data['cancel'] = 'support/ds';
        $data['list'] = $this->vdb->find_by_list('support',array('type'=>'2','city_id'=>$city_id),array('id'=>'asc'));
        $data['city_id'] = $city_id;
        $this->form_validation->set_rules('type','','');
        if($this->form_validation->run()){
            $ar_nick = $this->input->post('ar_nick');
            $ar_name = $this->input->post('ar_name');
            $this->vdb->delete('support',array('type'=>2,'city_id'=>$city_id));
            for($i = 0; $i < sizeof($ar_nick); $i++){
                if($ar_nick[$i]){
                    $vdata['name'] = $ar_name[$i];
                    $vdata['nick'] = $ar_nick[$i];
                    $vdata['type'] = $this->input->post('type');
                    $vdata['city_id'] = $this->input->post('city_id');
                    $this->vdb->update('support',$vdata);
                }
            }
            
            $this->session->set_flashdata('message','Lưu thành công');
            $option =  $this->input->post('option');
            if($option == 'save'){
               $url = 'support/ds';
            }else{
                $url = 'support/skype/'.$city_id;
            }
            redirect($url);
        }
        $this->_templates['page'] = 'skype';
        $this->templates->load($this->_templates['page'],$data);
    }
    
    function write_config(){
        $this->load->helper('file');
        
        $list_city_yahoo = $this->support->get_list_city(1);
        $list_city_skype = $this->support->get_list_city(2);        
        
        $yahoo = "";
        $y = 1;
        foreach($list_city_yahoo as $val):
            $yahoo_list = $this->vdb->find_by_list('support',array('type'=>1,'city_id'=>$val->city_id),array('id'=>'asc'));
            
            $yahoo .="<div class=\"nick_support_content\">\n";
            $yahoo .="<div class=\"iconyahoo\">".$val->city_name."</div>\n"; 
            foreach($yahoo_list as $rs):
                $yahoo .="<div class=\"sp\"><a onClick=\"_gaq.push(['_trackEvent', 'OnlineSupport', 'Click', 'Yahoo-chamsockhachhang']);\" href=\"ymsgr:sendim?".$rs->nick."\"><img align=\"absmiddle\" src=\"http://opi.yahoo.com/online?u=".$rs->nick."&amp;m=g&amp;t=5\" style=\"border: 0;\">".$rs->name."</a></div>\n";
            endforeach;
            $yahoo .="</div>";
            if(!($y % 3)){
                $yahoo .="<div class=\"clear\"></div>\n";
            }
            $y++;
        endforeach;
        $yahoo .="";
        
        write_file(ROOT.'site/config/support/yahoo.db', $yahoo);
       
        $skype = "";  
        $s = 1;
        foreach($list_city_skype as $val):
            $skype_list = $this->vdb->find_by_list('support',array('type'=>2,'city_id'=>$val->city_id),array('id'=>'asc'));
            $skype .="<div class=\"nick_support_content\">\n";
            $skype .="<div class=\"iconskype\">".$val->city_name."</div>\n";
            foreach($skype_list as $rs):
                $skype .="<div class=\"sp\"><a onClick=\"_gaq.push(['_trackEvent', 'OnlineSupport', 'Click', 'Skype-chamsockhachhang']);\" href=\"skype:".$rs->nick."?chat\"><img align=\"absmiddle\" src=\"http://mystatus.skype.com/smallicon
/".$rs->nick."\" style=\"border: 0;\">".$rs->name."</a></div>\n";                
            endforeach;
            $skype .="</div>";
            if(!($s % 3)){
                $skype .="<div class=\"clear\"></div>\n";
            }
        $s++;
        endforeach;
        
        
        write_file(ROOT.'site/config/support/skype.db', $skype);
    }
}
