<?php
class search_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    
    function get_all_search($num,$offset,$key){
        /*
        $this->db->where('lang','en');
        $this->db->where('published',1);
        if($key != ''){
            $this->db->like('title',$key);
            $this->db->or_like('introtext',$key);
            $this->db->or_like('fulltext',$key);
        }
        */
        $lang = vnit_lang();
        $sql = "
            SELECT * FROM 
                content
            WHERE
                published = 1 AND lang = '$lang' AND ((title LIKE '%$key%') OR (introtext LIKE '%$key%'))  limit $num offset $offset
        ";
        return $this->db->query($sql)->result();
    }
    
    function get_num_search($key){
        $lang = vnit_lang();
        $sql = "
            SELECT * FROM 
                content
            WHERE
                published = 1 AND lang = '$lang' AND ((title LIKE '%$key%') OR (introtext LIKE '%$key%'))
        ";
        return $this->db->query($sql)->num_rows();
    }    
}
