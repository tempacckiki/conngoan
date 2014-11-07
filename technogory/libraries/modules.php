<?php
class CI_modules{
    function __construct(){
        $this->CI =& get_instance();
        //$this->CI->load->helper('modules');
    }
    
    function read_module($position){
        $list = $this->get_position($position);
        if(count($list) > 0){
            $data ='';
            foreach($list as $rs):
                $modules['title'] = $rs->title;
                $modules['show_title'] = $rs->show_title;
                $modules['content'] = $rs->content;
                $modules['module'] = $rs->module;
                $data .= mod($modules, $rs->params);
            endforeach;
            return $data;
        }else{
            return FALSE;
        }
    }
    
    function get_position($position){
        $this->CI->db->where('lang',vnit_lang());
        $this->CI->db->where('position',$position);
        $this->CI->db->where('published',1);
        $this->CI->db->order_by('ordering','asc');
        return $this->CI->db->get('modules')->result();
        
    }
}
