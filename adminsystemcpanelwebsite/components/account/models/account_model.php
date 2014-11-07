<?php
class account_model extends CI_Model{
    function __construct(){
        parent::__construct();
        $this->db = $this->load->database('default', TRUE); 
    }
    
    function get_num_user($city_id = 0){
        $this->member = $this->load->database('member', TRUE); 
        if($city_id != 0){
            $this->member->where('city_id',$city_id);
        }
        return $this->member->get('user')->num_rows();
        
    }
    
    function get_all_user($num, $offset, $city_id = 0, $field, $order){
        $this->member = $this->load->database('member', TRUE); 
        if($city_id != 0){
            $this->member->where('city_id',$city_id);
        }
        $this->member->order_by($field,$order);
        return $this->member->get('user',$num,$offset)->result(); 
        
    }
    
	function get_num_userAdmin($city_id = 0){
        $this->member = $this->load->database('member', TRUE); 
        if($city_id != 0){
            $this->member->where('city_id',$city_id);
        }
         $this->member->where('active_shop',1);
         $this->member->where('group_id >=',17);
        return $this->member->get('user')->num_rows();
        
    }
    
	function get_all_userAdmin($num, $offset, $city_id = 0, $field, $order){
        $this->member = $this->load->database('member', TRUE); 
        if($city_id != 0){
            $this->member->where('city_id',$city_id);
        }
        $this->member->where('active_shop',1);
         $this->member->where('group_id >=',17);
        $this->member->order_by($field,$order);
        return $this->member->get('user',$num,$offset)->result(); 
        
    }
    
    
    function get_account_by_date($tungay,$denngay,$city_id){
        $this->member = $this->load->database('member', TRUE); 
        $begin = strtotime($tungay);
        $end = strtotime($denngay);
        if($begin > 0 && $end > 0){
        $this->member->where('create_time >=',$begin);
        $this->member->where('create_time <=',$end);
        }
        if($city_id !=0){
            $this->member->where('city_id',$city_id);
        }
        $this->member->order_by('create_time','asc');
        return $this->member->get('user')->result();
    }
    
    function find_by_member($user_id){
        $this->member = $this->load->database('member', TRUE);
        $this->member->where('user_id',$user_id);
        return $this->member->get('user')->row();
    }
    
    function find_city_by_id($city_id){
        $this->db = $this->load->database('default', TRUE);
        $this->db->where('city_id',$city_id);
        $row = $this->db->get('city')->row();
        if($row){
            return $row->city_name;
        }else{
            return '';
        }
    }

    function get_all_admin(){
        $this->member = $this->load->database('member', TRUE); 
        $this->member->where('group_id',17);
        $this->member->order_by('fullname','asc');
        return $this->member->get('user')->result(); 
        
    }
    
    function get_num_history($user_id, $begin, $end){
        $this->member = $this->load->database('member', TRUE); 
        if($begin != 0){
            $this->member->where('date >',$begin);
            $this->member->where('date <',$end);
        }
        $this->member->where('user_id',$user_id);
        return $this->member->get('logs')->num_rows();
        
    }
    
    function get_all_history($num, $offset, $user_id, $begin, $end){
        $this->member = $this->load->database('member', TRUE); 
        if($begin != 0){
            $this->member->where('date >',$begin);
            $this->member->where('date <',$end);
        }
        $this->member->where('user_id',$user_id);   
        $this->member->order_by('date','desc');
        return $this->member->get('logs',$num,$offset)->result(); 
    }
    
    function get_phanquyen($phanquyen_id){
        $this->db = $this->load->database('default', TRUE);
        $this->db->where('id',$phanquyen_id);
        $row = $this->db->get('phanquyen')->row();
        if($row){
            return $row->name;
        }else{
            return '';
        }
    }
    function get_chucnang($function_id){
        $this->db = $this->load->database('default', TRUE);
        $this->db->where('function_id',$function_id);
        $row = $this->db->get('phanquyen_chucnang')->row();
        if($row){
            return $row->function_notice;
        }else{
            return '';
        }
    }
}
