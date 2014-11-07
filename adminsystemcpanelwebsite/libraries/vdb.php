<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_vdb {
    public function __construct()
    {
        $this->CI =& get_instance();
    } 
	
	/*------------------------------------+
     * delet cache
     +---------------------------------*/
 	function delcache($dir="")
	{
		if ($handle = opendir($dir)) {
				while (false !== ($file = readdir($handle))) {
					if(strlen($file)>4 && file_exists($dir.'/'.$file)){
						chmod($dir.'/'.$file,0777);
						unlink($dir.'/'.$file);
					}				
			}
		}
	}
	
    // Insert 
    function insert($table,$data)
    {
        $this->CI->db->insert($table, $data);
        return $this->CI->db->insert_id();
    }
    
    // Update
    function update($table,$data ,$id = 0)
    {
        if(!is_array($id)){
            if($this->CI->db->insert($table,$data)){
                return $this->CI->db->insert_id();
            }else{
                return FALSE;
            }            
        }else{
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);            
            }
            if($this->CI->db->update($table, $data)){
                return TRUE;
            }else{
                return FALSE;
            }
        }
    }
    
    // Delete
    function delete($table, $id)
    {
        if (is_array($id))
        {
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);            
            }
            if($this->CI->db->delete($table)){
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            show_error('ID is no Array()');
        }
    }  
        
    function find_by_id($table, $id)
    {
        if(!is_array($id)) {
            show_error('ID is no array');
        }else{
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);
            }
            $query = $this->CI->db->get($table);
            $result = $query->row();
            return $result;
        }
    }
    function find_by_list($table, $id = 0, $order = '')
    {
        if(is_array($id)) { 
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);
            }           
        }
        if(is_array($order)){
            foreach($order as $k => $v) {
                $this->CI->db->order_by($k, $v);
            }  
        }        
        $query = $this->CI->db->get($table);
        return $query->result();
    }

    
    // Get Total
    function find_by_all($table, $num, $offset,$id =0 ,$field = '', $order = ''){
       if(is_array($id)) { 
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);
            }           
       }
       if($field != '' && $order != ''){
           $this->CI->db->order_by($field, $order);
       }
       return $this->CI->db->get($table, $num, $offset)->result();
    }
    
    function find_by_num($table,$id = 0){
        if(is_array($id)) { 
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);
            }           
        }
        $query = $this->CI->db->get($table);
        return $query->num_rows();        
    }
    
    function find_by_order($table, $value, $id = 0){
        $this->CI->db->select_max($value);
        if(is_array($id)) { 
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);
            }           
        }
        $query = $this->CI->db->get($table)->row();
        return $query->$value + 1;
    }
    function find_by_max($table,$order = '',$key = ''){
        if(is_array($order)){
            foreach($order as $k => $v) {
                $this->CI->db->order_by($k, $v);
            }  
        }
        if(is_array($key)) { 
            foreach($key as $k => $v) {
                $this->CI->db->where($k, $v);
            }           
        }
        return $this->CI->db->get($table)->num_rows();
    }
    // Total
    function find_by_total($table, $id = 0){
        if(is_array($id)) { 
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);
            }           
        }
        $query = $this->CI->db->get($table);
        return count($query->result());        
    }
    
    function get_ar($catid){
        $this->CI->db->where('catid',$catid);
        $row = $this->CI->db->get('cachecat')->row();
        $ar_list = $row->ar_cat;
        $ar =  explode(',',$ar_list);
        $ar_id = array();
        for($i = 0; $i < sizeof($ar);$i++){
            $id = $ar[$i];
            array_push($ar_id, $ar[$i]);
            
        }
        return $ar_id;
    }
    
    
 

 
   
}
 
/* End of file MY_Model.php */
/* Location: ./system/application/libraries/MY_Model.php */