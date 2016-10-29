<?php

$host = "u31.fr"; // SMTP host
$username = "ulysse@u31.fr"; //SMTP username
$password = "rutaba9a"; // SMTP password

require("class.phpmailer.php");

$uploaddir = 'upload';
$key = 0;
$tmp_name = $_FILES["userfile"]["tmp_name"][$key];
        $name = $_FILES["userfile"]["name"][$key];
        $sendfile = "$uploaddir/$name";
move_uploaded_file($tmp_name, $sendfile);

 
//exit;


$to = $_POST['to'];
$addresses = array();

$addresses = explode("\n",$to);
//print_r($addresses);exit;


$f1 = $_POST['f1'];
$field_1 = array();

$field_1 = explode("\n",$f1);

$f2 = $_POST['f2'];
$field_2 = array();

$field_2 = explode("\n",$f2);

if(count($addresses) !=  count($field_1) OR  count($addresses) !=  count($field_2))
{
    echo 'Error,fields and addresses lengths do not match.';
    exit;
}

$name = $_POST['who'];
$email_subject = $_POST['subject'];
$Email_msg = $_POST['message'];

//$Email_to = "you@yourSite.com"; // the one that recieves the email
$email_from = $_POST['from'];
//$dir = "uploads/$filename";
//chmod("uploads",0777);
$attachments = array();

//foreach ($addresses as $Email_to) { echo $Email_to."<br>"; }
//exit;
$i = 0;
foreach ($addresses as $Email_to)
{

    //Preparing message :
    $Email_msg = str_replace("\$f1", $field_1[$i], $Email_msg);
    $Email_msg = str_replace("\$f2", $field_2[$i], $Email_msg);
    $Email_msg2 = str_replace("\n", "<br>", $Email_msg);
    $i++;
    echo $Email_msg;


$mail = new PHPMailer();

$mail->IsSendMail();//->IsSMTP();                                   // send via SMTP
$mail->Host     = $host; // SMTP servers
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = $username;  // SMTP username
$mail->Password = $password; // SMTP password

$mail->From     = $email_from;
$mail->FromName = $name;
$mail->AddAddress($Email_to);  
//$mail->AddReplyTo("info@worldtradetown.com","Information");
//foreach($attachments as $key => $value) { //loop the Attachments to be added …
//$mail->AddAttachment(”uploads”.”/”.$value);
//}

$mail->AddAttachment($sendfile);

$mail->WordWrap = 50;                              // set word wrap
$mail->IsHTML(true);                               // send as HTML

$mail->Subject  =  $email_subject;
$mail->Body     =  $Email_msg2;
$mail->AltBody  =  $Email_msg;

if(!$mail->Send())
{
   echo "Message was not sent <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}

echo "Message to $Email_to has been sent<br>";

}

?>
 
