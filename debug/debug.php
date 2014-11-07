<?php

function lytk_log_message($path, $level = 'error', $msg)
{
        //if ($_SERVER['REMOTE_ADDR'] == '86.182.174.205' || $_SERVER['REMOTE_ADDR'] == '173.212.202.170' || $_SERVER['REMOTE_ADDR'] == '113.161.85.105')
        {
                
                $_date_fmt = 'Y-m-d H:i:s';
                $filepath = $path . 'log-' . date('Y-m-d') . '.php';

                $message = '';

                if (!file_exists($filepath))
                {
                        $message .= "<" . "?php  defined('PHPFOX') or exit('NO DICE!');; ?" . ">\n\n";
                }

                if (!$fp = @fopen($filepath, 'ab'))
                {
                        return FALSE;
                }

                $message .= $level . ' ' . (($level == 'INFO') ? ' -' : '-') . ' ' . date($_date_fmt) . ' --> ' . $msg . "\n";

                flock($fp, LOCK_EX);
                fwrite($fp, $message);
                flock($fp, LOCK_UN);
                fclose($fp);

                @chmod($filepath, 0666);
                return TRUE;
        }
}

?>