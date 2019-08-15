<?php
function email($fromName, $to, $subject, $body)
{
 require_once ('class.phpmailer.php');
 $Mail = new PHPMailer();
 $Mail->IsSMTP();
 $Mail->Host        = "hostname.com";//SMTP server
 $Mail->SMTPDebug   = 0;
 $Mail->SMTPAuth    = TRUE;
 $Mail->SMTPSecure  = "tls";
 $Mail->Port        = 587;//SMTP port
 $Mail->Username    = 'username';//SMTP account username
 $Mail->Password    = 'password';//SMTP account password
 $Mail->Priority    = 1;
 $Mail->CharSet     = 'UTF-8';
 $Mail->Encoding    = '8bit';
 $Mail->Subject     = $subject;
 $Mail->ContentType = 'text/html; charset=utf-8\r\n';
 $Mail->From        = 'email@domain.com';
 $Mail->FromName    = $fromName;
 $Mail->WordWrap    = 900;
 $Mail->AddAddress($to);
 $Mail->isHTML(TRUE);
 $Mail->Body        = $body;
 $Mail->AltBody     = $body;
 $Mail->Send();
 $Mail->SmtpClose();
 if ($Mail->IsError()) return 'emailNotSent';
 else return 'emailSent';
}
?>