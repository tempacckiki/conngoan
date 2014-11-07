<?php
define('BASEPATH', ''); 
require('../site/config/database.php');
$local =  $db['member']['hostname'];
$user = $db['member']['username'];
$pass = $db['member']['password'];
$db_name = $db['member']['database'];
$db_charset = $db['member']['char_set'];

// Connect
if (!$conn = @mysql_connect($local, $user, $pass)) {
      die('Error: Could not make a database link using ' . $user . '@' . $local);
}

if (!mysql_select_db($db_name, $conn)) {
      die('Error: Could not connect to database ' . $db_name);
}

mysql_query("SET NAMES '".$db_charset."'", $conn);
mysql_query("SET CHARACTER SET ".$db_charset, $conn);
mysql_query("SET CHARACTER_SET_CONNECTION=".$db_charset, $conn);
mysql_query("SET SQL_MODE = ''", $conn);

$table_logs = 'logs';
$table_logs_rename = "logs_".date('d_m_Y_H_i',time());

$query = "RENAME TABLE ".$table_logs." TO ".$table_logs_rename;

$query = mysql_query($query);
//mysql_close($conn);
if ($query) {
        $sql = "CREATE TABLE logs
        (
           `id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            `user_id`         INT(11) NULL,
            `phanquyen_id`    INT(11) NULL,
            `function_id`     INT(11) NULL,
            `message`         VARCHAR(500) NULL,
            `url`             VARCHAR(200) NULL,
            `date`            INT(11) NULL,
            `ip_address`      VARCHAR(50) NULL
        )";

        // Execute query
        if(mysql_query($sql,$conn)){
            mysql_close($conn);    
        }else{
            die('Not Create Table Name: logs');
        }

}else{
    die('Not Rename Table');
}