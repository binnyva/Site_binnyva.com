<?php
require('../../../../iframe/common.php');

if(i($_POST, 'pass') != 'noyoume') {
	exit;
}

$from = i($_POST, 'from');
if(!$from) $from = 'Binny V A <binnyva@gmail.com>';
$to = i($_POST, 'to');
$subject = i($_POST, 'subject');
$body = i($_POST, 'body');

if(!$to or !$subject or !$body) exit;

if(strpos($message,"<br")===false) { //A Plain Text message
	$type = "text/plain";
} else { //HTML message
	$type = "text/html";
}

$headers  = "MIME-Version: 1.0\r\n";
$headers .= "Content-type: $type; charset=iso-8859-1\r\n";
$headers .= "From: $from";

if(mail($to,$subject,$message,$headers)) {
	print "Email sent";
} else {
	print "Failed in sending the message";
}
