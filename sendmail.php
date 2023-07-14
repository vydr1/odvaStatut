<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

echo 'im here';


$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail-> setLanguage('ru', 'phpmailer/languange/');

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = '3sendmailtest12@gmail.com';
$mail->Password = 'rkspqymvvqmaqzob';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
$mail->Port = 465;

$mail->setFrom('3sendmailtest12@gmail.com', 'test');
//$mail->addAddress('3sendmailtest12@gmail.com');               

$mail->isHTML(true);
$mail->Subject = 'bla bla bla';

//echo var_dump($_POST);

$name = $_POST["name"];
$email = $_POST["email"];

$mail->addAddress($email);               

$phone = $_POST["phone"];
$secondName = $_POST["secondName"];
$addNumber = $_POST["addNumber"];
$dob = $_POST["dob"];
$third = $_POST["third"];

//$mail->Body .= 'фыврфоы  ' . $name;

$email_template = "template_mail.html";

$body = file_get_contents($email_template);

$body = str_replace('%name%', $name, $body);
$body = str_replace('%email%', $email, $body);
$body = str_replace('%secondName%', $secondName, $body);
$body = str_replace('%third%', $third, $body);
$body = str_replace('%phone%', $phone, $body);
$body = str_replace('%addNumber%', $addNumber, $body);
$body = str_replace('%dob%', $dob, $body);


// $mail->SMTPDebug = SMTP::DEBUG_SERVER;

   // $body .= "grgggggg";
echo $body;

$mail->Body = $body;

//echo htmlentities($_POST['dob']);
echo $mail->Body;
if(count($_POST) != 0){
    echo 'yyyyyyy';
}
var_dump($_POST);
if(!$mail->send()) 
{
    $message = "Ошибка отправки";
} 
else 
{
    $message = "Данные отправлены!";
}
            
//header('Content-type: application/json');
//echo json_encode(($response));