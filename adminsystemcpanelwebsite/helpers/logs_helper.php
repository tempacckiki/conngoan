<?php
if (! function_exists('write_log')){  
    function write_log($phanquyen_id = 0, $function_id = 0, $message){
        $CI = get_instance();
        
        $user_id = $CI->session->userdata('user_id');  
        $date = time();
        $vdata['user_id'] = $user_id;
        $vdata['phanquyen_id'] = $phanquyen_id;
        $vdata['function_id'] = $function_id;
        $vdata['message'] = $message;
        $vdata['date'] = $date;
        $vdata['url'] = uri_string();
        $vdata['ip_address'] = $CI->input->ip_address();
        
        $CI->member = $CI->load->database('member', TRUE); 
        $CI->member->insert('logs',$vdata);
        $CI->db = $CI->load->database('default', TRUE); 
         
        
    }
}
?>
