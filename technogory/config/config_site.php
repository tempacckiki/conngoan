<?php
if(!is_dir(ROOT.'technogory/config/site/'.vnit_lang())){
    mkdir(ROOT.'technogory/config/site/'.vnit_lang(),0775);
    $fp = fopen(ROOT.'technogory/config/site/'.vnit_lang().'/config_site.php', 'w');
}
$config['config_file']    = ROOT."technogory/config/site/".vnit_lang()."/config_site.php";
require_once($config['config_file']);  

$config['config_contact']    = ROOT."technogory/config/config_contact.php";
require_once($config['config_contact']);  
?>