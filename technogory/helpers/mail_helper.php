<?php
      function sendmail($name,$from,$to,$subject,$message){        
        $mess =$message;
        $headers = "From: ".$name." <".$from.">\n";
        $headers .= "Reply-To: ".$name." <".$from.">\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: text/html; charset=\"utf-8\"\n";
        return @mail( $to, $subject, $mess, $headers );          
      }
      
      function send($to,$subject,$message,$contact_name,$contact_email){          
          $contact_name = "=?UTF-8?B?".base64_encode($contact_name).'?=';
          $headers = "From: ".$contact_name." <".$contact_email.">\n";
          $headers .= "Reply-To: ".$contact_name." <".$contact_email.">\n";
          $headers .= "MIME-Version: 1.0\n";
          $headers .= "Content-Type: text/html; charset=UTF-8\n";
          return @mail( $to, "=?UTF-8?B?".base64_encode($subject).'?=', $message, $headers );          
      }
      
      function send_cart($to,$subject,$message){
          $CI = get_instance();          
          $mess =$message;
          $contact_name = "=?UTF-8?B?".base64_encode($CI->config->item('contact_name')).'?=';
          $headers = "From: ".$contact_name." <".$CI->config->item('contact_email').">\n";
          $headers .= "Reply-To: ".$contact_name." <".$CI->config->item('contact_email').">\n";
          $headers .= "MIME-Version: 1.0\n";
          $headers .= "Content-Type: text/html; charset=UTF-8\n";
          return @mail( $to, "=?UTF-8?B?".base64_encode($subject).'?=', $mess, $headers );          
      }      
      function send_mail_templates($to,$subject,$message){
          $CI = get_instance();          
          $mess =$message;
          $contact_name = "=?UTF-8?B?".base64_encode('ALOBUY VIỆT NAM - WEBSITE TMĐT SỐ 1 VIỆT NAM').'?=';
          $headers = "From: ".$contact_name." <info@alobuy.vn>\n";
          $headers .= "Reply-To: ".$contact_name." <info@alobuy.vn>\n";
          $headers .= "MIME-Version: 1.0\n";
          $headers .= "Content-Type: text/html; charset=UTF-8\n";
          return @mail( $to, "=?UTF-8?B?".base64_encode($subject).'?=', $mess, $headers );         
      }
      function send_mail_to_friend($nguoigui,$emailnguoigui,$emailnguoinhan,$subject,$message){      

          $nguoigui1 = "=?UTF-8?B?".base64_encode($nguoigui).'?='; 
          $headers = "From: ".$nguoigui1." <".$emailnguoigui.">\n";
          $headers .= "Reply-To: ".$nguoigui1." <".$emailnguoigui.">\n";
          $headers .= "MIME-Version: 1.0\n";
          $headers .= "Content-Type: text/html; charset=UTF-8\n";
          if(@mail( $emailnguoinhan, "=?UTF-8?B?".base64_encode($subject).'?=', $message, $headers )){
              return true;
          }else{
              return false;
          }
      }      

?>
