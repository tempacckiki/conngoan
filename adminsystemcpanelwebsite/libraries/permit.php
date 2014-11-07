<?php
class CI_permit{
    function __construct(){
        $this->CI = get_instance();
        $this->user_id = $this->CI->session->userdata('user_id');
        $this->group_id = $this->CI->session->userdata('group_id');
        $this->uri1 = $this->CI->uri->segment(1);
        $this->uri2 = $this->CI->uri->segment(2);
        $this->uri3 = $this->CI->uri->segment(3);
        $this->uri4 = $this->CI->uri->segment(4);
        $this->uri5 = $this->CI->uri->segment(5);
        $this->check_permit();
    }
    
    function get_permit_by_user(){
        
    }
    
    function get_permit_icon($url){
        if($this->group_id == 18){
            return true;
        }else{
            $uri = explode('/',$url); 
            $this->CI->db->where('uri1',$uri[0]);
            $this->CI->db->where('uri2',$uri[1]);
            if(isset($uri[2])){
                if( (int)$uri[2] == 0){
                    $this->CI->db->where('uri3',$uri[2]);
                }
            }
            $this->CI->db->where('user_id',$this->user_id);
            $row = $this->CI->db->get('phanquyen_user')->row();
            if($row){
                return true;
            }else{
                return false;
            } 

        }
    }
    
    function get_permit_add($url){
        if($this->group_id == 18){
            return true;
        }else{
            $uri = explode('/',$url);
            $component = $uri[0];
            if(count($uri) == 2){
                $module = '';
                $function = $uri[1];
            }else{
                $module = $uri[1];
                $function = $uri[2];
            }
            
            $this->CI->db->where('component',$component);
            $this->CI->db->where('module',$module);
            $this->CI->db->where('function_name',$function);
            $this->CI->db->where('user_id',$this->user_id);
            $row = $this->CI->db->get('phanquyen_user')->row();
            if($row){
                return true;
            }else{
                return false;
            }
        }        
    }
    
    function get_permit_mainmenu($menu){
        $this->db = $this->CI->load->database('default', TRUE); 
        if($this->group_id == 18){
            return true;
        }else{
            $this->db->where('menu',$menu);
            $this->db->where('user_id',$this->user_id);
            $total = $this->db->get('phanquyen_user')->num_rows();
            if($total > 0){
                return true;
            }else{
                return false;
            }  
        }
    }
    
    
    function check_permit(){
        $this->db = $this->CI->load->database('default', TRUE); 
        if($this->group_id == 18){
            return true;
        }else{
            $uri = explode('/',uri_string());
            if(uri_string() != ''){
            if($this->get_uri_system()){
                
                $uri1 = $uri[0];
                $uri2 = $uri[1];
               // $uri3 = (int)$uri[2];
                $this->db->where('uri1',$uri1);
                $this->db->where('uri2',$uri2);
                if(isset($uri[2])){
                    $uri3  = (int)$uri[2];
                    if($uri3 == 0){
                        $this->db->where('uri3',$uri3);
                    }
                }
                $this->db->where('user_id',$this->user_id);
                $total = $this->db->get('phanquyen_user')->row();
                if($total){
                    return true;
                }else{
                    $msg = "<p class=\"text\">Bạn không có quyền truy cập trang này.</p>";
                    $msg .="<p class=\"text\">Hệ thống sẽ tự động chuyển bạn qua trang mặc định sau 5 giây</p>";
                    $msg .= '<p class="redirect"><b><a href="javascript:goBack();">Bấm vào đây để quay lại</a></b></p>';
                    show_error($msg,$status_code= 500,'Giới hạn truy cập')  ;
                } 
            } 
        }else{
            return true;
        }
        }
    }
    
    function get_uri_system(){
        $this->db = $this->CI->load->database('default', TRUE); 
        if($this->CI->uri->segment(2) == ''){
            return false;
        }else{
            $uri = explode('/',uri_string());
            $uri1 = $uri[0];
            $uri2 = $uri[1];
            $this->db->where('uri1',$uri1);
            $this->db->where('uri2',$uri2);
            if(isset($uri[2])){
                $uri3  = (int)$uri[2];
                if($uri3 == 0){
                    $this->db->where('uri3',$uri3);
                }
            }
            $row = $this->db->get('phanquyen_uri')->row();
            if($row){
                return true;
            }else{
                return false;
            }  
        }
    }
}
