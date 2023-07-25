<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';


$errors = [];


foreach($_POST as $fieldName => $fieldValue)
{
    if(empty($fieldValue))
    {
        $errors[$fieldName] = 'this field is requaered';
    } 
}

//$_POST['name'] = clear_data($_POST['name']);
//$_POST['secondName'] = clear_data($_POST['secondName']);

$errors = validateData($errors);


if (!empty($errors))
{
    echo json_encode([
        'success' => false,
        'errors' => $errors
    ]);
    exit();
}


$mail = mailerConfig();
$mail = mailBodyFill($mail);



if(!$mail->send()) 
{
    header('Content-Type: application/json');
    echo json_encode([
        'message' => 'Ошибка отправки'
    ]);
} 
else 
{
    header('Content-Type: application/json');
    echo json_encode([
        'message' => 'отправка прошла успешно!'
    ]);
}


function validateData($errors)
{
    $mailRegExp = '/^[-\w.]+@([A-z0-9][-A-z0-9]+\.)+[A-z]{2,4}$/';
    $nameRegExp = '/^[А-ЯЁ][а-яё]*$/u';
    $numberRegExp = '/((\+7|7|8)+([0-9]){10})$/';
    //var_dump($_POST);

    if(!preg_match($mailRegExp, $_POST["email"]))
    {
        $errors = validErrorMessageAd($errors, 'email');
    }

    if(!preg_match($nameRegExp, $_POST["name"]))
    {
        $errors = validErrorMessageAd($errors, 'name');
    }

    if(!preg_match($nameRegExp, $_POST["secondName"]))
    {
        $errors = validErrorMessageAd($errors, 'secondName');
    }

    if(!preg_match($numberRegExp, $_POST["phone"]))
    {
        $errors = validErrorMessageAd($errors, 'phone');

    }

    return $errors;
    
}


function validErrorMessageAd($errors, $name)
{
    if (!isset($errors[$name])) 
    {
        $errors[$name] = "validation error";
    }
    return $errors;
}

function clear_data($val)
{
    $val = trim($val);
    $val = stripslashes($val);
    $val = strip_tags($val);
    $val = htmlspecialchars($val, ENT_QUOTES);

    return $val;
}

function mailerConfig()
{
    $mail = new PHPMailer(true);
    $mail->CharSet = 'UTF-8';
    $mail-> setLanguage('ru', 'phpmailer/languange/');

    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'mail1send2test3@gmail.com';
    $mail->Password = 'ewuukpelubkgwtdo';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom('3sendmailtest12@gmail.com', 'test');
    //$mail->addAddress('3sendmailtest12@gmail.com');               

    $mail->isHTML(true);
    return $mail;
}

function mailBodyFill($mail)
{
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
    $gender = $_POST["gender"];

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
    if($gender === '1')
    {
        $body = str_replace('%gender%', ' Женский', $body);
    }
    else if($gender === '2')
    {
        $body = str_replace('%gender%', ' Мужской', $body);

    }



    $mail->Body = $body;
    return $mail;
}

//header('Content-type: application/json');
//echo json_encode(($response));