<?php

class CI_pconnect{
    function __construct(){
        $this->CI = get_instance();
        $this->connect();
        //if(file_exists(ROOT.'site/config/database.php')){}
        require_once(ROOT.'site/config/database.php');   
    }
    
    function connect(){
        $this->CI->member = $this->CI->load->database('member', TRUE); 
        $hostname =  $this->CI->db->hostname;
        $username =  $this->CI->db->username;
        $password =  $this->CI->db->password;
        $database =  $this->CI->db->database;
        $fyi = mysql_connect($hostname,$username,$password);
        mysql_select_db($database,$fyi);
        mysql_set_charset('utf8',$fyi);
        $this->CI->db = $this->CI->load->database('default', TRUE); 
    }
    
    /*
    function connect_db($host, $user, $pass, $database, $char_set='utf8', $dbcollat='utf8_general_ci'){
        $this->conn = mysql_connect($host, $user, $pass) or die('Error connecting to mysql'); 
        mysql_select_db($database, $this->conn);
        $this->db_set_charset($char_set, $dbcollat);
        return $this->conn; 
    }*/
    
    function _query($sql){
        $result = mysql_query($sql);
        if (!$result) {
            echo 'Invalid query: ' . mysql_error();
        }
        return $result;
    }
    
    function _query_num_rows($sql){
        $result = mysql_query($sql);
        if (!$result) {
            echo 'Invalid query: ' . mysql_error();
        }
        
        return mysql_num_rows($result);
    }
    
    function str_insert($table, $keys, $values){    
        return "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES (".implode(', ', $values).")";
    }
    
    function _insert($table, $values){
        foreach($values as $key=>$val)
        {
            $values[$key] = $this->escape($val);
        }
        $sql = $this->str_insert($table, array_keys($values), array_values($values));
        return $this->_query($sql);
    }
    
    function insert_id(){
        return mysql_insert_id($this->conn);
    }
    
    function close_db($conn)
    {
        mysql_close($conn);
    }
    /**
     * "Smart" Escape String
     *
     * Escapes data based on type
     * Sets boolean and null types
     *
     * @access    public
     * @param    string
     * @return    mixed        
     */    
    function escape($str){
        if (is_string($str))
        {
            $str = "'".$this->escape_str($str)."'";
        }
        elseif (is_bool($str))
        {
            $str = ($str === FALSE) ? 0 : 1;
        }
        elseif (is_null($str))
        {
            $str = 'NULL';
        }

        return $str;
    }

    /**
     * Escape String
     *
     * @access    public
     * @param    string
     * @param    bool    whether or not the string will be used in a LIKE condition
     * @return    string
     */
    function escape_str($str, $like = FALSE){    
        if (is_array($str))
        {
            foreach($str as $key => $val)
               {
                $str[$key] = $this->escape_str($val, $like);
               }
           
               return $str;
           }

        if (function_exists('mysql_real_escape_string') AND is_resource($this->conn))
        {
            $str = mysql_real_escape_string($str, $this->conn);
        }
        elseif (function_exists('mysql_escape_string'))
        {
            $str = mysql_escape_string($str);
        }
        else
        {
            $str = addslashes($str);
        }
        
        // escape LIKE condition wildcards
        if ($like === TRUE)
        {
            $str = str_replace(array('%', '_'), array('\\%', '\\_'), $str);
        }
        
        return $str;
    }
    /**
     * Set client character set
     *
     * @access    public
     * @param    string
     * @param    string
     * @return    resource
     */
    function db_set_charset($charset, $collation){
        return @mysql_query("SET NAMES '".$this->escape_str($charset)."' COLLATE '".$this->escape_str($collation)."'", $this->conn);
    }
} 
?>
