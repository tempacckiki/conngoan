<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CI_vdb {
    public function __construct()
    {
        $this->CI =& get_instance();
        //Session language
        $lang = $this->CI->session->userdata('lang');
        if(!$lang){
            $this->CI->session->set_userdata('lang','vi');
        }
        
        $lang_site = $this->CI->session->userdata('lang_site');
        if(!$lang_site){
            $uri_lang = $this->CI->uri->segment(1);
            if($uri_lang=='vi'){
                $this->CI->session->set_userdata('lang_site','vietnamese');    
            }else if($uri_lang=='en'){
                $this->CI->session->set_userdata('lang_site','english');    
            }else{
                $this->CI->session->set_userdata('lang_site','vietnamese');    
            }
        }
        $regions = $this->CI->session->userdata('fyi_regions');
        if(!$regions){
            $this->CI->session->set_userdata('fyi_regions','miennam');
        }
        
        $city = $this->CI->session->userdata('city_site');
        if(!$city){
            $this->CI->session->set_userdata('city_site',25);
        }
        
        $config['config_file']    = ROOT."technogory/config/site/".vnit_lang()."/config_site.php";
        require_once($config['config_file']);          
        
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
        
    function find_by_id($table, $id,  $strSelect = null)
    {
    	if(!empty($strSelect)){
    		$this->CI->db->select(trim($strSelect));
    	}
    	
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
    function find_by_list($table, $id = 0, $order = '', $strSelect = null)
    {
    	if(!empty($strSelect)){
    		$this->CI->db->select(trim($strSelect));
    	}
    	
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
	//******************************
    function find_by_listNew($table,  $strSelect = null, $id = 0, $order = '', $limit = null)
    {
    	if(!empty($strSelect)){
    		$this->CI->db->select(trim($strSelect));
    	}
    	
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
    	$query = $this->CI->db->get($table, $limit);
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
    
    // Find max barcode  
    
    function find_barcode($table,$order,$id=0){
        if(is_array($id)) { 
            foreach($id as $k => $v) {
                $this->CI->db->where($k, $v);
            }           
        }  
        if(is_array($order)) { 
            foreach($order as $k => $v) {
                $this->CI->db->order_by($k, $v);
            }           
        }
        return $this->CI->db->get($table)->row();
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
    
    function get_ar_temp($catid){
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
 

  	/*-----------------------------------------------+
     * get news cache
     +---------------------------------------------*/
	
	public function getCacheNews($table, $strSelect = "",  $id = 0, $order = '', $limit = null)
    {
    	$options = '';
    	$file 	 = ROOT."site/cache/news/news.db" ;
    	
    	if(file_exists($file)){
    		$options = @file_get_contents($file);
    	}else{
    		if(!empty($strSelect)){
    			$this->CI->db->select(trim($strSelect));
	    	}	     
	        
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
	        $query 		= $this->CI->db->get($table, $limit);
	        $result 	= $query->result();
	        if(count($result)>0){	        	
	        	foreach ($result as $valNews){	
	        		$nameNew  = $valNews->title;
	        		$linkNews = site_url('news/'.$valNews->caturl.'/'.$valNews->title_alias.'-'.$valNews->newsid);
	        		$imgHot   = base_url().'site/templates/fyi/images/hot.gif';
	        		$options .= '<li><a href="'.$linkNews.'">'.$nameNew.' <img src="'.$imgHot.'" width="20" alt="'.$nameNew.'"></a></li>';
	        	}
	        	
	        }
	        //check options 
	        if(!empty($options)){
	        	@file_put_contents($file, $options);
	        }
	        
    	}
    	return $options;
    
    }
 
   
}
 
/* End of file MY_Model.php */
/* Location: ./system/application/libraries/MY_Model.php */