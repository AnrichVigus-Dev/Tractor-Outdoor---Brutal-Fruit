<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';


// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

$mail->isSMTP(); // Set mailer to use SMT

$mail->Host = 'smtp.sendgrid.net'; // Specify main and backup SMTP servers

//$mail->SMTPDebug = 1; // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only

$mail->SMTPAuth = true; // Enable SMTP authentication

$mail->Username = 'apikey'; // SMTP username

$mail->Password = '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'; // SMTP password

$mail->SMTPSecure = 'ssl'; // Enable TLS encryption, `ssl` also accepted

$mail->Port = 465; // TCP port to connect to


$mail->setFrom('no-reply@brutalfruit.dooh-share.com', 'Brutal Fruit');

//$mail->addAttachment('/var/tmp/file.tar.gz'); // Add attachments

//$mail->addAttachment('/tmp/image.jpg', 'new.jpg'); // Optional name

$mail->isHTML(true); // Set email format to HTML

?>
